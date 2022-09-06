{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend><a class="btn btn-default" href="{$home_url}" role="button">选大区</a> | <a class="btn btn-default" href="{$main_url}" role="button">菜单</a> | 魔域之{$name}</legend>
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
		</table>
	</fieldset>
	{section name=sec loop=$list}
	<fieldset>
		<legend>{$list[sec].server_name}</legend>
		<table class="table table-hover">
			{section name=sec2 loop=$list[sec].info}
			<tr>
			  <td class="active">{$list[sec].info[sec2].filename}</td>
			  <td class="active">{$list[sec].info[sec2].size}</td>
			  <td class="active">{$list[sec].info[sec2].update}</td>
			  <td class="active"><a href="javascript:showLuaError('{$list[sec].info[sec2].filename}', '{$list[sec].server_id}', '{$list[sec].id}');">查看</a></td>
			</tr>
			<tr>
				<td colspan="4">
					<div class="panel panel-default" > <div style="display:none;" class="panel-body" id="error_all_{$list[sec].id}"></div></div>
				</td>
			</tr>
			{/section}
		</table>
	</fieldset>
	{/section}

	<div class="panel panel-default"> <div class="panel-body" id="msg_lua_error"></div></div>
</div>

<script type="text/javascript">
	function showLuaError(filename, server_id, id)
	{
		var content_id='#error_all_'+id;
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
