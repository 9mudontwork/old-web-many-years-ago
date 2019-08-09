<?php
	session_start();
	include 'includes/cont.main.php';
	include 'includes/seo.php';
	include 'includes/seo2.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="favicon.png">
		
		<title>Admin Control Panel - <?=$web_config['main-title'];?></title>
		
		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootswatch.min.css" rel="stylesheet">
		<link href="css/sb-admin.css" rel="stylesheet">
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/process.js"></script>
		<script type="text/javascript" src="js/fileinput.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script>
	</head>
	
	<body>
		<?php echo(isAdmin() ? '<div id="wrapper">':'<div class="container">'); ?>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<!-- เมนูมือถือ -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=$web_config['home-url'];?>"><?=$web_config['home-title'];?></a>
			</div>
			<!-- เมนูมือถือ -->
			<?php if(isAdmin()){ ?>
				<!-- เมนูด้านข้าง-->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav side-nav">
						<?php 
							$action = $_GET['action'];
							switch($action)
							{
								case "":
								case "all-manga":
								case "edit-manga":
								case "add-manga":
								case "chapter-list":
								case "edit-chapter":
								case "add-chapter":
								case "search":
							?>
							<li class="active">
								<a href="?action=all-manga"><i class="glyphicon glyphicon-film"></i> รายชื่อการ์ตูนทั้งหมด</a>
							</li>
							<li>
								<a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="glyphicon glyphicon-cog"></i> ตั้งค่า <i class="glyphicon glyphicon-chevron-down"></i></a>
								<ul id="demo" class="collapse">
									<li>
										<a href="?action=seo-setting">ตั้งค่า SEO</a>
									</li>
									<li>
										<a href="?action=web-setting">ปรับแต่งเว็บ</a>
									</li>
								</ul>
							</li>
							<?php
								break;
								case "seo-setting":
								case "web-setting":
							?>
							<li>
								<a href="?action=all-manga"><i class="glyphicon glyphicon-film"></i> รายชื่อการ์ตูนทั้งหมด</a>
							</li>
							<li class="active">
								<a href="javascript:;" data-toggle="collapse" data-target="#demo" aria-expanded="true"><i class="glyphicon glyphicon-cog"></i> ตั้งค่า <i class="glyphicon glyphicon-chevron-down"></i></a>
								<ul id="demo" class="collapse in" aria-expanded="true">
									<li>
										<a href="?action=seo-setting">ตั้งค่า SEO</a>
									</li>
									<li>
										<a href="?action=web-setting">ปรับแต่งเว็บ</a>
									</li>
								</ul>
							</li>
							<?php
								break;
								case "seo-setting":
							}
						?>
						<li>
							<a href="admin-cp.php"type="submit" onclick="DoLogout(); return false">ออกจากระบบ</a>
						</li>
					</ul>
				</div>
				<!-- เมนูด้านข้าง-->
			</nav>
			
			
			
			<div id="page-wrapper">
				<div class="container-fluid">
					<?php 
						$action = $_GET['action'];
						switch($action)
						{
							case "":
							case "all-manga":
							include 'acp/all-manga.php';
							break;
							
							case "edit-manga":
							include 'acp/edit-manga.php';
							break;
							
							case "add-manga":
							include 'acp/add-manga.php';
							break;
							
							case "chapter-list":
							include 'acp/chapter-list.php';
							break;
							
							case "edit-chapter":
							include 'acp/edit-chapter.php';
							break;
							
							case "add-chapter":
							include 'acp/add-chapter.php';
							break;
							
							case "search":
							include 'acp/search-manga.php';
							break;
							
							case "seo-setting":
							include 'acp/seo-setting.php';
							break;
							
							case "web-setting":
							include 'acp/web-setting.php';
							break;
						}
					} 
					else 
					{
					?>
				</nav><!-- /.navbar-->
				
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div id="msgstyle"></div>
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Please Login</h3>
							</div>
							<div class="panel-body">
								<form class="form-horizontal">
									<fieldset>
										<div class="form-group">
											<label class="col-lg-3 control-label">Username</label>
											<div class="col-lg-9">
												<input type="text" class="form-control" id="user" placeholder="Username">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3 control-label">Password</label>
											<div class="col-lg-9">
												<input type="password" class="form-control" id="pass" placeholder="Password">
											</div>
										</div>     
										<button class="btn btn-primary pull-right" type="submit" onclick="DoLogin(); return false">Login</button>   
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	
</div><!-- /.container -->

</body>
</html>						