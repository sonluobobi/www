<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F4136085871";a:2:{i:0;s:43:"../template/template/Player.setOffRank.html";i:1;i:1476160027;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2021-02-26 13:37:02
         compiled from "../template/template/Player.setOffRank.html" */ ?>
<div align="center">
<form id="subform" name="subform" method="post" action="./?act=Player.setOffRank">
<br/><?php echo $_smarty_tpl->getVariable('lang')->value['setOffRankNotice'];?>
<br/>
<input type="hidden" id="server_ids[]" name="server_ids[]" value="<?php echo $_GET['server_id'];?>
"/>
<input type="hidden" id="server_id" name="server_id" value="<?php echo $_GET['server_id'];?>
"/>
<input type="hidden" id="roleId" name="roleId" value="<?php echo $_GET['roleId'];?>
" />
<input type="hidden" id="isOff" name="isOff" value="<?php echo $_GET['isOff'];?>
"/>
</form>
</div>