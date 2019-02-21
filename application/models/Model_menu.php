<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_menu extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getMenuModuleGroup(){
		$sql	= "SELECT a.module_group_id, module_group_name, module_group_active_status, module_group_order_value, module_group_images
				   FROM tbl_module_group a
				   INNER JOIN tbl_module b ON a.module_group_id = b.module_group_id
				   WHERE module_group_active_status = 1 AND a.module_group_id <> 1 
				   GROUP BY a.module_group_order_value ASC, a.module_group_id DESC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;
	}
	
	function getMenuModule($modulegroupid){
		$sql		= "SELECT module_id, module_name, module_path, module_active_status, module_order_value
					  FROM tbl_module WHERE module_group_id = ".$this->db->escape_str($modulegroupid)." AND module_active_status = 1 ORDER BY module_order_value ASC, module_id ASC";
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;
	}
	
	function getMenuModuleGroupAccessUserLevel($userlevelid,$modulegroupid){
		$sql		= "SELECT a.user_level_id, a.access_id, a.module_id, c.module_group_id
					   FROM tbl_access a
					   INNER JOIN tbl_module b ON a.module_id = b.module_id
					   INNER JOIN tbl_module_group c ON b.module_group_id = c.module_group_id
					   WHERE a.user_level_id = ".$this->db->escape_str($userlevelid)." AND c.module_group_id = ".$this->db->escape_str($modulegroupid)." AND a.access_active_status = 1
					   GROUP BY c.module_group_id";
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;
	}
	
	function getMenuModuleAccessUserLevel($userlevelid, $modulegroupid, $moduleid){
		$sql		= "SELECT a.access_id, a.module_id, a.user_level_id, b.privilege_id, b.access_privilege_status
					   FROM tbl_access a
					   INNER JOIN tbl_access_privilege b ON a.access_id = b.access_id
					   INNER JOIN tbl_module c ON a.module_id = c.module_id
					   WHERE a.user_level_id= ".$this->db->escape_str($userlevelid)." AND a.module_id = ".$this->db->escape_str($moduleid)." AND
					   c.module_group_id = ".$this->db->escape_str($modulegroupid)." AND b.privilege_id = 1";

		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;
	}
}