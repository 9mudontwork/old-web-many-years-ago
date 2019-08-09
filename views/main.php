<?php
	include_once _DIR . '/class/mysql.class.php';
	include_once _DIR . '/class/pagination.class.php';
	include_once _DIR . '/views/include/function.php';
	include_once _DIR . '/include/seo.php';
	$myFunction = new myFunction;
	$myFunction->root_uri = $this->root_uri;
	
	if($this->arr_uri_get['s'])
	{
		switch($_GET['s'])
		{
			case 'mostviews':
			$search = $_GET['s'];
			$objPost = $db->Query(APP_TABLES_PREFIX . 'manga_titles','name,slug,description,status,a_status,cover,datetime_post,count_view',null,null,null,array('count_view'=>'DESC'));
			break;
			
			case 'manga-end':
			$objPost = $db->Query(APP_TABLES_PREFIX . 'manga_titles','name,slug,description,status,a_status,cover,datetime_post,count_view',"status = '1'",null,null,array('datetime_post'=>'DESC'));
			break;
			
			case 'manga-ongoing':
			$objPost = $db->Query(APP_TABLES_PREFIX . 'manga_titles','name,slug,description,status,a_status,cover,datetime_post,count_view',"status = '2'",null,null,array('datetime_post'=>'DESC'));
			break;
			
			case 'a-to-z':
			$objPost = $db->Query(APP_TABLES_PREFIX . 'manga_titles','name,slug',null,null,null,array('name'=>'ASC'));
			break;
			
			case 'last-chapter':
			$objPost = $db->Query(APP_TABLES_PREFIX . '`manga_ep` LEFT JOIN `manga_titles` ON manga_ep.manga_id=manga_titles.id','manga_ep.manga_id as ch_manga_id,manga_ep.name as ch_name,manga_ep.chapter as ch_id,manga_ep.last_update as ch_last_update,manga_titles.name as manga_name,manga_titles.slug as manga_slug,manga_titles.cover as manga_cover',null,null,null,array('manga_ep.last_update'=>'DESC'),array('offset'=>'0','rows'=>'50'));
			break;
			
			default:
			$search = urldecode($_GET['s']);
			$objPost = $db->Query(APP_TABLES_PREFIX . 'manga_titles','name,slug,description,status,a_status,cover,datetime_post,count_view',"name LIKE '%".$search."%' OR other_name LIKE '%".$search."%'");
			break;
		}
	}
	else
	{
		$objPost = $db->Query(APP_TABLES_PREFIX . 'manga_titles','name,slug,description,status,a_status,cover,datetime_post,count_view',null,null,null,array('datetime_post'=>'DESC'));
	}
	
	$myFunction->Num_Rows = count($objPost); # จำนวนโพสทั้งหมด
	
	$Page_Start = (($myFunction->Per_Page*$this->Page)-$myFunction->Per_Page);
	$Page_End = $Page_Start+$myFunction->Per_Page;
	
	### เช็คแสดง title
	
	if(!$this->arr_uri_get['s'])
	{
		if($this->Page == 1)
		$head['title'] = $web_config['main-title'];
		
		if($this->Page != 1)
		$head['title'] = 'มังงะเรียงตามอัพเดทล่าสุด หน้า '.$this->Page.' จาก '.ceil($myFunction->Num_Rows / $myFunction->Per_Page).' หน้า - ทั้งหมด '.$myFunction->Num_Rows.' เรื่อง - '.$web_config['main-title'];
	}
	elseif($this->arr_uri_get['s'])
	{
		switch($_GET['s'])
		{
			case 'mostviews':
			$head['title'] = 'มังงะเรียงตามคนอ่านมากสุด หน้า '.$this->Page.' จาก '.ceil($myFunction->Num_Rows / $myFunction->Per_Page).' หน้า - '.$web_config['main-title'];
			break;
			
			case 'manga-end':
			$head['title'] = 'มังงะจบแล้ว หน้า '.$this->Page.' จาก '.ceil($myFunction->Num_Rows / $myFunction->Per_Page).' หน้า - ทั้งหมด '.$myFunction->Num_Rows.' เรื่อง - '.$web_config['main-title'];
			break;
			
			case 'manga-ongoing':
			$head['title'] = 'มังงะยังไม่จบ หน้า '.$this->Page.' จาก '.ceil($myFunction->Num_Rows / $myFunction->Per_Page).' หน้า - ทั้งหมด '.$myFunction->Num_Rows.' เรื่อง - '.$web_config['main-title'];
			break;
			
			case 'a-to-z':
			$head['title'] = 'รายชื่อมังงะทั้งหมด '.$myFunction->Num_Rows.' เรื่อง - '.$web_config['main-title'];
			break;
			
			case 'last-chapter':
			$head['title'] = 'มังงะ 50 ตอน อัพเดทล่าสุด - '.$web_config['main-title'];
			break;
			
			default:
			$head['title'] = 'ค้นหามังงะที่มีคำว่า '.urldecode($_GET['s']).' หน้า '.$this->Page.' จาก '.ceil($myFunction->Num_Rows / $myFunction->Per_Page).' หน้า - '.$web_config['main-title'];
			break;
		}
	}

	$head['description'] = htmlspecialchars($web_config['main-description']);
	$head['keywords'] = htmlspecialchars($web_config['main-keyword']);
	$head['favicon'] = $this->root_uri.'views/views/favicon.ico';
	$head['ogtype'] = 'website';
	$head['ogsitename'] = 'www.box-manga.com';
	$head['publisher'] = 'https://www.facebook.com/box.manga.page';
	$head['app_id'] = '463370687174583';
	$head['ogtitle'] = htmlspecialchars($head['title']);
	$head['ogdescription'] = htmlspecialchars($web_config['main-description']);
	$head['ogimage'] = 'https://www.box-manga.com/coverpage3.jpg';
	$head['can_url'] = $this->can_url;
	$head['rss'] = ''; //$this->root_uri.'rss.php';
	
	include _DIR . '/views/views/main.php';
?>