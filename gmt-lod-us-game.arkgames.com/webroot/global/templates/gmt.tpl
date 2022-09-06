{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend>{include file="default_top.tpl"}</legend>

			{include file="server.tpl"}

			<div class="form-group">
			    <label for="func">函数名</label>
			  	<select class="form-control" name="func" id="func">
					{html_options values=$func_values selected=$func_selected output=$func_output}
				</select>
			</div>

			<div class="form-group">
			    <label for="params">对应参数 <font color="red">(多个参数用空格间隔)</font></label>
			    <textarea class="form-control" rows="3" id="params" name="params"></textarea>
  			</div>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	<button type="button" class="btn btn-success" id="btn_exec">执行</button>
            </div>
        </fieldset>
	</form>

	<div class="panel panel-default"> <div class="panel-body" id="msg_lua_error"></div></div>
</div>

<script type="text/javascript">
$(document).ready(function(){

	$("#btn_exec").click(function(){
		var server_id = $("#server_id").val();
		var val_func = $("#func").val();
		var val_params = $("#params").val();

		if (server_id == "" || server_id == "0")
		{
			alert('选择游戏服');
			$("#server_id").focus();
			return false;
		}

		if (val_func == "")
		{
			alert('请选择函数名');
			$("#func").focus();
			return false;
		}

		if (val_params == "")
		{
			alert('对应参数');
			$("#params").focus();
			return false;
		}

		var t = $("#t").val();
		var sign = $("#s").val();
		var auth_user = $("#auth_user").val();
		var auth_sign = $("#auth_sign").val();
		var pars = 'do_search=do&server_id='+server_id+'&func='+val_func+'&params='+val_params+'&auth_user='+auth_user+'&auth_sign='+auth_sign+'&t='+t+'&sign='+sign+'&r=' + Math.random();

		$.ajax({
			url:"gmt.php",
			async:false,
			data:pars,
			type:"POST",
			beforeSend:function(){
				$("#msg_lua_error").html("执行中...");
			},
			success:function(data , textStatus){
				$("#msg_lua_error").html(data);
			},
		});
	});
});
</script>


{include file="footer.tpl"}
