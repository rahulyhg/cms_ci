<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_video extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
    }
	
	function getListVideo($cond = null){
		$query		= "SELECT video_id, video_name, video_file,	video_cover,
					  DATE_FORMAT( video_create_date, '%d-%m-%Y %H:%i:%s' ) as video_create_date, video_create_by
					  FROM tbl_video ".$cond;
		$query		= $this->db->query($query)->result_array();
		
		return $query;
	}
	
	function getVideo($id = ''){
		$where = '';
		if($id != ''){
			$where = "WHERE video_id = ".$id;
		}
		$sql	= "SELECT video_id, video_name, video_file, video_cover
				  FROM tbl_video $where ORDER BY video_id ASC";	
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 
		
		return $rs;	
	}
	
	
	function deleteVideo($id){
		$sql	= "DELETE FROM tbl_video WHERE video_id = ".$id;	
		$query	= $this->db->query($sql);
		
		$str = $this->db->last_query();
		
		return $str;
	}
	
	function checkVideo($pagestitle){
		$sql	= "SELECT video_name FROM tbl_video WHERE video_name = '".$pagestitle."'";
		$query	= $this->db->query($sql);
		$rs		= $query->result_array(); 

		return $rs;
	}
	
	function insertVideo($videoname,$videofile,$coverfile){

		$sql	= "INSERT INTO tbl_video SET 
					video_name='".$videoname."', 
					video_file='".$videofile."', 
					video_cover='".$coverfile."', 
					video_create_by = ".$_SESSION['admin_data']['user_id'].", video_create_date = now()";	
		
		$query  = $this->db->query($sql);
		$last_id  = $this->db->insert_id();
		
		return $last_id;
	}
	
	function updateVideo($id,$videoname,$videofile,$coverfile){
		$sql	= "UPDATE tbl_video SET 
				   video_name='".$videoname."', 
				   video_file='".$videofile."', 
				   video_cover='".$coverfile."', 
				   video_create_by = ".$_SESSION['admin_data']['user_id'].", video_update_date=now() 
				   WHERE video_id = ".$id;	
		$query	= $this->db->query($sql);
		
		return $query;
	}
}