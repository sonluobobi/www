<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F3215229056";a:2:{i:0;s:35:"../template/template/Base.Data.html";i:1;i:1555559303;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-07-21 15:56:44
         compiled from "../template/template/Base.Data.html" */ ?>

<table width="98%" class="tableContent" align="center" id="myTable">
  	<thead>
		<tr>
			<!-- 字段标题 -->
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('titles')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			<th ><?php echo $_smarty_tpl->getVariable('lang')->value[$_smarty_tpl->getVariable('v')->value];?>
</th>		
			<?php }} ?>
        </tr>
	</thead>
	<tbody>
        <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['name'] = "ii";
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['loop'] = is_array($_loop=$_smarty_tpl->getVariable('dataList')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['total']);
?>
		<tr align="center">
			<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('fields')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['f']->key;
?>
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']][$_smarty_tpl->getVariable('f')->value];?>
</td>
			<?php }} ?>
        </tr>
		<?php endfor; endif; ?>
	</tbody>
</table>

