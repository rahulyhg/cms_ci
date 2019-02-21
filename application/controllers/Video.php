<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("memory_limit", "256M");
ini_set('max_execution_time', 600);
		
class Video extends CI_Controller {
	public $arrMenu = array();
	public $data;
	public $privilege = array();
	public $section = 3; //get module group id from database
	public $module_id = 10; //get module id from database
	public $module = "Video";
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_video','Model_logcms'));
		$this->load->helper(array('menu','accessprivilege','alias'));
		$this->load->library(array('Utils'));
		
		//Check Cookie
		if(isset($_COOKIE['cms_user_id'])) {
			checkCookieLogin($_COOKIE['cms_user_id']);
		}
	
		if(empty($_SESSION['admin_data']) && !isset($_COOKIE['cms_user_id'])){
			session_destroy();
			setcookie('cms_user_id', '', 1, '/');
			redirect(BASE_URL_BACKEND."/signin");
			exit();
		}
		
		//get menu from helper menu
		$this->arrMenu = menu();
		$this->data = array();
        $this->data['ListMenu'] = $this->arrMenu;
        $this->data['CountMenu'] = count($this->arrMenu);
		
		//check privilege module
		$this->privilege = accessprivilegeuserlevel($_SESSION['admin_data']['user_level_id'], $this->module_id);
		$this->breadcrump = breadCrump($this->module_id);
	}
	
	
	public function index()
	{
		$this->view();
	}
	
	function view(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;
		
		$searchkey = "";
		$searchby = "";
		$where = "";
		$orderBy = "";
		$perpage = "";
		
		if(isset($_POST["tbSearch"])){
			$_SESSION["searchkey".$this->module_id] = '';
			$_SESSION["searchby".$this->module_id] = '';
			$_SESSION["perpage".$this->module_id] = '';
			
			$searchkey = $this->security->xss_clean(secure_input($_POST['searchkey']));
			$searchby = $this->security->xss_clean(secure_input($_POST['searchby']));
			$perpage = $this->security->xss_clean(secure_input($_POST['perpage']));
			
									
			$pesan = array();

			if ($searchkey=="") {
				$pesan[] = 'Keyword search is empty';
			} else if ($searchby=="") {
				$pesan[] = 'Search by has not been choose';
			}
			
			if (! count($pesan)==0 ) {
				foreach ($pesan as $indeks=>$pesan_tampil) {
					$_SESSION["searchkey".$this->module_id] = '';
					$_SESSION["searchby".$this->module_id] = '';
					$_SESSION["perpage".$this->module_id] = '';
				}
			} else {
				$_SESSION["searchkey".$this->module_id] = $searchkey;
				$_SESSION["searchby".$this->module_id] = $searchby;
				$_SESSION["perpage".$this->module_id] = $perpage;
					
				if(isset($_POST['searchkey'])){
					$searchkey = $_SESSION["searchkey".$this->module_id];
				}
				if(isset($_POST['searchby'])){
					$searchby = $_SESSION["searchby".$this->module_id];
				}
				
				if($searchkey != "" && $searchby != ""){
					$where   =   " WHERE ".$searchby." LIKE '%". $searchkey ."%' ";
				}
			}	
		} else {
			$searchkey = @$_SESSION["searchkey".$this->module_id];
			$searchby = @$_SESSION["searchby".$this->module_id];
			
			if($searchkey != "" && $searchby != ""){
				$where   =   " WHERE ".$searchby." LIKE '%". $searchkey ."%' ";
			}
			
			if(isset($_POST['perpage'])){
				$perpage = $this->security->xss_clean(secure_input($_POST['perpage'])); 
				$_SESSION["perpage".$this->module_id] = $perpage;
			} else {
				$perpage = @$_SESSION["perpage".$this->module_id];
				
				if($perpage == ""){
					$perpage = PER_PAGE;
				}
			}
		}
		
		$orderBy = "ORDER BY video_id DESC";
		
		$cond 			= $where." ".$orderBy;
		$rsUserLevel	= $this->Model_video->getListVideo($cond);
		$base_url		= BASE_URL_BACKEND."/video/view/";
		$total_rows		= count($rsUserLevel);
		$per_page		= $perpage;
		
		$this->data['paging']		= pagging($base_url , $total_rows, $per_page);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$start = $per_page*$page - $per_page;
		if ($start<0) $start = 0;
		$cond .= " LIMIT ".$start.",".$per_page;
		$rsQuestion = $this->Model_video->getListVideo($cond);
		
		$this->data["ListQuestion"] = $rsQuestion;
		
		$this->data['perpage'] 	= $per_page;
		$this->data['total'] 	= $total_rows;
		
		$this->data['searchkey'] = $searchkey;
		$this->data['searchby'] = $searchby;
		
		//extract privilege
		$this->data["list"] = $this->privilege[0];
		$this->data["view"] = $this->privilege[1];
		$this->data["add"] = $this->privilege[2];
		$this->data["edit"] = $this->privilege[3];
		$this->data["publish"] = $this->privilege[4];
		$this->data["approve"] = $this->privilege[5];
		$this->data["delete"] = $this->privilege[6];
		$this->data["order"] = $this->privilege[7];
		
		if($this->data["list"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}

		$this->load->view('header_list',$this->data);
		$this->load->view('video/list');
	}
	
	function delete($id){
		//extract privilege
		$this->data["delete"] = $this->privilege[3];
		
		if($this->data["delete"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$id = $this->security->xss_clean(secure_input($id));
		
		if(empty($id)){
			redirect(BASE_URL_BACKEND."/video");
			exit();
		}
		
		$rsVideo = $this->Model_video->getVideo($id);
		$title = $rsVideo[0]['video_name'];
		$fileName = isset($rsVideo[0]['video_file'])?$rsVideo[0]['video_file']:"";
		$fileNameCoverDelete = isset($rsVideo[0]['video_cover'])?$rsVideo[0]['video_cover']:"";
		
		$delete = $this->Model_video->deleteVideo($id);
		
		if(!empty($fileName)){
			$destination = PATH_ASSETS . "/upload/video/$fileName";
			unlink($destination);
		}
		
		if(!empty($fileNameCoverDelete)){
			$destinationCoverOld = PATH_ASSETS . "/upload/video/$fileNameCoverDelete";
			unlink($destinationCoverOld);
		}
		
		$log_module = "Delete ".$this->module;
		$log_value = $id." | ".$title;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/video");
	}
	
	public function add(){
		//extract privilege
		$this->data["add"] = $this->privilege[2];
		
		if($this->data["add"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;				
		$this->data['breadcrump'] = $this->breadcrump;
		
		$this->load->view('header',$this->data);
		$this->load->view('video/add',$this->data);
	}
	
	public function doAddAjax(){
		error_reporting(0);
		
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}
		
		$result = array();
		$status = 0;
		$msg = 'Error Add Ajax '.$this->module;
		
		$name = $this->security->xss_clean(secure_input($_POST['name']));
		$video = $_FILES['video'];
		$cover = $_FILES['cover'];
		
		$pesan = array();
		// Validasi data
		if ($name=="") {
			$pesan[] = 'Name is empty';
		} else if(empty($video['tmp_name'])){
			$pesan[] = 'Video file not selected';
		} else if(empty($cover['tmp_name'])){
			$pesan[] = 'Cover file not selected';
		} 
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$msg = $pesan_tampil;
			}
		} else {
			$this->load->library('Getid3lib');

			$error_upload = "";
			$error_upload_cover = "";
			
			if (!file_exists(PATH_PROJECT . '/temp') && !is_dir(FCPATH . '/temp')) {
				mkdir(PATH_PROJECT . '/temp', 0766);         
			}
			
			$fileName 	= Ramsey\Uuid\Uuid::uuid1()->__toString(). '.mp4';	
			//$fileName 	= basename($video['name']);	
			$destination = PATH_ASSETS . "/upload/video/$fileName";
			
			$videoSize = $video['size'];
			$mediaPict = '';
			if( $video['error'] > 0 ) {
				switch ($video['error']) {
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
						$error_upload = 'File size exceeds limit';
						break;
					case UPLOAD_ERR_PARTIAL:
						$error_upload = 'File was only partially uploaded';
						break;
					case UPLOAD_ERR_NO_FILE:
						$error_upload = 'No file was uploaded';
						break;
					default:
						$error_upload = 'Unknown file upload error';
				}
			} else {
				$fileinfo = $this->getid3lib->getVideoInfo($video['tmp_name']);
			
				$fileSize = $fileinfo['filesize'];
				$validMime = $fileinfo['fileformat'];
				$playtimeSeconds = $fileinfo['playtime_seconds'];
				$resolution_x = $fileinfo['video']['resolution_x'];
				$resolution_y = $fileinfo['video']['resolution_y'];
				
				if( !$fileSize || $validMime != "mp4" ) {
					$error_upload = 'Invalid image format';
				} else {					
					if( move_uploaded_file($video['tmp_name'], $destination) ) {
						$mediaPict = $destination;
					} 
				}
			}
			
			
			$fileNameCover 	= Ramsey\Uuid\Uuid::uuid1()->__toString(). '.jpeg';	
			//$fileNameCover 		= basename($cover['name']);	
			$destinationCover 	= PATH_ASSETS . "/upload/video/$fileNameCover";
			
			$coverSize = $cover['size'];
			$coverPict = '';
			if( $cover['error'] > 0 ) {
				switch ($cover['error']) {
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
						$error_upload = 'File size exceeds limit';
						break;
					case UPLOAD_ERR_PARTIAL:
						$error_upload = 'File was only partially uploaded';
						break;
					case UPLOAD_ERR_NO_FILE:
						$error_upload = 'No file was uploaded';
						break;
					default:
						$error_upload = 'Unknown file upload error';
				}
			} else {
				$imageSize = getimagesize($cover['tmp_name']);	
				$validMime = array('image/jpeg', 'image/jpg');
				if( !$imageSize || !in_array($imageSize['mime'], $validMime) ) {
					$error_upload = 'Invalid image format';
				} else {					
					if( move_uploaded_file($cover['tmp_name'], $destinationCover) ) {
						$coverPict = $destinationCover;
					}
				}
			}
			
			if(!empty($error_upload) && !empty($error_upload_cover)){
				if(!empty($error_upload)){
					$msg = $error_upload;
				} 
				
				if(!empty($error_upload_cover)){
					$msg = $error_upload_cover;
				}
			} else {
				$id = $this->Model_video->insertVideo($name, $fileName, $fileNameCover);

				$log_module = "Insert ".$this->module;
				$log_value = $id." - ".$name." - ".$fileName." - ".$fileNameCover;
				$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
				
				$status = 1;	
			}
		}
		

		$result['status'] = $status;
		$result['msg'] = $msg;
		
		echo json_encode($result);
	}	
	
	public function doAdd(){
		//extract privilege
		$this->data["add"] = $this->privilege[2];
		
		if($this->data["add"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$tb = $_POST['tbSave'];
		if (!$tb) {
			redirect(BASE_URL_BACKEND."/video");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;
		
		$name = $this->security->xss_clean(secure_input($_POST['name']));
		$video = $_FILES['video'];
		$cover = $_FILES['cover'];
		
		$pesan = array();
		// Validasi data
		if ($name=="") {
			$pesan[] = 'Name is empty';
		} else if(empty($video['tmp_name'])){
			$pesan[] = 'Video file not selected';
		} else if(empty($cover['tmp_name'])){
			$pesan[] = 'Cover file not selected';
		} 

		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
			}
			
			$this->data['name']=$name;
			
			$this->load->view('header',$this->data);
			$this->load->view('video/add',$this->data);
		} else {		
			$this->load->library('Getid3lib');

			$error_upload = "";
			$error_upload_cover = "";
			
			if (!file_exists(PATH_ASSETS . '/upload/video') && !is_dir(FCPATH . '/temp')) {
				mkdir(PATH_ASSETS . '/upload/video', 0766);         
			}
			
			$fileName 	= Ramsey\Uuid\Uuid::uuid1()->__toString(). '.mp4';	
			//$fileName 	= basename($video['name']);	
			$destination = PATH_ASSETS . "/upload/video/$fileName";
			
			$videoSize = $video['size'];
			$mediaPict = '';
			if( $video['error'] > 0 ) {
				switch ($video['error']) {
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
						$error_upload = 'File size exceeds limit';
						break;
					case UPLOAD_ERR_PARTIAL:
						$error_upload = 'File was only partially uploaded';
						break;
					case UPLOAD_ERR_NO_FILE:
						$error_upload = 'No file was uploaded';
						break;
					default:
						$error_upload = 'Unknown file upload error';
				}
			} else {
				$fileinfo = $this->getid3lib->getVideoInfo($video['tmp_name']);
			
				$fileSize = $fileinfo['filesize'];
				$validMime = $fileinfo['fileformat'];
				$playtimeSeconds = $fileinfo['playtime_seconds'];
				$resolution_x = $fileinfo['video']['resolution_x'];
				$resolution_y = $fileinfo['video']['resolution_y'];
				
				if( !$fileSize || $validMime != "mp4" ) {
					$error_upload = 'Invalid image format';
				} else {					
					if( move_uploaded_file($video['tmp_name'], $destination) ) {
						$mediaPict = $destination;
					} 
				}
			}
			
			$fileNameCover 	= Ramsey\Uuid\Uuid::uuid1()->__toString(). '.jpeg';	
			//$fileNameCover 		= basename($cover['name']);	
			$destinationCover 	= PATH_ASSETS . "/upload/video/$fileNameCover";
			
			$coverSize = $cover['size'];
			$coverPict = '';
			if( $cover['error'] > 0 ) {
				switch ($cover['error']) {
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
						$error_upload_cover = 'File size exceeds limit';
						break;
					case UPLOAD_ERR_PARTIAL:
						$error_upload_cover = 'File was only partially uploaded';
						break;
					case UPLOAD_ERR_NO_FILE:
						$error_upload_cover = 'No file was uploaded';
						break;
					default:
						$error_upload_cover = 'Unknown file upload error';
				}
			} else {
				$imageSize = getimagesize($cover['tmp_name']);	
				$validMime = array('image/jpeg', 'image/jpg');
				if( !$imageSize || !in_array($imageSize['mime'], $validMime) ) {
					$error_upload = 'Invalid image format';
				} else {					
					if( move_uploaded_file($cover['tmp_name'], $destinationCover) ) {
						$coverPict = $destinationCover;
					}
				}
			}
			
			if(!empty($error_upload) && !empty($error_upload_cover)){
				if(!empty($error_upload)){
					$this->data['error'] = $error_upload;
				} 
				
				if(!empty($error_upload_cover)){
					$this->data['error'] = $error_upload_cover;
				}

				$this->data['name']=$name;

				$this->load->view('header',$this->data);
				$this->load->view('video/add',$this->data);
			} else {
				$id = $this->Model_video->insertVideo($name, $fileName, $fileNameCover);

				$log_module = "Insert ".$this->module;
				$log_value = $id." - ".$name." - ".$fileName." - ".$fileNameCover;
				$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
				
				redirect(BASE_URL_BACKEND."/video");	
			}	
		}  
	} 
	
	public function edit($id){	
		//extract privilege
		$this->data["edit"] = $this->privilege[2];
		
		if($this->data["edit"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/video");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;

		$rsUserLevel = $this->Model_video->getVideo($id);  // mengambil database dari model untuk dikirim ke view
		$countUserLevel = count($rsUserLevel);

		$this->data['rsUserLevel'] = $rsUserLevel;
		$this->data['countUserLevel'] = $countUserLevel;
		
		$this->load->view('header',$this->data);
		$this->load->view('video/edit',$this->data);
	}
	
	public function doEditAjax(){
		error_reporting(0);
		
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}
		
		$result = array();
		$status = 0;
		$msg = 'Error Edit Ajax '.$this->module;
		
		$id = $this->security->xss_clean(secure_input($_POST['id']));
		$name = $this->security->xss_clean(secure_input($_POST['name']));
		$video = $_FILES['video'];
		$cover = $_FILES['cover'];
		
		$pesan = array();
		// Validasi data
		if ($name=="") {
			$pesan[] = 'Name is empty';
		} 
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$msg = $pesan_tampil;
			}
		} else {
			$this->load->library('Getid3lib');

			$error_upload = "";
			$error_upload_cover = "";
			
			$mediaPict = '';
			$fileName = isset($rsUserLevel[0]['video_file'])?$rsUserLevel[0]['video_file']:"";
			if(!empty($video['tmp_name'])){
				if (!file_exists(PATH_ASSETS . '/upload/video') && !is_dir(FCPATH . '/temp')) {
					mkdir(PATH_ASSETS . '/upload/video', 0766);         
				}
				
				$fileName 	= Ramsey\Uuid\Uuid::uuid1()->__toString(). '.mp4';	
				//$fileName 	= basename($video['name']);	
				$destination = PATH_ASSETS . "/upload/video/$fileName";
			
				if( $video['error'] > 0 ) {
					switch ($video['error']) {
						case UPLOAD_ERR_INI_SIZE:
						case UPLOAD_ERR_FORM_SIZE:
							$error_upload = 'File size exceeds limit';
							break;
						case UPLOAD_ERR_PARTIAL:
							$error_upload = 'File was only partially uploaded';
							break;
						case UPLOAD_ERR_NO_FILE:
							$error_upload = 'No file was uploaded';
							break;
						default:
							$error_upload = 'Unknown file upload error';
					}
				} else {
					$fileinfo = $this->getid3lib->getVideoInfo($video['tmp_name']);
				
					$fileSize = $fileinfo['filesize'];
					$validMime = $fileinfo['fileformat'];
					$playtimeSeconds = $fileinfo['playtime_seconds'];
					$resolution_x = $fileinfo['video']['resolution_x'];
					$resolution_y = $fileinfo['video']['resolution_y'];
					
					if( !$fileSize || $validMime != "mp4" ) {
						$error_upload = 'Invalid image format';
					} else {					
						if( move_uploaded_file($video['tmp_name'], $destination) ) {
							$mediaPict = $destination;
							
							$fileNameDelete = isset($rsUserLevel[0]['video_file'])?$rsUserLevel[0]['video_file']:"";
							if(!empty($fileNameDelete)){
								$destinationOld = PATH_ASSETS . "/upload/video/$fileNameDelete";
								unlink($destinationOld);
							}
						} 
					}
				}
			}
			
			$fileNameCover = isset($rsUserLevel[0]['video_cover'])?$rsUserLevel[0]['video_cover']:"";
			$coverPict = '';
			if(!empty($cover['tmp_name'])){
				$fileNameCover 	= Ramsey\Uuid\Uuid::uuid1()->__toString(). '.jpeg';	
				//$fileNameCover 		= basename($cover['name']);	
				$destinationCover 	= PATH_ASSETS . "/upload/video/$fileNameCover";
				
				if( $cover['error'] > 0 ) {
					switch ($cover['error']) {
						case UPLOAD_ERR_INI_SIZE:
						case UPLOAD_ERR_FORM_SIZE:
							$error_upload_cover = 'File size exceeds limit';
							break;
						case UPLOAD_ERR_PARTIAL:
							$error_upload_cover = 'File was only partially uploaded';
							break;
						case UPLOAD_ERR_NO_FILE:
							$error_upload_cover = 'No file was uploaded';
							break;
						default:
							$error_upload_cover = 'Unknown file upload error';
					}
				} else {
					$imageSize = getimagesize($cover['tmp_name']);	
					$validMime = array('image/jpeg', 'image/jpg');
					if( !$imageSize || !in_array($imageSize['mime'], $validMime) ) {
						$error_upload = 'Invalid image format';
					} else {					
						if( move_uploaded_file($cover['tmp_name'], $destinationCover) ) {
							$coverPict = $destinationCover;
							
							$fileNameCoverDelete = isset($rsUserLevel[0]['video_cover'])?$rsUserLevel[0]['video_cover']:"";
							if(!empty($fileNameCoverDelete)){
								$destinationCoverOld = PATH_ASSETS . "/upload/video/$fileNameCoverDelete";
								unlink($destinationCoverOld);
							}
						}
					}
				}
			}
			
			if(!empty($error_upload) && !empty($error_upload_cover)){
				if(!empty($error_upload)){
					$msg = $error_upload;
				} 
				
				if(!empty($error_upload_cover)){
					$msg = $error_upload_cover;
				}

				$msg = $error_upload;
			} else {
				$update = $this->Model_video->updateVideo($id,$name,$fileName,$fileNameCover);

				$log_module = "Edit ".$this->module;
				$log_value = $id." - ".$name." - ".$fileName." - ".$fileNameCover;
				$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
				
				$status = 1;
			}
		}
		

		$result['status'] = $status;
		$result['msg'] = $msg;
		
		echo json_encode($result);
	}
	
	public function doEdit($id){
		//extract privilege
		$this->data["edit"] = $this->privilege[2];
		
		if($this->data["edit"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$tb = $_POST['tbEdit'];
		if (!$tb OR $id == '') {
			redirect(BASE_URL_BACKEND."/theater_video");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;

		$rsUserLevel = $this->Model_video->getVideo($id);  // mengambil database dari model untuk dikirim ke view
		$countUserLevel = count($rsUserLevel);

		$this->data['rsUserLevel'] = $rsUserLevel;
		$this->data['countUserLevel'] = $countUserLevel;
		
		$name = $this->security->xss_clean(secure_input($_POST['name']));
		$video = $_FILES['video'];
		$cover = $_FILES['cover'];
		
		$pesan = array();
		// Validasi data
		if ($name=="") {
			$pesan[] = 'Name is empty';
		} 
		
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
			}

			$this->load->view('header',$this->data);
			$this->load->view('video/edit',$this->data);
		} else {
			$this->load->library('Getid3lib');
			
			$error_upload = "";
			$error_upload_cover = "";
			
			$mediaPict = '';
			$fileName = isset($rsUserLevel[0]['video_file'])?$rsUserLevel[0]['video_file']:"";
			if(!empty($video['tmp_name'])){
				if (!file_exists(PATH_ASSETS . '/upload/video') && !is_dir(FCPATH . '/temp')) {
					mkdir(PATH_ASSETS . '/upload/video', 0766);         
				}
				
				$fileName 	= Ramsey\Uuid\Uuid::uuid1()->__toString(). '.mp4';	
				//$fileName 	= basename($video['name']);	
				$destination = PATH_ASSETS . "/upload/video/$fileName";
			
				if( $video['error'] > 0 ) {
					switch ($video['error']) {
						case UPLOAD_ERR_INI_SIZE:
						case UPLOAD_ERR_FORM_SIZE:
							$error_upload = 'File size exceeds limit';
							break;
						case UPLOAD_ERR_PARTIAL:
							$error_upload = 'File was only partially uploaded';
							break;
						case UPLOAD_ERR_NO_FILE:
							$error_upload = 'No file was uploaded';
							break;
						default:
							$error_upload = 'Unknown file upload error';
					}
				} else {
					$fileinfo = $this->getid3lib->getVideoInfo($video['tmp_name']);
				
					$fileSize = $fileinfo['filesize'];
					$validMime = $fileinfo['fileformat'];
					$playtimeSeconds = $fileinfo['playtime_seconds'];
					$resolution_x = $fileinfo['video']['resolution_x'];
					$resolution_y = $fileinfo['video']['resolution_y'];
					
					if( !$fileSize || $validMime != "mp4" ) {
						$error_upload = 'Invalid image format';
					} else {					
						if( move_uploaded_file($video['tmp_name'], $destination) ) {
							$mediaPict = $destination;
							
							$fileNameDelete = isset($rsUserLevel[0]['video_file'])?$rsUserLevel[0]['video_file']:"";
							if(!empty($fileNameDelete)){
								$destinationOld = PATH_ASSETS . "/upload/video/$fileNameDelete";
								unlink($destinationOld);
							}
						} 
					}
				}
			}
			
			$fileNameCover = isset($rsUserLevel[0]['video_cover'])?$rsUserLevel[0]['video_cover']:"";
			$coverPict = '';
			if(!empty($cover['tmp_name'])){
				//$fileNameCover 	= Ramsey\Uuid\Uuid::uuid1()->__toString(). '.jpeg';	
				$fileNameCover 		= basename($cover['name']);	
				$destinationCover 	= PATH_ASSETS . "/upload/video/$fileNameCover";
				
				if( $cover['error'] > 0 ) {
					switch ($cover['error']) {
						case UPLOAD_ERR_INI_SIZE:
						case UPLOAD_ERR_FORM_SIZE:
							$error_upload_cover = 'File size exceeds limit';
							break;
						case UPLOAD_ERR_PARTIAL:
							$error_upload_cover = 'File was only partially uploaded';
							break;
						case UPLOAD_ERR_NO_FILE:
							$error_upload_cover = 'No file was uploaded';
							break;
						default:
							$error_upload_cover = 'Unknown file upload error';
					}
				} else {
					$imageSize = getimagesize($cover['tmp_name']);	
					$validMime = array('image/jpeg', 'image/jpg');
					if( !$imageSize || !in_array($imageSize['mime'], $validMime) ) {
						$error_upload = 'Invalid image format';
					} else {					
						if( move_uploaded_file($cover['tmp_name'], $destinationCover) ) {
							$coverPict = $destinationCover;
							
							$fileNameCoverDelete = isset($rsUserLevel[0]['video_cover'])?$rsUserLevel[0]['video_cover']:"";
							if(!empty($fileNameCoverDelete)){
								$destinationCoverOld = PATH_ASSETS . "/upload/video/$fileNameCoverDelete";
								unlink($destinationCoverOld);
							}
						}
					}
				}
			}
			
			if(!empty($error_upload) && !empty($error_upload_cover)){
				if(!empty($error_upload)){
					$this->data['error'] = $error_upload;
				} 
				
				if(!empty($error_upload_cover)){
					$this->data['error'] = $error_upload_cover;
				}

				$this->load->view('header',$this->data);
				$this->load->view('video/edit',$this->data);
			} else {
				$update = $this->Model_video->updateVideo($id,$name,$fileName,$fileNameCover);

				$log_module = "Edit ".$this->module;
				$log_value = $id." - ".$name." - ".$fileName." - ".$fileNameCover;
				$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
				
				redirect(BASE_URL_BACKEND."/video");
			}	
		}
	}
}