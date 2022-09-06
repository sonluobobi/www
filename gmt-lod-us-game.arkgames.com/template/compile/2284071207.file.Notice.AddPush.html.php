<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1664926753";a:2:{i:0;s:40:"../template/template/Notice.AddPush.html";i:1;i:1611915799;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2021-01-29 18:23:43
         compiled from "../template/template/Notice.AddPush.html" */ ?>
<div id="bodyTitle">
<?php if ($_GET['id']>0){?>
	<?php echo $_smarty_tpl->getVariable('lang')->value['noticeEditTitle'];?>

<?php }else{ ?>
	短信添加
<?php }?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
<div class="bodyContentHead" style="text-align:left">
<iframe id="iframeload" name="iframeload" src="/img/1.gif" style="width:0px; height:0px; display:none" frameborder="0" scrolling="no">
</iframe>
<form id="subform" name="subform" method="post" action="./?act=Notice.sendPropsEquip" target="iframeload">
<table align="center" cellspacing="1" cellpadding="0" class="userTable" style="width:80%;" id="tbl">
<tr>
<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['ServerName'];?>
：</td>
<td align="left">
<?php if ($_GET['id']>0){?>
<span id='servername'><?php echo $_smarty_tpl->getVariable('server_text')->value;?>
</span>
<input type="hidden" id="id" name="id" value="<?php echo $_smarty_tpl->getVariable('id')->value;?>
" />
<input type="hidden" id="server_ids[]" name="server_ids[]" value="<?php echo $_smarty_tpl->getVariable('server_id')->value;?>
" />
<?php }else{  $_template = new Smarty_Template ("Common_server.Checkbox.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template);  }?>
</td>
</tr>
<tr>
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
：</td>
	<td align="left"><input type="text" name="push_title" value="<?php echo $_smarty_tpl->getVariable('title')->value;?>
" id="title" style="width:200px" /></td>
</tr>
	<tr>
		<td align="right">发送时间：</td>
		<td align="left"><input type="text" name="begTime" style="width:200px" value="<?php echo $_smarty_tpl->getVariable('begTime')->value;?>
" id="begTime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="Wdate" >
		</td>
	</tr>
<tr>
	<td></td>
	<td><font color="red"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['contentNotice'];?>
</strong></font></td>
</tr>
<tr>
	<td>默认内容：</td>
	<td align="left">
	<textarea id="contents" name="contents" rows="6" cols="40"><?php echo $_smarty_tpl->getVariable('content')->value;?>
</textarea>
	</td>
</table>
<div style="width:50%;margin:auto;padding:20px;">
<input name="submit" type="submit"  value="<?php echo $_smarty_tpl->getVariable('lang')->value['Submit'];?>
" />&nbsp;&nbsp;
</div>
</form>
</div>
</div>


