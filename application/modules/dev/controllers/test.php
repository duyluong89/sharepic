<?php
class test extends CI_Controller
{
	function insert()
	{
		# Header response as JSON
		header('Content-Type: application/json');
		
		# Init API server
		$this->rest->initialize(array('server' => config_item('api_web')));
		$api_param = array(
				'table' 	=> 'activities',
				'models' 	=> json_encode(array(
						'id_city'=>1,
						'name'=>'activity-test-222',
						'color'=>'blue',
						'created_at'=>date('Y-m-d H:i:s')
				))
		);
		$api_result = $this->rest->post('web/kendoui/index', $api_param, 'json');
		echo $api_result->data;
	}
	
	function update(){
		# Header response as JSON
		header('Content-Type: application/json');
		
		# Init API server
		$this->rest->initialize(array('server' => config_item('api_web')));
		$api_param = array(
				'key'	=> 'id',
				'table' 	=> 'activities',
				'models' 	=> json_encode(array(
							'id'		=> 46,
							'id_city'	=>1,
							'name'		=>'activity-test-22put2',
							'color'		=>'blue',
							'created_at'=>date('Y-m-d H:i:s')
						))
		);
		$api_result = $this->rest->put('web/kendoui/index', $api_param, 'json');
		echo $api_result->data;
	}
}
?>