<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_signin extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

	function cekAdminLogin($email, $password){	
		$rs = array();

		$sql				= "SELECT user_pass FROM tbl_user WHERE user_name = ".$this->db->escape($email)." OR user_email = ".$this->db->escape($email)."";	
		$query 				= $this->db->query($sql);
		$pass_db			= $query->result_array();
		$password_verify 	= isset($pass_db[0]['user_pass'])?$pass_db[0]['user_pass']:"";

		if(!empty($password_verify)){
			if (password_verify($password, $password_verify)) {
				$sql	= "SELECT a.user_id, a.user_name, a.user_level_id, a.user_email, a.user_create_date, b.user_level_name, a.user_avatar,
					   DATE_FORMAT( a.user_create_date, '%M, %Y' ) as user_create_date
					   FROM tbl_user a INNER JOIN tbl_user_level b ON a.user_level_id = b.user_level_id
					   WHERE (a.user_name = ".$this->db->escape($email)." OR a.user_email = ".$this->db->escape($email).") AND user_active_status = 1";
				$query	= $this->db->query($sql);
				$rs		= $query->result_array(); 
			}
		}

		return $rs;	
	}
	
	function cekAdminLoginCookies($userid){
		$sql	= "SELECT a.user_id, a.user_name, a.user_level_id, a.user_email, a.user_create_date, b.user_level_name, a.user_avatar, 
				   DATE_FORMAT( a.user_create_date, '%M, %Y' ) as user_create_date
				   FROM tbl_user a INNER JOIN tbl_user_level b ON a.user_level_id = b.user_level_id
				   WHERE a.user_id = ".$this->db->escape($userid)." AND user_active_status = 1";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
}