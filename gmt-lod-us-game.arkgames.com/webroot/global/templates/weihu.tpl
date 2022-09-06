{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="post" onsubmit="return submitEvent();">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

			{include file="server.tpl"}


            {if $show_set}
            <div class="form-group">
                <label for="week" class="col-md-2 control-label">维护周期</label>
                <div class="col-md-5" >
                    <select class="form-control" id="week" name="week">
                        {html_options values=$option_values_week selected=$option_selected_week output=$option_output_weeek}
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="begin_hour" class="col-md-2 control-label">维护开始小时</label>
                <div class="col-md-5" >
                    <select class="form-control" id="begin_hour" name="begin_hour">
                        {html_options values=$option_values_hour selected=$option_selected_begin_hour output=$option_output_hour}
                    </select>
                </div>
            </div>
        
            <div class="form-group">
                <label for="end_hour" class="col-md-2 control-label">维护结束小时</label>
                <div class="col-md-5" >
                    <select class="form-control" id="end_hour" name="end_hour">
                        {html_options values=$option_values_hour selected=$option_selected_end_hour output=$option_output_hour}
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="begin_minute" class="col-md-2 control-label">维护开始分钟</label>
                <div class="col-md-5" >
                    <select class="form-control" id="begin_minute" name="begin_minute">
                        {html_options values=$option_values_minute selected=$option_selected_begin_minute output=$option_output_minute}
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="end_minute" class="col-md-2 control-label">维护结束分钟</label>
                <div class="col-md-5" >
                    <select class="form-control" id="end_minute" name="end_minute">
                        {html_options values=$option_values_minute selected=$option_selected_end_minute output=$option_output_minute}
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="is_tmp_weihu" class="col-md-2 control-label">是否临时维护</label>
                <div class="col-md-5" >
                    <input type="checkbox" id="is_tmp_weihu" name="is_tmp_weihu" value="1" {if $is_tmp_weihu} checked="true" {/if}>
                </div>
            </div>
            {/if}

            <div class="col-md-7 control-label">
                <input type="hidden" id="do_search" name="do_search" value="do" />
                {include file="default_hidden.tpl"}
                {include file="default_btn.tpl"}
                {if $show_set}
                <button type="submit" class="btn btn-success" name="do_set" value="do_set">提交设置</button>
                {/if}
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
