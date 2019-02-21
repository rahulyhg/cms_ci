<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_logcms extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getListLogCMS($cond = null){
		/* $query		= "SELECT log_id_cms, log_module, log_value, 
					   DATE_FORMAT( log_create_date, '%d-%m-%Y %H:%i:%s' ) as log_create_date,
					   a.user_id, b.user_name
					   FROM tbl_log_cms a
					   INNER JOIN tbl_user b ON a.user_id = b.user_id
					   ".$cond; */
		$query		= "SELECT '', log_id_cms, log_module, log_value, 
					   b.user_name, DATE_FORMAT( log_create_date, '%d-%m-%Y %H:%i:%s' ) as log_create_date
					   FROM tbl_log_cms a
					   INNER JOIN tbl_user b ON a.user_id = b.user_id
					   ".$cond;			   
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function insertLogCMS($log_module,$log_value)
	{
		$sql	= "INSERT INTO tbl_log_cms SET log_module='".$log_module."', log_value='".$log_value."',
					ip = '".$this->input->ip_address()."',
					user_id = ".$_SESSION['admin_data']['user_id'].", log_create_date = now()";	
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;

	}
}