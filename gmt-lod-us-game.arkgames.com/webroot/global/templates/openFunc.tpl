{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="post">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

            <div class="alert alert-success" role="alert">{$desc_msg}</div>
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
        <legend>列表</legend>

        <table class="table table-hover">
            <tr>
              <td class="success">功能开关id</td>
              <td class="success">功能开关配置值</td>
              <td class="success">功能开关描述</td>
            </tr>
            {section name=sec loop=$sysinfo}
            <tr>
              <td class="active">{$sysinfo[sec].func_id}</td>
              <td class="active">{$sysinfo[sec].value}</td>
              <td class="active">{$sysinfo[sec].func_title}</td>
            </tr>
            {/section}
        </table>
    </fieldset>
</div>

{include file="footer.tpl"}
