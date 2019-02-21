<?php
require APPPATH.'libraries/php-excel-reader/excel_reader2.php';
require APPPATH.'libraries/php-excel-reader/SpreadsheetReader.php';

class Excel_reader{
	public function __construct()
	{
		$this->CI = & get_instance();
	}
    
    public function read_excel($filename) {
		try {
			$Reader = new SpreadsheetReader($filename);
			
			$arrData = array();
			foreach ($Reader as $key => $Row){
				foreach ($Row as $idx => $val){
					$val = trim($val);
					//if(!empty($val)){
					if($val != ""){
						$arrData[$key][$idx] = $val;
					}
				}
			} 
			
			return $arrData;
		} catch (Exception $e){
			echo $e->getMessage();
		}
	}
}
?>