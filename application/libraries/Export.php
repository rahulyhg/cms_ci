<?php

class Export{
    
    function to_excel($array, $filename) {
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'.xls');
	
		//Filter all keys, they'll be table headers
		$h = array();
		foreach($array as $row){
			foreach($row as $key=>$val){
				if(!in_array($key, $h)){
				 $h[] = $key;   
				}
			}
		}
		//echo the entire table headers
		echo '<table><tr>';
		foreach($h as $key) {
			$key = ucwords($key);
			echo '<th>'.$key.'</th>';
		}
		echo '</tr>';
		
		foreach($array as $row){
			echo '<tr>';
			foreach($row as $val){
				$this->writeRow($val);
			}
		}
		echo '</tr>';
		echo '</table>';	
	}
	
	function to_excel_noheaders($array, $filename) {
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'.xls');
	
		//Filter all keys, they'll be table headers
		$h = array();
		foreach($array as $row){
			foreach($row as $key=>$val){
				if(!in_array($key, $h)){
				 $h[] = $key;   
				}
			}
		}
		//echo the entire table headers
		echo '<table>';
		
		foreach($array as $row){
			echo '<tr>';
			foreach($row as $val){
				$this->writeRow($val);
			}
		}
		echo '</tr>';
		echo '</table>';	
	}
	
    function writeRow($val) {
       	echo '<td>'.utf8_decode($val).'</td>';              
    }
	
	function to_csv_report_group($array,$filename)
	{
		header('Content-Type: application/csv');
		header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");	
		header("Content-Transfer-Encoding: UTF-8");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$no = 1;
		$res = "Date, New Group, User Join, Unique User Join, Media Photo, Media Video, Media Text, Chat, Users Who Can Chat, Unique New Group, Unique Media, Group Active \n";
		for($i=0;$i<count($array);$i++)
		{
		 $res .= $array[$i]['dt'].",".$array[$i]['new_group'].",".$array[$i]['user_join'].",".$array[$i]['unique_user_join'].",".$array[$i]['photo'].",".$array[$i]['video'].",".$array[$i]['text'].",".$array[$i]['chat'].",".$array[$i]['users_who_can_chat'].",".$array[$i]['unique_new_group'].",".$array[$i]['unique_media'].",".$array[$i]['group_active']." \n";
		 $no++;
		}
		echo $res;
	}
	
	function to_csv_report_withdraw($array,$filename)
	{
		header('Content-Type: application/csv');
		header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");	
		header("Content-Transfer-Encoding: UTF-8");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$no = 1;
		$res = "No., Name, Email, Phone Number, Bank, Account Name, Account Number, Amount, No KTP, No NPWP, Status, Create Date,KTP URL, NPWP URL \n";
		for($i=0;$i<count($array);$i++)
		{
		 $res .= $array[$i]['no'].",".$array[$i]['name'].",".$array[$i]['email'].",".$array[$i]['phone_number'].",".$array[$i]['bank'].",".$array[$i]['account_name'].",".$array[$i]['account_number'].",".$array[$i]['amount'].",".$array[$i]['noktp'].",".$array[$i]['nonpwp'].",".$array[$i]['status'].",".$array[$i]['create_date'].",".$array[$i]['ktpimageurl'].",".$array[$i]['npwpimageurl']."\n";
		 $no++;
		}
		echo $res;
	}
	
	function to_csv_report_payout($array,$filename)
	{
		header('Content-Type: application/csv');
		header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");	
		header("Content-Transfer-Encoding: UTF-8");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$no = 1;
		$res = "No., Reference Number, Name, Email, Phone Number, Bank, Account Name, Account Number, Amount, Payout, Status, Request Date, Action Date, No NPWP, NPWP URL, No KTP, KTP URL \n";
		for($i=0;$i<count($array);$i++)
		{
		 $res .= $array[$i]['no'].",".$array[$i]['ref_no'].",".$array[$i]['name'].",".$array[$i]['email'].",".$array[$i]['phone_number'].",".$array[$i]['bank'].",".$array[$i]['account_name'].",".$array[$i]['account_number'].",".$array[$i]['amount'].",".$array[$i]['payout'].",".$array[$i]['status'].",".$array[$i]['request_date'].",".$array[$i]['action_date'].",".$array[$i]['nonpwp'].",".$array[$i]['npwpimageurl'].",".$array[$i]['noktp'].",".$array[$i]['ktpimageurl']."\n";
		 $no++;
		}
		echo $res;
	}
	
	function to_csv_report_ovo($array,$filename)
	{
		header('Content-Type: application/csv');
		header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");	
		header("Content-Transfer-Encoding: UTF-8");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$no = 1;
		$res = "No., Name, Email, Phone Number, Amount, Payout, No KTP, No NPWP, Status, Create Date,KTP URL, NPWP URL \n";
		for($i=0;$i<count($array);$i++)
		{
		 $res .= $array[$i]['no'].",".$array[$i]['name'].",".$array[$i]['email'].",".$array[$i]['phone_number'].",".$array[$i]['amount'].",".$array[$i]['payout'].",".$array[$i]['noktp'].",".$array[$i]['nonpwp'].",".$array[$i]['status'].",".$array[$i]['create_date'].",".$array[$i]['ktpimageurl'].",".$array[$i]['npwpimageurl']."\n";
		 $no++;
		}
		echo $res;
	}
	
	function to_csv_report_game($array,$filename)
	{
		header('Content-Type: application/csv');
		header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");	
		header("Content-Transfer-Encoding: UTF-8");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$no = 1;
		$res = "No., Game, New User, Total User, Winner, Prize, Prize Winner, Babak Maruk User, Babak Maruk Winner, Babak Maruk Prize Winner \n";
		for($i=0;$i<count($array);$i++)
		{
		 $res .= $array[$i]['no'].",".$array[$i]['game'].",".$array[$i]['new_user'].",".$array[$i]['total_user'].",".$array[$i]['winner'].",".$array[$i]['prize'].",".$array[$i]['prize_winner'].",".$array[$i]['bm_user'].",".$array[$i]['bm_winner'].",".$array[$i]['bm_prize_winner']."\n";
		 $no++;
		}
		echo $res;
	}
	
	function to_csv_report_dailyregister($array,$filename)
	{
		header('Content-Type: application/csv');
		header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");	
		header("Content-Transfer-Encoding: UTF-8");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$res = "Date, Facebook SMS, Google, Android, IOS, Total\n";
		for($i=0;$i<count($array);$i++)
		{
		 $res .= $array[$i]['dt'].",".$array[$i]['reg_ak'].",".$array[$i]['reg_gl'].",".$array[$i]['reg_and'].",".$array[$i]['reg_ios'].",".$array[$i]['total']." \n";
		}
		echo $res;
	}
	
	function to_csv_report_submittrivia($array,$filename)
	{
		header('Content-Type: application/csv');
		header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");	
		header("Content-Transfer-Encoding: UTF-8");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$res = "Name,Question,Answer,Option 1,Option 2,Option 3,Category\n";
		for($i=0;$i<count($array);$i++)
		{
		 $res .= $array[$i]['name'].",".$array[$i]['question'].",".$array[$i]['opttrue'].",".$array[$i]['opt1'].",".$array[$i]['opt2'].",".$array[$i]['opt3'].",".$array[$i]['cat_title']." \n";
		}
		echo $res;
	}
	
	function to_csv_report_totalplayer($array,$filename)
	{
		header('Content-Type: application/csv');
		header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");	
		header("Content-Transfer-Encoding: UTF-8");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$no = 1;
		$res = "No., Start, Total Play \n";
		for($i=0;$i<count($array);$i++)
		{
		 $res .= $array[$i]['no'].",".$array[$i]['start'].",".$array[$i]['total_play']."\n";
		 $no++;
		}
		echo $res;
	}
}
?>