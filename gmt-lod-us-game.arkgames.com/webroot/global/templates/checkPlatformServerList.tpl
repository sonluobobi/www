{include file="header.tpl"}

<div class="container">
    <fieldset>
        <legend>{include file="default_top.tpl"}</legend>
    </fieldset>

	<fieldset>
		<legend>{$caption}</legend>
		<table class="table table-hover">
			<td class="active">检查项</td>
			<td class="active">检查结果</td>
		</table>
	</fieldset>

	{section name=sec loop=$list}
	<fieldset>
		<legend>{$list[sec].server_id}--{$list[sec].server_date}--{$list[sec].base_domain}</legend>
		<table class="table table-hover">
			{section name=sec2 loop=$list[sec].info}
			<tr>
			  <td class="active">{$list[sec].info[sec2].var}</td>
			  <td class="active">{$list[sec].info[sec2].txt}</td>
			</tr>
			{/section}
		</table>
	</fieldset>
	{/section}
</div>


{include file="footer.tpl"}
