<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_userlevel extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getListUserLevel($cond = null){
		$query		= "SELECT '', user_level_id, user_level_name, user_level_active_status, user_level_desc,
					  DATE_FORMAT( user_level_create_date, '%d-%m-%Y %H:%i:%s' ) as user_level_create_date, user_level_create_by
					  FROM tbl_user_level ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getUserLevel($id = '')
	{
		$where = '';
		if($id != ''){
			$where = "WHERE user_level_id = ".$this->db->escape($id);
		}
		$sql	= "SELECT user_level_id, user_level_name, user_level_desc, user_level_active_status FROM tbl_user_level $where ORDER BY user_level_id ASC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	function activeUserLevel($id)
	{
		$sql	= "UPDATE tbl_user_level SET user_level_active_status = abs(user_level_active_status-1) WHERE user_level_id = ".$this->db->escape($id);	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function deleteUserLevel($id = '')
	{
		$sql	= "DELETE FROM tbl_user_level WHERE user_level_id = ".$this->db->escape($id);	
		$query	= $this->db->query($sql);
		
		$str = $this->db->last_query();
		
		return $str;
	}
	
	function deleteSelectedUserLevel($id = '')
	{
		
		$pisah_kata  = explode("-",$id);
		$jml_katakan = (integer)count($pisah_kata);
		
		for($i=0;$i<$jml_katakan;$i++) {
			$pisah_kata[$i] = trim($pisah_kata[$i]);
			
			$sql	= "DELETE FROM tbl_user_level where user_level_id = $pisah_kata[$i] and user_level_id != 1";	
			$query	= $this->db->query($sql);
		}
		
		return $query;
	}
	
	function checkUserLevel($userlevelname){
		$sql	= "SELECT * FROM tbl_user_level WHERE user_level_name = ".$this->db->escape($userlevelname);
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 

		return $rs;
	}
	
	function insertUserLevel($userlevelname,$userleveldesc)
	{
		$sql	= "INSERT INTO tbl_user_level SET 
					user_level_name = ".$this->db->escape($userlevelname).",
					user_level_desc = ".$this->db->escape($userleveldesc).", 
					user_level_active_status = 0, 
					user_level_create_by = ".$_SESSION['admin_data']['user_id'].", user_level_create_date = now()";	
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;

	}
	
	function updateUserLevel($id,$user_level_name,$userleveldesc)
	{
		$sql	= "UPDATE tbl_user_level SET 
				   user_level_name = ".$this->db->escape($user_level_name).", 
				   user_level_desc = ".$this->db->escape($userleveldesc).", 
				   user_level_update_by = ".$_SESSION['admin_data']['user_id'].", user_level_update_date=now() WHERE user_level_id = ".$this->db->escape($id);	
		$query	= $this->db->query($sql);
		
		return $query;
	}
}