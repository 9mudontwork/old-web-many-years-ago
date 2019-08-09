<?php
	session_start();
	include 'includes/cont.main.php';
	include ROOT_DIR.'/classes/class.upload.php';
	//turn on php error reporting
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$name     = $_FILES['file']['name'];
		$tmpName  = $_FILES['file']['tmp_name'];
		$error    = $_FILES['file']['error'];
		$size     = $_FILES['file']['size'];
		$ext	  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
		
		$RandomNumber 	= rand(0, 9999999999);
		$NewImageName = md5($RandomNumber.time());
		switch ($error) {
			case UPLOAD_ERR_OK:
			$valid = true;
			//validate file extensions
			if ( !in_array($ext, array('jpg','jpeg','png','gif')) ) {
				$valid = false;
				$response = 'Invalid file extension.';
			}
			//validate file size
			if ( $size/1024/1024 > 2 ) {
				$valid = false;
				$response = 'File size is exceeding maximum allowed size.';
			}
			//upload file
			if ($valid) {
				/*$targetPath =  dirname( __FILE__ ) . DIRECTORY_SEPARATOR. 'uploads' . DIRECTORY_SEPARATOR. $NewImageName;
					move_uploaded_file($tmpName,$targetPath); 
				echo $NewImageName;*/
				$foo = new Upload($_FILES['file']); 
				if ($foo->uploaded) {
					// save uploaded image with a new name,
					// resized to 100px wide
					$foo->file_new_name_body = $NewImageName;
					$foo->image_resize          = true;
					$foo->image_ratio_crop      = true;
					$foo->image_convert = jpg;
					$foo->image_x = 255; 
					$foo->image_y = 360;
					$foo->Process(ROOT_DIR.'/uploads');
					if ($foo->processed) {
						echo $NewImageName.'.jpg';
						$foo->Clean();
						} else {
						echo 'error : ' . $foo->error;
					} 
				}  
				exit;
			}
			break;
			case UPLOAD_ERR_INI_SIZE:
			$response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
			break;
			case UPLOAD_ERR_PARTIAL:
			$response = 'The uploaded file was only partially uploaded.';
			break;
			case UPLOAD_ERR_NO_FILE:
			$response = 'No file was uploaded.';
			break;
			case UPLOAD_ERR_NO_TMP_DIR:
			$response = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
			break;
			case UPLOAD_ERR_CANT_WRITE:
			$response = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
			break;
			default:
			$response = 'Unknown error';
			break;
		}
		
		echo $response;
	}
?>		