<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_banner extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getAllGrid($start,$limit,$sidx,$sord,$where){
		$query		= "SELECT banner_id, banner_name, banner_images, banner_url, banner_type, banner_active_status, 
				      DATE_FORMAT( banner_create_date, '%d-%m-%Y %H:%i:%s' ) as banner_create_date, banner_create_by
					  FROM tbl_banner
					  WHERE 1 = 1 ".$where." ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
		$query		= $this->db->query($query)->result();
		
		return $query;
	}
	
	function getCountAllGrid($where){
		$query		= "SELECT banner_id, banner_name, banner_images, banner_url, banner_type, banner_active_status,
					  DATE_FORMAT( banner_create_date, '%d-%m-%Y %H:%i:%s' ) as banner_create_date, banner_create_by
					  FROM tbl_banner 
					  WHERE 1 = 1 ".$where;
		$count		= $this->db->query($query)->num_rows();
		
		return $count;
	}
	
	function getListBanner($cond = null){
		$query		= "SELECT banner_id, banner_name, banner_active_status, banner_images, banner_type, banner_url,
					  DATE_FORMAT( banner_create_date, '%d-%m-%Y %H:%i:%s' ) as banner_create_date, banner_create_by
					  FROM tbl_banner ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getBanner($id = '')
	{
		$where = '';
		if($id != ''){
			$where = "WHERE banner_id = ".$id;
		}
		$sql	= "SELECT banner_id, banner_name, banner_images, banner_type, banner_url, banner_active_status FROM tbl_banner $where ORDER BY banner_id ASC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	function activeBanner($id)
	{
		$sql	= "UPDATE tbl_banner SET banner_active_status = abs(banner_active_status-1) WHERE banner_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function deleteBanner($id = '')
	{
		$sql	= "DELETE FROM tbl_banner WHERE banner_id = ".$id;	
		$query	= $this->db->query($sql);
		
		$str = $this->db->last_query();
		
		return $str;
	}
	
	function checkBanner($bannername){
		$sql	= "SELECT * FROM tbl_banner WHERE banner_name = '".$bannername."'";
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 

		return $rs;
	}
	
	function insertBanner($bannername,$bannersimageurl,$bannertype,$bannerurl)
	{
		$sql	= "INSERT INTO tbl_banner SET banner_name='".$bannername."',
					banner_images = '".$bannersimageurl."',
					banner_type='".$bannertype."',
				    banner_url='".$bannerurl."',					
					banner_active_status = 0, 
					banner_create_by = ".$_SESSION['admin_data']['user_id'].", banner_create_date = now()";	
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;

	}
	
	function updateBanner($id,$bannername,$bannersimageurl,$bannertype,$bannerurl)
	{
		$sql	= "UPDATE tbl_banner SET 
				   banner_name='".$bannername."',
				   banner_images='".$bannersimageurl."',
				   banner_type='".$bannertype."',
				   banner_url='".$bannerurl."',
				   banner_update_by = ".$_SESSION['admin_data']['user_id'].", banner_update_date=now() WHERE banner_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
}