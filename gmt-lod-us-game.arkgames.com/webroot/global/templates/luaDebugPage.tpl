{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

			{include file="server.tpl"}

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_btn.tpl"}
            </div>
        </fieldset>
	</form>
	
	{include file="default_msg.tpl"}

	<fieldset>
    	<table class="table table-hover">
			<tr>
				<td colspan="4">
					<div class="panel panel-default" > <div class="panel-body" id="error_id}">{$first_msg}</div></div>
				</td>
			</tr>
		</table>
	</fieldset>

</div>

<script type="text/javascript">
	var server_id = "{$server_id}";

	function showLuaError()
	{
		var content_id='#error_id';
		var display_status = $(content_id).css("display");

		if(display_status == 'none')
		{
			$(content_id).css('display','block');
			var pars = 'do_search=search&server_id='+server_id+'&r=' + Math.random();

			$.ajax({
				url:"luaDebugPage.php",
				async:false,
				data:pars,
				type:"POST",
				beforeSend:function(){
					$(content_id).html("查询中...");
				},
				success:function(data , textStatus){
					$(content_id).html(data);
				},
			});
		}
		else
		{
			$(content_id).css('display','none');
		}
	}

	function showLuaErrorMore( more_div_id, end_line)
	{
		var content_id='#'+more_div_id;
		$(content_id).html("查询中...");

		var pars = 'do_search=search&server_id='+server_id+'&end_line='+end_line+'&r=' + Math.random();

		$.ajax({
			url:"luaDebugPage.php",
			async:false,
			data:pars,
			type:"POST",
			beforeSend:function(){
				$(content_id).html("查询中...");
			},
			success:function(data , textStatus){
				$(content_id).html(data);
			},
		});
		
	}

</script>

{include file="footer.tpl"}
