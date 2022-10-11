<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1939694216";a:2:{i:0;s:42:"../template/template/User_Type.Select.html";i:1;i:1662457797;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-09 10:22:22
         compiled from "../template/template/User_Type.Select.html" */ ?>
<?php echo $_smarty_tpl->getVariable('lang')->value['selectUserType'];?>
(search by)：<select id="user_type" name="user_type">
<?php $_smarty_tpl->assign('t',$_POST['user_type'],null,null); $_smarty_tpl->assign('p',$_POST['isPay'],null,null); $_smarty_tpl->assign('s',$_POST['status'],null,null);?>
	<option value="0" <?php if ($_smarty_tpl->getVariable('t')->value=='0'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['plaseClew'];?>
</option>
	<option value="1" <?php if ($_smarty_tpl->getVariable('t')->value=='1'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['pid'];?>
(UID)</option>
	<option value="3" <?php if ($_smarty_tpl->getVariable('t')->value=='3'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['roleId'];?>
(character id)</option>
	<option value="4" <?php if ($_smarty_tpl->getVariable('t')->value=='4'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['roleName'];?>
(ign)</option>			
</select>
<input id="user_value" name="user_value" type="text" value="<?php echo $_POST['user_value'];?>
" />
&nbsp;&nbsp;
			  
