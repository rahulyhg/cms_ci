<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_access extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getListPrivilege($cond = null){
		$query		= "SELECT privilege_id, privilege_name
					  FROM tbl_privilege ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getListModulePrivilege($cond = null){
		$query		= "SELECT a.module_id, module_name, module_path, module_active_status, module_order_value,
					  DATE_FORMAT( module_create_date, '%d-%m-%Y %H:%i:%s' ) as module_create_date, module_create_by,
					  b.module_group_id, module_group_name 
					  FROM tbl_module a INNER JOIN tbl_module_group b
					  ON a.module_group_id = b.module_group_id
					  ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getListModuleAccessPrivilege($cond = null){
		$query		= "SELECT a.module_id, module_name, module_path, module_active_status, module_order_value,
					  b.module_group_id, module_group_name, c.user_level_id, c.access_id, c.access_active_status
					  FROM tbl_module a INNER JOIN tbl_module_group b
					  ON a.module_group_id = b.module_group_id
					  INNER JOIN tbl_access c ON a.module_id = c.module_id
					  ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getListAccessPrivilege($cond = null){
		$query		= "SELECT a.privilege_id, access_id, b.privilege_name, access_privilege_status, a.access_privilege_id
					  FROM tbl_access_privilege a INNER JOIN tbl_privilege b
					  ON a.privilege_id = b.privilege_id
					  ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getListPrivilegeModule($moduleid, $privilegeid){
		$query		= "SELECT module_privilege_id, module_id, privilege_id
					  FROM tbl_module_privilege WHERE module_id = ".$moduleid." AND privilege_id = ".$privilegeid."";
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function insertAccess($userlevelid,$moduleid){
		$sql	= "INSERT INTO tbl_access SET user_level_id=".$userlevelid.", module_id=".$moduleid.", 
					access_active_status = 1,
					access_create_by = ".$_SESSION['admin_data']['user_id'].", access_create_date = now()";	
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;

	}
	
	function insertAccessPrivilege($userlevelid,$moduleid){
		$sql	= "INSERT INTO tbl_access_privilege SET access_id=".$userlevelid.", privilege_id=".$moduleid."";	
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;

	}
	
	function activeAccessPrivilege($id)
	{
		$sql	= "UPDATE tbl_access_privilege SET access_privilege_status = abs(access_privilege_status-1) WHERE access_privilege_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function getListAccess($userlevelid, $moduleid){
		$query		= "SELECT access_id, user_level_id, b.module_id, b.module_name, c.module_group_id, c.module_group_name
					  FROM tbl_access a
					  INNER JOIN tbl_module b ON a.module_id = b.module_id
					  INNER JOIN tbl_module_group c ON b.module_group_id = c.module_group_id
					  WHERE user_level_id = ".$userlevelid." AND b.module_id = ".$moduleid;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getAccess($userlevelid,$moduleid)
	{
		$query		= "SELECT access_id, user_level_id, module_id
					  FROM tbl_access 
					  WHERE user_level_id = ".$userlevelid." AND module_id = ".$moduleid;
	
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function deleteAccess($userlevelid){
		$sql	= "DELETE FROM tbl_access WHERE user_level_id=".$userlevelid;	
		$query	= $this->db->query($sql);
		
		return $query;

	}
	
	function deleteAccessPrivilege($accessid){
		$sql	= "DELETE FROM tbl_access_privilege WHERE access_id=".$accessid;	
		$query	= $this->db->query($sql);
		
		return $query;

	}
}