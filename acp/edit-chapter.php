<?php
	session_start();
	include '../includes/cont.main.php';
	include '../includes/seo.php';
	include '../includes/seo2.php';
?>
<?php
	$id = isset($_GET['id']) ? $_GET['id'] : NULL; 
	$query = $db->Query(APP_TABLES_PREFIX . 'anime_ep','*',array('id'=>$id));
	$thisChapter = $query[0];
	$thisAnime = $db->Query(APP_TABLES_PREFIX . 'anime_titles','name',array('id'=>$thisChapter['anime_id']));
	
	$urlcontent = explode(',',$thisChapter['url_content']);
?>
<div class="col-lg-12">
	<form class="form-horizontal" autocomplete="off">
		<fieldset>
			<div class="form-group">
				<label class="col-lg-2 control-label">ชื่อตอน</label>
				<div class="col-lg-10">
					<input value="<?=$thisChapter['name'];?>" type="text" class="form-control" id="ch_name" name="ch_name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">เลข(เรียงตอน)</label>
				<div class="col-lg-10">
					<input value="<?=$thisChapter['id'];?>" style="display:none;" type="text" class="form-control" id="main_ch_id" name="main_ch_id">
					<input value="<?=$thisChapter['chapter'];?>" type="text" class="form-control" id="ch_id" name="ch_id">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ 1</label>
				<div class="col-lg-10">
					<input value="<?=$urlcontent[0];?>" type="text" class="form-control" id="ch_url1" name="ch_url1">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ 2</label>
				<div class="col-lg-10">
					<input value="<?=$urlcontent[1];?>" type="text" class="form-control" id="ch_url2" name="ch_url2">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ 3</label>
				<div class="col-lg-10">
					<input value="<?=$urlcontent[2];?>" type="text" class="form-control" id="ch_url3" name="ch_url3">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ 4</label>
				<div class="col-lg-10">
					<input value="<?=$urlcontent[3];?>" type="text" class="form-control" id="ch_url4" name="ch_url4">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ 5</label>
				<div class="col-lg-10">
					<input value="<?=$urlcontent[4];?>" type="text" class="form-control" id="ch_url5" name="ch_url5">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ 6</label>
				<div class="col-lg-10">
					<input value="<?=$urlcontent[5];?>" type="text" class="form-control" id="ch_url6" name="ch_url6">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ 7</label>
				<div class="col-lg-10">
					<input value="<?=$urlcontent[6];?>" type="text" class="form-control" id="ch_url7" name="ch_url7">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ 8</label>
				<div class="col-lg-10">
					<input value="<?=$urlcontent[7];?>" type="text" class="form-control" id="ch_url8" name="ch_url8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ 9</label>
				<div class="col-lg-10">
					<input value="<?=$urlcontent[8];?>" type="text" class="form-control" id="ch_url9" name="ch_url9">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ 10</label>
				<div class="col-lg-10">
					<input value="<?=$urlcontent[9];?>" type="text" class="form-control" id="ch_url10" name="ch_url10">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">หมวดหมู่</label>
				<div class="col-lg-10">
					<div class="checkbox">
						<label>
							<input <? echo $thisChapter['trans_group'] == '1' ? 'checked ':'';?> type="checkbox" id="trans1" name="trans1" value="1"> ซับไทย
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input <? echo $thisChapter['trans_group'] == '2' ? 'checked ':'';?> type="checkbox" id="trans2" name="trans2" value="2"> พากย์ไทย
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-10 col-lg-offset-2">
					<div id="msgstyle3"></div>
					<button type="submit" onclick="editChapter(); return false" class="btn btn-primary">บันทึก</button>
				</div>
			</div>
		</fieldset>
	</form>
</div>