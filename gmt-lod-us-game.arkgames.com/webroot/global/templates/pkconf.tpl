{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend><a class="btn btn-default" href="{$home_url}" role="button">选大区</a> | <a class="btn btn-default" href="{$main_url}" role="button">菜单</a> | 魔域之{$name} | {$caption}</legend>

			{include file="server.tpl"}

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_btn.tpl"}
            </div>
        </fieldset>
	</form>
	
	{include file="default_msg.tpl"}

	<fieldset>
		<legend>
			<div class="panel panel-default" > <div class="panel-body" id="all_log_content">{$content}</div></div>
		</legend>
	</fieldset>

</div>

{include file="footer.tpl"}
