{include file="header.tpl"}

<div class="container">
    <fieldset>
        <legend>{include file="default_top.tpl"}</legend>
    </fieldset>

	<fieldset>
		<legend>{$caption}</legend>
		{if $desc_msg}
		<div class="alert alert-success" role="alert">{$desc_msg}</div>
		{/if}
		
		{if $show_page}
			{include file="default_subpage.tpl"}
		{/if}

    	{if $titles}
		<table class="table table-hover">
			<tr>
			{section name=title loop=$titles}
			  <td class="success">{$titles[title].txt}</td>
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
</div>


{include file="footer.tpl"}
