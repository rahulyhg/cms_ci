<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require APPPATH.'libraries/getid3/getid3.php';

class Getid3lib {
	public function __construct()
	{
		$this->CI = & get_instance();
	}
	
	public function getVideoInfo($pathfile){
		$getID3 = new getID3();
		$fileinfo = $getID3->analyze($pathfile);
		
		return $fileinfo;
	}
}
?>
