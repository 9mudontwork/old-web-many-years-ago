<?php
	#ban
	$iplist = array('171.5.237.190');
	foreach($iplist as $ip)
	{
		if (strpos($_SERVER['REMOTE_ADDR'], $ip) === 0) {
			header('HTTP/1.0 404 Not Found');
			header('Content-Type: text/html; charset=utf-8');
			echo "<h1>พอเหอะ ต้องการอะไรวะ อยากรู้จริงๆ มาก่อกวนอยู่ได้ทุกวี่ทุกวัน แบนวิทมันอันลิมิต - - </h1>";
			exit();
		}
	}
	
	include_once 'includes/seo.php';
	include_once 'includes/seo2.php';
	
	class allFunction
	{
		public function curPageURL()
		{
			$pageURL = 'http';
			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			return $pageURL;
		}
		public function agotime($date)
		{
			if(empty($date)) {
				return "No date provided";
			}
			
			$periods         = array("วินาที", "นาที", "ชั่วโมง", "วัน", "อาทิตย์", "เดือน", "ปี");
			$lengths         = array("60","60","24","7","4.35","12");
			
			$now             = time();
			$unix_date         = strtotime($date);
			
			// check validity of date
			if(empty($unix_date)) {    
				return "Bad date";
			}
			
			// is it future date or past date
			if($now > $unix_date) {    
				$difference     = $now - $unix_date;
				$tense         = "ที่แล้ว";
				
				} else {
				$difference     = $unix_date - $now;
				$tense         = "เมื่อสักครู่";
			}
			
			for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
				$difference /= $lengths[$j];
			}
			
			$difference = round($difference);
			
			return "$difference $periods[$j] {$tense}";
		}
		
		//จับเวลาโหลดหน้าเว็บ
		var $_start ;
		var $_end ;
		public function _startTime(){
			$this->_startTime = time()+ microtime();
		}
		public function _endTime(){
			$this->_endTime = time()+ microtime();
			return round($this->_endTime - $this->_startTime,4) ;
		}
		
		public function _head($title,$desc,$key,$type,$cur_url,$ogimg,$url,$ptime=null)
		{
			if($type != 'website')
			{
				$myjs = '<script type="text/javascript" src="'.$url.'js/way.min.js?v=1002"></script>';
				$newptime = '<meta property="article:published_time" content="'.$ptime.'" />';
			}
			return 
			'<!DOCTYPE html>
			<html lang="th" prefix="og: http://ogp.me/ns#">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			
			<title>'.$title.'</title>
			<meta name="description" content="'.htmlspecialchars($desc).'">
			<meta name="keywords" content="'.htmlspecialchars($key).'">
			<link rel="icon" href="'.$url.'favicon.ico">
			<link rel="apple-touch-icon" href="'.$url.'favicon.ico">
			<link rel="apple-touch-icon-precomposed" href="'.$url.'favicon.ico">
			
			<meta name="robots" content="noodp,noydir,index,follow,noarchive"/>
			<meta property="og:locale" content="th_TH" />
			<meta property="og:type" content="'.$type.'" />
			<meta property="og:site_name" content="'.htmlspecialchars($title).'" />
			<meta property="article:publisher" content="https://www.facebook.com/box.manga.page" />
			<meta property="fb:app_id" content="463370687174583" />
			
			<meta property="og:title" content="'.htmlspecialchars($title).'" />
			<meta property="og:description" content="'.htmlspecialchars($desc).'" />
			<meta property="og:url" content="'.$cur_url.'" />
			<meta property="og:image" content="'.$ogimg.'" />
			'.$newptime.'
			<link rel="canonical" href="'.$cur_url.'" />
			
			<link rel="alternate" type="application/rss+xml" title="RSS" href="'.$url.'rss.php" />
			<!-- Bootstrap core CSS -->
			<link href="'.$url.'css/bootstrap.min.css?v=1001" rel="stylesheet">
			<link href="'.$url.'css/bootswatch.min.css?v=1001" rel="stylesheet">
			<link href="'.$url.'css/custom.css?v=1011" rel="stylesheet">
			
			<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js?v=1001"></script>
			<script type="text/javascript" src="'.$url.'js/bootstrap.min.js?v=1002"></script>
			<!--<script type="text/javascript" src="'.$url.'js/smoothscroll.js?v=1001"></script>-->
			
			'.$myjs.'
			<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->
			</head>';
		}
		public function _menu($url,$title,$page,$manga_name=null,$url_manga=null)
		{
			if($page == 'index')
			$list = '<li><a href="'.$url.'list/">รายชื่อการ์ตูน</a></li>';
			if($page == 'manga')
			$list = '<li class="active"><a href="#">มังงะ</a></li>
			<li><a href="'.$url.'list/">รายชื่อการ์ตูน</a></li>';
			if($page == 'chapter')
			$list = '<li class="active"><a href="'.$url_manga.'">'.$manga_name.'</a></li>
			<li><a href="'.$url.'list/">รายชื่อการ์ตูน</a></li>';
			if($page == 'list')
			$list = '<li class="active"><a href="'.$url.'list/">รายชื่อการ์ตูน</a></li>';
			return'<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
			<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="'.$url.'">'.$title.'</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
			'.$list.'
			</ul>
			<form action="'.$url.'list/" class="navbar-form navbar-right" role="search">
			<div class="form-group">
			<input id="s" name="s" type="text" class="form-control" placeholder="ค้นหาการ์ตูน">
			</div>
			<button type="submit" class="btn btn-default">ค้นหา</button>
			</form>
			</div><!--/.nav-collapse -->
			</div>
			</nav>
			<div style="max-height: 500px;overflow: hidden;text-align: center;margin-bottom: 21px;/* margin-top: 10px; */" class="headerdiv">
			<img style="width: 100%;position: relative;max-height: 350px;" src="'.$url.'header.jpg" alt="'.$title.'">
			</div>';
		}
	}
?>