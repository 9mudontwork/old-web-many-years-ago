<?php
	
	/* #ban
		$iplist = array('125.26.86.171','103.233.194.143','125.25.30.197','119.46.60.66','124.120.81.227');
		foreach($iplist as $ip)
		{
		if ( (strpos($_SERVER['REMOTE_ADDR'], $ip) === 0) || ($_SERVER['HTTP_USER_AGENT'] == 'Apache-HttpClient/UNAVAILABLE (java 1.4)') ) {
		header('HTTP/1.0 404 Not Found');
		header('Content-Type: text/html; charset=utf-8');
		header( "location: http://manga555.com/" );
		exit();
		}
	} */
	include 'banip.php';
	/*
	$strFileName = "logweb.php";
	
	if(filesize($strFileName) > 300000)
	{
		unlink($strFileName);
	}
	
	$objFopen = fopen($strFileName, 'a');
	$strText1 = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']).' - '.$_SERVER['REMOTE_ADDR'].' - '.$_SERVER["REQUEST_METHOD"].' - '.$_SERVER['REQUEST_URI'].' - '.$_SERVER['HTTP_REFERER'].' - '.$_SERVER['HTTP_USER_AGENT'].'<br>';
	fwrite($objFopen, $strText1);
	fclose($objFopen); */
	
	# Difine รูทโฟลเดอร์
	define("_DIR",str_replace('\\', '/', dirname(__FILE__)));
	
	include_once _DIR .'/cont/uri.cont.php'; #ไฟล์ จัดการ url
	$set_uri = new SetURI;
	$set_uri->ResultURI();
	
	$arr_uri = $set_uri->arr_uri;
	
	if($arr_uri[0] == null)
	$set_uri->SendIndex();
	
	if($arr_uri[0] == 'page')
	$set_uri->SendIndexPage($arr_uri[1]);
	
	if(($set_uri->arr_uri[0] != null) && ($arr_uri[0] != 'page'))
	$set_uri->SendOtherPage($arr_uri[0]);
?>
