{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get" onsubmit="return submitEvent();">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

			{include file="server.tpl"}
			<div class="form-group">
                <label for="begin_date" class="col-md-2 control-label">开始日期</label>
                <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy hh:ii:ss" data-link-field="begin_date" data-link-format="yyyy-mm-dd hh:ii:ss">
                    <input class="form-control" size="16" type="text" value="{$begin_date}" readonly>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<input type="hidden" id="begin_date" name="begin_date" value="{$begin_date}" />
			</div>
			
			<div class="form-group">
                <label for="end_date" class="col-md-2 control-label">结束日期</label>
                <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy hh:ii:ss" data-link-field="end_date" data-link-format="yyyy-mm-dd hh:ii:ss">
                    <input class="form-control" size="16" type="text" value="{$end_date}" readonly>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<input type="hidden" id="end_date" name="end_date" value="{$end_date}" />
			</div>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	<button type="submit" class="btn btn-success" id="btn_submit">提交</button>
                <span color="red" id="btn_msg"></span>
            </div>
        </fieldset>
	</form>

	{include file="default_msg.tpl"}
</div>

<script type="text/javascript">
	$('.form_date').datetimepicker({
        language:  'zh-CN',
		format: 'yyyy-mm-dd hh:ii:ss',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0
    });

    function submitEvent()
    {
        $('#btn_submit').remove();
        $('#btn_msg').html('操作中。。。');
        return true;
    }
</script>
{include file="footer.tpl"}
