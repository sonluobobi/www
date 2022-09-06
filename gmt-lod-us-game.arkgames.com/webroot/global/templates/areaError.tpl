{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="post" onsubmit="return submitEvent();">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

			{include file="server.tpl"}

            <div class="form-group">
                <label for="week" class="col-md-2 control-label">角色id是否去重</label>
                <div class="col-md-5" >
                    <select class="form-control" id="op_type" name="op_type">
                        {html_options values=$op_map_values selected=$op_map_selected output=$op_map_output}
                    </select>
                </div>
            </div>

            <div class="col-md-7 control-label">
                <input type="hidden" id="do_search" name="do_search" value="do" />
                {include file="default_hidden.tpl"}
                {include file="default_btn.tpl"}
                <span color="red" id="btn_msg"></span>
            </div>
        </fieldset>
	</form>
    {if $desc_msg}
    <div class="alert alert-success" role="alert">{$desc_msg}</div>
    {/if}
	<fieldset>
        <legend>列表</legend>

        <table class="table table-hover">
            <tr>
              <td class="success">序号</td>
              <td class="success">记录时间</td>
              <td class="success">账号id</td>
              <td class="success">角色id</td>
              <td class="success">角色战力</td>
              <td class="success">被挑战者角色id</td>
              <td class="success">被挑战者排名</td>
              <td class="success">是否胜出</td>
            </tr>
            {section name=sec loop=$data_list}
            <tr>
              <td class="active">{$data_list[sec].id}</td>
              <td class="active">{$data_list[sec].date_time}</td>
              <td class="active">{$data_list[sec].pid}</td>
              <td class="active">{$data_list[sec].cid}</td>
              <td class="active">{$data_list[sec].fc}</td>
              <td class="active">{$data_list[sec].passive_pk_cid}</td>
              <td class="active">{$data_list[sec].passive_pk_rank}</td>
              <td class="active">{$data_list[sec].is_win_title}</td>
            </tr>
            {/section}
        </table>
    </fieldset>

</div>

<script type="text/javascript">
    function submitEvent()
    {
        $('#btn_msg').html('操作中。。。');
        return true;
    }
</script>

{include file="footer.tpl"}
