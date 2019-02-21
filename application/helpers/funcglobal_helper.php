<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('email')){
	function email($to,$name,$subject,$isi){
		
		//echo $to.'===='.$name.'===='.$subject.'===='.$isi
		
		$ci = &get_instance();
		$ci->load->library('email');
		$ci->email->clear();
		$config['protocol'] 	= 'smtp';//'mail';
		$config['smtp_host']	= $ci->config->item('smtp_server'); //'10.2.121.8';
		$config['smtp_user']	= $ci->config->item('smtp_user'); //'';
		$config['smtp_pass']	= $ci->config->item('smtp_password'); //'';
		$config['smtp_port']	= $ci->config->item('smtp_port'); //'25'; 
		$config['priority'] 	= 1;
		$config['wordwrap'] 	= TRUE;
		$config['mailtype']   	= 'html';
		$config['smtp_timeout'] = '10'; 
		$config['charset']		=	'utf-8';  
		$config['newline']		= '\r\n';
		$ci->email->initialize($config);
		$ci->email->from($config['email_from'], $name);
		$ci->email->to($to);
		$ci->email->subject($subject);
		$ci->email->message($isi);		
		if($ci->config->item('flag_email')){
			if(!$ci->email->send()){
				echo $ci->email->print_debugger();
			}
		}
	}
}

if( ! function_exists('pagging')){
	function pagging($base_url, $total_rows, $per_page){
		$ci = &get_instance();
		$ci->load->library('pagination');
		
		$config['base_url']			= $base_url;
		$config['total_rows']		= $total_rows;
		$config['per_page']			= $per_page;
		$config['num_links'] 		= 6;
		$config['uri_segment'] 		= 3;
		$config['use_page_numbers'] = TRUE;
		
		// Config link
		$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$config['prev_link'] = '<';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		
		$config['next_link'] = '>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		
		$config['first_link'] = '<<';
		//$config['first_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_link'] = '>>';
		//$config['last_link'] = false;
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$ci->pagination->initialize($config); 
		
		return $ci->pagination->create_links();
	}
}

if( ! function_exists('pagging_frontend')){
	function pagging_frontend($base_url, $total_rows, $per_page, $uri_segment){
		$ci = &get_instance();
		$ci->load->library('pagination');
		
		$config['base_url']			= $base_url;
		$config['total_rows']		= $total_rows;
		$config['per_page']			= $per_page;
		$config['num_links'] 		= 4;
		$config['uri_segment'] 		= $uri_segment;
		$config['use_page_numbers'] = TRUE;
		/*$config['display_pages'] 	= FALSE;*/ //hide page number
		
		$config['first_link'] 		= FALSE;
		$config['last_link'] 		= FALSE;
		$config['next_link'] 		= FALSE;
		$config['prev_link'] 		= FALSE;
		
		// Config link
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '';
		$config['first_tag_close'] = '';
		$config['last_tag_open'] = '';
		$config['last_tag_close'] = '';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '';
		$config['prev_link'] = '';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		
		$ci->pagination->initialize($config); 
		
		return $ci->pagination->create_links();
	}
}

if( ! function_exists('date_convert')){
	function date_convert ($date) {
		$date = date('Y-m-d', strtotime($date));
		$bulan = array ('01'=>'Januari',
				'02'=>'Februari',
				'03'=>'Maret',
				'04'=>'April',
				'05'=>'Mei',
				'06'=>'Juni',
				'07'=>'Juli',
				'08'=>'Agustus',
				'09'=>'September',
				'10'=>'Oktober',
				'11'=>'November',
				'12'=>'Desember'
		);
		$date = explode ('-',$date); 

		return  $bulan[$date[1]] . ' ' . $date[2].", ". $date[0];
	}
}

if( ! function_exists('createCache')){
	function createCache($arrayValue, $filename){
		$str = "";
		
		if(!empty($filename)){
			if(count($arrayValue) > 0){
				$pathjson = PATH_ASSETS."/json/";
				$filename = $filename.".json";
				$contentCache = json_encode($arrayValue);

				if (!$handle = fopen($pathjson.$filename, 'w+')) {
					 $str = "Cannot open file ($filename)";
				}
				if (fwrite($handle, $contentCache) === FALSE) {
					$str = "Cannot write to file ($filename)";
				}
				fclose($handle);
			}
		}	
		
		return $str;
	}	
}

if( ! function_exists('cacheJson')){
	function cacheJson($path, $value){
		$return = array();
		$return['status'] = TRUE;
		$return['err'] = '';
		
		if (!$handle = fopen($path, 'w+')) {
			 $return['err'] = "Cannot open file ($path)";
			 $return['status'] = FALSE;
		}
		
		if (fwrite($handle, $value) === FALSE) {
			$return['err'] = "Cannot write to file ($path)";
			$return['status'] = FALSE;
		}
		fclose($handle);
		
		return $return;
	}	
}

if( ! function_exists('searcharray')){
	function searcharray($value, $key, $array) {
		foreach ($array as $k => $val) {
		   if ($val[$key] == $value) {
			   return $k;
		   }
		}
		return null;
	}
}

if( ! function_exists('searchmanyarray')){
	function searchmanyarray($value, $key, $array, $valuesearch) {
		$arrKey = array();
		foreach ($array as $k => $val) {
		   if ($val[$key] == $value) {
			   array_push($arrKey,$k);
		   }
		}

		return $arrKey;
	}
}


if( ! function_exists('genRandomString')){
	function genRandomString(){
		$length = 10;
		$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$string = "";    

		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		
		return $string;
	}	
}	

if( ! function_exists('secure_input')){
	function secure_input($data)
    {
		$filter_sql = stripslashes(strip_tags(trim($data)));
		return $filter_sql;
    }
}	

if( ! function_exists('secure_input_password')){
	function secure_input_password($data)
    {
		$filter_sql = trim($data);
		return $filter_sql;
    }
}

if( ! function_exists('secure_input_editor')){
	function secure_input_editor($data)
    {
		$filter_sql = trim($data);
		return $filter_sql;
    }
}

if( ! function_exists('rc4')){
	function rc4( $key_str, $data_str ) {
		// convert input string(s) to array(s)
		$key = array();
		$data = array();
		for ( $i = 0; $i < strlen($key_str); $i++ ) {
		 $key[] = ord($key_str{$i});
		}
		for ( $i = 0; $i < strlen($data_str); $i++ ) {
		 $data[] = ord($data_str{$i});
		}
		// prepare key
		$state = array( 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,
					  16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,
					  32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,
					  48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,
					  64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,
					  80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,
					  96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,
					  112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,
					  128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,
					  144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,
					  160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,
					  176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,
					  192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,
					  208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,
					  224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,
					  240,241,242,243,244,245,246,247,248,249,250,251,252,253,254,255 );
		$len = count($key);
		$index1 = $index2 = 0;
		for( $counter = 0; $counter < 256; $counter++ ){
		 $index2   = ( $key[$index1] + $state[$counter] + $index2 ) % 256;
		 $tmp = $state[$counter];
		 $state[$counter] = $state[$index2];
		 $state[$index2] = $tmp;
		 $index1 = ($index1 + 1) % $len;
		}
		// rc4
		$len = count($data);
		$x = $y = 0;
		for ($counter = 0; $counter < $len; $counter++) {
		 $x = ($x + 1) % 256;
		 $y = ($state[$x] + $y) % 256;
		 $tmp = $state[$x];
		 $state[$x] = $state[$y];
		 $state[$y] = $tmp;
		 $data[$counter] ^= $state[($state[$x] + $state[$y]) % 256];
		}
		// convert output back to a string
		$data_str = "";
		for ( $i = 0; $i < $len; $i++ ) {
		 $data_str .= chr($data[$i]);
		}
		return $data_str;
	}
}

if( ! function_exists('encryptRC4MD5')){
	function encryptRC4MD5($msisdn){
		$haskey = md5(KEY_COOKIE, true);
		$msisdn_rc4decrypt = rc4($haskey, $msisdn);
		$msisdn_base64encode = base64_encode($msisdn_rc4decrypt);
		
		return $msisdn_base64encode;
	} 
}

if( ! function_exists('decryptRC4MD5')){
	function decryptRC4MD5($msisdn){
		$haskey = md5(KEY_COOKIE, true);
		$msisdn_base64decode = base64_decode($msisdn);
		$msisdn_rc4encrypt = rc4($haskey, $msisdn_base64decode);
		
		return $msisdn_rc4encrypt;
	} 
}

if( ! function_exists('enc_dec')){
	function enc_dec($a, $str) {
		$out = false;
		$enc_method = "AES-256-CBC";
		$sk = "Share_Your_Story";
		$siv = "GamerZAsia";
		
		$key = hash('sha256', $sk);
		
		$iv = substr(hash('sha256', $siv), 0, 16);
		
		if ($a == "enc") {
			$out = openssl_encrypt($str, $enc_method, $key, 0, $iv);
			$out = base64_encode($out);
		} else {
			$out = openssl_decrypt(base64_decode($str), $enc_method, $key, 0, $iv);
		}
		return $out;
	}
}

if( ! function_exists('date_dropdown')){
	function date_dropdown($year_limit = 0){
        $html_output='';
        /*days*/
        $html_output .= '           <select class="date-dis-a" style="width:80px" name="date_day" id="day_select">'."\n";
            for ($day = 1; $day <= 31; $day++) {
                $html_output .= '               <option value="' . $day . '">' . $day . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

        /*months*/
        $html_output .= '           <select class="date-dis-a" style="margin-left:10px; width:140px" name="date_month" id="month_select" >'."\n";
        $months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            for ($month = 1; $month <= 12; $month++) {
                $html_output .= '               <option value="' . $month . '">' . $months[$month] . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

        /*years*/
        $html_output .= '           <select class="date-dis-a" style="margin-left:10px; width:140px" name="date_year" id="year_select">'."\n";
            for ($year = 1950; $year <= (date("Y") - $year_limit); $year++) {
                $html_output .= '               <option value="' . $year . '">' . $year . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

 
		return $html_output;
	}
}


if( ! function_exists('date_dropdown_backend')){
	function date_dropdown_backend($year_limit = 0){
        $html_output='';
        //$html_output .= '        <span> Date of Birth </span>'."\n";

        /*days*/
        $html_output .= '           <select class="form-control" style="width:80px" name="date_day" id="day_select">'."\n";
            for ($day = 1; $day <= 31; $day++) {
                $html_output .= '               <option value="' . $day . '">' . $day . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

        /*months*/
        $html_output .= '           <select class="form-control" style="margin-left:10px; width:140px" name="date_month" id="month_select" >'."\n";
        $months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            for ($month = 1; $month <= 12; $month++) {
                $html_output .= '               <option value="' . $month . '">' . $months[$month] . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

        /*years*/
        $html_output .= '           <select class="form-control" style="margin-left:10px; width:140px" name="date_year" id="year_select">'."\n";
            for ($year = 1950; $year <= (date("Y") - $year_limit); $year++) {
                $html_output .= '               <option value="' . $year . '">' . $year . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";

 
		return $html_output;
	}
}

if( ! function_exists('buildBaseString')){
	function buildBaseString($baseURI, $method, $params) {
		$r = array();
		ksort($params);
		foreach($params as $key=>$value){
			$r[] = "$key=" . rawurlencode($value);
		}
		return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
	}
}	
	
if( ! function_exists('buildAuthorizationHeader')){	
	function buildAuthorizationHeader($oauth) {
		$r = 'Authorization: OAuth ';
		$values = array();
		foreach($oauth as $key=>$value)
			$values[] = "$key=\"" . rawurlencode($value) . "\"";
		$r .= implode(', ', $values);
		return $r;
	}
}

if( ! function_exists('seo_story')){	
	function seo_story($s) {
		$c = array (' ');
		$d = array ('_','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');

		$s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
		
		$s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
		return $s;
	}
}


if( ! function_exists('month_indonesia')){	
	function month_indonesia($bln) {
		$bulan = $bln;
		Switch ($bulan){
		case 1 : $bulan="Januari";
		Break;
		case 2 : $bulan="Februari";
		Break;
		case 3 : $bulan="Maret";
		Break;
		case 4 : $bulan="April";
		Break;
		case 5 : $bulan="Mei";
		Break;
		case 6 : $bulan="Juni";
		Break;
		case 7 : $bulan="Juli";
		Break;
		case 8 : $bulan="Agustus";
		Break;
		case 9 : $bulan="September";
		Break;
		case 10 : $bulan="Oktober";
		Break;
		case 11 : $bulan="November";
		Break;
		case 12 : $bulan="Desember";
		Break;
		}
		return $bulan;
	}
}
?>
