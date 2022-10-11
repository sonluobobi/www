<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F3580315536";a:2:{i:0;s:41:"../template/template/Player.BlockGag.html";i:1;i:1614065431;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2021-02-23 15:30:40
         compiled from "../template/template/Player.BlockGag.html" */ ?>
<div align="center">
<form id="subform" name="subform" method="post" action="./?act=Player.<?php if ($_smarty_tpl->getVariable('undo')->value==1){?>undoUser<?php }else{ ?>user<?php }?>BlockGag">
<?php if ($_smarty_tpl->getVariable('undo')->value!=1){ if ($_GET['type']==1){ echo $_smarty_tpl->getVariable('lang')->value['block']; }elseif($_GET['type']==2){ echo $_smarty_tpl->getVariable('lang')->value['gag']; } echo $_smarty_tpl->getVariable('lang')->value['DateTime'];?>
：<input type="text" class="Wdate" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id="endTime" value="" style="width: 200px;" name="endTime" realvalue=""/><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php } echo $_smarty_tpl->getVariable('lang')->value['reason'];?>
：<textarea name="reason" id="reason" rows="4" cols="21"></textarea>	
<input type="hidden" id="server_id" name="server_id" value="<?php echo $_GET['server_id'];?>
">
<input type="hidden" id="roleId" name="roleId" value="<?php echo $_GET['roleId'];?>
" />
<input type="hidden" id="type" name="type" value="<?php echo $_GET['type'];?>
"/> 
</form>
</div>