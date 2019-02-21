<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_accessprivilege extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getListModulePrivilege($moduleid, $privilegeid){
		$query		= "SELECT module_id, privilege_id
					  FROM tbl_module_privilege
					  WHERE module_id = ".$moduleid." AND privilege_id = ".$privilegeid;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getListAccessPrivilege($userlevelid, $moduleid){
		$query		= "SELECT a.privilege_id, privilege_name, b.access_id, b.access_privilege_status
					  FROM tbl_privilege a
					  INNER JOIN tbl_access_privilege b ON a.privilege_id = b.privilege_id
					  INNER JOIN tbl_access c ON b.access_id = c.access_id
					  WHERE c.user_level_id = ".$userlevelid." AND c.module_id = ".$moduleid."
					  ORDER BY a.privilege_id";
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
}