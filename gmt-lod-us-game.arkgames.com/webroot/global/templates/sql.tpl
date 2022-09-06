{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="post" onsubmit="return submitEvent();">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

			{include file="server.tpl"}

			<div class="form-group">
			    <label for="params">sql语句 <font color="red">(不支持双引号且仅支持单表查询操作)</font><br>demo: SELECT id,player_id,nick,vip,level,ban_type,ban_expire,now_login_time,logout_time,created FROM tbl_player_character WHERE player_id=9920
</label>
			    <textarea class="form-control" rows="3" id="params" name="params" >{$params}</textarea>
  			</div>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	{include file="default_btn.tpl"}
            	<span color="red" id="btn_msg"></span>
            </div>
        </fieldset>
	</form>

	{include file="common_list.tpl"}

</div>

<script type="text/javascript">
    function submitEvent()
    {
        $('#btn_msg').html('操作中。。。');
        return true;
    }
</script>

{include file="footer.tpl"}
