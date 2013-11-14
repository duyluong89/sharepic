<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User Controller
 * @author chientran <tran.duc.chien@kloon.vn>
 * @created 11 Nov 2013
 */

class Company extends MY_Controller {
    private $_id_city     = 1;
    private $_limit       = 10;
    private $_offset      = 0;
    private $_edit_flag   = false;

    public function __construct() {
        parent::__construct();

        # Init API server
        $this->rest->initialize(array('server' => config_item('api_web')));

        # Breakcrumbs
        $this->breadcrumb->append_crumb('User', create_url('sys/user'));
    }

    function index() {
        if ($this->input->is_ajax_request()) {
            $this->_process();
            return;
        }

        # View
        $this->data['limit'] = $this->_limit;
        $this->view          = 'company/index';
    }

    function add() {
        $this->_update();
    }

    function edit($id = 0) {
        $this->_edit_flag = true;
        $this->_update($id);
    }

    function _update($id = NULL) {
        if (!$this->input->is_ajax_request()) {
            redirect(create_url('sys/user'));
        }

        # Libs
        $this->load->library('form_validation');

        if (!is_null($id)) {
            $id = intval($id);
            if ($id > 0) {
                $this->data['id'] = $id;
            } else {
                $id = 0;
            }
        }
        $id = 1;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            # Post data
            $username = trim($this->input->post('username'));
            $email    = trim($this->input->post('email'));
            $group    = intval($this->input->post('group'));
            $company  = intval($this->input->post('company'));

            # Validation
            $this->form_validation->set_rules('username', 'Username', 'required|alpha_dash');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('group', 'Group', 'required|is_natural_no_zero');
            $this->form_validation->set_rules('company', 'Company', 'required|is_natural_no_zero');
            if ($this->form_validation->run() === TRUE) {
                $api_param   = array(
                    'id'       => $id,
                    'username' => $username,
                    'email'    => $email,
                    'group'    => $group,
                    'company'  => $company,
                );

                if ($this->_edit_flag) {
                    $api_param['id'] = $id;
                    $api_results = $this->rest->put('web/user', $api_param, 'json');
                } else {
                    $api_results = $this->rest->post('web/user', $api_param, 'json');
                }
                $api_status  = $this->rest->status();
                if ( isset($api_results->status) AND ($api_results->status == REST_STATUS_SUCCESS) ) {
                    $this->data['msg'] = 'User information has been saved';
                }
            }
        }

        # Data
        if ($this->_edit_flag) {
            $api_param = array(
                'id' => $id
            );
            $api_results = $this->rest->get('web/user', $api_param, 'json');
            $api_status  = $this->rest->status();
            if ( isset($api_results->data) AND !empty($api_results->data) ) {
                $data               = $api_results->data;
                $this->data['data'] = $data[0];
            }
        }

        # Company
        $company = array();
        $api_param = array(
            'id_city' => $this->_id_city
        );
        $api_results = $this->rest->get('web/company/index', $api_param, 'json');
        $api_status  = $this->rest->status();
        if ( isset($api_results->data) AND !empty($api_results->data) ) {
            $data               = $api_results->data;
            $this->data['data'] = $data[0];
        }

        $this->layout = false;
        $this->view   = 'company/detail';
    }

    function delete($id = 0) {
        $return = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = intval($id);
            if ($id > 0) {
                $api_param = array(
                    'id' => $id
                );
                $api_results = $this->rest->delete('web/user', $api_param, 'json');
                if ( isset($api_results->status) AND ($api_results->status == REST_STATUS_SUCCESS) ) {
                    $return['status'] = true;
                    $return['msg']    = 'User has been deleted';
                } else {
                    $return['status'] = false;
                    $return['msg']    = 'Has an error when update database';
                }
            } else {
                $return['status'] = false;
            }
        } else {
            $return['status'] = false;
        }
        echo json_encode($return);
    }

    function _process() {
        # Header response as JSON
        header('Content-Type: application/json');

        # Init API server
        $this->rest->initialize(array('server' => config_item('api_web')));

        $api_param = json_decode(file_get_contents('php://input'), true);
        if (empty($api_param)) {
            $api_param = $_REQUEST;
        }

        $api_result = $this->rest->post('dev/kendoui/index', $api_param, 'json');
        $api_status = $this->rest->status();
        $api_result->request = $api_param;
        echo json_encode($api_result);
    }
}