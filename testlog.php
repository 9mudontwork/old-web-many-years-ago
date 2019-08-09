<html>
	<head>
		<title>ThaiCreate.Com PHP & writefile</title>
	</head>
	<body>
		<?php
			/* $strFileName = "logweb.php";
				$objFopen = fopen($strFileName, 'a');
				$strText1 = 'ไอพี '.$_SERVER['HTTP_X_REAL_IP'].' ไอพี '.$_SERVER['HTTP_X_REAL_IP'].' ใช้ '.$_SERVER['HTTP_USER_AGENT'].' มาจาก '.$_SERVER['HTTP_REFERER'].'<br>';
				fwrite($objFopen, $strText1);
			fclose($objFopen); */
			$strFileName = "logweb.php";
			if(filesize($strFileName) > 300000)
			{
				unlink($strFileName);
			}
			echo date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']).' - '.$_SERVER['REMOTE_ADDR'].' - '.$_SERVER['REQUEST_URI'].' - '.$_SERVER['HTTP_REFERER'].' - '.$_SERVER['HTTP_USER_AGENT'];
			print_r($_SERVER);
		?>
	</body>
</html>