{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="post">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

            <div class="alert alert-success" role="alert">{$desc_msg}</div>
			     {include file="server.tpl"}

           <div class="form-group">
            <label for="player_id" class="col-md-2 control-label">账号id(player_id)</label>
            <div class="col-md-5" >
		<input type="text" id="player_id" name="player_id" value="{$player_id}" />
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
    
    <fieldset>
        <legend>列表</legend>

        <table class="table table-hover">
            <tr>
              <td class="success">角色id</td>
              <td class="success">账号id</td>
              <td class="success">创建时间</td>
            </tr>
            {section name=sec loop=$data_list}
            <tr>
              <td class="active">{$data_list[sec].id}</td>
              <td class="active">{$data_list[sec].player_id}</td>
              <td class="active">{$data_list[sec].created}</td>
            </tr>
            {/section}
        </table>
    </fieldset>
</div>

{include file="footer.tpl"}
