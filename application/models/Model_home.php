<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_home extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
	
	function getPassword(){
		$sql	= "SELECT user_pass FROM tbl_user WHERE 
				   user_id = ".$_SESSION['admin_data']['user_id'];	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	function updatePassword($password){
		$password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 15]);

		$sql	= "UPDATE tbl_user SET user_pass = '".$this->db->escape_str($password)."', 
				  user_update_by = ".$_SESSION['admin_data']['user_id'].", 
				  user_update_date=now() WHERE 
				  user_id = ".$_SESSION['admin_data']['user_id'];	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function getMenuModuleGroupAccessUserLevel($userlevelid){
		$sql		= "SELECT a.user_level_id, a.access_id, a.module_id, c.module_group_id
					   FROM tbl_access a
					   INNER JOIN tbl_module b ON a.module_id = b.module_id
					   INNER JOIN tbl_module_group c ON b.module_group_id = c.module_group_id
					   WHERE a.user_level_id = ".$this->db->escape_str($userlevelid)." AND a.access_active_status = 1
					   GROUP BY c.module_group_id";
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;
	}
	
	function getProfile($userid){
		$sql	= "SELECT user_id, user_name, user_email, user_avatar
				   FROM tbl_user WHERE 
				   user_id = ".$userid;	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	function updateProfile($userid,$username,$email,$avatar){
		$sql	= "UPDATE tbl_user SET 
				  user_name = '".$this->db->escape_str($username)."', 
				  user_email = '".$this->db->escape_str($email)."', 
				  user_avatar = '".$this->db->escape_str($avatar)."', 
				  user_update_by = ".$_SESSION['admin_data']['user_id'].", 
				  user_update_date=now() WHERE 
				  user_id = ".$userid;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
}