<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_user extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getListUser($cond = null){
		$query		= "SELECT '', user_id, user_name, user_active_status, user_email,
					  DATE_FORMAT( user_create_date, '%d-%m-%Y %H:%i:%s' ) as user_create_date, user_create_by,
					  b.user_level_id, user_level_name 
					  FROM tbl_user a INNER JOIN tbl_user_level b 
					  ON a.user_level_id = b.user_level_id ".$cond;
		$query		= $this->db->query($query)->result_array();

		return $query;
	}
	
	function activeUser($id){
		$sql	= "UPDATE tbl_user SET user_active_status = abs(user_active_status-1) WHERE user_id = ".$this->db->escape($id);	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function deleteUser($id = ''){
		$sql	= "DELETE FROM tbl_user WHERE user_id = ".$this->db->escape($id);	
		$query	= $this->db->query($sql);
		
		$str = $this->db->last_query();
		
		return $str;
	}
	
	function deleteSelectedUser($id = ''){
		
		$pisah_kata  = explode("-",$id);
		$jml_katakan = (integer)count($pisah_kata);
		
		for($i=0;$i<$jml_katakan;$i++) {
			$pisah_kata[$i] = trim($pisah_kata[$i]);
			
			$sql	= "DELETE FROM tbl_user where user_id = $pisah_kata[$i] and user_id != 1";	
			$query	= $this->db->query($sql);
		}
		
		return $query;
	}
	
	function checkUser($username){
		$sql	= "SELECT * FROM tbl_user WHERE user_name = ".$this->db->escape($username);
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 

		return $rs;
	}
	
	function checkUserEmail($email){
		$sql	= "SELECT * FROM tbl_user WHERE user_email = ".$this->db->escape($email);
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 

		return $rs;
	}
	
	function insertUser($userlevelid,$username,$email,$password){
		$password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 15]);

		$sql	= "INSERT INTO tbl_user SET 
					user_name = ".$this->db->escape($username).", 
					user_level_id = ".$this->db->escape($userlevelid).", 
					user_active_status = 0, 
					user_email= ".$this->db->escape($email).", 
					user_pass = '".$password."',
					user_create_by = ".$_SESSION['admin_data']['user_id'].", user_create_date = now()";	
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;

	}
	
	function getUser($id = ''){
		$where = '';
		if($id != ''){
			$where = "WHERE user_id = ".$this->db->escape($id);
		}
		$sql	= "SELECT user_id, user_name, user_active_status, user_email, user_level_id FROM tbl_user $where ORDER BY user_id ASC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	function updateUser($id,$username,$email,$userlevelid){
		$sql	= "UPDATE tbl_user SET 
				   user_name = ".$this->db->escape($username).",
				   user_email = ".$this->db->escape($email).",
				   user_level_id = ".$this->db->escape($userlevelid).",
				   user_create_by = ".$_SESSION['admin_data']['user_id'].", user_create_date=now() WHERE user_id = ".$this->db->escape($id);	
		$query	= $this->db->query($sql);
		
		return $query;
	}
}