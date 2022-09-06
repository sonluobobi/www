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

            <div class="form-group">
              <label for="command" class="col-md-2 control-label">命令</label>
              <div class="col-md-5" >
                  <input type="text" id="command" name="command" value="{$command}" class="form-control input-lg"/>
              </div>
            </div>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	<button type="submit" class="btn btn-success" id="btn_submit">提交</button>
            </div>
        </fieldset>
	</form>

    <fieldset>
	<legend>命令demo列表(角色在线才可操作gm指令|如执行相应命令后，没有效果的，请重启客户端)</legend>

        <table class="table table-hover">
            <tr>
              <td class="success">命令</td>
              <td class="success">描述</td>
            </tr>
            {section name=sec loop=$data_list}
            <tr>
              <td class="active">{$data_list[sec].cmd}</td>
              <td class="active">{$data_list[sec].desc}</td>
            </tr>
            {/section}
        </table>
    </fieldset>
    
</div>

{include file="footer.tpl"}
