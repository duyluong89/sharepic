<?php
class home extends MY_Controller{
	protected $models  = array("pic");
	function __construct(){
		parent::__construct();
		
		//$this->load->model("pic/pic_model","pic");
	}
	
	function index(){
		
		$this->data['pics']  = $this->pic->get_all();
		/* Load view**/
		$this->view ="home/index";
		$this->layout = "layouts/index";
	}
}