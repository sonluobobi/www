{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

			{include file="server.tpl"}

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_btn.tpl"}
            </div>
        </fieldset>
	</form>
	
	{include file="default_msg.tpl"}

	{if $sysinfo}
	<div class="form-group">
	<div class="row">
		<div class="col-xs-2">
	    <input type="text" class="form-control" name="cid" id="cid" placeholder="角色id">
	    </div>
	    <div class="col-xs-4">
	    <button type="button" class="btn btn-default" onclick="do_search()">查询</button>
	    <button type="button" class="btn btn-default" onclick="clear_server_log()">清空</button>
	    </div>
	    <div class="col-xs-2" id="show_msg">
	    </div>
	</div>
	</div>
	<div class="panel panel-default" > <div style="display:none;" class="panel-body" id="map_server_log"></div></div>

	<fieldset>
		<legend>{$caption} -- 总数:{$total}</legend>

    	<table class="table table-hover">
			<tr>
			  <td class="success">操作</td>
			  <td class="success">文件名</td>
			  <td class="success">大小</td>
			  <td class="success">更新时间</td>
			</tr>
			{section name=sec loop=$sysinfo}
			<tr>
				{if isset($sysinfo[sec].id)}
				<td class="success"><input type="checkbox" name="selectAll" id="{$sysinfo[sec].id}" onclick="toggleSelectAll(this)" />全选{$sysinfo[sec].id}</td>
				<td class="active"></td>
				<td class="active"></td>
				<td class="active"></td>
				{else}

			  <td class="active"><input type="checkbox" name="filename" class="serverBox" pid="{$sysinfo[sec].pid}" onclick="selectServer(this)" value="{$sysinfo[sec].filename}" /></td>
			  <td class="active">{$sysinfo[sec].filename}</td>
			  <td class="active">{$sysinfo[sec].size}</td>
			  <td class="active">{$sysinfo[sec].update}</td>
				{/if}
			</tr>
			
			{/section}
		</table>
	</fieldset>
	{/if}
</div>

<script type="text/javascript">
	

function toggleSelectAll(obj) {
	var id = obj.id;

	$('.serverBox').each(function (index) {
		var pid = $(this).attr('pid');
		if (pid == id)
		{
			$(this).attr('checked', obj.checked);
		}
	});
}

function selectServer(obj) {
	var my_pid = $(obj).attr('pid');
	var pid_content = '#'+my_pid;
	if(!obj.checked) 
	{
		$(pid_content).attr('checked', false);
	}
	else 
	{
		var root = this;
		root.isAll = '';
		$('.serverBox').each(function (index) {
			var pid = $(this).attr('pid');
			if(my_pid==pid && !$(this).attr('checked')) {
				root.isAll = 'noooo';
				return false;
			}
		});
		if(root.isAll=='') $(pid_content).attr('checked', true);
	}
}

function do_search()
{
	var server_id = "{$server_id}";
	var content_id = '#map_server_log';
	$(content_id).css('display','block');
	var cid  = $('#cid').val();

	if (cid == '' || isNaN(cid))
	{
		$(content_id).html('<font color="red">请正确填写角色id</font>');
		return false;
	}

	//获取已经勾选的文件列表
	var filenames = '';

	$("input[name='filename']:checkbox:checked").each(function(){ 
		filenames += $(this).val() + ',';
	}) 

	if (filenames == '')
	{
		$(content_id).html('<font color="red">请勾选需要统计的文件名</font>');
		return false;
	}

	var show_msg = '<font color="red">正在查询，请稍后。。。</font>';
	$('#show_msg').html(show_msg);
	$(content_id).html(show_msg);

	filenames = filenames.substr(0,filenames.length-1);
	var pars = 'do_search=search&server_id='+server_id+'&cid='+cid+'&filenames='+filenames+'&r=' + Math.random();

	$.ajax({
		url:"mapServerLog.php",
		async:false,
		data:pars,
		type:"POST",
		beforeSend:function(){
			$(content_id).html("查询中...");
		},
		success:function(data , textStatus){
			$(content_id).html(data);
		},
	});

	$('#show_msg').html('');
}

function clear_server_log()
{
	$('#map_server_log').html("");
	$('#map_server_log').css('display','none');
}
</script>

{include file="footer.tpl"}
