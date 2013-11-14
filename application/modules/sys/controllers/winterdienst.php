<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Winterdienst Controller
 * @author chientran <tran.duc.chien@kloon.vn>
 * @created 5 Nov 2013
 */
class Winterdienst extends MY_Controller {
    private $_id_city = 1;
    function __construct() {
        parent::__construct();

        # Init API server
        $this->rest->initialize(array('server' => config_item('api_web')));

        # Breadcrumb
        $this->breadcrumb->append_crumb('Winterdienst', create_url('sys/winterdienst'));
    }

    function index() {
        # Worker
        $workers    = array();
        $api_param  = array(
            'id_city' => $this->_id_city
        );
        $api_result = $this->rest->get('web/worker/index', $api_param, 'json');
        $api_status = $this->rest->status();
        if ( isset($api_result->status) AND ($api_result->status == REST_STATUS_SUCCESS) AND (isset($api_result->data)) AND (!empty($api_result->data)) ) {
            foreach ($api_result->data as $key => $value) {
                $workers[$value->id] = $value;
            }
        }
        $this->data['workers'] = $workers;

        # Machine
        $machines    = array();
        $api_param  = array(
            'id_city' => $this->_id_city
        );
        $api_result = $this->rest->get('web/machine/index', $api_param, 'json');
        $api_status = $this->rest->status();
        if ( isset($api_result->status) AND ($api_result->status == REST_STATUS_SUCCESS) AND (isset($api_result->data)) AND (!empty($api_result->data)) ) {
            foreach ($api_result->data as $key => $value) {
                $machines[$value->id] = $value;
            }
        }
        $this->data['machines'] = $machines;

        # GPS
        $gps       = array();
        $api_param = array();

        # by_date param
        $by_date       = trim($this->input->get('by_date'));
        $by_date_array = explode('.', $by_date);
        if ( is_array($by_date_array) AND (count($by_date_array) == 3) ) {
            $by_date_timestamp = strtotime("{$by_date_array[2]}-{$by_date_array[1]}-{$by_date_array[0]}");
            $tmp               = date('d.m.Y',  $by_date_timestamp);
            if ($by_date === $tmp) {
                $api_param['day']      = date('Y-m-d', $by_date_timestamp);
                $this->data['by_date'] = $by_date;
            }
        }

        # by_worker param
        $by_worker = intval($this->input->get('by_worker'));
        if ($by_worker <= 0) {
            $by_worker = FALSE;
        } else {
            $api_param['worker']     = $by_worker;
            $this->data['by_worker'] = $by_worker;
        }

        # by_worker param
        $by_machine = intval($this->input->get('by_machine'));
        if ($by_machine <= 0) {
            $by_machine = FALSE;
        } else {
            $api_param['machine']     = $by_machine;
            $this->data['by_machine'] = $by_machine;
        }

        # Get gps data with condition
        $api_result = $this->rest->get('web/gps/index', $api_param, 'json');
        $api_status = $this->rest->status();
        if ( isset($api_result->status) AND ($api_result->status == REST_STATUS_SUCCESS) AND (isset($api_result->data)) AND (!empty($api_result->data)) ) {
            $gps = $api_result->data;
        }
        $this->data['gps'] = $gps;

        # GPS data for javascript
        $gps_data = array();
        foreach ($gps as $key => $value) {
            $worker_info = isset($workers[$value->id_worker]) ? $workers[$value->id_worker] : false;
            $item = array(
                'worker'    => $worker_info ? $worker_info->first_name . ' ' . $worker_info->last_name : '',
                'starttime' => '',
                'endtime'   => '',
                'date'      => date('d.m.Y', strtotime($value->ontime)),
                'position'  => $this->_position_process($value->position)
            );
            $gps_data[$value->id] = $item;
        }
        $this->data['gps_position_data'] = $gps_data;

        # View
        $this->view = 'winterdienst/index';
    }

    function detail() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $linestring = trim($this->input->post('linestring'));
            $gps        = intval($this->input->post('gps'));
            $return     = array();
            $linestring_array = explode('(', $linestring);
            if ( is_array($linestring_array) AND (count($linestring_array) > 1) ) {
                switch ($linestring_array[0]) {
                    case 'LINESTRING':
                        $data = trim(trim($linestring_array[1], ')'));
                        $data = explode(',', $data);
                        if (!empty($data)) {
                            foreach ($data as $key => $value) {
                                $item     = explode(' ', trim($value));
                                $item[]   = $gps;
                                $return[] = $item;
                            }
                        }
                        break;

                    default:
                        # code...
                        break;
                }
            }
            /*$return = array(
                array('105.825', '21.039'),
                array('105.828', '21.033'),
            );*/
            echo json_encode($return);
            $this->view   = FALSE;
            $this->layout = FALSE;
        } else {
            redirect(create_url('sys/winterdienst'));
        }
    }

    function information($id_worker_gps = 0) {
        $id_worker_gps = intval($id_worker_gps);
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id_worker_gps = 1;
            if ($id_worker_gps > 0) {
                $api_param  = array(
                    'id_worker_gps' => $id_worker_gps
                );
                $api_result = $this->rest->get('web/infor/index', $api_param, 'json');
                $api_status = $this->rest->status();
                $message = array();
                $voice = array();
                $image = array();
                $video = array();
                if ( isset($api_result->status) AND ($api_result->status == REST_STATUS_SUCCESS) AND (isset($api_result->data)) AND (!empty($api_result->data)) ) {
                    $data = $api_result->data;
                    foreach ($data as $value)
                    {
                    	$item = array(
                    			'id' 			=> $value->id,
                    			'id_city' 		=> $value->id_city,
                    			'id_config' 	=> $value->id_config,
                    			'id_worker_gps' => $value->id_worker_gps,
                    			'type' 			=> $value->type,
                    			'data' 			=> $value->data,
                    			'updated_at' 	=> $value->updated_at,
                    			'created_at' 	=> $value->created_at,
                    			'ontime' 		=> $value->ontime
                    	);
                    	switch ($value->type)
                    	{
                    		case INFO_MESSAGE:
                    			array_push($message,$item);
                    			break;
                    		case INFO_VOICE:
                    			array_push($voice,$item);
                    			break;
                    		case INFO_IMAGE:
                    			array_push($image,$item);
                    			break;
                    		case INFO_VIDEO:
                    			array_push($video,$item);
                    			break;
                    		default:
                    			break;
                    	}
                    }
                }
                $this->data['message'] = $message;
                $this->data['voice'] = $voice;
                $this->data['image'] = $image;
                $this->data['video'] = $video;
                $this->layout = false;
                $this->view   = 'winterdienst/information';
            } else {
                die('Err');
            }
        } else {
            $return = array();
            $api_param = array(
                'id_worker_gps' => $id_worker_gps
            );
            $api_result = $this->rest->get('web/infor/index', $api_param, 'json');
            $api_status = $this->rest->status();
            if ( isset($api_result->status) AND ($api_result->status == REST_STATUS_SUCCESS) ) {
                $return = array(
                    'status' => true,
                    'data'   => array(
                        'message' => $api_result->message,
                        'video' => $api_result->video,
                        'image' => $api_result->image,
                        'voice' => $api_result->voice,
                    )
                );
            } else {
                $return = array(
                    'status' => false
                );
            }

            echo json_encode($return);
        }
    }

    function _information_detail($id = 0) {
    }

    function _position_process($linestring) {
        $linestring_array = explode('(', $linestring);
        $return           = array();
        if ( is_array($linestring_array) AND (count($linestring_array) > 1) ) {
            switch ($linestring_array[0]) {
                case 'LINESTRING':
                    $data = trim(trim($linestring_array[1], ')'));
                    $data = explode(',', $data);
                    if (!empty($data)) {
                        foreach ($data as $key => $value) {
                            $item     = explode(' ', trim($value));
                            $return[] = $item;
                        }
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }
        return $return;
    }
}