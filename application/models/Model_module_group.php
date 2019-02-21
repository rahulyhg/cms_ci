<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_module_group extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getListGroup($cond = null){
		$query		= "SELECT '', module_group_id, module_group_name, module_group_active_status, module_group_order_value, module_group_images,
					  DATE_FORMAT( module_group_create_date, '%d-%m-%Y %H:%i:%s' ) as module_group_create_date, module_group_create_by
					  FROM tbl_module_group ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getGroup($id = '')
	{
		$where = '';
		if($id != ''){
			$where = "WHERE module_group_id = ".$this->db->escape($id);
		}
		$sql	= "SELECT module_group_id, module_group_name, module_group_images, module_group_active_status FROM tbl_module_group $where ORDER BY module_group_id ASC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	function activeGroup($id)
	{
		$sql	= "UPDATE tbl_module_group SET module_group_active_status = abs(module_group_active_status-1) WHERE module_group_id = ".$this->db->escape($id);	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function deleteGroup($id = '')
	{
		$sql	= "DELETE FROM tbl_module_group WHERE module_group_id = ".$this->db->escape($id);	
		$query	= $this->db->query($sql);
		
		$str = $this->db->last_query();
		
		return $str;
	}
	
	function deleteSelectedGroup($id = '')
	{
		
		$pisah_kata  = explode("-",$id);
		$jml_katakan = (integer)count($pisah_kata);
		
		for($i=0;$i<$jml_katakan;$i++) {
			$pisah_kata[$i] = trim($pisah_kata[$i]);
			
			$sql	= "DELETE FROM tbl_module_group WHERE module_group_id = $pisah_kata[$i]";	
			$query	= $this->db->query($sql);
		}
		
		return $query;
	}
	
	function checkGroup($groupname){
		$sql	= "SELECT * FROM tbl_module_group WHERE module_group_name = ".$this->db->escape($groupname);
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 

		return $rs;
	}
	
	function insertGroup($groupname)
	{
		$sql	= "INSERT INTO tbl_module_group SET 
					module_group_name = ".$this->db->escape($groupname).",
					module_group_active_status = 0, 
					module_group_create_by = ".$_SESSION['admin_data']['user_id'].", module_group_create_date = now()";	
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;

	}
	
	function updateGroup($id,$groupname)
	{
		$sql	= "UPDATE tbl_module_group SET 
				   module_group_name = ".$this->db->escape($groupname).",
				   module_group_update_by = ".$_SESSION['admin_data']['user_id'].", module_group_update_date=now() 
				   WHERE module_group_id = ".$this->db->escape($id);	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function updateOrderGroup($id,$order)
	{
		$sql	= "UPDATE tbl_module_group SET 
				   module_group_order_value= ".$order.",
				   module_group_update_by = ".$_SESSION['admin_data']['user_id'].", module_group_update_date=now() WHERE module_group_id = ".$this->db->escape($id);	
		$query	= $this->db->query($sql);
		
		return $query;
	}
}