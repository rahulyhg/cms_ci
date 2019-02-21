<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pages extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function getListPages($cond = null){
		$query		= "SELECT pages_id, pages_title, pages_short_desc, pages_image, pages_desc, pages_active_status, pages_alias, pages_meta_description, pages_meta_keywords,
					  DATE_FORMAT( pages_create_date, '%d-%m-%Y %H:%i:%s' ) as pages_create_date, pages_create_by
					  FROM tbl_pages ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getListPagesAlias(){
		$query		= "SELECT pages_id, pages_title, pages_short_desc, pages_image, pages_desc, pages_meta_description, pages_meta_keywords,
						DATE_FORMAT( pages_create_date, '%d %M %Y' ) as pages_create_date,
						c.web_alias, c.web_ori
						FROM tbl_pages a
						INNER JOIN tbl_alias c ON a.pages_id = c.key_id 
						WHERE a.pages_active_status = 1 AND c.alias_category = 'pages' AND c.alias_active_status = 1
						ORDER BY pages_id DESC";
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getPages($id = ''){
		$where = '';
		if($id != ''){
			$where = "WHERE pages_id = ".$id;
		}
		$sql	= "SELECT pages_id, pages_title, pages_short_desc, pages_image, pages_desc, pages_alias, pages_meta_description, pages_meta_keywords, pages_active_status
				  FROM tbl_pages $where ORDER BY pages_id ASC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	function activePages($id){
		$sql	= "UPDATE tbl_pages SET pages_active_status = abs(pages_active_status-1),  
				   pages_update_date = now(), 
				   pages_update_by = ".$_SESSION['admin_data']['user_id']."
				   WHERE pages_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
	
	function deletePages($id = ''){
		$sql	= "DELETE FROM tbl_pages WHERE pages_id = ".$id;	
		$query	= $this->db->query($sql);
		
		$str = $this->db->last_query();
		
		return $str;
	}
	
	function checkPages($pagestitle){
		$sql	= "SELECT pages_title FROM tbl_pages WHERE pages_title = '".$pagestitle."'";
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 

		return $rs;
	}
	
	function insertPages($pagestitle,$pagesdesc,$pagesimageurl,$pagesalias,$pagesmetadescription,$pagesmetakeywords,$pagesshortdesc){

		$sql	= "INSERT INTO tbl_pages SET 
					pages_title='".$pagestitle."', 
					pages_short_desc='".$pagesshortdesc."', 
					pages_image='".$pagesimageurl."', 
					pages_alias ='".$pagesalias."', 
					pages_meta_description='".$pagesmetadescription."', 
					pages_meta_keywords='".$pagesmetakeywords."', 
					pages_active_status = 0, 
					pages_desc='".$pagesdesc."',
					pages_create_by = ".$_SESSION['admin_data']['user_id'].", pages_create_date = now()";	
		
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;
	}
	
	function updatePages($id,$pagestitle,$pagesdesc,$pagesimageurl,$pagesalias,$pagesmetadescription,$pagesmetakeywords,$pagesshortdesc){
		$sql	= "UPDATE tbl_pages SET 
				   pages_title='".$pagestitle."', 
				   pages_short_desc='".$pagesshortdesc."', 
				   pages_image='".$pagesimageurl."',
				   pages_alias ='".$pagesalias."', 
				   pages_desc='".$pagesdesc."', 
				   pages_meta_description='".$pagesmetadescription."', 
				   pages_meta_keywords='".$pagesmetakeywords."', 
				   pages_active_status = 1, 
				   pages_update_by = ".$_SESSION['admin_data']['user_id'].", 
				   pages_update_date=now() WHERE pages_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
}