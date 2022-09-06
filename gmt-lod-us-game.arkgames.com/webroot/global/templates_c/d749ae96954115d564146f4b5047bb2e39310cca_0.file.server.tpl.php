<?php
/* Smarty version 3.1.29, created on 2019-11-08 10:25:34
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/server.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5dc4d21e681149_88785635',
  'file_dependency' => 
  array (
    'd749ae96954115d564146f4b5047bb2e39310cca' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/server.tpl',
      1 => 1462941456,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc4d21e681149_88785635 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/smarty/plugins/function.html_options.php';
?>
<div class="form-group">
	<label for="server_id" class="col-md-2 control-label">选择游戏服</label>
	<div class="col-md-5" >
	  	<select class="form-control" id="server_id" name="server_id">
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['option_values']->value,'selected'=>$_smarty_tpl->tpl_vars['option_selected']->value,'output'=>$_smarty_tpl->tpl_vars['option_output']->value),$_smarty_tpl);?>

		</select>
	</div>
</div><?php }
}
