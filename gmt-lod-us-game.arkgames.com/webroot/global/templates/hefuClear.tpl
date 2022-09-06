{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="post" onsubmit="return submitEvent();">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

            <div class="alert alert-success" role="alert">{$desc_msg}</div>
			{include file="server.tpl"}

			<div class="form-group">
                <label for="min_level">保留最低角色等级(<)(范围 {$level_begin} - {$level_end} )</label>
                <input type="text" name="min_level" id="min_level" value="{$min_level}">
            </div>

            <div class="form-group">
                <label for="min_vip">保留最低角色vip(<)(范围 {$vip_begin} - {$vip_end} )</label>
                <input type="text" name="min_vip" id="min_vip" value="{$min_vip}">
            </div>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	{include file="default_btn.tpl"}
            	<span color="red" id="btn_msg"></span>
            </div>
        </fieldset>
	</form>

    {include file="default_msg.tpl"}
    
    {if $info}
    <div class="alert alert-success" role="alert">{$info}</div>
    {/if}
</div>

{include file="footer.tpl"}
