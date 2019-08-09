<?php
	$id = isset($_GET['id']) ? $_GET['id'] : NULL; 
	$query = $db->Query(APP_TABLES_PREFIX . 'manga_titles','id,name',array('id'=>$id));
	$thisManga = $query[0];
	
	$query = $db->Query(APP_TABLES_PREFIX . 'manga_ep','*',array('manga_id'=>$id),null,null,array('abs(chapter)'=>'ASC'));
?>
<div class="page-header">
	<h2 class="page-header">รายชื่อตอน เรื่อง <a href="?action=search&s=<?=$thisManga['name']?>"><?=$thisManga['name']?></a></h2>
</div>
<div class="col-lg-12">
	<div id="msgstyle2"></div>
	<div style="margin-bottom: 15px;">
		<a data-toggle="modal" href="#myModal2" onclick="getAddChapter('<?=$thisManga['id']?>');" ahref="?action=add-chapter&id=<?=$thisManga['id']?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> เพิ่มตอนใหม่</a>
	</div>
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr class="success">
					<th style="max-width:50px;">เลข(เรียงตอน)</th>
					<th>ตอน</th>
					<th>แก้ไข / ลบ ลิงก์พากย์ไทย</th>
					<th>วันที่ลง</th>
					<th>แก้ไข / ลบ ลิงก์ซับไทย</th>
					<th>วันที่ลง</th>
				</tr>
			</thead>
			<tbody>
				<?
					$CheckChapter = '';
					$countQ = count($query);
					for($i=0;$i<$countQ;$i++)
					{
						echo '<tr>';
						echo '<td><p>'.$query[$i]['chapter'].'</p></td>';
						echo '<td><p>'.$query[$i]['name'].'</p></td>';
						echo '<td><p>-</p></td>';
					echo '<td><p>-</p></td></tr>';

			}
		?>
	</tbody>
</table> 
</div>
<div style="margin-bottom: 15px;">
	<a data-toggle="modal" href="#myModal2" onclick="getAddChapter('<?=$thisManga['id']?>');" ahref="?action=add-chapter&id=<?=$thisManga['id']?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> เพิ่มตอนใหม่</a>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">ลบตอน</h4>
			</div>
			<div class="modal-body">
				<p>
					ต้องการจะลบ
					<div id="get_chaptername"></div>
				</p>
			</div>
			<div class="modal-footer">
				<form>
					<fieldset>
						<input style="display:none;" type="textbox" name="ch_id" id="ch_id" value=""> 
						<a onclick="delChapter();" class="btn btn-danger">ลบ</a>
					</fieldset>
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal 2 -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 id="title_edit" class="modal-title"></h4>
			</div>
			<div id="ifedit" class="modal-body" style="display: inline-block;width: 100%;">
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
	function getDelChapter(id,name)
	{
		$('#get_chaptername').html(name);
		$( "#ch_id" ).val(id);
	}
	function getEditChapter(id,name)
	{
		var datastring = "id="+id;
		$.ajax({
			type: "GET",
			url:"/acp/edit-chapter.php",
			cache: false,
			data:datastring,
			contentType: "application/x-www-form-urlencoded",
			success: function(response)
			{
				$('#ifedit').html(response);
				$('#title_edit').html("แก้ไข <?=htmlspecialchars($thisManga['name']);?> "+name);
			}
		});
	}
	function getAddChapter(id)
	{
		var datastring = "id="+id;
		$.ajax({
			type: "GET",
			url:"/acp/add-chapter.php",
			cache: false,
			data:datastring,
			contentType: "application/x-www-form-urlencoded",
			success: function(response)
			{
				$('#ifedit').html(response);
				$('#title_edit').html("เพิ่มตอนใหม่ <?=htmlspecialchars($thisManga['name']);?>");
			}
		});
	}
	</script>							