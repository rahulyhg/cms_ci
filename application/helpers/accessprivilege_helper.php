<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('accessprivilegeuserlevel')){
	function accessprivilegeuserlevel($userlevelid, $moduleid){
		$CI = get_instance();
		
		$CI->load->model('Model_accessprivilege');
		
		$rsListAccessPrivilege = $CI->Model_accessprivilege->getListAccessPrivilege($userlevelid, $moduleid);
		$countListAccessPrivilege = count($rsListAccessPrivilege);
		
		$arrPrivilege = array();
		
		if($countListAccessPrivilege > 0){
			for($i=0; $i<$countListAccessPrivilege; $i++){
				$rsListModulePrivilege = $CI->Model_accessprivilege->getListModulePrivilege($moduleid, $rsListAccessPrivilege[$i]['privilege_id']);
				$countListModulePrivilege = count($rsListModulePrivilege);
				if($countListModulePrivilege > 0){
					$rsListAccessPrivilege[$i]['module_privilege_active'] = 1;
				} else {
					$rsListAccessPrivilege[$i]['module_privilege_active'] = 0;
				}
			}
			
			$list = 0;
			$view = 0;
			$add = 0;
			$edit = 0;
			$publish = 0;
			$approve = 0;
			$delete = 0;
			$setpopular = 0;
			
			//List
			if($rsListAccessPrivilege[0]['access_privilege_status'] == 1 && $rsListAccessPrivilege[0]['module_privilege_active'] == 1) $list = 1;
			//View
			if($rsListAccessPrivilege[1]['access_privilege_status'] == 1 && $rsListAccessPrivilege[1]['module_privilege_active'] == 1) $view = 1;
			//View
			if($rsListAccessPrivilege[2]['access_privilege_status'] == 1 && $rsListAccessPrivilege[2]['module_privilege_active'] == 1) $add = 1;
			//Edit
			if($rsListAccessPrivilege[3]['access_privilege_status'] == 1 && $rsListAccessPrivilege[3]['module_privilege_active'] == 1) $edit = 1;
			//Publish
			if($rsListAccessPrivilege[4]['access_privilege_status'] == 1 && $rsListAccessPrivilege[4]['module_privilege_active'] == 1) $publish = 1;
			//Approve
			if($rsListAccessPrivilege[5]['access_privilege_status'] == 1 && $rsListAccessPrivilege[5]['module_privilege_active'] == 1) $approve = 1;
			//Delete
			if($rsListAccessPrivilege[6]['access_privilege_status'] == 1 && $rsListAccessPrivilege[6]['module_privilege_active'] == 1) $delete = 1;
			//Set Popular
			if($rsListAccessPrivilege[7]['access_privilege_status'] == 1 && $rsListAccessPrivilege[7]['module_privilege_active'] == 1) $setpopular = 1;
			
			$arrPrivilege = array($list,$view,$add,$edit,$publish,$approve,$delete,$setpopular);
		} else {
			show_404();
		}
			
		return $arrPrivilege;
	}
}

if( ! function_exists('breadCrump')){
	function breadCrump($moduleid){
		$CI = get_instance();
		
		$CI->load->model('Model_module');
		
		$arrbreadCrump = array();
		
		$rsListModule = $CI->Model_module->getListModule(" WHERE module_id = ".$moduleid);
		$countListModule = count($rsListModule);
		
		if($countListModule > 0){
			$arrbreadCrump['module_group_name'] = $rsListModule[0]['module_group_name'];
			$arrbreadCrump['module_name'] = $rsListModule[0]['module_name'];
			$arrbreadCrump['module_path'] = $rsListModule[0]['module_path'];
		}
		
		return $arrbreadCrump;
	}
}

if( ! function_exists('checkCookieLogin')){
	function checkCookieLogin($cookie){
		$CI = get_instance();
		
		$CI->load->model('Model_signin');
		$CI->load->library('Utils');
		
		$user_id = decryptRC4MD5($cookie);
		
		if(!empty($user_id)){
			$rsAdmin = $CI->Model_signin->cekAdminLoginCookies($user_id); 
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
	}
}
?>
