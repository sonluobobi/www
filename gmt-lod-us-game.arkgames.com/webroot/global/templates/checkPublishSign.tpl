{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>
			<div class="alert alert-success" role="alert">对应游戏服文件 /data/moyu/s?/script/verpub.txt</div>

			<div class="form-group">
				<label for="type" class="col-md-1 control-label">选择类型</label>
				<div class="col-md-2" >
				  	<select class="form-control" id="type" name="type">
						{html_options values=$type_map_values selected=$type_selected output=$type_map_output}
					</select>
				</div>
			</div>

			<div class="form-group">
                <label for="content" class="col-md-1 control-label">检查内容</label>
               	<div class="col-md-2" >
                	<input type="text" name="content" id="content" value="{$content}" size="100">
                </div>
            </div>
			
            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	<button type="submit" class="btn btn-success">查询</button>
            </div>
        </fieldset>
	</form>

	<fieldset>
    	<table class="table table-hover">
    		<tr>
			  <td class="success">游戏服数量</td>
			  <td class="success">内容</td>
			  <td class="success">rsync日志检查</td>
			</tr>
			{section name=sec loop=$base_list}
			<tr>
			  <td class="active">{$base_list[sec].var}</td>
			  <td class="active">{$base_list[sec].txt}</td>
			  <td class="active">{$base_list[sec].rsync_log}</td>
			</tr>
			{/section}
		</table>
	</fieldset>

</div>
{include file="footer.tpl"}
