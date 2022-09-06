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
		<legend>连接信息</legend>
    	<table class="table table-hover">
			<tr>
			  <td class="success">类型</td>
			  <td class="success">对应状态</td>
			</tr>
			{section name=sec loop=$list}
			<tr>
			  <td class="active">{$list[sec].var}</td>
			  <td class="active">{$list[sec].txt}</td>
			</tr>
			{/section}
		</table>
	</fieldset>
</div>


{include file="footer.tpl"}
