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

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	{include file="default_btn.tpl"}
            </div>
        </fieldset>
	</form>

	{include file="default_msg.tpl"}
	
	<fieldset>
		<legend>
	    	<div class="panel panel-success">
	    		<div class="panel-body">
	    		目前实时在线人数:{$online_cnt}
	    		</div>
	    	</div>
		</legend>
	</fieldset>

	<fieldset>
		<legend>在线数据列表</legend>
    	<table class="table table-hover">
			<tr>
			  <td class="success">时间(小时)</td>
			  <td class="success">平均在线人数</td>
			</tr>
			{section name=online_info loop=$online_list}
			<tr>
			  <td class="active">{$online_list[online_info].t}</td>
			  <td class="active">{$online_list[online_info].cnt}</td>
			</tr>
			{/section}
		</table>
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
</script>
{include file="footer.tpl"}
