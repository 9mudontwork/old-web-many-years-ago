<?php
	
	//ob_start();
	session_start();
	//error_reporting(-1);
	/* ROOT DIR */
	define( 'ROOT_DIR', realpath(dirname(__FILE__) . '/..') );
	
	include ROOT_DIR.'/includes/config2.php';
	
	include ROOT_DIR.'/classes/class.db2.php';
	
	$db = MySQLDatabase::GetInstance();
	//$huy = new huy();
	
	date_default_timezone_set('Asia/Bangkok');
	$now = date("Y-m-d H:i:s");
	
	function isAdmin(){
		return (isset($_SESSION['Admin']) ? true : false);
	}