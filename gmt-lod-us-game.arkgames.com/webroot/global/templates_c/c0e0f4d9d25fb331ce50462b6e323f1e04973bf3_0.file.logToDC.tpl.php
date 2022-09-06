<?php
/* Smarty version 3.1.29, created on 2019-12-17 16:16:14
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/logToDC.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5df88ece5b48d6_44987310',
  'file_dependency' => 
  array (
    'c0e0f4d9d25fb331ce50462b6e323f1e04973bf3' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/logToDC.tpl',
      1 => 1479794690,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:default_top.tpl' => 1,
    'file:server.tpl' => 1,
    'file:default_hidden.tpl' => 1,
    'file:default_msg.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5df88ece5b48d6_44987310 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/smarty/plugins/function.html_options.php';
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend><?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:default_top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</legend>

			<div class="form-group">
                <label for="begin_date" class="col-md-2 control-label">选择日期</label>
                <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="begin_date" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['begin_date']->value;?>
" readonly>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<input type="hidden" id="begin_date" name="begin_date" value="<?php echo $_smarty_tpl->tpl_vars['begin_date']->value;?>
" />
			</div>
			
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:server.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


			<div class="form-group">
				<label for="log_type" class="col-md-2 control-label">日志文件类型</label>
				<div class="col-md-5" >
				  	<select class="form-control" id="log_type" name="log_type">
						<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['log_map_values']->value,'selected'=>$_smarty_tpl->tpl_vars['log_map_selected']->value,'output'=>$_smarty_tpl->tpl_vars['log_map_output']->value),$_smarty_tpl);?>

					</select>
				</div>
			</div>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:default_hidden.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            	<button type="button" class="btn btn-success" onclick="javascript:showAllLog();">查询当前服</button>
            </div>
        </fieldset>
	</form>

	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:default_msg.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	
	<fieldset>
		<legend>
			<div class="panel panel-default" > <div class="panel-body" id="all_log_content"></div></div>
		</legend>
	</fieldset>
</div>

<?php echo '<script'; ?>
 type="text/javascript">
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

    var base_frame_url =  "<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
/getAllLog.php";

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

<?php echo '</script'; ?>
>
<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
