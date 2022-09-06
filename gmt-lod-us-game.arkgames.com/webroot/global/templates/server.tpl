<div class="form-group">
	<label for="server_id" class="col-md-2 control-label">选择游戏服</label>
	<div class="col-md-5" >
	  	<select class="form-control" id="server_id" name="server_id">
			{html_options values=$option_values selected=$option_selected output=$option_output}
		</select>
	</div>
</div>