{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="post">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

            <div class="alert alert-success" role="alert">{$desc_msg}</div>
			     {include file="server.tpl"}

           <div class="form-group">
            <label for="cid" class="col-md-2 control-label">角色id</label>
            <div class="col-md-5" >
                <input type="text" id="cid" name="cid" value="{$cid}" />
            </div>
          </div>

           <div class="form-group">
            <label for="equip_id" class="col-md-2 control-label">道具id</label>
            <div class="col-md-5" >
                <input type="text" id="equip_id" name="equip_id" value="{$equip_id}" />
            </div>
          </div>

           <div class="form-group">
            <label for="equip_num" class="col-md-2 control-label">道具数量</label>
            <div class="col-md-5" >
                <input type="text" id="equip_num" name="equip_num" value="{$equip_num}" />
            </div>
          </div>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
		<button type="submit" class="btn btn-success" id="btn_submit">提交</button>
            </div>
        </fieldset>
	</form>

    {include file="default_msg.tpl"}
    
    
</div>

{include file="footer.tpl"}
