<?php
	include_once 'classes/class.func.php';
	$allFunc = new allFunction;
?>
<?php
	$search = isset($_GET['s']) ? $_GET['s'] : NULL; 
	$objQuery = $db->Query(APP_TABLES_PREFIX . 'manga_titles','*',"name LIKE '%".$search."%' OR other_name LIKE '%".$search."%'");
	$Num_Rows = count($objQuery);
	
	$Per_Page = 30;   // Per Page
	
	$Page = $_GET["Page"];
	if(!$_GET["Page"])
	{
		$Page=1;
	}
	
	$Prev_Page = $Page-1;
	$Next_Page = $Page+1;
	
	$Page_Start = (($Per_Page*$Page)-$Per_Page);
	if($Num_Rows<=$Per_Page)
	{
		$Num_Pages =1;
	}
	else if(($Num_Rows % $Per_Page)==0)
	{
		$Num_Pages =($Num_Rows/$Per_Page) ;
	}
	else
	{
		$Num_Pages =($Num_Rows/$Per_Page)+1;
		$Num_Pages = (int)$Num_Pages;
	}

	$objQuery = $db->Query(APP_TABLES_PREFIX . 'manga_titles','*',"name LIKE '%".$search."%' OR other_name LIKE '%".$search."%'",null,null,array('datetime_post'=>'DESC'),array('offset'=>$Page_Start,'rows'=>$Per_Page));
?>
<div class="page-header">
	<h2 class="page-header">รายชื่อการ์ตูนทั้งหมด ที่ตรงกับคำว่า "<?=$search;?>" <?php echo $Num_Rows;?> เรื่อง</h2>
</div>
<div class="row">
	<div class="col-lg-2 col-xs-12" style="margin-bottom: 15px;">
		<a href="?action=add-manga" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> เพิ่มเรื่องใหม่</a>
	</div>
	<div class="col-lg-3 col-xs-12">
		<form>
			<fieldset>
				<div class="form-group">
					<input style="display:none;" id="action" name="action" value="search" type="text">
					<div class="input-group">
						<input id="s" name="s" type="text" class="form-control" placeholder="ค้นหาการ์ตูน">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<div id="msgstyle2"></div>
<div class="row">
	<?php
		foreach($objQuery as $objResult)
		{
		?>
		
		<div class="col-lg-4 col-xs-12">
			<table class="table table-bordered table-hover ">
				<tbody>
					<tr>
						<td style="background-image:url('<?=$objResult["cover"];?>');background-repeat: no-repeat;width:100px;height:120px;background-size: 100px; background-position:50% 50%;">
						</td>
						<td>
							<p><a href="#"><?=$objResult["name"];?></a></p>
							<div class="btn-group">
								<a class="btn btn-danger btn-sm"><?=$objResult["id"];?></a>
								<a href="?action=edit-manga&id=<?=$objResult["id"];?>" class="btn btn-info btn-sm">แก้ไขเรื่อง</a>
								<a href="?action=chapter-list&id=<?=$objResult["id"];?>" class="btn btn-success btn-sm">รายชื่อตอน</a>
								<a data-toggle="modal" href="#myModal" onclick="getDelManga('<?=$objResult["id"];?>','<?=$objResult["name"];?>');" class="btn btn-danger btn-sm">ลบ</a>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
		}
	?>
</div>
<div class="text-center">
	<ul class="pagination">
		<?php
			
			$pages = new Paginator;
			$pages->items_total = $Num_Rows;
			$pages->mid_range = 10;
			$pages->current_page = $Page;
			$pages->default_ipp = $Per_Page;
			$pages->url_next = $_SERVER["PHP_SELF"]."?action=search&s=".$search."&Page=";
			
			$pages->paginate();
			
			echo $pages->display_pages()
		?>		
	</ul>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">ลบการ์ตูน </h4>
			</div>
			<div class="modal-body">
				<p>
					ต้องการจะลบการ์ตูนเรื่อง
					<div id="getname"></div>
				</p>
			</div>
			<div class="modal-footer">
				<form>
					<fieldset>
						<input style="display:none;" type="textbox" name="am_id" id="am_id" value=""> 
						<a onclick="delManga()" class="btn btn-danger">ลบ</a>
					</fieldset>
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
	function getDelManga(id,name)
	{
		$('#getname').html(name);
		$( "#am_id" ).val(id);
	}
</script>	