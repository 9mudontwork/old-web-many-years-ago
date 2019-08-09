<?
	#ban
	$iplist = array('125.26.86.171',
	'103.233.194.91',
	'128.199.240.204',
	'188.166.243.236');
	foreach($iplist as $ip)
	{
		if ( (strpos($_SERVER['REMOTE_ADDR'], $ip) === 0) || ($_SERVER['HTTP_USER_AGENT'] == 'Apache-HttpClient/UNAVAILABLE (java 1.4)') || ($_SERVER['HTTP_USER_AGENT'] == 'WinHTTP') || ($_SERVER['HTTP_USER_AGENT'] == '') || ($_SERVER['HTTP_USER_AGENT'] == 'WebZIP/4.21 (http://www.spidersoft.com)') ) {
			header('HTTP/1.0 404 Not Found');
			header('Content-Type: text/html; charset=utf-8');
			exit();
		}
	}
?>