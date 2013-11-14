<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Home Controller
 * @author chientran <tran.duc.chien@kloon.vn>
 * @created 1 Nov 2013
 */
class Home extends MY_Controller {
    public function __construct() {
        parent::__construct();

        # Breakcrumbs
        #$this->breadcrumb->append_crumb('Home', base_url());
    }

	public function index()
	{
        $this->view = 'home/index';
	}

    function test() {
        // Run some setup
        $this->rest->initialize(array('server' => config_item('api_web')));

        // Pull in an array of tweets
        $api_param = array(
            'username' => 'admin',
            'password' => '123456'
        );

        # Call API. Available method :
        #   -> $this->rest->post
        #   -> $this->rest->get
        #   -> $this->rest->put
        #   -> $this->rest->delete
        $api_results = $this->rest->post('validate_code', $api_param, 'json');

        # Debug request
        $this->rest->debug();
    }

    function mail() {
        var_dump(mail('saobang_8908@yahoo.com.vn', 'Test email', 'Hello'));
    }

    function language() {
        #$this->load->helper('language');
        echo lang('email_format');
    }
}