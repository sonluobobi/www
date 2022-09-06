{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend><a class="btn btn-default" href="{$home_url}" role="button">选大区</a> | <a class="btn btn-default" href="{$main_url}" role="button">菜单</a> | 魔域之{$name}</legend>

			{include file="server.tpl"}

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_btn.tpl"}
            </div>
        </fieldset>
	</form>
	
	{include file="default_msg.tpl"}

	<fieldset>
		<legend>lua_error列表</legend>

    	<table class="table table-hover">
			<tr>
			  <td class="success">文件名</td>
			  <td class="success">大小</td>
			  <td class="success">更新时间</td>
			  <td class="success">操作</td>
			</tr>
			{section name=sec loop=$sysinfo}
			<tr>
			  <td class="active">{$sysinfo[sec].filename}</td>
			  <td class="active">{$sysinfo[sec].size}</td>
			  <td class="active">{$sysinfo[sec].update}</td>
			  <td class="active"><a href="javascript:showLuaError('{$sysinfo[sec].filename}', {$sysinfo[sec].id});">查看</a></td>
			</tr>
			<tr>
				<td colspan="4">
					<div class="panel panel-default" > <div style="display:none;" class="panel-body" id="error_{$sysinfo[sec].id}"></div></div>
				</td>
			</tr>
			{/section}
		</table>
	</fieldset>

</div>

<script type="text/javascript">
	var server_id = "{$server_id}";

	function showLuaError(filename, id)
	{
		var content_id='#error_'+id;
		var display_status = $(content_id).css("display");

		if(display_status == 'none')
		{
			$(content_id).css('display','block');
			var pars = 'do_search=do&server_id='+server_id+'&filename='+filename+'&r=' + Math.random();

			$.ajax({
				url:"luaerror.php",
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
		}
		else
		{
			$(content_id).css('display','none');
		}
	}

</script>

{include file="footer.tpl"}
