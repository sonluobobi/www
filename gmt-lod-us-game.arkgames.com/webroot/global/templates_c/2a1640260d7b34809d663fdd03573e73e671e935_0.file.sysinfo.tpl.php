<?php
/* Smarty version 3.1.29, created on 2021-02-02 11:59:46
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/sysinfo.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_6018ce327afd75_30920953',
  'file_dependency' => 
  array (
    '2a1640260d7b34809d663fdd03573e73e671e935' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/sysinfo.tpl',
      1 => 1469014044,
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
function content_6018ce327afd75_30920953 ($_smarty_tpl) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="container">
    <form action="" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend><?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:default_top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</legend>

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
		<legend>系统信息</legend>
    	<table class="table table-hover">
			<?php
$__section_sec_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_sec']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec'] : false;
$__section_sec_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['sysinfo']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_sec_0_total = $__section_sec_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_sec'] = new Smarty_Variable(array());
if ($__section_sec_0_total != 0) {
for ($__section_sec_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] = 0; $__section_sec_0_iteration <= $__section_sec_0_total; $__section_sec_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']++){
?>
			<tr>
			  <td class="active"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] : null)]['var'];?>
</td>
			  <td class="active"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] : null)]['txt'];?>
</td>
			</tr>
			<?php
}
}
if ($__section_sec_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_sec'] = $__section_sec_0_saved;
}
?>
		</table>
	</fieldset>

	<fieldset>
		<legend>系统空闲内存数据</legend>
    	<table class="table table-hover">
			<?php
$_from = $_smarty_tpl->tpl_vars['free_info']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_data_list_0_saved_item = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v'] : false;
$__foreach_data_list_0_saved_key = isset($_smarty_tpl->tpl_vars['k']) ? $_smarty_tpl->tpl_vars['k'] : false;
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['v']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
$__foreach_data_list_0_saved_local_item = $_smarty_tpl->tpl_vars['v'];
?>
			<tr>	
				<?php
$_from = $_smarty_tpl->tpl_vars['v']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_sub_v_1_saved_item = isset($_smarty_tpl->tpl_vars['sub_v']) ? $_smarty_tpl->tpl_vars['sub_v'] : false;
$__foreach_sub_v_1_saved_key = isset($_smarty_tpl->tpl_vars['sub_k']) ? $_smarty_tpl->tpl_vars['sub_k'] : false;
$_smarty_tpl->tpl_vars['sub_v'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['sub_k'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['sub_v']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['sub_k']->value => $_smarty_tpl->tpl_vars['sub_v']->value) {
$_smarty_tpl->tpl_vars['sub_v']->_loop = true;
$__foreach_sub_v_1_saved_local_item = $_smarty_tpl->tpl_vars['sub_v'];
?>
			  	<td class="active"><?php echo $_smarty_tpl->tpl_vars['sub_v']->value;?>
</td>
			  	<?php
$_smarty_tpl->tpl_vars['sub_v'] = $__foreach_sub_v_1_saved_local_item;
}
if ($__foreach_sub_v_1_saved_item) {
$_smarty_tpl->tpl_vars['sub_v'] = $__foreach_sub_v_1_saved_item;
}
if ($__foreach_sub_v_1_saved_key) {
$_smarty_tpl->tpl_vars['sub_k'] = $__foreach_sub_v_1_saved_key;
}
?>
			</tr>
			<?php
$_smarty_tpl->tpl_vars['v'] = $__foreach_data_list_0_saved_local_item;
}
if ($__foreach_data_list_0_saved_item) {
$_smarty_tpl->tpl_vars['v'] = $__foreach_data_list_0_saved_item;
}
if ($__foreach_data_list_0_saved_key) {
$_smarty_tpl->tpl_vars['k'] = $__foreach_data_list_0_saved_key;
}
?>
		</table>
		
	</fieldset>
</div>


<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
