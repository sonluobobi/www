{include file="header.tpl"}

<div class="jumbotron">
    <div class="container">
        {section name=platform loop=$platform_map}
            <p><a class="btn btn-primary btn-lg" href="http://{$web_sign}{$platform_map[platform].domain}/global/main.php?p={$platform_map[platform].sign}&auth_user={$auth_user}&auth_sign={$auth_sign}" role="button">{$platform_map[platform].title}</a></p>
        {/section}
    </div>
</div>

{include file="footer.tpl"}
