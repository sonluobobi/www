{include file="header.tpl"}

<div class="container">
    <fieldset>
        <legend>{include file="default_top.tpl"}</legend>
    </fieldset>

	<fieldset>
		<legend>热更新判断</legend>
		<div class="alert alert-success" role="alert">对应游戏服文件 /data/moyu/s?/script/?baseserver/ctrl/base_checkUpdateCtrl.lua</div>

		{if $show_page}
			{include file="default_subpage.tpl"}
		{/if}
    	<table class="table table-hover">
			{section name=sec loop=$sysinfo}
			<tr>
			  <td class="active">{$sysinfo[sec].var}</td>
			  <td class="active">{$sysinfo[sec].txt}</td>
			</tr>
			{/section}
		</table>
		{if $show_page}
			{include file="default_subpage.tpl"}
		{/if}
	</fieldset>
</div>


{include file="footer.tpl"}
