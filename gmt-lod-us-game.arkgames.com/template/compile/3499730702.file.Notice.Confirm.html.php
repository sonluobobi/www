<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:10:"F998328840";a:2:{i:0;s:40:"../template/template/Notice.Confirm.html";i:1;i:1578895050;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-01-13 13:57:50
         compiled from "../template/template/Notice.Confirm.html" */ ?>
<div  align="center">
<table align="center" cellspacing="1" cellpadding="0" class="userTable" style="width:100%;" id="tbl">  
<tr>  
<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['ServerName'];?>
：</td>  
<td align="left">
	<span id='mask_serverName'></span>
</td>
</tr>
<tr>  
	<td align="right" width="20%"><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
：</td>  
	<td align="left"><span id="mask_title"></span></td>  
</tr>
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['sender'];?>
：</td>  
	<td align="left"><span  id="mask_author"></span></td>  
</tr>  
<tr>
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['noticeType'];?>
：</td>  
	<td align="left">  
		<span id="mask_d1" style='display:none'><?php echo $_smarty_tpl->getVariable('lang')->value['scrollNotice'];?>
</span>  
		<span id="mask_d2" style='display:none'><?php echo $_smarty_tpl->getVariable('lang')->value['talkNotice'];?>
</span>  
		<span id="mask_d3" style='display:none'><?php echo $_smarty_tpl->getVariable('lang')->value['scrollAndTalkNotice'];?>
</span>  
	</td>  
</tr>
<tr>
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：</td>  
	<td align="left"><span id="mask_begTime"></span>
	</td>  
</tr>  
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['endDate'];?>
：</td>  
	<td align="left"><span id="mask_endTime"></span></td>  
</tr>  
<tr style="display:none" id="NoticeDIV">  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['picUrl'];?>
：</td>  <td align="left"><span id="mask_pictureUrl"/></span></td>  
</tr>  
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['tollgate_id'];?>
：</td>  <td align="left"><span id="mask_tollgate_id"></span></td>  
</tr>
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['cycle'];?>
：</td>  <td align="left"><span id="mask_cycle"></span><?php echo $_smarty_tpl->getVariable('lang')->value['second'];?>
</td>  
</tr>  

<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['content'];?>
：</td>  
	<td align="left">
	<div id="mask_content"></div>
	</td>  
</tr>  
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
：</td>  
	<td align="left">
		<span id='mask_status1' style='display:none'><?php echo $_smarty_tpl->getVariable('lang')->value['normal'];?>
</span> &nbsp;
		<span id='mask_status2' style='display:none'><?php echo $_smarty_tpl->getVariable('lang')->value['pause'];?>
</span>&nbsp;
	</td>  
</tr>  
</table>  
</div>
