<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Image_utils {
	
	public static function newTextProfilePict($text, $outFile, $fontSize = 88, $width = 200, $height = 200 ) {
		//Color palettes
		$hexColors = array('F44336', 'E91E63', '9C27B0', '673AB7', '3F51B5', '2196F3', '03A9F4', '00BCD4', '009688', 
		    '4CAF50', '8BC34A', 'CDDC39', 'FFEB3B', 'FFC107', 'FF9800', 'FF5722', '795548', '424242', '607D8B');
		
		$color	= $hexColors[mt_rand(0, count($hexColors)-1)];	
		$im		= imagecreatetruecolor($width, $height);
		$bgColor	= imagecolorallocate($im, hexdec(substr($color, 0, 2)), hexdec(substr($color, 2, 2)), hexdec(substr($color, 4, 2)));
		$white	= imagecolorallocate($im, 255, 255, 255);
		imagefilledrectangle($im, 0, 0, $width, $height, $bgColor);
		
		$font = realpath(dirname(__FILE__)) . '/arial.ttf';
		$bbox = imagettfbbox($fontSize, 0, $font, $text);

		// This is our cordinates for X and Y
		$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2) ;
		$y = $bbox[1] + (imagesy($im) / 2) - ($bbox[5] / 2) ;

		imagettftext($im, $fontSize, 0, $x, $y, $white, $font, $text);
		return imagejpeg($im, $outFile, 90);
	}
}
