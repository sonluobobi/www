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
	
	<div class="panel panel-default" > <div style="display:none;" class="panel-body" id="map_server_log"></div></div>

	<fieldset>
		<legend>{$caption} -- 总数:{$total}</legend>

    	<table class="table table-hover">
			<tr>
			  <td class="success">文件名</td>
			  <td class="success">大小</td>
			  <td class="success">更新时间</td>
			</tr>
			{section name=sec loop=$sysinfo}
			<tr>
			  <td class="active">{$sysinfo[sec].filename}</td>
			  <td class="active">{$sysinfo[sec].size}</td>
			  <td class="active">{$sysinfo[sec].update}</td>
			</tr>
			
			{/section}
		</table>
	</fieldset>
	{/if}
</div>

{include file="footer.tpl"}
