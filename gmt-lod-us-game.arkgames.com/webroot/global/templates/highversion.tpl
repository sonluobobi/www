{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend><a class="btn btn-default" href="{$home_url}" role="button">选大区</a> | <a class="btn btn-default" href="{$main_url}" role="button">菜单</a> | 魔域之{$name} | {$caption}</legend>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	<button type="submit" class="btn btn-success" name="do_open" value="open">开启白名单访问</button>
            	<button type="submit" class="btn btn-success" name="do_close" value="close">关闭白名单访问</button>
                &nbsp;&nbsp;
                <a class="btn btn-primary btn-lg" target="_blank" href="http://{$ios_pl}{$domain}/servlist_shenhe2.php" role="button">
                    查看审核服
                </a>
                &nbsp;&nbsp;
                <a class="btn btn-primary btn-lg" target="_blank" href="http://pl{$domain}/t.php" role="button">
                    查看ip
                </a>
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
