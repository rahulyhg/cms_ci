<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alias extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getListAlias($cond = null){
		$query		= "SELECT alias_id, alias_category, key_id, web_alias, web_ori, alias_active_status
					  DATE_FORMAT( alias_create_date, '%d-%m-%Y %H:%i:%s' ) as alias_create_date
					  FROM tbl_alias ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function checkAlias($alias){
		$sql	= "SELECT web_alias FROM tbl_alias WHERE web_alias = '".$alias."'";
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;
	}
	
	function checkAliasCategory($alias,$category){
		$sql	= "SELECT web_alias FROM tbl_alias WHERE alias_category = '".$category."' AND web_alias = '".$alias."'";
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;
	}
	
	function getPages()
	{
		$sql	= "SELECT pages_id, pages_title, pages_alias FROM tbl_pages WHERE pages_active_status = 1 ORDER BY pages_id ASC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	function insertAlias($id,$category,$alias,$original)
	{
		$sql	= "INSERT INTO tbl_alias SET alias_category='".$category."', key_id=".$id.",
					web_alias='".$alias."', web_ori='".$original."',
					alias_active_status = 1, 
					alias_create_date = now()";	
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;

	}
	
	function updateAlias($id,$alias,$alias_category)
	{
		$sql	= "UPDATE tbl_alias SET 
				   web_alias='".$alias."',
				   alias_update_date=now() 
				   WHERE key_id = ".$id." AND alias_category = '".$alias_category."'";	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function deleteAlias($id,$alias_category)
	{
		$sql	= "DELETE FROM tbl_alias WHERE key_id = ".$id." AND alias_category = '".$alias_category."'";	
		$query	= $this->db->query($sql);
		
		return $query;
	}
}