<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Worker Controller
 * @author chientran <tran.duc.chien@kloon.vn>
 * @created 1 Nov 2013
 */
class Worker extends MY_Controller {
    public function index() {
        // Run some setup
        $this->rest->initialize(array('server' => config_item('api_web')));

        // Pull in an array of tweets
        $api_param = array(
            'username' => 'admin',
            'password' => '123456'
        );
        $api_results = $this->rest->post('validate_code', $api_param, 'json');

        # View
        $this->data['result'] = $api_results;
        $this->view = 'worker/index';
	}
}