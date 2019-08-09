function MyMsg(text,style)
{
	$("#msgstyle").html('<div class="alert alert-dismissible alert-'+style+'"><button type="button" class="close" data-dismiss="alert">×</button><span>'+text+'</span></div>');
}
function MyMsg2(text,style)
{
	$("#msgstyle2").html('<div class="alert alert-dismissible alert-'+style+'"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+text+'</strong></div>');
}
function MyMsg3(text,style)
{
	$("#msgstyle3").html('<div class="alert alert-dismissible alert-'+style+'"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+text+'</strong></div>');
}
function DoLogin()
{
	var user = $("#user").val();
	var pass = $("#pass").val();
	if(user== "")
	{
		MyMsg("กรุณากรอก Username","danger");
		return false
	}
	if(pass == "")
	{
		MyMsg("กรุณากรอก Password","danger");
		return false
	}
	var datastring = "action=login&user="+user+"&pass="+pass;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			if(response == "รหัสผ่านไม่ถูกต้อง"){
				MyMsg(response,"danger");
				}else{
				MyMsg(response,"success");
			}
			setTimeout(function(){location.reload()});
		}
	});
}
function DoLogout()
{
	var datastring = "action=logout";
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			MyMsg(response);
			setTimeout(function(){location.reload()});
		}
	});
}
function addManga()
{
	var name = $("#name").val();
	var slug = $("#slug").val();
	var other_name = $("#other_name").val();
	var released = $("#released").val();
	var description = $("#description").val();
	
	if (document.getElementById('status_end').checked) {
		var status = $("#status_end").val();
	}
	if (document.getElementById('status').checked) {
		var status = $("#status").val();
	}
	
	var name = name.replace(/&/g, "%26");
	var other_name = other_name.replace(/&/g, "%26");
	var description = description.replace(/&/g, "%26");
	
	var cover = $("#cover").val();
	if (name == '' || slug == '' || other_name == '' || description == ''){
		MyMsg2("กรุณาใส่ข้อมูลให้ครบ","danger");
	}
	else{
		var datastring = "action=add-manga&name="+name+"&slug="+slug+"&other_name="+other_name+"&released="+released+"&description="+description+"&status="+status+"&cover="+cover;
		$.ajax({
			type: "POST",
			url:"process.php",
			cache: false,
			data:datastring,
			contentType: "application/x-www-form-urlencoded",
			success: function(response)
			{
				if(response == '')
				{
					MyMsg2('เพิ่มการ์ตูนเรื่อง '+name+' เรียบร้อย',"success");
				}
				else
				{
					MyMsg2('เกิดข้อผิดพลาด ลองใหม่อีกครั้ง => '+response,"danger");
				}
			}
		});
	}
}

function editManga()
{
	var id = $("#id").val();
	var name = $("#name").val();
	var slug = $("#slug").val();
	var other_name = $("#other_name").val();
	var released = $("#released").val();
	var description = $("#description").val();
	var a_status = $("#a_status").val();
	
	if (document.getElementById('status_end').checked) {
		var status = $("#status_end").val();
	}
	if (document.getElementById('status').checked) {
		var status = $("#status").val();
	}
	
	var name = name.replace(/&/g, "%26");
	var other_name = other_name.replace(/&/g, "%26");
	var description = description.replace(/&/g, "%26");
	
	var cover = $("#cover").val();
	if (name == '' || slug == '' || other_name == '' || released == '' || description == ''){
		MyMsg2("กรุณาใส่ข้อมูลให้ครบ","danger");
	}
	else{
		var datastring = "action=edit-manga&id="+id+"&name="+name+"&slug="+slug+"&other_name="+other_name+"&released="+released+"&description="+description+"&a_status="+a_status+"&status="+status+"&cover="+cover;
		$.ajax({
			type: "POST",
			url:"process.php",
			cache: false,
			data:datastring,
			contentType: "application/x-www-form-urlencoded",
			success: function(response)
			{
				if(response == '')
				{
					MyMsg2('แก้ไข '+name+' เรียบร้อย',"success");
					setTimeout(function(){location.reload()},1000);
				}
				else
				{
					MyMsg2('เกิดข้อผิดพลาด ลองใหม่อีกครั้ง => '+response,"danger");
				}
			}
		});
	}
}

function addChapter()
{
	var manga_id = $("#manga_id").val();
	var ch_name = $("#ch_name").val();
	var ch_id = $(".modal-body #ch_id").val();
	var a_status = $("#a_status").val();
	
	var img_content = $("#img_content").val();
	
	var img_content = img_content.replace(/&/g, "%26");
	
	if (manga_id == '' || ch_name == '' || ch_id == '' || img_content == ''){
		MyMsg3("กรุณาใส่ข้อมูลให้ครบ","danger");
	}
	else
	{
		var datastring = "action=add-chapter&id="+manga_id+"&ch_name="+ch_name+"&ch_id="+ch_id+"&img_content="+img_content+"&a_status="+a_status;
		$.ajax({
			type: "POST",
			url:"process.php",
			cache: false,
			data:datastring,
			contentType: "application/x-www-form-urlencoded",
			success: function(response)
			{
				if(response == '')
				{
					MyMsg3('เพิ่ม '+ch_name+' เรียบร้อย',"success");
					setTimeout(function(){location.reload()},500);
				}
				else
				{
					MyMsg3('เกิดข้อผิดพลาด ลองใหม่อีกครั้ง => '+response,"danger");
				}
			}
		});
	}
}

function editChapter()
{
	var main_ch_id = $("#main_ch_id").val();
	var ch_name = $("#ch_name").val();
	var ch_id = $(".modal-body #ch_id").val();
	var ch_url1 = $("#ch_url1").val();
	var ch_url2 = $("#ch_url2").val();
	var ch_url3 = $("#ch_url3").val();
	var ch_url4 = $("#ch_url4").val();
	var ch_url5 = $("#ch_url5").val();
	var ch_url6 = $("#ch_url6").val();
	var ch_url7 = $("#ch_url7").val();
	var ch_url8 = $("#ch_url8").val();
	var ch_url9 = $("#ch_url9").val();
	var ch_url10 = $("#ch_url10").val();
	
	var ch_url1 = ch_url1.replace(/&/g, "%26");
	var ch_url2 = ch_url2.replace(/&/g, "%26");
	var ch_url3 = ch_url3.replace(/&/g, "%26");
	var ch_url4 = ch_url4.replace(/&/g, "%26");
	var ch_url5 = ch_url5.replace(/&/g, "%26");
	var ch_url6 = ch_url6.replace(/&/g, "%26");
	var ch_url7 = ch_url7.replace(/&/g, "%26");
	var ch_url8 = ch_url8.replace(/&/g, "%26");
	var ch_url9 = ch_url9.replace(/&/g, "%26");
	var ch_url10 = ch_url10.replace(/&/g, "%26");
	
	if (document.getElementById('trans1').checked) {
		var trans1 = $("#trans1").val();
	}
	else{
		var trans1 = '';
	}
	if (document.getElementById('trans2').checked) {
		var trans2 = $("#trans2").val();
	}
	else{
		var trans2 = '';
	}
	if (main_ch_id == '' || ch_name == '' || ch_id == '' || ch_url1 == '' || (trans1 == '' && trans2 == '')){
		MyMsg3("กรุณาใส่ข้อมูลให้ครบ","danger");
	}
	else if(trans1 != '' && trans2 != '')
	{
		MyMsg3("เลือกหมวดหมู่ได้เพียงอันเดียว","danger");
	}
	else{
		var datastring = "action=edit-chapter&id="+main_ch_id+"&ch_name="+ch_name+"&ch_id="+ch_id+"&ch_url1="+ch_url1+"&ch_url2="+ch_url2+"&ch_url3="+ch_url3+"&ch_url4="+ch_url4+"&ch_url5="+ch_url5+"&ch_url6="+ch_url6+"&ch_url7="+ch_url7+"&ch_url8="+ch_url8+"&ch_url9="+ch_url9+"&ch_url10="+ch_url10+"&trans1="+trans1+"&trans2="+trans2;
		$.ajax({
			type: "POST",
			url:"process.php",
			cache: false,
			data:datastring,
			contentType: "application/x-www-form-urlencoded",
			success: function(response)
			{
				if(response == '')
				{
					MyMsg3('อัพเดท '+ch_name+' เรียบร้อย',"success");
					//setTimeout(function(){location.reload()},1000);
				}
				else
				{
					MyMsg3('เกิดข้อผิดพลาด ลองใหม่อีกครั้ง => '+response,"danger");
				}
			}
		});
	}
}

function delManga()
{
	var am_id = $("#am_id").val();
	var getname = $("#getname").html();
	
	var datastring = "action=del-manga&id="+am_id;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			if(response == '')
			{
				$('#myModal').modal('hide');
				MyMsg2('ลบ '+getname+' เรียบร้อย',"success");
				setTimeout(function(){location.reload()},1000);
			}
			else
			{
				MyMsg2('เกิดข้อผิดพลาด ลองใหม่อีกครั้ง => '+response,"danger");
			}
		}
	});
}
function delChapter()
{
	var ch_id = $("#ch_id").val();
	var get_chaptername = $("#get_chaptername").html();
	
	var datastring = "action=del-chapter&id="+ch_id;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			if(response == '')
			{
				$('#myModal').modal('hide');
				MyMsg2('ลบ '+get_chaptername+' เรียบร้อย',"success");
				setTimeout(function(){location.reload()},500);
			}
			else
			{
				MyMsg2('เกิดข้อผิดพลาด ลองใหม่อีกครั้ง => '+response,"danger");
			}
		}
	});
}
function delCover()
{
	var cover = $("#cover").val();
	
	var datastring = "action=del-cover&cname="+cover;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			MyMsg2('ลบ '+cover+' เรียบร้อย',"success");
			setTimeout(function(){location.reload()},1000);
		}
	});
}
function webSetting()
{
	var homeurl = $("#home-url").val();
	var hometitle = $("#home-title").val();
	var urlheader = $("#url-header").val();
	
	var datastring = "action=web-setting&home-url="+homeurl+"&home-title="+hometitle+"&url-header="+urlheader;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			MyMsg2('บันทึกเรียบร้อย',"success");
			setTimeout(function(){location.reload()},1000);
		}
	});
}
function seoSetting()
{
	var maintitle = $("#main-title").val();
	var maindescription = $("#main-description").val();
	var mainkeyword = $("#main-keyword").val();
	
	var detailtitle = $("#detail-title").val();
	var detaildescription = $("#detail-description").val();
	var detailkeyword = $("#detail-keyword").val();
	
	var chaptertitle = $("#chapter-title").val();
	var chapterdescription = $("#chapter-description").val();
	var chapterkeyword = $("#chapter-keyword").val();
	
	var datastring = "action=seo-setting&main-title="+maintitle+"&main-description="+maindescription+"&main-keyword="+mainkeyword+"&detail-title="+detailtitle+"&detail-description="+detaildescription+"&detail-keyword="+detailkeyword+"&chapter-title="+chaptertitle+"&chapter-description="+chapterdescription+"&chapter-keyword="+chapterkeyword;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			MyMsg2('บันทึกเรียบร้อย',"success");
			setTimeout(function(){location.reload()},1000);
		}
	});
}
///////////////////////