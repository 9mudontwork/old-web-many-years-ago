<?php
	class SetURI{
		public $arr_uri = array(); #uri แบ่งเป็นเป็น array จาก /
		public $arr_uri_get = array(); #uri แบ่งเป็นเป็น array จาก GET
		public $get_uri = ''; #uri # เอาไว้ query
		public $get_uri_2 = ''; #uri # เอาไว้ query 2
		public $can_url = ''; #canonical url ที่แท้จริงของลิงก์
		#ตั้งค่า url
		public $root_uri = ''; #ลิงก์ root folder
		public $prefix_uri = ''; # / แรก
		public $prefix_uri_2 = ''; # / ที่สอง
		public $prefix_uri_page = '';
		public $page_type = ''; # ประเภทหน้า
		
		public $Page = ''; #page หน้า 123..
		
		public function __construct() {
			include_once _DIR . '/config/uri.con.php'; #ไฟล์ ตั้งค่า url
			$this->root_uri = $root_uri;
			$this->prefix_uri = $prefix_uri;
			$this->prefix_uri_2 = $prefix_uri_2;
			$this->prefix_uri_page = $prefix_uri_page;
		}
		
		#เรียก main.php
		public function SendIndex(){
			$this->can_url = $this->root_uri;
			
			if($_GET['s']){ $haveGET = isset($_GET['s']) ? '?s='.$_GET['s'] : '';}
			$this->can_url = $this->root_uri.$haveGET;
			
			$this->page_type = 'main';
			$this->Page = 1;
			include _DIR . '/views/main.php';
		}
		
		#เรียก main.php แบบ page
		public function SendIndexPage($Page){
			if(!is_numeric($Page)){
				header('HTTP/1.1 301 Moved Permanently');
				header('Location: '.$this->root_uri);
				exit();
			}
			if($this->arr_uri[2]){
				header('HTTP/1.1 301 Moved Permanently');
				header('Location: '.$this->root_uri);
				exit();
			}
			$this->page_type = 'page';
			$this->Page = $Page;
			
			if($_GET['s']){ $haveGET = isset($_GET['s']) ? '?s='.$_GET['s'] : '';}
			
			$this->can_url = $this->root_uri .'page/'.$Page.'/'.$haveGET;
			include_once _DIR . '/views/main.php';
		}
		
		#เรียกไฟลือื่น
		public function SendOtherPage($uri){
			# ถ้า / แรก ตรงกับที่ตั้งค่าไว้
			if(strpos($uri,$this->prefix_uri) === 0){
				# ถ้า / สอง ตรงกับที่ตั้งค่าไว่
				if(strpos($this->arr_uri[1],$this->prefix_uri_2) === 0){
					
					$this->get_uri = str_replace($this->prefix_uri,'',$uri);
					$this->get_uri_2 = str_replace($this->prefix_uri_2,'',$this->arr_uri[1]);
					$this->can_url = $this->root_uri . $uri.'/'.$this->arr_uri[1].'/';
					
					if($this->arr_uri[2]){
						header('HTTP/1.0 404 Not Found');
						header('Location: '.$this->can_url);
						exit();
					}
					
					$this->page_type = 'chapter';
					include_once _DIR . '/views/chapter.php';
					exit();
				}
				# ถ้า / แรก ตรงกับที่ตั้งค่าไว้
				elseif( (strpos($uri,$this->prefix_uri) === 0) && !isset($this->arr_uri[1]) ){
					
					$this->get_uri = str_replace($this->prefix_uri,'',$uri);
					$this->can_url = $this->root_uri . $uri.'/';
					$this->page_type = 'content';
					include_once _DIR . '/views/content.php';
					exit();
				}
				else{
					
					header('HTTP/1.0 404 Not Found');
					header('Location: '.$this->root_uri . $uri);
					exit();
					
				}
			} # ถ้า / แรก ไม่ตรงกับที่ตั้งค่าไว้ส่งไป 404
			else{
				header('HTTP/1.0 404 Not Found');
				header('Location: '.$this->root_uri);
				exit();
			}
		}
		
		# แยก url เป็น array
		public function ResultURI(){
			$GURI = str_replace(_DIR . '/','', $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI']);
			$URIALL = explode('?',$GURI);
			$uri_past = $this->cleanArray(explode('/',$URIALL[0]));
			$uri_frist = $this->cleanArray(explode('&',$URIALL[1]));
			if(is_array($uri_frist)){
				foreach($uri_frist as $xuri){
					$thum = explode('=',$xuri,2);
					if(count($thum) == 2 and trim($thum[0]) != "") $uri[trim($thum[0])] = trim($thum[1]);
				}
			}
			$this->arr_uri = $uri_past;
			$this->arr_uri_get = $uri;
		}
		
		private function cleanArray($arr){
			$size = sizeof($arr);
			for($i=0;$i<$size;$i++){
				$thum = trim($arr[$i]);
				if($thum != ""){
					$r[] = $thum;
				}
			}
			return $r;
		}
	}
?>