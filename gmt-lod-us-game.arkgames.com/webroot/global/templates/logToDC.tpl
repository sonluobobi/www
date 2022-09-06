{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend>{include file="default_top.tpl"}</legend>

			<div class="form-group">
                <label for="begin_date" class="col-md-2 control-label">选择日期</label>
                <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="begin_date" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="{$begin_date}" readonly>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<input type="hidden" id="begin_date" name="begin_date" value="{$begin_date}" />
			</div>
			
			{include file="server.tpl"}

			<div class="form-group">
				<label for="log_type" class="col-md-2 control-label">日志文件类型</label>
				<div class="col-md-5" >
				  	<select class="form-control" id="log_type" name="log_type">
						{html_options values=$log_map_values selected=$log_map_selected output=$log_map_output}
					</select>
				</div>
			</div>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	<button type="button" class="btn btn-success" onclick="javascript:showAllLog();">查询当前服</button>
            </div>
        </fieldset>
	</form>

	{include file="default_msg.tpl"}
	
	<fieldset>
		<legend>
			<div class="panel panel-default" > <div class="panel-body" id="all_log_content"></div></div>
		</legend>
	</fieldset>
</div>

<script type="text/javascript">
	$('.form_date').datetimepicker({
        language:  'zh-CN',
		format: 'yyyy-mm-dd',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });

    var base_frame_url =  "{$domain}/getAllLog.php";

	function showAllLog()
	{
    	var server_id = $('#server_id').val();
		var frame_url = 'http://' + server_id + base_frame_url;
		var log_type = $('#log_type').val();
		var begin_date = $('#begin_date').val();
		var pars = 'log_type='+log_type+'&begin_date='+begin_date+'&r=' + Math.random();

		$.ajax({
			url:frame_url,
			async:false,
			data:pars,
			type:"GET",
			dataType:"jsonp",/*加上datatype*/
 			jsonpCallback:"cb",
			beforeSend:function(){
				$('#all_log_content').html("查询中...");
			},
			success:function(data){
				$('#all_log_content').html(data.content);
			},
		});
	}

</script>
{include file="footer.tpl"}
