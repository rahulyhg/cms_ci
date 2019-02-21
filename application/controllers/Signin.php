<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Model_signin','Model_logcms'));
		$this->load->library(array('Utils'));
	}
	
	public function index(){
		$this->login();
	}
	
	function login(){
		//Check Cookie
		if(isset($_COOKIE['cms_user_id'])) {
			$user_id = decryptRC4MD5($_COOKIE['cms_user_id']);
			
			$rsAdmin = $this->Model_signin->cekAdminLoginCookies($user_id); 
			$countAll = count($rsAdmin);
			if($countAll > 0){
				$admin_data = array("user_id" => $rsAdmin[0]['user_id'],
                                                    "user_name" => ucwords(strtolower($rsAdmin[0]['user_name'])),
                                                    "user_level_id" => $rsAdmin[0]['user_level_id'],
                                                    "user_level_name" => ucwords(strtolower($rsAdmin[0]['user_level_name'])),
                                                    "user_avatar" => $rsAdmin[0]['user_avatar'],
                                                    "user_create_date" => $rsAdmin[0]['user_create_date']
									);
				$_SESSION['admin_data'] = $admin_data;
			}	
		}

		if(!empty($_SESSION['admin_data'])){
			redirect(BASE_URL_BACKEND."/home");
			exit();
		}else{
			$wrong = isset($_SESSION['wrong'])?$_SESSION['wrong']:0;
			$this->data["wrong"] = $wrong;
			
			if($wrong >= 2){
				$alphanumerik = '0123456789';	
				$word = str_shuffle(substr(str_shuffle($alphanumerik),1,6));
				$_SESSION['captcha'] = $word;
				
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
			}
			
			$this->load->view('signin',$this->data);
		}
	}
	
	function cekLogin(){
		$tbSignin = $this->input->post('tbSignin');

		if (!$tbSignin) {
			redirect(BASE_URL_BACKEND.'/signin');
			die;
		}
		
		$wrong = isset($_SESSION['wrong'])?($_SESSION['wrong']+1):0;
		
		$username = $this->security->xss_clean(secure_input($_POST['username']));
		$password = $this->security->xss_clean(secure_input_password($_POST['password']));
		//$pass 	  = md5($password);
		$pass 	  = $password;
		
		$remember = $this->security->xss_clean(secure_input(@$_POST['remember']));
		
		$pesan = array();
		// Validasi data
		if (trim($username)=="") {
			$pesan[] = "Username or Email is empty";
		} else if (trim($password)=="") {
			$pesan[] = "Password is empty";
		} 
		
		if($wrong > 2){
			$capctha = $this->security->xss_clean(secure_input($_POST['capctha']));
			
			if (trim($capctha)=="") {
				$pesan[] = "Security Code is empty";
			} else if($_SESSION['captcha'] != @$capctha){
				$pesan[] = "Security Code is not valid";
			} 
		}	
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
			}
			
			$_SESSION['wrong'] = $wrong;
			$this->data["wrong"] = $wrong;
			
			$alphanumerik = '0123456789';	
			$word = str_shuffle(substr(str_shuffle($alphanumerik),1,6));
			$_SESSION['captcha'] = $word;
			
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

			$this->load->view('signin',$this->data);
		} else {
			$rsAdmin = $this->Model_signin->cekAdminLogin($username, $pass); 
			$countAll = count($rsAdmin);
			if($countAll > 0){
				$admin_data = array("user_id" => $rsAdmin[0]['user_id'],
                                                    "user_name" => ucwords(strtolower($rsAdmin[0]['user_name'])),
                                                    "user_level_id" => $rsAdmin[0]['user_level_id'],
                                                    "user_level_name" => ucwords(strtolower($rsAdmin[0]['user_level_name'])),
													"user_avatar" => $rsAdmin[0]['user_avatar'],
                                                    "user_create_date" => $rsAdmin[0]['user_create_date']
									);
				$_SESSION['admin_data'] = $admin_data;
				
				if($remember == 1){
					setcookie("cms_user_id", encryptRC4MD5($rsAdmin[0]['user_id']), time()+EXPIRED_COOKIE, "/");
				}
				
				$log_module = "Login";
				$log_value = $_SESSION['admin_data']['user_name']." | ".$_SESSION['admin_data']['user_level_id'];
				$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
				
				unset($_SESSION['wrong']);
				
				redirect(BASE_URL_BACKEND.'/home');
				die;
			} else {
				$_SESSION['wrong'] = $wrong;
				$this->data["wrong"] = $wrong;
				
				$alphanumerik = '0123456789';	
				$word = str_shuffle(substr(str_shuffle($alphanumerik),1,6));
				$_SESSION['captcha'] = $word;
				
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
				
				$this->data['error'] = "Incorrect username and password";
				$this->load->view('signin',$this->data);
			}
		}
	}
	
	function signout(){
		session_destroy();
		unset($_SESSION['admin_data']);
		if(isset($_COOKIE['cms_user_id'])) {
			setcookie('cms_user_id', '', 1, '/');
		}

		redirect(BASE_URL_BACKEND."/home"); 
		exit();
	}
	
	function reload_captcha(){		
		$alphanumerik = '0123456789';	
		$word = str_shuffle(substr(str_shuffle($alphanumerik),1,6));
		$_SESSION['captcha'] = $word;
		

		$vals = array(
				'word'	 => $word,
				'img_path'	 => PATH_ASSETS.'/capctha/',
				'img_url'	 => BASE_URL.'/assets/capctha/',
				'img_width'	 => '150',
				'img_height' => 30,
				'expiration' => 7200
				);
			
		$cap = create_captcha($vals);
		$return["captcha"] = $cap['image'];
		
		echo $return["captcha"];
	}
} 