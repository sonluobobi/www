{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend><a class="btn btn-default" href="{$home_url}" role="button">选大区</a> | <a class="btn btn-default" href="{$main_url}" role="button">菜单</a> | 魔域之{$name}</legend>
        </fieldset>
	</form>
	
	{include file="default_msg.tpl"}

	<fieldset>
		<legend>ip对应游戏服数据 -- ip数: {$cnt}</legend>

    	<table class="table table-hover">
			<tr>
			  <td class="success">ip</td>
			  <td class="success">游戏服数量</td>
			  <td class="success">操作</td>
			</tr>
			{section name=sec loop=$sysinfo}
			<tr>
			  <td class="active">{$sysinfo[sec].ip}</td>
			   <td class="active">{$sysinfo[sec].server_cnt}</td>
			  <td class="active">
			  	<a href="javascript:showGameInfo('{$sysinfo[sec].id}', '{$sysinfo[sec].ip}');">详情</a>
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

	function showGameInfo(id, ip)
	{
		var content_id='#error_'+id;
		var display_status = $(content_id).css("display");

		if(display_status == 'none')
		{
			$(content_id).css('display','block');
			var pars = 'do_search=do'+'&ip='+ip+'&r=' + Math.random();

			$.ajax({
				url:"ipToServers.php",
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
