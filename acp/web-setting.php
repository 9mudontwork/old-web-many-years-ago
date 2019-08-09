<div class="page-header">
	<h2 class="page-header">ตั้งค่า เว็บ</h2>
</div>
<div class="col-lg-8">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">ตั้งค่า เว็บ</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">URL เว็บไซต์</label>
						<div class="col-lg-10">
							<input id="home-url" type="text" class="form-control" value="<?=$web_config['home-url'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">ชื่อเว็บไซต์</label>
						<div class="col-lg-10">
							<input id="home-title" type="text" class="form-control" value="<?=$web_config['home-title'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">รูปภาพ Header</label>
						<div class="col-lg-10">
							<input id="url-header" type="text" class="form-control" value="<?=$web_config['url-header'];?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<div id="msgstyle2"></div>
							<button onclick="webSetting(); return false" class="btn btn-primary">บันทึก</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>