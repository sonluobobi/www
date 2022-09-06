{include file="header.tpl"}

<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend>{include file="default_top.tpl"}|{$caption}</legend>

			<div class="form-group">
				<label for="type" class="col-md-2 control-label">请选择正式服类型</label>
				<div class="col-md-5" >
				  	<select class="form-control" id="type" name="type">
						{html_options values=$type_map_values selected=$type_selected output=$type_map_output}
					</select>
				</div>
			</div>
			
            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	{include file="default_hidden.tpl"}
            	<button type="submit" class="btn btn-success">查询</button>
            </div>
        </fieldset>
	</form>

	{include file="common_list.tpl"}

</div>
{include file="footer.tpl"}
