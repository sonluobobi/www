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
		<legend>表信息</legend>

    	<table class="table table-hover">
			<tr>
			  <td class="success">表名</td>
			  <td class="success">操作</td>
			</tr>
			{section name=sec loop=$sysinfo}
			<tr>
			  <td class="active">{$sysinfo[sec].tbl}</td>
			  <td class="active">
			  	<a href="javascript:showTableInfo('{$sysinfo[sec].tbl}', {$sysinfo[sec].id}, 'Fields');">表字段</a>
			  	&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:showTableInfo('{$sysinfo[sec].tbl}', {$sysinfo[sec].id}, 'Desc');">表结构</a>
			  </td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="panel panel-default" > <div style="display:none;" class="panel-body" id="error_{$sysinfo[sec].id}"></div></div>
				</td>
			</tr>
			{/section}
		</table>
	</fieldset>

</div>

<script type="text/javascript">
	var server_id = "{$server_id}";

	function showTableInfo(tablename, id, action_type)
	{
		var content_id='#error_'+id;
		var display_status = $(content_id).css("display");

		if(display_status == 'none')
		{
			$(content_id).css('display','block');
			var pars = 'do_search=do&server_id='+server_id+'&tbl='+tablename+'&type='+action_type+'&r=' + Math.random();

			$.ajax({
				url:"tablelist.php",
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
