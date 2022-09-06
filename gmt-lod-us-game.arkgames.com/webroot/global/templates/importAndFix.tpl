{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>
            <div class="alert alert-success" role="alert">{$desc_msg}</div>

			{include file="server.tpl"}

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	{include file="default_btn.tpl"}
            </div>
        </fieldset>
	</form>
	
	{include file="default_msg.tpl"}
	
	<div class="form-group">
		<div class="row">
			<div class="col-xs-2">
		    <input type="text" class="form-control" name="cid" id="cid" placeholder="角色id">
		    </div>
		</div>
	</div>

	<div class="panel panel-default" > <font color="red"><div class="panel-body" id="msg_id"></div></font></div>

	<fieldset>
		<legend>备份数据库列表</legend>

    	<table class="table table-hover">
			<tr>
			  <td class="success">备份日期</td>
			  <td class="success">大小</td>
			  <td class="success">更新时间</td>
			  <td class="success">操作</td>
			</tr>
			{section name=sec loop=$sysinfo}
			<tr>
			  <td class="active">{$sysinfo[sec].filename}</td>
			  <td class="active">{$sysinfo[sec].size}</td>
			  <td class="active">{$sysinfo[sec].update}</td>
			  <td class="active" id="td_{$sysinfo[sec].filename}">
			  		<a href="javascript:doImport('{$sysinfo[sec].filename}');">1、导入备份数据库</a>
			  		&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:doFix('{$sysinfo[sec].filename}');">2、导入并修复丢失角色</a>
			  		&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:doBack('{$sysinfo[sec].filename}');">3、角色回档</a>
			  </td>
			</tr>
			{/section}
		</table>
	</fieldset>

	
	<fieldset>
		<legend><a href="javascript:showRoleRoseList();">检查丢失角色列表</a> &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:showDbImportedList();">查看当前已经导入的备份库列表</a> </legend>
	</fieldset>
	<div class="panel panel-default" > <div class="panel-body" id="role_rose_list"></div></div>
</div>

<script type="text/javascript">
	var server_id = "{$server_id}";

	function doImport(filename)
	{
		var content_id='#msg_id';
		$("#msg_id").html("");
		var show_msg = '正在操作[1、导入备份数据库 -- '+filename+']，请稍后。。。';
		$('#msg_id').html(show_msg);

		$('#msg_id').css('display','block');
		var pars = 'do_search=doImport&server_id='+server_id+'&filename='+filename+ getCommPars();

		var td_id = '#td_'+filename;
		$(td_id).html('<font color="red">'+show_msg+'</font>');

		$.ajax({
			url:"importAndFix.php",
			async:false,
			data:pars,
			type:"POST",
			success:function(data , textStatus){
				$('#msg_id').html(data);
				$(td_id).html('<font color="red">'+data+'</font>');
			},
		});
	}

	function doBack(filename)
	{
		var cid  = $('#cid').val();

		if (cid == '' || isNaN(cid) || cid < 1037)
		{
			$("#msg_id").html("请正确填写角色id");
		}
		else
		{
			$("#msg_id").html("");
			var show_msg = '正在操作[3、角色id( '+cid+' )回档 -- 回档日期: '+filename+']，请稍后。。。';
			$("#msg_id").html(show_msg);
			$('#msg_id').css('display','block');

			var td_id = '#td_'+filename;
			$(td_id).html('<font color="red">'+show_msg+'</font>');

			var pars = 'do_search=doBack&server_id='+server_id+'&cid='+cid+'&filename='+filename+ getCommPars();

			$.ajax({
				url:"importAndFix.php",
				async:false,
				data:pars,
				type:"POST",
				beforeSend:function(){
					$("#msg_id").html(show_msg);
				},
				success:function(data , textStatus){
					$('#msg_id').html(data);
					$(td_id).html('<font color="red">'+data+'</font>');
				},
			});
		}
	}

	function doFix(filename)
	{
		var content_id='#msg_id';
		$("#msg_id").html("");
		var show_msg = '正在操作[2、导入并修复丢失角色-- '+filename+']，请稍后。。。';
		$('#msg_id').html(show_msg);

		$('#msg_id').css('display','block');
		var pars = 'do_search=doFix&server_id='+server_id+'&filename='+filename+ getCommPars();

		var td_id = '#td_'+filename;
		$(td_id).html('<font color="red">'+show_msg+'</font>');

		$.ajax({
			url:"importAndFix.php",
			async:false,
			data:pars,
			type:"POST",
			success:function(data , textStatus){
				$('#msg_id').html(data);
				$(td_id).html('<font color="red">'+data+'</font>');
			},
		});
	}

	function showRoleRoseList()
	{
		var pars = 'do_search=showRoleRose&server_id='+server_id+ getCommPars();
		$('#role_rose_list').html("查询中...");

		$.ajax({
			url:"importAndFix.php",
			async:false,
			data:pars,
			type:"POST",
			beforeSend:function(){
				$('#role_rose_list').html("查询中...");
			},
			success:function(data , textStatus){
				$('#role_rose_list').html(data);
			},
		});
	}

	function showDbImportedList()
	{
		var pars = 'do_search=showDbImported&server_id='+server_id+ getCommPars();
		$('#role_rose_list').html("查询中...");

		$.ajax({
			url:"importAndFix.php",
			async:false,
			data:pars,
			type:"POST",
			beforeSend:function(){
				$('#role_rose_list').html("查询中...");
			},
			success:function(data , textStatus){
				$('#role_rose_list').html(data);
			},
		});
	}

	function getCommPars()
	{
		var t = $("#t").val();
		var sign = $("#s").val();
		var auth_user = $("#auth_user").val();
		var auth_sign = $("#auth_sign").val();
		var pars = '&auth_user='+auth_user+'&auth_sign='+auth_sign+'&t='+t+'&sign='+sign+'&r=' + Math.random();

		return pars;
	}

</script>

{include file="footer.tpl"}
