<div class="page-header">
	<h2 class="page-header">ตั้งค่า SEO</h2>
</div>
<div class="col-lg-8">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">ตั้งค่า SEO</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal">
				<fieldset>
					<h3 class="panel-title">หน้าแรก</h3>
					<div class="form-group">
						<label class="col-lg-2 control-label">Title</label>
						<div class="col-lg-10">
							<input id="main-title" type="text" class="form-control" value="<?=$web_config['main-title'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Meta description</label>
						<div class="col-lg-10">
							<input id="main-description" type="text" class="form-control" value="<?=$web_config['main-description'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Meta keywords</label>
						<div class="col-lg-10">
							<input id="main-keyword" type="text" class="form-control" value="<?=$web_config['main-keyword'];?>">
						</div>
					</div>
					<hr>
					<h3 class="panel-title">หน้าข้อมูลการ์ตูน => ชื่อเรื่อง {detail-title} ชื่ออื่นๆ {detail-other-title} เรื่องย่อ {detail-description}</h3>
					<div class="form-group">
						<label class="col-lg-2 control-label">Title</label>
						<div class="col-lg-10">
							<input id="detail-title" type="text" class="form-control" value="<?=$web_config['detail-title'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Meta description</label>
						<div class="col-lg-10">
							<input id="detail-description" type="text" class="form-control" value="<?=$web_config['detail-description'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Meta keywords</label>
						<div class="col-lg-10">
							<input id="detail-keyword" type="text" class="form-control" value="<?=$web_config['detail-keyword'];?>">
						</div>
					</div>
					<hr>
					<h3 class="panel-title">หน้าตอนการ์ตูน => ชื่อเรื่อง {detail-title} ชื่อตอน {chapter-title} ชื่อตอน(เอาแต่เลข) {chapter-title-num} ชื่ออื่นๆ {chapter-other-title}</h3>
					<div class="form-group">
						<label class="col-lg-2 control-label">Title</label>
						<div class="col-lg-10">
							<input id="chapter-title" type="text" class="form-control" value="<?=$web_config['chapter-title'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Meta description</label>
						<div class="col-lg-10">
							<input id="chapter-description" type="text" class="form-control" value="<?=$web_config['chapter-description'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Meta keywords</label>
						<div class="col-lg-10">
							<input id="chapter-keyword" type="text" class="form-control" value="<?=$web_config['chapter-keyword'];?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<div id="msgstyle2"></div>
							<button onclick="seoSetting(); return false" type="submit" class="btn btn-primary">บันทึก</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>