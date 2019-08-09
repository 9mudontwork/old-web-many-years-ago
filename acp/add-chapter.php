<?php
	session_start();
	include '../includes/cont.main.php';
	include '../includes/seo.php';
	include '../includes/seo2.php';
?>
<?php
	$id = isset($_GET['id']) ? $_GET['id'] : NULL; 
	$query = $db->Query(APP_TABLES_PREFIX . 'manga_titles','*',array('id'=>$id));
	$thisManga = $query[0];
?>
<div class="col-lg-12">
	<form class="form-horizontal" autocomplete="off">
		<fieldset>
			<div class="form-group">
				<label class="col-lg-2 control-label">ชื่อตอน</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="ch_name" name="ch_name" value="ตอนที่">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">เลข(เรียงตอน)</label>
				<div class="col-lg-10">
					<input value="<?=$thisManga['id'];?>" style="display:none;" type="text" class="form-control" id="manga_id" name="manga_id">
					<input type="text" class="form-control" id="ch_id" name="ch_id">
				</div>
			</div>
			<div class="form-group">
				<label for="textArea" class="col-lg-2 control-label">ลิงก์รูป คั่นด้วย ,</label>
				<div class="col-lg-10">
					<textarea class="form-control" rows="5" name="img_content" id="img_content"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">อัพเดทสถาณะ</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="a_status" name="a_status">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-10 col-lg-offset-2">
					<div id="msgstyle3"></div>
					<button type="submit" onclick="addChapter(); return false" class="btn btn-primary">บันทึก</button>
				</div>
			</div>
		</fieldset>
	</form>
</div>