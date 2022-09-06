<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1542578418";a:2:{i:0;s:45:"../template/template/Common_logOpId.list.html";i:1;i:1555559304;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-01-02 18:20:55
         compiled from "../template/template/Common_logOpId.list.html" */ ?>
<select name="op_id" id="op_id">
<?php $_smarty_tpl->assign('s',$_REQUEST['op_id'],null,null);?>
	<option value=""><?php echo $_smarty_tpl->getVariable('lang')->value['op_id_title'];?>
</option>
	<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('lang')->value['op_id_ex']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
		<option value="<?php echo $_smarty_tpl->getVariable('k')->value;?>
" <?php if ($_smarty_tpl->getVariable('s')->value==$_smarty_tpl->getVariable('k')->value){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('i')->value;?>

	<?php }} ?>
</select>