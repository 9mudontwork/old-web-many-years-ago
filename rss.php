<?php
	include_once 'classes/class.func.php';
	$allFunc = new allFunction;
	
	$myurl = 'https://www.box-manga.com/';
	
	include 'includes/cont.main.php';
	
	$objQuery = $db->Query(APP_TABLES_PREFIX . 'manga_titles','*',null,null,null,array('datetime_post'=>'DESC'));
	
	$date = new DateTime($now);
	$date = $date->format(DATE_RSS);
	
	header('Content-Type: application/xml; charset=utf-8'); 
	header("Last-Modified: ".$date); 
	
	echo '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"><channel><title>'.$web_config['main-title'].'</title><link>'.$myurl.'</link><description>'.$web_config['main-description'].'</description><language>th-TH</language><lastBuildDate>'.$date.'</lastBuildDate><copyright>Copyright '.$myurl.'</copyright><image><title>'.$web_config['main-title'].'</title><url>'.$web_config['url-header'].'</url><link>'.$myurl.'</link></image>';foreach($objQuery as $objResult){$date = new DateTime($objResult["datetime_post"]);$date = $date->format(DATE_ATOM);$mangaURL = $myurl.'manga-'.$objResult["slug"].'/';$mangaIMG = $myurl.'uploads/'.$objResult["cover"];?><item><title><![CDATA[<?=$objResult["name"];?>]]></title><link><?=$mangaURL;?></link><description><![CDATA[<?=$objResult["description"];?>]]></description><pubDate><?=$date;?></pubDate></item><?}?></channel></rss>