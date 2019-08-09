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
	echo $this->get_uri; */
	
	
	if($this->get_uri)
	{
		$query = $db->Query(APP_TABLES_PREFIX . 'manga_titles','*',array('slug'=>$this->get_uri));
	}
	
	if(!$query[0])
	{
		header('HTTP/1.0 404 Not Found');
		header('Location: '.$this->root_uri);
		exit();
	}
	
	$thisPost = $query[0]; //object ของ post
	
	$web_config['detail-title'] = preg_replace('/{detail-title}/i', $thisPost['name'], $web_config['detail-title']);
	
	$web_config['detail-description'] = preg_replace('/{detail-title}/i', $thisPost['name'], $web_config['detail-description']);
	$web_config['detail-description'] = preg_replace('/{detail-other-title}/i', $thisPost['other_name'], $web_config['detail-description']);
	
	$web_config['detail-keyword'] = preg_replace('/{detail-title}/i', $thisPost['name'], $web_config['detail-keyword']);
	$web_config['detail-keyword'] = preg_replace('/{detail-other-title}/i', $thisPost['other_name'], $web_config['detail-keyword']);
	
	if($thisPost['status'] == '1')
	{
		$realStatus = '<span class="label label-info">จบ</span>';
	}
	elseif($thisPost['status'] == '2')
	{
		$realStatus .= ' <span class="label label-info">ยังไม่จบ</span>';
	}
	
	//เรียกรายชื่อตอน
	$query = $db->Query(APP_TABLES_PREFIX . 'manga_ep','id,manga_id,name,chapter,last_update,count_view',array('manga_id'=>$thisPost['id']),null,null,array('abs(chapter)'=>'DESC'));
	
	$inputInfo = array('count_view'=>$thisPost['count_view'] = $thisPost['count_view']+1);
	$db->Update(APP_TABLES_PREFIX . 'manga_titles',array('id'=>$thisPost['id']),$inputInfo);
	
	function CheckGroup($thisStatus)
	{
		if($thisStatus == '1')
		$realStatus = 'จบ';
		if($thisStatus == '2')
		$realStatus = 'ยังไม่จบ';
		
		return $realStatus;
	}
	
	$head['title'] = $web_config['detail-title'];
	$head['description'] = htmlspecialchars($web_config['detail-description']);
	$head['keywords'] = htmlspecialchars($web_config['detail-keyword']);
	$head['favicon'] = $this->root_uri.'views/views/favicon.ico';
	$head['ogtype'] = 'article';
	$head['ogsitename'] = 'www.box-manga.com';
	$head['publisher'] = 'https://www.facebook.com/box.manga.page';
	$head['app_id'] = '463370687174583';
	$head['ogtitle'] = htmlspecialchars($head['title']);
	$head['ogdescription'] = htmlspecialchars($web_config['detail-keyword']);
	//$head['ogimage'] = $this->root_uri.'uploads/'.$thisPost['cover'];
	$head['ogimage'] = $thisPost['cover'];
	$head['can_url'] = $this->can_url;
	
	$thisPost['datetime_post'] = new DateTime($thisPost['datetime_post']);
	$thisPost['datetime_post'] = $thisPost['datetime_post']->format(DATE_ATOM);
	$head['uptime'] = $thisPost['datetime_post'];
	
	include_once _DIR . '/views/views/content.php';
?>