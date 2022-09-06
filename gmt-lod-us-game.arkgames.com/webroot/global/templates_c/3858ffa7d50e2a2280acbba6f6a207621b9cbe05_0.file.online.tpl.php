<?php
/* Smarty version 3.1.29, created on 2019-12-17 16:17:50
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/online.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5df88f2e8ca708_25896990',
  'file_dependency' => 
  array (
    '3858ffa7d50e2a2280acbba6f6a207621b9cbe05' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/online.tpl',
      1 => 1469014103,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:default_top.tpl' => 1,
    'file:server.tpl' => 1,
    'file:default_hidden.tpl' => 1,
    'file:default_btn.tpl' => 1,
    'file:default_msg.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5df88f2e8ca708_25896990 ($_smarty_tpl) {
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


            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:default_hidden.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:default_btn.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            </div>
        </fieldset>
	</form>

	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:default_msg.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	
	<fieldset>
		<legend>
	    	<div class="panel panel-success">
	    		<div class="panel-body">
	    		目前实时在线人数:<?php echo $_smarty_tpl->tpl_vars['online_cnt']->value;?>

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
			<?php
$__section_online_info_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_online_info']) ? $_smarty_tpl->tpl_vars['__smarty_section_online_info'] : false;
$__section_online_info_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['online_list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_online_info_0_total = $__section_online_info_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_online_info'] = new Smarty_Variable(array());
if ($__section_online_info_0_total != 0) {
for ($__section_online_info_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_online_info']->value['index'] = 0; $__section_online_info_0_iteration <= $__section_online_info_0_total; $__section_online_info_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_online_info']->value['index']++){
?>
			<tr>
			  <td class="active"><?php echo $_smarty_tpl->tpl_vars['online_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_online_info']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_online_info']->value['index'] : null)]['t'];?>
</td>
			  <td class="active"><?php echo $_smarty_tpl->tpl_vars['online_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_online_info']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_online_info']->value['index'] : null)]['cnt'];?>
</td>
			</tr>
			<?php
}
}
if ($__section_online_info_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_online_info'] = $__section_online_info_0_saved;
}
?>
		</table>
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
<?php echo '</script'; ?>
>
<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
