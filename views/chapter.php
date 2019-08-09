<?php
	include_once _DIR . '/class/mysql.class.php';
	include_once _DIR . '/class/pagination.class.php';
	include_once _DIR . '/views/include/function.php';
	include_once _DIR . '/include/seo.php';
	$myFunction = new myFunction;
	$myFunction->root_uri = $this->root_uri;
	
	
	/* echo $this->root_uri;
		echo '<br>';
		echo $this->can_url;
		echo '<br>';
		echo $this->get_uri;
		echo '<br>';
	echo $this->get_uri_2; */
	
	# ดึงข้อมูลเรื่องที่ต้องการ
	$query = $db->Query(APP_TABLES_PREFIX . 'manga_titles','id,name,slug,other_name,cover',array('slug'=>$this->get_uri));
	
	if(!$query[0])
	{
		header('HTTP/1.0 404 Not Found');
		header('Location: '.$this->root_uri);
		exit();
	}
	
	$thisManga = $query[0];
	
	# get all chapter manga #
	$queryAllChapter = $db->Query(APP_TABLES_PREFIX . 'manga_ep','chapter,name',array('manga_id'=>$thisManga['id']),null,null,array('abs(chapter)'=>'DESC'));
	# get this chapter
	$thisChapter = $db->Query(APP_TABLES_PREFIX . 'manga_ep','*',array('manga_id'=>$thisManga['id'],'chapter'=>$this->get_uri_2));
	
	if(!$thisChapter[0])
	{
		header('HTTP/1.0 404 Not Found');
		header('Location: '.$this->root_uri.'manga-'.$this->get_uri.'/');
		exit();
	}
	$thisChapter = $thisChapter[0];
	
	$inputInfo = array('count_view'=>$thisChapter['count_view'] = $thisChapter['count_view']+1);
	$db->Update(APP_TABLES_PREFIX . 'manga_ep',array('manga_id'=>$thisManga['id'],'chapter'=>$thisChapter['chapter']),$inputInfo);
	
	
	# gen meta #
	$web_config['chapter-title'] = preg_replace('/{detail-title}/i', $thisManga['name'], $web_config['chapter-title']);
	$web_config['chapter-title'] = preg_replace('/{chapter-title-num}/i', str_replace('ตอนที่ ','',$thisChapter['name']), $web_config['chapter-title']);
	$web_config['chapter-title'] = preg_replace('/{chapter-title}/i', $thisChapter['name'], $web_config['chapter-title']);
	
	$web_config['chapter-description'] = preg_replace('/{detail-title}/i', $thisManga['name'], $web_config['chapter-description']);
	$web_config['chapter-description'] = preg_replace('/{chapter-title}/i', $thisChapter['name'], $web_config['chapter-description']);
	$web_config['chapter-description'] = preg_replace('/{chapter-title-num}/i', str_replace('ตอนที่ ','',$thisChapter['name']), $web_config['chapter-description']);
	$web_config['chapter-description'] = preg_replace('/{chapter-other-title}/i', $thisManga['other_name'], $web_config['chapter-description']);
	
	$web_config['chapter-keyword'] = preg_replace('/{detail-title}/i', $thisManga['name'], $web_config['chapter-keyword']);
	$web_config['chapter-keyword'] = preg_replace('/{chapter-title-num}/i', str_replace('ตอนที่ ','',$thisChapter['name']), $web_config['chapter-keyword']);
	$web_config['chapter-keyword'] = preg_replace('/{chapter-title}/i', $thisChapter['name'], $web_config['chapter-keyword']);
	$web_config['chapter-keyword'] = preg_replace('/{chapter-other-title}/i', $thisManga['other_name'], $web_config['chapter-keyword']);
	
	# gen seo
	$head['title'] = $web_config['chapter-title'];
	$head['description'] = htmlspecialchars($web_config['chapter-description']);
	$head['keywords'] = htmlspecialchars($web_config['chapter-keyword']);
	$head['favicon'] = $this->root_uri.'views/views/favicon.ico';
	$head['ogtype'] = 'article';
	$head['ogsitename'] = 'www.box-manga.com';
	$head['publisher'] = 'https://www.facebook.com/box.manga.page';
	$head['app_id'] = '463370687174583';
	$head['ogtitle'] = htmlspecialchars($head['title']);
	$head['ogdescription'] = htmlspecialchars($web_config['chapter-keyword']);
	//$head['ogimage'] = $this->root_uri.'uploads/'.$thisManga['cover'];
	$head['ogimage'] = $thisManga['cover'];
	$head['can_url'] = $this->can_url;
	
	$thisChapter['last_update'] = new DateTime($thisChapter['last_update']);
	$thisChapter['last_update'] = $thisChapter['last_update']->format(DATE_ATOM);
	$head['uptime'] = $thisChapter['last_update'];
	
	include_once _DIR . '/views/views/chapter.php';
?>