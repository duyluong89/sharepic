<?php
class pictures extends MY_Controller{
	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->data['pics']  = $this->pic->get("status",1);
		$this->view ="home/index";
		$this->layout = "layouts/index";
	}
}