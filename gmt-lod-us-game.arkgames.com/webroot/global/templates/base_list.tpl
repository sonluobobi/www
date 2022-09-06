{include file="header.tpl"}

<div class="container">
    <fieldset>
        <legend>{include file="default_top.tpl"}</legend>
    </fieldset>

	<fieldset>
		<legend>{$caption}</legend>
		{if $show_page}
			{include file="default_subpage.tpl"}
		{/if}

    	<table class="table table-hover">
			{section name=sec loop=$base_list}
			<tr>
			  <td class="active">{$base_list[sec].var}</td>
			  <td class="active">{$base_list[sec].txt}</td>
			</tr>
			{/section}
		</table>
		
		{if $show_page}
			{include file="default_subpage.tpl"}
		{/if}
	</fieldset>
</div>


{include file="footer.tpl"}
