{include file="header.tpl"}

<div class="container">
    <fieldset>
        <legend>{include file="default_top.tpl"}</legend>
    </fieldset>

	<fieldset>
		<legend>{$caption}</legend>

    	<table class="table table-hover">
			{section name=sec loop=$base_list}
			<tr>
			  <td class="active">{$base_list[sec].var}</td>
			  <td class="active">{$base_list[sec].txt}</td>
			</tr>
			{/section}
		</table>
		
	</fieldset>


	<fieldset>
		<legend>{$caption2}</legend>

    	<table class="table table-hover">
			{section name=sec2 loop=$history}
			<tr>
			  <td class="active" colspan="2">{$history[sec2].txt}</td>
			</tr>
			{/section}
		</table>
		
	</fieldset>
</div>


{include file="footer.tpl"}
