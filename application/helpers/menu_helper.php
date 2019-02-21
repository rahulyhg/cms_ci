<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('menu')){
	function menu(){
		$CI = get_instance();
		
		$CI->load->model('model_menu');
		
		$arrMenu = array();
		if(isset($_SESSION['admin_data'])){
			$rsListMenuModuleGroup = $CI->model_menu->getMenuModuleGroup();
			for($i=0; $i<count($rsListMenuModuleGroup); $i++){
				$rsMenuModuleGroupAccessUserLevel = $CI->model_menu->getMenuModuleGroupAccessUserLevel($_SESSION['admin_data']['user_level_id'], $rsListMenuModuleGroup[$i]['module_group_id']);
				if(count($rsMenuModuleGroupAccessUserLevel) > 0){
					$arrMenu[$i]['module_group_id'] =  $rsListMenuModuleGroup[$i]['module_group_id'];
					$arrMenu[$i]['module_group_name'] =  $rsListMenuModuleGroup[$i]['module_group_name'];
					$arrMenu[$i]['module_group_active_status'] =  $rsListMenuModuleGroup[$i]['module_group_order_value'];
					$arrMenu[$i]['module_group_order_value'] =  $rsListMenuModuleGroup[$i]['module_group_active_status'];
					
					$rsListMenuModule = $CI->model_menu->getMenuModule($rsListMenuModuleGroup[$i]['module_group_id']);
					
					if(count($rsListMenuModule) > 0) {
						for($j=0; $j<count($rsListMenuModule); $j++){
							$rsListMenuModule[$j]['module_id'] =  $rsListMenuModule[$j]['module_id'];
							$rsListMenuModule[$j]['module_name'] =  $rsListMenuModule[$j]['module_name'];
							$rsListMenuModule[$j]['module_path'] =  $rsListMenuModule[$j]['module_path'];
							$rsListMenuModule[$j]['module_active_status'] =  $rsListMenuModule[$j]['module_active_status'];
							$rsListMenuModule[$j]['module_order_value'] =  $rsListMenuModule[$j]['module_order_value'];
							
							$rsMenuModuleAccessUserLevel = $CI->model_menu->getMenuModuleAccessUserLevel($_SESSION['admin_data']['user_level_id'],$rsListMenuModuleGroup[$i]['module_group_id'],$rsListMenuModule[$j]['module_id']);
							if(count($rsMenuModuleAccessUserLevel) > 0) {
								$rsListMenuModule[$j]['access_privilege_status'] =  $rsMenuModuleAccessUserLevel[0]['access_privilege_status'];
							} else {
								$rsListMenuModule[$j]['access_privilege_status'] =  0;
							}

						}
						
						$arrMenu[$i]['module'] =  $rsListMenuModule;
					}	
				}	
			}
		}
		
		return $arrMenu;
	}
}
?>
