<?php
	ob_start();
	session_start();
	include 'includes/cont.main.php';
	
	$act = $_POST['action'];
	if($act == "login")
	{
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		
		if($user == "admin" && $pass == "admin")
		{
			$_SESSION['Admin'] = true;
			$ccAdmin = $_SESSION['Admin'];
			echo "ล็อคอินสำเร็จ กรุณารอสักครู่...";
			setcookie('ccAdmin', $ccAdmin,time()+3600*24*356);
			return false;
			} else {
			echo "รหัสผ่านไม่ถูกต้อง";
			return false;
		}
	}
	if($act == "logout")
	{
		session_destroy();
		setcookie('ccAdmin', false,time()-3600);
		return false;
	}
	if($act == "add-manga")
	{
		if(isAdmin()){

			$inputInfo = array('name'=>str_replace('%26','&',$_POST['name']),
			'slug'=>$_POST['slug'],
			'other_name'=>str_replace('%26','&',$_POST['other_name']),
			'released'=>$_POST['released'],
			'description'=>str_replace('%26','&',$_POST['description']),
			'status'=>$_POST['status'],
			'a_status'=>'',
			'cover'=>$_POST['cover'],
			'datetime_post'=>$now);
			$db->Create(APP_TABLES_PREFIX . 'manga_titles',$inputInfo);
		}
	}
	if($act == "edit-manga")
	{
		if(isAdmin()){

			$inputInfo = array('name'=>str_replace('%26','&',$_POST['name']),
			'slug'=>$_POST['slug'],
			'other_name'=>str_replace('%26','&',$_POST['other_name']),
			'released'=>$_POST['released'],
			'description'=>str_replace('%26','&',$_POST['description']),
			'status'=>$_POST['status'],
			'a_status'=>$_POST['a_status'],
			'cover'=>$_POST['cover']);
			$db->Update(APP_TABLES_PREFIX . 'manga_titles',array('id'=>$_POST['id']),$inputInfo);
		}
	}
	if($act == "add-chapter")
	{
		
		if(isAdmin()){
			$inputInfo = array('manga_id'=>$_POST['id'],
			'name'=>$_POST['ch_name'],
			'chapter'=>$_POST['ch_id'],
			'img_content'=>str_replace('%26','&',$_POST['img_content']),
			'last_update'=>$now);
			$db->Create(APP_TABLES_PREFIX . 'manga_ep',$inputInfo);
			if($_POST['a_status'] != '')
			{
				$inputInfo = array('a_status'=>$_POST['a_status'],'datetime_post'=>$now);
				$db->Update(APP_TABLES_PREFIX . 'manga_titles',array('id'=>$_POST['id']),$inputInfo);
			}
		}
	}
	if($act == "edit-chapter")
	{
		if(isset($_POST['ch_url1']) && ($_POST['ch_url1'] != ''))
		$ch_url = $_POST['ch_url1'];
		if((isset($_POST['ch_url2'])) && ($_POST['ch_url2'] != ''))
		$ch_url = $ch_url.','.$_POST['ch_url2'];
		if((isset($_POST['ch_url3'])) && ($_POST['ch_url3'] != ''))
		$ch_url = $ch_url.','.$_POST['ch_url3'];
		if((isset($_POST['ch_url4'])) && ($_POST['ch_url4'] != ''))
		$ch_url = $ch_url.','.$_POST['ch_url4'];
		if((isset($_POST['ch_url5'])) && ($_POST['ch_url5'] != ''))
		$ch_url = $ch_url.','.$_POST['ch_url5'];
		if((isset($_POST['ch_url6'])) && ($_POST['ch_url6'] != ''))
		$ch_url = $ch_url.','.$_POST['ch_url6'];
		if((isset($_POST['ch_url7'])) && ($_POST['ch_url7'] != ''))
		$ch_url = $ch_url.','.$_POST['ch_url7'];
		if((isset($_POST['ch_url8'])) && ($_POST['ch_url8'] != ''))
		$ch_url = $ch_url.','.$_POST['ch_url8'];
		if((isset($_POST['ch_url9'])) && ($_POST['ch_url9'] != ''))
		$ch_url = $ch_url.','.$_POST['ch_url9'];
		if((isset($_POST['ch_url10'])) && ($_POST['ch_url10'] != ''))
		$ch_url = $ch_url.','.$_POST['ch_url10'];
		
		if(isAdmin()){
			$inputInfo = array('name'=>$_POST['ch_name'],
			'chapter'=>$_POST['ch_id'],
			'trans_group'=>$_POST['trans1'].$_POST['trans2'],
			'url_content'=>str_replace('%26','&',$ch_url),
			'last_update'=>$now);
			$db->Update(APP_TABLES_PREFIX . 'manga_ep',array('id'=>$_POST['id']),$inputInfo);
		}
	}
	if($act == "del-manga")
	{
		if(isAdmin()){
			$db->Delete(APP_TABLES_PREFIX . 'manga_titles',array('id'=>$_POST['id']));
			$db->Delete(APP_TABLES_PREFIX . 'manga_ep',array('manga_id'=>$_POST['id']));
		}
	}
	if($act == "del-chapter")
	{
		if(isAdmin()){
			$db->Delete(APP_TABLES_PREFIX . 'manga_ep',array('id'=>$_POST['id']));
		}
	}
	if($act == "del-cover")
	{
		if(isAdmin()){
			$fileName = $_POST['cname'];
			$filePath = 'uploads/'.$fileName;
			// remove file if it exists
			if ( file_exists($filePath) ) {
				unlink($filePath);
			}
		}
	}
	if($act == "web-setting")
	{
		if(isAdmin()){
			$string = '<?php
			$web_config[\'home-url\'] = "'.$_POST['home-url'].'";
			$web_config[\'home-title\'] = "'.$_POST['home-title'].'";
			$web_config[\'url-header\'] = "'.$_POST['url-header'].'";
			';
			$fp = fopen("includes/seo.php", "w");
			fwrite($fp, $string);
			fclose($fp);
		}
	}
	if($act == "seo-setting")
	{
		if(isAdmin()){
			$string = '<?php
			$web_config[\'main-title\'] = "'.$_POST['main-title'].'";
			$web_config[\'main-description\'] = "'.$_POST['main-description'].'";
			$web_config[\'main-keyword\'] = "'.$_POST['main-keyword'].'";
			
			$web_config[\'detail-title\'] = "'.$_POST['detail-title'].'";
			$web_config[\'detail-description\'] = "'.$_POST['detail-description'].'";
			$web_config[\'detail-keyword\'] = "'.$_POST['detail-keyword'].'";
			
			$web_config[\'chapter-title\'] = "'.$_POST['chapter-title'].'";
			$web_config[\'chapter-description\'] = "'.$_POST['chapter-description'].'";
			$web_config[\'chapter-keyword\'] = "'.$_POST['chapter-keyword'].'";
			';
			$fp = fopen("includes/seo2.php", "w");
			fwrite($fp, $string);
			fclose($fp);
		}
	}
	if($act == "autoslug")
	{
		echo slug($_POST['slug']);
	}
	function slug($str) {
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
		$str = preg_replace('/[^A-Za-z0-9\-._]/', '', $str); // Removes special chars.
		$str = preg_replace('/-+/', '-', $str);
		$str = strtolower($str);
		return $str;
	}
?>