{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend>{include file="default_top.tpl"}</legend>

			{include file="server.tpl"}

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	{include file="default_btn.tpl"}
            </div>
        </fieldset>
	</form>
	
	{include file="default_msg.tpl"}
	
	<fieldset>
		<legend>系统信息</legend>
    	<table class="table table-hover">
			{section name=sec loop=$sysinfo}
			<tr>
			  <td class="active">{$sysinfo[sec].var}</td>
			  <td class="active">{$sysinfo[sec].txt}</td>
			</tr>
			{/section}
		</table>
	</fieldset>

	<fieldset>
		<legend>系统空闲内存数据</legend>
    	<table class="table table-hover">
			{foreach key=k item=v name=data_list from=$free_info}
			<tr>	
				{foreach key=sub_k item=sub_v from=$v}
			  	<td class="active">{$sub_v}</td>
			  	{/foreach}
			</tr>
			{/foreach}
		</table>
		
	</fieldset>
</div>


{include file="footer.tpl"}
