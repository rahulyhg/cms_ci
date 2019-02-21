<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_module extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getListModule($cond = null){
		$query		= "SELECT '', module_id, module_name, module_path, module_active_status, module_order_value,
					  DATE_FORMAT( module_create_date, '%d-%m-%Y %H:%i:%s' ) as module_create_date, module_create_by,
					  b.module_group_id, module_group_name 
					  FROM tbl_module a INNER JOIN tbl_module_group b
					  ON a.module_group_id = b.module_group_id
					  ".$cond;
		//echo $query."<br><br>"; 
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getModule($id = '')
	{
		$where = '';
		if($id != ''){
			$where = "WHERE module_id = ".$id;
		}
		$sql	= "SELECT module_id, module_name, module_path, module_group_id, module_active_status FROM tbl_module $where ORDER BY module_id ASC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	function activeModule($id)
	{
		$sql	= "UPDATE tbl_module SET module_active_status = abs(module_active_status-1) WHERE module_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function deleteModule($id = '')
	{
		$sql	= "DELETE FROM tbl_module WHERE module_id = ".$id;	
		$query	= $this->db->query($sql);
		
		$str = $this->db->last_query();
		
		return $str;
	}
	
	function deleteSelectedModule($id = '')
	{
		
		$pisah_kata  = explode("-",$id);
		$jml_katakan = (integer)count($pisah_kata);
		
		for($i=0;$i<$jml_katakan;$i++) {
			$pisah_kata[$i] = trim($pisah_kata[$i]);
			
			$sql	= "DELETE FROM tbl_module WHERE module_id = $pisah_kata[$i]";	
			$query	= $this->db->query($sql);
		}
		
		return $query;
	}
	
	function checkModule($modulename,$modulegroupid){
		$sql	= "SELECT * FROM tbl_module WHERE module_name = '".$modulename."' AND module_group_id = ".$modulegroupid;
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 

		return $rs;
	}
	
	function insertModule($modulename,$modulepath,$modulegroupid){
		$sql	= "INSERT INTO tbl_module SET 
					module_name='".$modulename."',
					module_path='".$modulepath."',
					module_group_id=".$modulegroupid.",
					module_active_status = 0, 
					module_create_by = ".$_SESSION['admin_data']['user_id'].", module_create_date = now()";	
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;

	}
	
	function updateModule($id,$modulename,$modulepath,$modulegroupid)
	{
		$sql	= "UPDATE tbl_module SET 
				   module_name='".$modulename."',
				   module_path='".$modulepath."',
				   module_group_id=".$modulegroupid.",
				   module_create_by = ".$_SESSION['admin_data']['user_id'].", module_create_date=now() WHERE module_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function getListModulePrivilege($cond = null){
		$query		= "SELECT a.module_privilege_id, a.module_id, b.privilege_id, b.privilege_name
					  FROM tbl_module_privilege a
					  INNER JOIN tbl_privilege b ON a.privilege_id = b.privilege_id
					  ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getPrivilege($id = ''){
		$where = '';
		if($id != ''){
			$where = "WHERE privilege_id = ".$id;
		}
		$sql	= "SELECT privilege_id, privilege_name FROM tbl_privilege $where ORDER BY privilege_id ASC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	function deleteModulePrivilege($id){
		$sql	= "DELETE FROM tbl_module_privilege WHERE module_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function insertModulePrivilege($moduleid,$privilegeid){
		$sql	= "INSERT INTO tbl_module_privilege SET 
					module_id=".$moduleid.",
					privilege_id=".$privilegeid.",
					module_privilege_create_by = ".$_SESSION['admin_data']['user_id'].", module_privilege_create_date = now()";	
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;

	}
	
	function deleteModulePrivilegeOne($id){
		$sql	= "DELETE FROM tbl_module_privilege WHERE module_privilege_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function deleteSelectedPrivilege($id = ''){
		$pisah_kata  = explode("-",$id);
		$jml_katakan = (integer)count($pisah_kata);
		
		for($i=0;$i<$jml_katakan;$i++) {
			$pisah_kata[$i] = trim($pisah_kata[$i]);
			
			$sql	= "DELETE FROM tbl_module_privilege where module_privilege_id = ".$pisah_kata[$i];	
			$query	= $this->db->query($sql);
		}
		
		return $query;
	}
	
	function updateOrderModule($id,$order)
	{
		$sql	= "UPDATE tbl_module SET 
				   module_order_value= ".$order.",
				   module_update_by = ".$_SESSION['admin_data']['user_id'].", module_update_date=now() WHERE module_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
}