<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1263294376";a:2:{i:0;s:38:"../template/template/Player.setGm.html";i:1;i:1434357611;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-09-28 18:30:45
         compiled from "../template/template/Player.setGm.html" */ ?>
<div align="center">
<form id="subform" name="subform" method="post" action="./?act=Player.setGm">
<br/><?php echo $_smarty_tpl->getVariable('lang')->value['gmNotice'];?>
<br/>
<input type="hidden" id="server_ids[]" name="server_ids[]" value="<?php echo $_GET['server_id'];?>
"/>
<input type="hidden" id="server_id" name="server_id" value="<?php echo $_GET['server_id'];?>
"/>
<input type="hidden" id="roleId" name="roleId" value="<?php echo $_GET['roleId'];?>
" />
<input type="hidden" id="isGm" name="isGm" value="<?php echo $_GET['isGm'];?>
"/>
</form>
</div>