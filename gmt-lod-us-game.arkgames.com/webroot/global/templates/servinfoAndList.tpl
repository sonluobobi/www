{include file="header.tpl"}

<div class="container">
    
</div>
<div class="jumbotron">
    <div class="container">
        <fieldset>
            <legend>{include file="default_top.tpl"}</legend>
        </fieldset>
    	<p>
    		当前请求ip -- {$remote_ip}
    	</p>
        <p>
            当前游戏服时间 -- {$cur_date}
        </p>
    	{if $https_domain}
            <div class="panel panel-primary">
              <div class="panel-heading">安卓版本</div>
              <div class="panel-body">
                 <p><a class="btn btn-success btn-sm" target="_blank" href="http://pl{$https_domain}/t.php" role="button">查看ip[安卓版本]</a></p>
                <p><a class="btn btn-success btn-sm" target="_blank" href="http://pl{$https_domain}/servinfo.php" role="button">版本列表信息[安卓版本]</a></p>
                <p><a class="btn btn-success btn-sm" target="_blank" href="http://pl{$https_domain}/servlist.php" role="button">游戏服列表信息[安卓版本]</a></p>
              </div>
            </div>
            <div class="panel panel-primary">
              <div class="panel-heading">ios版本</div>
              <div class="panel-body">
                <p><a class="btn btn-success btn-sm" target="_blank" href="https://pl{$https_domain}/t.php" role="button">查看ip[ios版本]</a></p>
                <p><a class="btn btn-success btn-sm" target="_blank" href="https://pl{$https_domain}/servinfo.php" role="button">版本列表信息[ios版本]</a></p>
                <p><a class="btn btn-success btn-sm" target="_blank" href="https://pl{$https_domain}/servlist.php" role="button">游戏服列表信息[ios版本]</a></p>
                 <p><a class="btn btn-success btn-sm" target="_blank" href="https://{$ios_pl}{$https_domain}/servlist_shenhe2.php" role="button">审核服[ios版本]</a></p>
            </div>
            </div>
        {/if}
    </div>
</div>

{include file="footer.tpl"}
