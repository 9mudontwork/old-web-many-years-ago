<?php
	$id = isset($_GET['id']) ? $_GET['id'] : NULL; 
	$query = $db->Query(APP_TABLES_PREFIX . 'manga_titles','*',array('id'=>$id));
	$thisManga = $query[0];
	$date = new DateTime($thisManga['released']);
?>
<div class="page-header">
	<h2 class="page-header">แก้ไขการ์ตูนเรื่อง <a href="?action=search&s=<?=$thisManga['name']?>"><?=$thisManga['name']?></a></h2>
</div>
<div class="col-lg-8">
	<form class="form-horizontal" autocomplete="off">
		<fieldset>
			<div class="form-group">
				<label class="col-lg-2 control-label">ชื่อเรื่อง</label>
				<div class="col-lg-10">
					<input style="display:none" value="<?=$thisManga['id'];?>" type="text" class="form-control" name="id" id="id">
					<input value="<?=$thisManga['name'];?>" type="text" class="form-control" name="name" id="name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ลิงก์ถาวร </label>
				<div class="col-lg-10">
					<input value="<?=$thisManga['slug'];?>" type="text" class="form-control" name="slug" id="slug">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ชื่ออื่นๆ</label>
				<div class="col-lg-10">
					<input value="<?=$thisManga['other_name'];?>" type="text" class="form-control" name="other_name" id="other_name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">ฤดูกาลที่ฉาย</label>
				<div class="col-lg-10">
					<input value="<?=$thisManga['released'];?>" type="text" class="form-control" name="released" id="released">
				</div>
			</div>
			<div class="form-group">
				<label for="textArea" class="col-lg-2 control-label">เรื่องย่อ</label>
				<div class="col-lg-10">
					<textarea class="form-control" rows="3" name="description" id="description"><?=$thisManga['description'];?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">หมวดหมู่</label>
				<div class="col-lg-10">
					<div class="checkbox">
						<label>
							<input <? echo ($thisManga['status'] == '1')? 'checked':'';?> type="checkbox" name="status_end" id="status_end" value="1"> จบ
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input <? echo ($thisManga['status'] == '2')? 'checked':'';?> type="checkbox" name="status" id="status" value="2"> ยังไม่จบ
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">อัพเดทสถาณะ</label>
				<div class="col-lg-10">
					<input value="<?=$thisManga['a_status'];?>" type="text" class="form-control" name="a_status" id="a_status">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">รูปเรื่องนี้</label>
				<div class="col-lg-10">
					<img id="precover" src="uploads/<?=$thisManga['cover'];?>" class="thumbnail img-responsive">
					<div class="input-group">
						<input value="<?=$thisManga['cover'];?>" type="text" id='cover' name='cover' class="form-control">
						<span class="input-group-btn">
							<button data-toggle="modal" href="#myModal" class="btn btn-primary" type="button"><i class="glyphicon glyphicon-upload"> อัพโหลดรูปภาพ</i></button>
							<a class="btn btn-danger" onclick="delCover(); return false">ลบรูปภาพ</a>
						</span>
					</div><!-- /input-group -->
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-10 col-lg-offset-2">
				<div id="msgstyle2"></div>
				<button type="submit" onclick="editManga(); return false" class="btn btn-primary">บันทึก</button>
			</div>
		</div>
	</fieldset>
</form>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">อัพโหลดรูป</h4>
			</div>
			<div class="modal-body">
				<p>
					<div id="cover_info_output"></div>
					<div id="cover_output"></div>
					<form id="cover_form" action="upload.php" method="POST" enctype="multipart/form-data">
						<input name="file" type="file" style="color:#fff;">
					</form>
				</p>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
	$(document).ready(function() {
	});
	$( "#name" ).change(function() {
		$.post('process.php', { action: "autoslug",slug: $( "#name" ).val() },
		function(data) {
			$("#slug").val(data);
		});
	});
</script>
<script> 
	$(document).ready(function() { 
		$('#cover_form').on('submit', function(e) {
			e.preventDefault();
			$('#cover_info_output').html("Waiting..");
			$(this).ajaxSubmit({
				beforeSubmit:  function(){
				},
				target: '#cover_output',
				success: function() {
					var img = $('#cover_output').text();
					$( "#cover" ).val( img );
					$('#precover').attr('src','uploads/' + img);
					$('#myModal').modal('hide');
				}
			});
		});
	});
</script>
<script type="text/javascript">
	$(function() {
		$("input:file").change(function (){
			$( "#cover_form" ).submit();
		});
	});
	</script>					