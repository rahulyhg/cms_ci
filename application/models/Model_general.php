<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_general extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getAllGrid($start,$limit,$sidx,$sord,$where){
		$query		= "SELECT general_id, general_title, general_description, general_keyword, general_cs_phonenumber, general_twitter, general_cs_email
					  FROM tbl_general
					  WHERE 1 = 1 ".$where." ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
		$query		= $this->db->query($query)->result();
		
		return $query;
	}
	
	function getCountAllGrid($where){
		$query		= "SELECT general_id, general_title, general_description, general_keyword, general_cs_phonenumber, general_twitter, general_cs_email
					  FROM tbl_general 
					  WHERE 1 = 1 ".$where;
		$count		= $this->db->query($query)->num_rows();
		
		return $count;
	}
	
	function getListGeneral($cond = null){
		$query		= "SELECT general_id, general_title, general_description, general_keyword, general_facebook, general_twitter, general_cs_phonenumber, general_cs_email
					  FROM tbl_general ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getGeneral($id = '')
	{
		$where = '';
		if($id != ''){
			$where = "WHERE general_id = ".$id;
		}
		$sql	= "SELECT general_id, general_title, general_description, general_keyword, general_facebook, general_twitter, general_cs_phonenumber, general_cs_email
					FROM tbl_general $where ORDER BY general_id ASC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	
	function updateGeneral($id,$generaltitle,$generaldescription,$generalkeywords,$generalfacebook,$generaltwitter,$generalcsphonenumber,$generalcsemail)
	{
		$sql	= "UPDATE tbl_general SET 
				   general_title='".$generaltitle."', 
				   general_description='".$generaldescription."', 
				   general_keyword='".$generalkeywords."',
				   general_facebook='".$generalfacebook."',
				   general_twitter='".$generaltwitter."',
				   general_cs_phonenumber='".$generalcsphonenumber."',
				   general_cs_email='".$generalcsemail."',
				   general_update_by = ".$_SESSION['admin_data']['user_id'].",
				   general_update_date = NOW()
				   WHERE general_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
}