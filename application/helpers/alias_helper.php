<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('generateAlias')){
	function generateAlias($alias){
		$alias = strtolower($alias);
		
		$strAnd = array("&amp;");
		$alias = str_replace($strAnd, "and", $alias);
		
		$strDollar = array("$");
		$alias = str_replace($strDollar, "usd", $alias);
		
		$strGreatThen = array(">");
		$alias = str_replace($strGreatThen, "greater-than", $alias);
		
		$strLessThen = array("<");
		$alias = str_replace($strLessThen, "less-than", $alias);
		
		$strSearch = array(" ","  ","_","-","");
		$alias = str_replace($strSearch, "-", $alias);
		
		$strSearchNew = array("!","@","#","$","%","^","*","(",")","+","|","’","‘","”",
						"{","}","[","]",":",";","\'","\"","<",">",",",".","?","\/","*(",
						"=","\\","~");
		$alias = str_replace($strSearchNew, "", $alias);
		
		return $alias;
	}
}

if( ! function_exists('createRouteAlias')){
	function createRouteAlias(){
		$CI = get_instance();
		$CI->load->model('backend/model_alias');
		
		$stat = FALSE;
		$str = "";
		
		$addroute = "";
		$route = "<?php ";
		
		//pages
		$category = "pages";
		$rsPages = $CI->model_alias->getPages();
		$countPages = count($rsPages);
		
		if($countPages > 0){
			for($i=0; $i<$countPages; $i++){
				if(!empty($rsPages[$i]['pages_alias'])){
					$addroute .= "\$route[\"".generateAlias($rsPages[$i]['pages_alias'])."\"] = \"pages/detail/".$rsPages[$i]['pages_id']."\"; ";
				} else {
					$addroute .= "\$route[\"".generateAlias($rsPages[$i]['pages_title'])."\"] = \"pages/detail/".$rsPages[$i]['pages_id']."\"; ";
				}
			}
			$stat = TRUE;
		}
		
		$route .= $addroute;
		$route .= " ?>";
		
		$filename = "alias_routes.php";
		if (!$handle = fopen(PATH."/config/".$filename, 'w+')) {
			 $str = "Cannot open file ($filename)";
			 $stat = FALSE;
		}
		if (fwrite($handle, $route) === FALSE) {
			$str = "Cannot write to file ($filename)";
			$stat = FALSE;
		}
		fclose($handle);

		
		return $stat;
	}
}
?>
