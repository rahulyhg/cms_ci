<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public $arrMenu = array();
	public $data;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_signin','Model_home','Model_user','Model_logcms'));
		$this->load->helper(array('menu','accessprivilege'));
		
		if(empty($_SESSION['admin_data']) && !isset($_COOKIE['cms_user_id'])){
			session_destroy();
			setcookie('cms_user_id', '', 1, '/');
			redirect(BASE_URL_BACKEND."/signin");
			exit();
		}
		
		//Check Cookie
		if(isset($_COOKIE['cms_user_id'])) {
			checkCookieLogin($_COOKIE['cms_user_id']);
		}

		//get menu from helper menu
		$this->arrMenu = menu();
		$this->data = array();
        $this->data['ListMenu'] = $this->arrMenu;
        $this->data['CountMenu'] = count($this->arrMenu);
	}
	
	public function index()
	{
		$this->home();
	}
	
	function home(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = 'home';
		$this->data['modul_id'] = 1;
		$this->data['user_level_id'] = $admin_data['user_level_id'];
		
		$this->load->view('header',$this->data);
		$this->load->view('home');
	}
	
	function changePassword(){
		$modul_id = 1;
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = 'home';
		$this->data['modul_id'] = $modul_id;
		
		$alphanumerik = '0123456789';	
		$word = str_shuffle(substr(str_shuffle($alphanumerik),1,6));
		$_SESSION['captcha_changepassword'] = $word;
		
		$vals = array(
			'word'	 => $word,
			'img_path'	 => PATH_ASSETS.'/capctha/',
			'img_url'	 => BASE_URL.'/assets/capctha/',
			'img_width'	 => '150',
			'img_height' => 30,
			'expiration' => 7200
			);
		
		$cap = create_captcha($vals);
		$this->data["captcha"] = $cap['image'];
		
		$this->load->view('header',$this->data);
		$this->load->view('changePassword');
	}
	
	function doChangePassword(){
		$tb = $_POST['tbSave'];
		if (!$tb) {
			redirect(BASE_URL_BACKEND."/changePassword");
			exit();
		}
		
		$modul_id = 1;
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = 'home';
		$this->data['modul_id'] = $modul_id;
		
		$pass_db = $this->Model_home->getPassword();
		
		$password_database = $pass_db[0]['user_pass'];
		$oldpassword = $this->security->xss_clean(secure_input_password($_POST['oldpassword']));
		$newpassword = $this->security->xss_clean(secure_input_password($_POST['newpassword']));
		$retypenewpassword = $this->security->xss_clean(secure_input_password($_POST['retypenewpassword']));
		$length_password = strlen($newpassword);
		$capctha = $this->security->xss_clean(secure_input($_POST['capctha']));
		
		$pesan = array();
		// Validasi data
		if (trim($oldpassword)=="") {
			$pesan[] = 'Old password is empty';
		} else if (trim($capctha)=="") {
			$pesan[] = "Security Code is empty";
		} else if ($length_password < 6) {
			$pesan[] = 'Minimal password is six character';
		} else if ($newpassword != $retypenewpassword) {
			$pesan[] = 'New password did not match with retype new password';
		} else if($_SESSION['captcha_changepassword'] != $capctha){
			$pesan[] = "Security Code is not valid";
		} 

		if(!empty($oldpassword)){
			if (!password_verify($oldpassword, $password_database)) {
				$pesan[] = 'Old password not correct';
			}
		}

		if(!empty($newpassword)){
			if (password_verify($newpassword, $password_database)) {
				$pesan[] = 'New password same as old password';
			}
		}
		
		// Untuk menampilkan pesan error
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
			}

			$alphanumerik = '0123456789';	
			$word = str_shuffle(substr(str_shuffle($alphanumerik),1,6));
			$_SESSION['captcha_changepassword'] = $word;
			
			$vals = array(
			'word'	 => $word,
			'img_path'	 => PATH_ASSETS.'/capctha/',
			'img_url'	 => BASE_URL.'/assets/capctha/',
			'img_width'	 => '150',
			'img_height' => 30,
			'expiration' => 7200
			);
			
			$cap = create_captcha($vals);
			$this->data["captcha"] = $cap['image'];
			
			// load view			
			$this->load->view('header',$this->data);
			$this->load->view('changePassword');
		} else {
			$update = $this->Model_home->updatePassword($newpassword);
			
			$log_module = "Change Password";
			$log_value = $_SESSION['admin_data']['user_name'];
			$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);

			//session_destroy();
			unset($_SESSION['admin_data']);
			setcookie('cms_user_id', '', 1, '/');
			
			redirect(BASE_URL_BACKEND."/home");
		}
	}	
	
	
	function changeProfile(){
		$modul_id = 1;
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = 'home';
		$this->data['modul_id'] = $modul_id;
		
		$user_id = $admin_data['user_id'];
		
		$rsUser = $this->Model_home->getProfile($user_id);
		$this->data["rsUser"] = $rsUser[0];
		
		$this->load->view('header',$this->data);
		$this->load->view('changeProfile');
	}
	
	function doChangeProfile(){
		$tb = $_POST['tbSave'];
		if (!$tb) {
			redirect(BASE_URL_BACKEND."/doChangeProfile");
			exit();
		}
		
		$modul_id = 1;
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = 'home';
		$this->data['modul_id'] = $modul_id;
		
		$userid = $this->security->xss_clean(secure_input($_POST['userid']));
		$username = $this->security->xss_clean(secure_input($_POST['username']));
		$usernameOld = $this->security->xss_clean(secure_input($_POST['usernameOld']));
		$email = $this->security->xss_clean(secure_input($_POST['email']));
		$emailOld = $this->security->xss_clean(secure_input($_POST['emailOld']));
		$avatar = $this->security->xss_clean(secure_input($_POST['avatar']));
		$avatarOld = $this->security->xss_clean(secure_input($_POST['avatarOld']));
		
		$pattern = "/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD";
		
		$pesan = array();
		// Validasi data
		if (trim($username)=="") {
			$pesan[] = 'Username is empty';
		} else if (trim($email)=="") {
			$pesan[] = "Email is empty";
		} else if(!preg_match($pattern, $email)){
			$pesan[] = 'Email is not valid';
		} 
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;

				$user_id = $admin_data['user_id'];
		
				$rsUser = $this->Model_home->getProfile($user_id);
				$this->data["rsUser"] = $rsUser[0];
				
				$this->load->view('header',$this->data);
				$this->load->view('changeProfile');
			}
		} else { 
			$cekUser = $this->Model_user->checkUser($username);
			$countUser = count($cekUser);
			
			if($username == $usernameOld){
				$countUser = 0;
			}
			
			$cekUserEmail = $this->Model_user->checkUserEmail($email);
			$countUserEmail = count($cekUserEmail);
			
			if($email == $emailOld){
				$countUserEmail = 0;
			}
			
			if(empty($avatar)){
				$avatar = $avatarOld;
			}

			
			if ($countUser > 0 || $countUserEmail > 0 ) {
				$this->data['error']='User Name or Email already exist';

				$user_id = $admin_data['user_id'];
		
				$rsUser = $this->Model_home->getProfile($user_id);
				$this->data["rsUser"] = $rsUser[0];
				
				$this->load->view('header',$this->data);
				$this->load->view('changeProfile');
			} else {
				$update = $this->Model_home->updateProfile($userid,$username,$email,$avatar);
				
				$_SESSION['admin_data']['user_name'] = ucwords(strtolower($username));
				$_SESSION['admin_data']['user_avatar'] = $avatar;
				
				redirect(BASE_URL_BACKEND."/changeProfile");
			}
		}
	}
	
	function ajaxUploadProfile() {
		$modul_id = 1;
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = 'home';
		$this->data['modul_id'] = $modul_id;
		
		$token_foto	= $this->input->post('token_foto');
		$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
		
		$config = array(
					"upload_path"=>PATH_ASSETS."/upload/avatar/",
					"allowed_types"=>"gif|jpg|jpeg|png",
					"file_name"=>"".$token_foto.".".$ext.""
				  );
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload()){
			$error = array('error' => $this->upload->display_errors());

			echo $error['error'];
		} else {
			$file_name		= $this->upload->data('file_name');
			echo $file_name;
		}
	}
	
	function ajaxRemoveProfile(){
		$modul_id = 1;
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = 'home';
		$this->data['modul_id'] = $modul_id;
		
		$filename	=	$this->input->post('foto_token');
		
		unlink(PATH_ASSETS."/upload/avatar/".$filename);
	}
}