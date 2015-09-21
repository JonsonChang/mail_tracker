
function group_select(e)
{
	val = $(e.target).attr('value');
	$.get("group.php?op=3&gid="+val,"",function(data){console.log(data);})
	.success(function(){window.location.href=window.location.href;});
}

function group_del(e)
{
	var val = $(e.target).attr('value');
	var gname = $(e.target).attr('alt');
	var answer = confirm("刪除「" + gname + "」?\n 訂閱者資料，和文章都會同時刪除")
	if (answer){
		$.get("group.php?op=5&gid="+val,"",function(data){console.log(data);})
		.success(function(){window.location.href=window.location.href;});
	}
	else{
	
	}
}

function group_edit(e)
{
	val = $(e.target).attr('value');
	//console.log(val);
	$.getJSON('group.php?op=1&id='+val, function(data) {
		$('#SMTP_Host').attr('value',data.SMTP_Host);
		$('#SMTP_Password').attr('value',data.SMTP_Password);
		$('#SMTP_ReplyMail').attr('value',data.SMTP_ReplyMail);
		$('#SMTP_user_account').attr('value',data.SMTP_user_account);
		$('#SMTP_username').attr('value',data.SMTP_username);
		$('#SMTP_ssl').attr('value',data.SMTP_ssl);
		$('#auth_mail').attr('value',data.auth_mail);
		$('#desc_url').attr('value',data.desc_url);
		$('#gname').attr('value',data.gname);
		$('#gid').attr('value',data.id);
		$('#success_url').attr('value',data.success_url);
		
	});
}

function group_detail_edit()
{
	var query = $("#group_form").formSerialize();
	console.log(query);
	$.post("group.php?op=2",query)
	.success(function(){window.location.href=window.location.href;});
}

function group_deltail_add()
{
	var query = $("#group_form").formSerialize();
	console.log(query);
	$.post("group.php?op=4",query)
	.success(function(){window.location.href=window.location.href;});
}

function init_group ()
{
	$('[id="group_select"]').click(group_select);
	$('[id="group_edit"]').click(group_edit);
	$('[id="group_del"]').click(group_del);
	$("#group_deltail_edit").click(group_detail_edit);
	$("#group_deltail_add").click(group_deltail_add);
}

function subscriber_edit_now()
{
	var today = new Date();
	var today_year = today.getFullYear();
	var today_month = today.getMonth()+1;
	var today_date = today.getDate();
	var today_day = today.getDay();
	var today_hour = today.getHours();
	var today_minute = today.getMinutes();
	var today_seconds = today.getSeconds();
	
	var datestr = today_year +'-'+ today_month +'-'+ today_date +' '+ today_hour +':'+ today_minute +':'+ today_seconds;
	$("#activedate").attr("value",datestr);
}

function init_subcriber_edit ()
{
	$("#subscriber_edit_now").click(subscriber_edit_now);
}
