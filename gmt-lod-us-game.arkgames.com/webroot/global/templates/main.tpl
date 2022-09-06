{include file="header.tpl"}

<div class="jumbotron">
    <div class="container">
    	<p><a class="btn btn-default" href="{$home_url}" role="button">选大区</a> | 魔域2之{$name}</p>
    	<p>
    		当前请求ip -- {$remote_ip}
    	</p>
        <p>
            当前游戏服时间 -- {$cur_date}
        </p>
        {section name=sec loop=$menu_map}
            <p><a class="btn btn-primary btn-lg" href="http://{$web_sign}{$domain}/global/{$menu_map[sec].sign}.php?p={$p}&auth_user={$auth_user}&auth_sign={$auth_sign}" role="button">{$menu_map[sec].title}</a></p>
        {/section}
    </div>
</div>

{include file="footer.tpl"}
