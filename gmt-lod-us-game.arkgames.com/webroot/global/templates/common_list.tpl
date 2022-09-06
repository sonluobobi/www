

<fieldset>
	<legend>{$data_title}</legend>
	{if $show_page}
		{include file="default_subpage.tpl"}
	{/if}

	{if $titles}
	<table class="table table-hover">
		<tr>
		{section name=title loop=$titles}
		  <td class="success">{$titles[title].var}</td>
		{/section}
		</tr>

		{section name=sec loop=$base_list}
		<tr>
			{section name=title loop=$titles}
		  	<td class="active">{$base_list[sec][$titles[title].var]}</td>
			{/section}
		</tr>
		{/section}
	</table>
	{/if}

	{if $show_page}
		{include file="default_subpage.tpl"}
	{/if}
</fieldset>

