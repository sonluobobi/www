<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:10:"F860389014";a:2:{i:0;s:54:"../template/template/Common_consumerServerId.list.html";i:1;i:1555559303;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-03-13 11:26:47
         compiled from "../template/template/Common_consumerServerId.list.html" */ ?>
<select name="consumerServerId" id="consumerServerId">
<?php $_smarty_tpl->assign('s',$_REQUEST['consumerServerId'],null,null);?>
	<option value=""><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_service_id_title'];?>
</option>
    <?php if ($_smarty_tpl->getVariable('consumberServerId_all')->value==true){?>
	<option value="9999" <?php if ($_smarty_tpl->getVariable('s')->value==9999){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['selectAll'];?>
</option>
    <?php }?>
	<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('lang')->value['consumer_service_id_ex']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
		<option value="<?php echo $_smarty_tpl->getVariable('k')->value;?>
" <?php if ($_smarty_tpl->getVariable('s')->value==$_smarty_tpl->getVariable('k')->value){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('i')->value;?>

	<?php }} ?>
</select>