{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>
            <div class="alert alert-success" role="alert">{$desc_msg}</div>

			{include file="server.tpl"}

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
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
	<div class="panel panel-default" > <div style="display:none;" class="panel-body" id="msg_id"></div></div>

	<fieldset>
		<legend>列表</legend>

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
			  <td class="active">
			  		<a href="javascript:doDownload('{$sysinfo[sec].filename}');">复制数据库备份文件到测试服</a>
			  		&nbsp;&nbsp;<a href="javascript:doImport('{$sysinfo[sec].filename}');">导入复制的备份数据库到测试服</a>
			  		&nbsp;&nbsp;<a href="javascript:doCopyCh('{$sysinfo[sec].filename}');">复制指定角色id数据到测试服</a>
			  </td>
			</tr>
			{/section}
		</table>
	</fieldset>

</div>

<script type="text/javascript">
	var server_id = "{$server_id}";

	function doDownload(filename)
	{
		var content_id='#msg_id';

		var show_msg = '<font color="red">正在操作[复制数据库备份文件到测试服]，请稍后。。。</font>';
		$(content_id).html(show_msg);

		$(content_id).css('display','block');
		var pars = 'do_search=download&server_id='+server_id+'&filename='+filename+'&r=' + Math.random();

		$.ajax({
			url:"backupDb.php",
			async:false,
			data:pars,
			type:"POST",
			beforeSend:function(){
				$(content_id).html(show_msg);
			},
			success:function(data , textStatus){
				$(content_id).html(data);
			},
		});
	}

	function doImport(filename)
	{
		var content_id='#msg_id';

		var show_msg = '<font color="red">正在操作[导入复制的备份数据库到测试服]，请稍后。。。</font>';
		$(content_id).html(show_msg);

		$(content_id).css('display','block');
		var pars = 'do_search=import&server_id='+server_id+'&filename='+filename+'&r=' + Math.random();

		$.ajax({
			url:"backupDb.php",
			async:false,
			data:pars,
			type:"POST",
			beforeSend:function(){
				$(content_id).html(show_msg);
			},
			success:function(data , textStatus){
				$(content_id).html(data);
			},
		});
	}

	function doCopyCh(filename)
	{
		var content_id='#msg_id';

		var cid  = $('#cid').val();
		$(content_id).css('display','block');

		if (cid == '' || isNaN(cid) || cid < 1037)
		{
			$(content_id).html('<font color="red">请正确填写角色id</font>');
		}
		else
		{
			var show_msg = '<font color="red">正在操作[复制指定角色id数据到测试服]，请稍后。。。</font>';
			$(content_id).html(show_msg);

			var pars = 'do_search=copy&server_id='+server_id+'&cid='+cid+'&filename='+filename+'&r=' + Math.random();

			$.ajax({
				url:"backupDb.php",
				async:false,
				data:pars,
				type:"POST",
				beforeSend:function(){
					$(content_id).html(show_msg);
				},
				success:function(data , textStatus){
					$(content_id).html(data);
				},
			});
		}
	}
</script>

{include file="footer.tpl"}
