<?php
class pic_model extends MY_Model{
	protected $table = "picture";
	protected $primary_key = "id";
	protected $result_mode = "object";
	protected $fields = array("id", "title", "title", "pic","thumb", "cattegory","views","likeId","commentId","create_at","status");
	
	public $before_create = array('timestamps');
	
	function timestamps($pic) {
		$pic['created_at'] = date('Y-m-d H:i:s');
		return $pic;
	}
}