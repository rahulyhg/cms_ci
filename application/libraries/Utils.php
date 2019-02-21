<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Utils {

	private static $hack = "image.php?n=";
	private static $MNC_MAP = array('510'=>'IDN', '525'=>'SGP', '655'=>"ZAF");
	private static $MNC_MAP_AFRICA = array(
		'621'=>'NGA', '636'=>'ETH', '602'=>'EGY', '629'=>'COD', '655'=>'ZAF',
		'640'=>'TZA', '639'=>'KEN', '603'=>'DZA', '659'=>'SDN', '641'=>'UGA',
		'604'=>'MAR', '620'=>'GHA', '643'=>'MOZ', '631'=>'AGO', '612'=>'CIV',
		'646'=>'MDG', '624'=>'CMR', '614'=>'NER', '613'=>'BFA', '610'=>'MLI',
		'650'=>'MWI', '645'=>'ZMB', '608'=>'SEN', '622'=>'TCD', '648'=>'ZWE',
		'659'=>'SSD', '635'=>'RWA', '605'=>'TUN', '637'=>'SOM', '627'=>'GNQ',
		'616'=>'BEN', '642'=>'BDI', '615'=>'TGO', '657'=>'ERI', '619'=>'SLE',
		'606'=>'LBY', '623'=>'CAF', '630'=>'COD', '630'=>'COG', '618'=>'LBR',
		'609'=>'MRT', '649'=>'NAM', '652'=>'BWA', '607'=>'GMB', '611'=>'GIN',
		'651'=>'LSO', '628'=>'GAB', '632'=>'GNB', '617'=>'MUS', '653'=>'SWZ',
		'638'=>'DJI', '647'=>'REU', '654'=>'COM', '626'=>'STP', '633'=>'SYC',
		'658'=>'SHN'
	);
	private static $enableCloudFront = true;
	private static $enableCloudFlare = true;
	
	public function __construct(){
        $CI =& get_instance();
    }
	
	public static function isReservedUsername($username) {
		$reservedUsername = array("admin", "administrator", "mypicmix", "picmix", "picmixteam", "support", "kfc",
			"mcdonald", "pizzahut", "cafenco", "pizzabar", "starbucks", "nama_user");

		return (in_array(strtolower($username), $reservedUsername) ? true : false);
	}

	public static function get($paramName, $default = null, $isInt = false) {
		$val = '';
		if( isset($_REQUEST[$paramName]) ) {
			$val = $_REQUEST[$paramName];
		} else {
			if( $default !== null ) {
				$val = $default;
			}
		}
		
		if($isInt && $val != '') {
			$val = intval($val);
		}
		return $val;
	}

	public static function post($paramName, $default = null, $isInt = false) {
		$val = '';
		if( isset($_POST[$paramName]) ) {
			$val = $_POST[$paramName];
		} else {
			if( $default !== null ) {
				$val = $default;
			}
		}
		
		if($isInt && $val != '') {
			$val = intval($val);
		}
		return $val;
	}

	public static function isValidEmail($email, &$message='') {
		if( empty($email) ){
			return false;
		} else {
			$isMatch = preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);

			$message = '';
			if( !$isMatch ) {
				//Find invalid character
				$invalidChar = '';
				for($i=0 ; $i<strlen($email) ; $i++ ) {
					$char = substr($email, $i, 1);					
					if( !preg_match("/^[_\.0-9a-zA-Z-@]$/i", $char) ) {
						$invalidChar = $char;
						break;
					}
				}
	
				if( !empty($invalidChar) ) {
					$message = '';
					if( $invalidChar == ' ') {
						$message = "Invalid email format, email can't contain space.";
					} else if( ctype_punct($char) ){
						$message = "Invalid email format, email can't contain character '$char'";
					} else {
						$message = "Invalid email format, please only use standard character set.";
					}
				} else {
					$message = "Invalid email format, please verify your email address.";
				}
			}
			
			return $isMatch;
		}
	}
	
	public static function isValidURL($url) {
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}
	
	public static function getAvatarURL($userid, $avatar=0, $useDefault=false) {
		if( PHOTO_IS_RELATIVE ) {
			return 0;
		}
		
		if( !empty($avatar) ) {
			if( $avatar == 1 ) {	//Old avatar
				if( Utils::$enableCloudFront ) {
					return 'http://dk56kqhpxi2qj.cloudfront.net/avatar/' . $userid . '.jpeg';
				} else {
					return AVATAR_BASE_PATH . $userid . '.jpeg';
				}
			} else {	//New avatar path							
				if(strpos($avatar, 'pmxavt') !== false) {	//Avatar in old bucket
					//URL http://pmxavt.s3.amazonaws.com/2fdb3_52455cb9.jpeg					
					if( Utils::$enableCloudFront ) {
						return str_replace('pmxavt.s3.amazonaws.com', 'd2e56ju6111681.cloudfront.net', $avatar);
					} else {
						return $avatar;
					}
				} else if( strpos($avatar, 'sgthm.picmix.it') !== false ) {
					//URL http://s3-ap-southeast-1.amazonaws.com/sgthm.picmix.it/vitest_142674940259_test.jpeg
					if( Utils::$enableCloudFlare) {
						//Return : http://sgthm.picmix.it/60000313_ths.jpeg
						return str_replace('s3-ap-southeast-1.amazonaws.com/', '', $avatar);
						//return $url;
					} else {
						return $avatar;
					}
				} else if(strpos($avatar, 'thm.picmix.it') !== false) { 
					//URL http://s3.amazonaws.com/thm.picmix.it/2fdb3_52455cb9.jpeg
					if( Utils::$enableCloudFlare) {
						//Return : http://thm.picmix.it/2fdb3_52455cb9.jpeg
						return str_replace('s3.amazonaws.com/', '', $avatar);
					} else if( Utils::$enableCloudFront ) {
						//Return : http://d2aachp7x3p7v2.cloudfront.net/2fdb3_52455cb9.jpeg
						return str_replace('s3.amazonaws.com/thm.picmix.it', 'd2aachp7x3p7v2.cloudfront.net', $avatar);						
					} else {
						return $avatar;
					}
				} else {
					return $avatar;
				}
			}
		} else {
			if( $useDefault ) {
				return AVATAR_BASE_PATH . '0.jpg';
			} else {
				return '';
			}
		}
	}
	
	public static function getPhotoURL($url) {
		if( Utils::isValidURL($url) ) { //Photo already in Amazon S3 server, e.g: http://mypicmiximg1.s3.amazonaws.com/afa54630-c0d3-11e1-88d2-406c8f092c35.jpeg	
			if (PHOTO_IS_RELATIVE) {		//Old client, use hack so it became relative path
				return Utils::$hack . urlencode($url);
			} else {						//New Client, use full path
				return  $url;
		 	}
		} else {	//Photo still in local server e.g: part3/120628/26754/2675318-150349.jpeg 
			if (PHOTO_IS_RELATIVE) {		//Old client, use relative path
				return $url;
			} else {						//New Client, use full path
				return  PHOTO_BASE_PATH . $url;
			}
		}
	}
	
	public static function getThumbURL($url) {
		//Thumbnail is always in local server e.g: thumbs/2675318-150349.jpeg 		
		if (PHOTO_IS_RELATIVE) {//Old client, use hack so it became relative path
			return substr($url, strlen(PHOTO_BASE_PATH) );;
		} else { //New Client, use full path
			return  $url;
		}
	}
	
	public static function getThumbPath($userid, $photoUrl, $thumbPath = THUMB_SAVE_PATH) {
		if( Utils::isValidURL($photoUrl) ) { //Photo already in Amazon S3 server
			$dir = $userid % 255;
			$thumbDir = $dir;

			if( !file_exists($thumbPath) ) {
				mkdir($thumbPath);
			}

			if( !file_exists($thumbPath . $thumbDir) ){
				mkdir($thumbPath . $thumbDir);
			}

			if( file_exists($thumbPath . $thumbDir) ){
				$cutUrl = substr($photoUrl, 0, strripos($photoUrl, "-"));
				$idx = substr($cutUrl, strlen($cutUrl)-2);
				$thumbDir = $thumbDir . "/" . $idx;
				if(!file_exists($thumbPath . $thumbDir) ) {
					mkdir($thumbPath . $thumbDir);
				}

				if(file_exists($thumbPath . $thumbDir) ) {
					$fileName = substr($photoUrl, strripos($photoUrl, '/') );
					return $thumbDir . "/" . $fileName;
				}
			} 
			
			return urlencode($photoUrl);
		} else { //Photo still in local server e.g: part3/120628/26754/2675318-150349.jpeg 
			$paths = split('/', $photoUrl);
			$fullPath = $thumbPath;
			for($i=0 ; $i < count($paths)-1 ; $i++) {
				$fullPath .= '/' . $paths[$i]; 
				if(!file_exists($fullPath)) {
					mkdir( $fullPath );
				}
			}
			return $photoUrl;
		}
	}

	public static function makeThumb($src, $dest, $targetSize) {
		if( Utils::isValidURL($src) ) { //Photo already in Amazon S3 server
			$srcImg = imagecreatefromjpeg($src);
		} else {
			$srcImg = imagecreatefromjpeg(PHOTO_BASE_PATH . $src);
		}
		$oldX = imageSX($srcImg);
		$oldY = imageSY($srcImg);
		$ratio = $oldX / $targetSize;
		$thumbW = $targetSize;
		$thumbH = $oldY / $ratio;
		$dstImg = ImageCreateTrueColor($thumbW, $thumbH);
		if( imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $thumbW, $thumbH, $oldX, $oldY) ) {
			if( !imagejpeg($dstImg, $dest) ) {
				unlink( $dest );
			}
		}
		imagedestroy($dstImg);
		imagedestroy($srcImg);
	}	

	public static function makeThumbPng($src, $dest, $targetSize) {
		$srcImg = imagecreatefrompng($src);
		$oldX = imageSX($srcImg);
		$oldY = imageSY($srcImg);
		$ratio = $oldX / $targetSize;
		$thumbW = $targetSize;
		$thumbH = $oldY / $ratio;
		$dstImg = ImageCreateTrueColor($thumbW, $thumbH);
		imagealphablending($dstImg, FALSE);
		imagesavealpha($dstImg, TRUE);
		if( imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $thumbW, $thumbH, $oldX, $oldY) ) {
			if( !imagepng($dstImg, $dest) ) {
				unlink( $dest );
			}
		}
		imagedestroy($dstImg);
		imagedestroy($srcImg);
	}	


	public static function mongoDateToSec($mongoDate) {
		$strDate = $mongoDate->__toString();
		$msecSec = explode(" ", $strDate);
		return intval($msecSec[1]);
	}

	public static function mongoDateToNormalDate($mongoDate) {
		$strDate = $mongoDate->__toString();
		$msecSec = explode(" ", $strDate);
		$date	 = date("Y-m-d H:i:s", $msecSec[1]);
		return $date;
	}

	public static function findHashtag($text, &$hashtags) {
		$text = strtolower($text);
		//$content = explode(" ", $text);
		$content = preg_split("/[\s]+/", $text);
		for ($i = 0; $i < sizeof($content); $i++) {
			if (strlen($content[$i]) > 3 && strlen($content[$i]) < 51 && strcmp(substr($content[$i], 0, 1), "#") == 0) {
				$content[$i] = substr($content[$i], 1);
				if( $content[$i] ) {
					$validHashtag = TRUE;
					for ($j = 0; $j < strlen($content[$i]); $j++) {
						$char = substr($content[$i], $j, 1);
						if (!(($char >= 'a' && $char <= 'z') || ($char >= '0' && $char <= '9') || ($char=='_') )) {
							$validHashtag = FALSE;
							break;
						}
					}
					if ($validHashtag && !in_array($content[$i], $hashtags)) {
						array_push($hashtags, $content[$i]);
					}
				}
			}
		}
		return $hashtags;
	}
	
	public static function findHashtagReplace($text) {
		$hashtags = array();
		//$content = explode(" ", $text);
		$content = preg_split("/[\s]+/", $text);
		for ($i = 0; $i < sizeof($content); $i++) {
			if (strlen($content[$i]) > 3 && strlen($content[$i]) < 51 && strcmp(substr($content[$i], 0, 1), "#") == 0) {
				$content[$i] = substr($content[$i], 1);
				if( $content[$i] ) {
					$validHashtag = TRUE;
					for ($j = 0; $j < strlen($content[$i]); $j++) {
						$char = substr($content[$i], $j, 1);
						$char = strtolower($char);
						if (!(($char >= 'a' && $char <= 'z') || ($char >= '0' && $char <= '9') || ($char=='_') )) {
							$validHashtag = FALSE;
							break;
						}
					}
					if ($validHashtag && !in_array($content[$i], $hashtags)) {
						array_push($hashtags, '<a href="picmix://hashtag/'.strtolower($content[$i]).'" class="obT2H2kjfo46">#'.strtolower($content[$i]).'</a>');
					}
				}
			} else {
				array_push($hashtags, '$&'.$content[$i]);
			}
		}
		$string = str_replace("$&","",implode(" ",$hashtags));
		return $string;
	}

	public static function findMention($text) {
		$text = strtolower($text);
		$content = explode(" ", $text);
		$mentions = array();
		
		for ($i = 0; $i < sizeof($content); $i++) {			
			$isMention = true;
			if (strlen($content[$i]) > 4 && strlen($content[$i]) < 51 && strcmp(substr($content[$i], 0, 1), "@") == 0) {
				$content[$i] = substr($content[$i], 1);
				for ($j = 0; $j < strlen($content[$i]); $j++) {
					$char = substr($content[$i], $j, 1);
					if (!(($char >= 'a' && $char <= 'z') || ($char >= '0' && $char <= '9') || $char == '_')) {
						$isMention = false;
						break;
					}
				}
				if( $isMention ) {
					array_push($mentions, $content[$i]);
				}
			}
		}
		return $mentions;
	}
	
	public static function findMentionReplace($text) {
		$content = explode(" ", $text);
		$mentions = array();
		
		for ($i = 0; $i < sizeof($content); $i++) {			
			$isMention = true;
			if (strlen($content[$i]) >= 3 && strlen($content[$i]) < 51 && strcmp(substr($content[$i], 0, 1), "@") == 0) {
				$content[$i] = substr($content[$i], 1);
				for ($j = 0; $j < strlen($content[$i]); $j++) {
					$char = substr($content[$i], $j, 1);
					$char = strtolower($char);
					if (!(($char >= 'a' && $char <= 'z') || ($char >= '0' && $char <= '9') || $char == '_')) {
						$isMention = false;
						break;
					}
				}
				if( $isMention ) {
					array_push($mentions, '<a href="picmix://profile/'.strtolower($content[$i]).'" class="obT2H2kjfo46">@'.strtolower($content[$i]).'</a>');
				}
			} else {
				array_push($mentions, $content[$i]);
			}
		}
		$string = str_replace("$&","",implode(" ",$mentions));
		return $string;
	}
	
	public static function arrChangeKey(&$array, $oldKey, $newKey) {
		$array[$newKey] = $array[$oldKey];
		unset($array[$oldKey]);
	}
	
	public function filter_ptags_on_images($content){
	   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}
	
	public static function convertEncoding($str, $from = 'auto', $to = "UTF-8") {
		if($from == 'auto') 
			$from = mb_detect_encoding($str);
		return mb_convert_encoding ($str , $to, $from); 
	}

	public static function regexEncode($str) {
		$regexChars = array('[', ']', '.', '\\', '+', '*', '?',  '^', '$', '(', ')', '{', '}', '|');
		while(in_array(substr($str, 0, 1), $regexChars)) {
			$str = substr($str, 1);			
		}
		
		$arrSearch = str_split($str, 1);
		for($i=0 ; $i<count($arrSearch) ; $i++) {
			if(in_array($arrSearch[$i], $regexChars) ) {
				if( $i > 3 ) {
					$arrSearch[$i] = '[' . $arrSearch[$i] . "]";
				} else {
					$arrSearch[$i] = '';
				}
			}			
		}
		return implode("", $arrSearch);
	}


	public static function mapNCCFromMCC(&$ncc, $mcc) {
		if( empty($ncc) && !empty($mcc) ) { 
			if( isset(Utils::$MNC_MAP[$mcc]) ) { 
				$ncc = Utils::$MNC_MAP[$mcc];
			} else if( isset(Utils::$MNC_MAP_AFRICA[$mcc]) ) { 
				$ncc = Utils::$MNC_MAP_AFRICA[$mcc];
			}
		}
	}

	public static function enc_encrypt($string, $key, $urlSafe = false) {
		$result = '';
		for($i = 0; $i < strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char) + ord($keychar));
			$result .= $char;
		}
		//return base64_encode($result);
		return ($urlSafe?Utils::base64url_encode($result) : base64_encode($result));
	}

	public static function enc_decrypt($string, $key) {
		$result = '';
		//$string = base64_decode($string);
		$string = Utils::base64url_decode($string);

		for($i = 0; $i < strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char) - ord($keychar));
			$result .= $char;
		}
		return $result;
	}

	public static function sessionSpec() {
		$sesVersion	= 2;
		$sesSeperator	= chr(8);
		$randomStr	= Utils::randomAlphaNum(8);
		return $sesVersion . $sesSeperator . $randomStr . $sesSeperator;
	}
	
	public static function sessionVersion($session) {		
		$specs = split(chr(8), $session);
		if( count($specs) == 3 && substr($session, -1, 1) == chr(8) ) {
			return $specs[0];
		}
		return false;
	}

	public static function randomAlphaNum($length) {
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$string = '';
		for ($i = 0; $i < $length; $i++) {
			$string .= $characters[rand(0, strlen($characters) - 1)];			
		}
		return $string;
	}


	public static function generateSession($userid, $password, $urlSafe=TRUE) {
		$key = Utils::randomAlphaNum(10);
		$session = $key;

		$userIdHex = dechex($userid);
		$userIdLen = strlen($userIdHex);
		$session .= ( $userIdLen . Utils::randomAlphaNum(9-$userIdLen) .  $userIdHex);
		$session .= Utils::enc_encrypt($password, $key, $urlSafe);
		return $session;
	}

	public static function decodeSession($session, &$userid, &$password) {
		$key = substr($session, 0, 10);
		$userIdLen = substr($session, 10, 1);
		$userid = hexdec( substr($session, 20-$userIdLen, $userIdLen) );
		$encriptedPassword = substr($session, 20);
		$password = Utils::enc_decrypt($encriptedPassword, $key);
	}

	static function base64url_encode($data) { 
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	}

	static function base64url_decode($data) { 
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	} 
	
	# make asynchronous post request
	public static function curl_post_async($url, $params = array()){
		$post_params = array();
	
		foreach ($params as $key => &$val) {
			if (is_array($val)) $val = implode(',', $val);
			$post_params[] = $key.'='.urlencode($val);
		}
		$post_string = implode('&', $post_params);
	
		$parts=parse_url($url);
	
		$fp = fsockopen($parts['host'],
				isset($parts['port'])?$parts['port']:80,
				$errno, $errstr, 30);
	
		$out = "POST ".$parts['path']." HTTP/1.1\r\n";
		$out.= "Host: ".$parts['host']."\r\n";
		$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out.= "Content-Length: ".strlen($post_string)."\r\n";
		$out.= "Connection: Close\r\n\r\n";
		if (isset($post_string)) $out.= $post_string;
	
		fwrite($fp, $out);
		fclose($fp);
	}
	
	public static function toCloudfrontBoardURL($url) {
		//Frame url : http://s3.amazonaws.com/frm.picmix.it/Kakao10.png
		if( Utils::$enableCloudFlare ) {
			//Change into http://frm.picmix.it/Kakao10.png
			$url = str_replace('s3.amazonaws.com/','', $url);
		} else if( Utils::$enableCloudFront ){
			//Change into http://d2mk5eq74k7ut7.cloudfront.net/Kakao10.png
			//CloudFront host name 'd2mk5eq74k7ut7.cloudfront.net' is assigned to 'frm.picmix.it.s3.amazonaws.com'
			$url = str_replace('s3.amazonaws.com/bnr.picmix.it', 'd274z2atepzqum.cloudfront.net', $url);
		}
		return $url;
	}

	public static function toCloudfrontFrameURL($url) {
		//Frame url : http://s3.amazonaws.com/frm.picmix.it/Kakao10.png
		if( Utils::$enableCloudFlare ) {
			//Change into http://frm.picmix.it/Kakao10.png
			if( strpos($url, 'picmixfrms') === false)
				$url = str_replace('s3.amazonaws.com/','', $url);
		} else if( Utils::$enableCloudFront ){
			//Change into http://d2mk5eq74k7ut7.cloudfront.net/Kakao10.png
			//CloudFront host name 'd2mk5eq74k7ut7.cloudfront.net' is assigned to 'frm.picmix.it.s3.amazonaws.com'			
			$url = str_replace('s3.amazonaws.com/frm.picmix.it', 'd2mk5eq74k7ut7.cloudfront.net', $url);			
		} 
		return $url; 
	}

	public static function toCloudfrontThumbURL($url) {		
		if( strpos($url, 'sgthm.picmix.it') !== false) { 
			//URL http://s3-ap-southeast-1.amazonaws.com/sgthm.picmix.it/vitest_142674940259_test.jpeg
			if( Utils::$enableCloudFlare) {
				//Return : http://sgthm.picmix.it/60000313_ths.jpeg
				return str_replace('s3-ap-southeast-1.amazonaws.com/', '', $url);
				//return $url;
			} else {
				return $url;
			}	
		} else if( strpos($url, 'thm.picmix.it') !== false) { 
			//URL http://s3.amazonaws.com/thm.picmix.it/60000313_ths.jpeg
			if( Utils::$enableCloudFlare) {
				//Return : http://thm.picmix.it/60000313_ths.jpeg
				return str_replace('s3.amazonaws.com/', '', $url);
			} else if( Utils::$enableCloudFront ) {
				//Return : http://d2aachp7x3p7v2.cloudfront.net/2fdb3_52455cb9.jpeg
				return str_replace('s3.amazonaws.com/thm.picmix.it', 'd2aachp7x3p7v2.cloudfront.net', $url);
			} else {
				return $url;
			}			
		} else if( strpos($url, 'pmxthm') !== false) {
			//Thumbnail still in old bucket 
			//URL : http://pmxthm.s3.amazonaws.com/227824537_thmm.jpeg
			if( Utils::$enableCloudFront ) {
				//Return : http://dlron5tc1tfqq.cloudfront.net/227824537_thmm.jpeg
				$url = str_replace('pmxthm.s3.amazonaws.com', 'dlron5tc1tfqq.cloudfront.net', $url);
			} 
		} else {
			return $url;
		}
				
		return $url;
	}

	public static function toCloudfrontPhotoURL($url) {		
		// Check if photo is in new bucket : img.picmix.it
		// Changed to using domain so can be used in CloudFlare
		
		if( strpos($url, 'sgimg.picmix.it') !== false) { 
			//URL http://s3-ap-southeast-1.amazonaws.com/sgimg.picmix.it/vitest_142674940259_test.jpeg
			if( Utils::$enableCloudFlare) {
				//Return : http://sgthm.picmix.it/60000313_ths.jpeg
				return str_replace('s3-ap-southeast-1.amazonaws.com/', '', $url);
				//return $url;
			} else {
				return $url;
			}
		} else if( strpos($url, 'img.picmix.it') !== false ) { 
			//URL format : http://s3.amazonaws.com/img.picmix.it/329aac20-2a6e-11e3-85f9-12313d23cc0d.jpeg 

			if( Utils::$enableCloudFlare ) {
				//Change into http://img.picmix.it/329aac20-2a6e-11e3-85f9-12313d23cc0d.jpeg
				$url = str_replace('s3.amazonaws.com/','', $url);
			} else if(Utils::$enableCloudFront) {				
				//Change into http://d33c4ggy8xd4fk.cloudfront.net/329aac20-2a6e-11e3-85f9-12313d23cc0d.jpeg
				//CloudFront host name 'd33c4ggy8xd4fk.cloudfront.net' is assigned to 'img.picmix.it.s3.amazonaws.com'
				$url = str_replace('s3.amazonaws.com/img.picmix.it','d33c4ggy8xd4fk.cloudfront.net', $url);
			}
		} else {
			//URL format : http://mypicmiximg1.s3.amazonaws.com/e9ba36e0-258f-11e3-8b1a-12313d23cc0d.jpeg
			// or http://mypicmiximg2.s3.amazonaws.com/e9ba36e0-258f-11e3-8b1a-12313d23cc0d.jpeg
			//Photo still in old bucket, only CloudFront can be supported			
			if(Utils::$enableCloudFront) {				
				//Change into http://d1nfi6zgulj8u1.cloudfront.net/e9ba36e0-258f-11e3-8b1a-12313d23cc0d.jpeg
				//CloudFront host name 'd1nfi6zgulj8u1.cloudfront.net' is assigned to 'mypicmiximg1.s3.amazonaws.com'
				$count = 0;
				$url = str_replace('mypicmiximg1.s3.amazonaws.com', 'd1nfi6zgulj8u1.cloudfront.net', $url, $count);
				if( $count === 0 ) {
					$url = str_replace('mypicmiximg2.s3.amazonaws.com', 'd2a6bnkuppzme9.cloudfront.net', $url);
				}
			}
		}
		
		return $url;
	}
	
	public static function toCloudfrontPhotoHDURL($url) {
		//It's just the same
		return Utils::toCloudfrontPhotoURL($url);
	} 

	public static function toCloudfrontCoverURL($url) {
		if( strpos($url, 'img.picmix.it') !== false ) { 
			//URL : http://s3.amazonaws.com/img.picmix.it/cover1_n.jpg
			if( Utils::$enableCloudFlare ) {
				//Return : http://img.picmix.it/cover1_n.jpg
				$url = str_replace('s3.amazonaws.com/','', $url);
			} else if( Utils::$enableCloudFront ) {
				//Return : http://d33c4ggy8xd4fk.cloudfront.net/cover1_n.jpg
				$url = str_replace('s3.amazonaws.com/img.picmix.it','d33c4ggy8xd4fk.cloudfront.net', $url);
			}
		} else if( strpos($url, 'profilecvr') !== false ) { 
			//URL : http://profilecvr.s3.amazonaws.com/n196019_1369625962.jpeg
			if( Utils::$enableCloudFront ) {
				//Return : http://d2e6zume7aeh2k.cloudfront.net/n196019_1369625962.jpeg
				$url = str_replace('profilecvr.s3.amazonaws.com', 'd2e6zume7aeh2k.cloudfront.net', $url);
			}
		}
		
		return $url;
	}

	public static function toCloudfrontVideoURL($url) {
		if( strpos($url, 'vid.picmix.it') !== false ) {
			//URL : http://s3.amazonaws.com/vid.picmix.it/cover1_n.mp4
			if( Utils::$enableCloudFlare ) {
				//Return : http://vid.picmix.it/cover1_n.mp4
				$url = str_replace('s3.amazonaws.com/','', $url);
			}
		}
		return $url;
	}
	

	public static function getPatternURL($patternUrl) {
		if(strpos($patternUrl, 'http://') === 0) { // Pattern already in S3
			return $patternUrl;
		} else { //Pattern in local server
			return PATTERN_BASE_PATH . $patternUrl;
		}
	}

	public static function makeRequest($url, $params, $method = "POST", $userName='', $password='') {
		$ch = curl_init();

		$opts = array(
			CURLOPT_CONNECTTIMEOUT => 30,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 60
		);
		
		
		if ($method == "GET" ) {
			$opts[CURLOPT_URL] = $url;
			if( $params ) {
				$opts[CURLOPT_URL] = $url . "?" . http_build_query($params, null, '&');
			}
		} else {
			$opts[CURLOPT_URL] = $url;
			if(is_array($params) ) {
				$opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
			} else {
				$opts[CURLOPT_POSTFIELDS] = $params;
			}
		}
		
		if( !empty($userName) && !empty($password) ) {
			$opts[CURLOPT_USERPWD] = $userName . ':' . $password;
		}
		
		// disable the 'Expect: 100-continue' behaviour. 
		// This causes CURL to wait for 2 seconds if the server does not support this header.
		if (isset($opts[CURLOPT_HTTPHEADER])) {
			$existing_headers = $opts[CURLOPT_HTTPHEADER];
			$existing_headers[] = 'Expect:';			
			$opts[CURLOPT_HTTPHEADER] = $existing_headers;
		} else {
			$opts[CURLOPT_HTTPHEADER] = array('Expect:');
		}		
		
		curl_setopt_array($ch, $opts);
		$result = curl_exec($ch);

		if (curl_errno($ch) == 60) { // CURLE_SSL_CACERT			
			$result = false;
		}
		
		curl_close($ch);
		return $result;
	}

	public static function checkedUnset(&$arr, $field) {
		if( isset($arr[$field]) ) {
			unset($arr[$field]);
		}
	}

	public static function createDefaultAvatar($text, $outFile, $fontSize = 88, $width = 200, $height = 200 ) {
		//Color palettes
		$hexColors = array('F44336', 'E91E63', '9C27B0', '673AB7', '3F51B5', '2196F3', '03A9F4', '00BCD4', '009688', 
		    '4CAF50', '8BC34A', 'CDDC39', 'FFEB3B', 'FFC107', 'FF9800', 'FF5722', '795548', '424242', '607D8B');
		
		$color	= $hexColors[mt_rand(0, count($hexColors)-1)];	
		$im		= imagecreatetruecolor($width, $height);
		$bgColor	= imagecolorallocate($im, hexdec(substr($color, 0, 2)), hexdec(substr($color, 2, 2)), hexdec(substr($color, 4, 2)));
		$white	= imagecolorallocate($im, 255, 255, 255);
		imagefilledrectangle($im, 0, 0, $width, $height, $bgColor);
		
		//$font = realpath(dirname(__FILE__)) . '/arial.ttf';
		$font = PATH_PICMIX . '/include/arial.ttf';
		$bbox = imagettfbbox($fontSize, 0, $font, $text);

		// This is our cordinates for X and Y
		$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2) ;
		$y = $bbox[1] + (imagesy($im) / 2) - ($bbox[5] / 2) ;

		imagettftext($im, $fontSize, 0, $x, $y, $white, $font, $text);
		return imagejpeg($im, $outFile, 95);
	}

	public static function seo($s) {
		$c = array (' ');
		$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
	
		$s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
		
		$s = strtolower(str_replace($c, '_', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
		return $s;
	}
	
	public static function in_multiarray($elem, $array, $field){
		$top = sizeof($array) - 1;
		$bottom = 0;
		$key = "";
		while($bottom <= $top)
		{
			if($array[$bottom][$field] == $elem){
				$key = $bottom;
			} else { 
				if(is_array($array[$bottom][$field]))
					if(in_multiarray($elem, ($array[$bottom][$field]))){
						$key = $bottom;
					}	
			}
			$bottom++;
		}        
		return $key;
	}
	
	public function text_cut($text, $length = 200, $dots = true) {
		$text = trim(preg_replace('#[\s\n\r\t]{2,}#', ' ', $text));
		$text_temp = $text;
		while (substr($text, $length, 1) != " ") { $length++; if ($length > strlen($text)) { break; } }
		$text = substr($text, 0, $length);
		return $text . ( ( $dots == true && $text != '' && strlen($text_temp) > $length ) ? '...' : ''); 
	}
	
	public function parse_youtube($string) {

		$ids = array();

		// find all urls
		preg_match_all('/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', $string, $links);

		foreach ($links[0] as $link) {
			if (preg_match('~youtube\.com~', $link)) {
				
				$regexstr = '~
					# Match Youtube link and embed code
					(?:				 				# Group to match embed codes
						(?:&lt;iframe [^&gt;]*src=")?	 	# If iframe match up to first quote of src
						|(?:				 		# Group to match if older embed
							(?:&lt;object .*&gt;)?		# Match opening Object tag
							(?:&lt;param .*&lt;/param&gt;)*  # Match all param tags
							(?:&lt;embed [^&gt;]*src=")?  # Match embed tag to the first quote of src
						)?				 			# End older embed code group
					)?				 				# End embed code groups
					(?:				 				# Group youtube url
						https?:\/\/		         	# Either http or https
						(?:[\w]+\.)*		        # Optional subdomains
						(?:               	        # Group host alternatives.
						youtu\.be/      	        # Either youtu.be,
						| youtube\.com		 		# or youtube.com 
						| youtube-nocookie\.com	 	# or youtube-nocookie.com
						)				 			# End Host Group
						(?:\S*[^\w\-\s])?       	# Extra stuff up to VIDEO_ID
						([\w\-]{11})		        # $1: VIDEO_ID is numeric
						[^\s]*			 			# Not a space
					)				 				# End group
					"?				 				# Match end quote if part of src
					(?:[^&gt;]*&gt;)?			 			# Match any extra stuff up to close brace
					(?:				 				# Group to match last embed code
						&lt;/iframe&gt;		         	# Match the end of the iframe	
						|&lt;/embed&gt;&lt;/object&gt;	        # or Match the end of the older embed
					)?				 				# End Group of last bit of embed code
					~ix';
				
				preg_match($regexstr, $link, $matches);
				
				$ids[] = $matches[1];
			}
		}

		return $ids;
	}
	
	public static function mongoIdToDateDefault($mongoid){
		$dt = new DateTime("now"); //first argument "must" be a string
		$dt->setTimestamp($mongoid->getTimestamp());

		return $dt->format('Y-m-d H:i:s');
	}
	
	public static function dateDifference($date){
		$datetime1 = date_create(date("Y-m-d H:i:s"));
		$datetime2 = date_create($date);
	   
		$interval = date_diff($datetime1, $datetime2);
		$selisih = json_decode(json_encode($interval), true);

		if($selisih['y'] != 0){
			return $selisih['y'].'y';
		} else if($selisih['m'] != 0){
			return $selisih['m'].'mo';
		} else if($selisih['d'] != 0){
			if($selisih['d'] <= 31){
				if($selisih['d']<7){
					return $selisih['d'].'d';
				} else {
					return floor($selisih['d']/7).'w';
				}
			} else {
				return $selisih['d'].'d';
			}
		} else if($selisih['h'] != 0){
			return $selisih['h'].'h';
		} else {
			if($selisih['i'] < 10){
				return 'Just now';
			} else {
				return $selisih['i'].'m';
			}
		}
	}
}
?>