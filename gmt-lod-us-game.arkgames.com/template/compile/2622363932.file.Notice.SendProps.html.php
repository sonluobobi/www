<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:10:"F347065159";a:2:{i:0;s:42:"../template/template/Notice.SendProps.html";i:1;i:1577936778;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-10-20 09:58:21
         compiled from "../template/template/Notice.SendProps.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['sendPropsTitle'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
	<div class="downDocment"><a href="docment/send_props_document.xls" target="_blank"><?php echo $_smarty_tpl->getVariable('lang')->value['sendEquipDoc'];?>
</a></div>
    <iframe id="iframeload" name="iframeload" src="/img/1.gif" style="width:0px; height:0px; display:none" frameborder="0" scrolling="no"></iframe>
  <div class="bodyContentHead">

  <form  method="post"  target="iframeload"  id="myform" action="./?act=Notice.sendProps" enctype="multipart/form-data" >
	<input type="hidden" value="9900000" name="MAX_FILE_SIZE"/>
	<table align="center" cellspacing="1" cellpadding="0" class="userTable" style="width:80%;" id="tbl">
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
：</td>
      <td align="left"><?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?></td>
    </tr>
	<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['receiverType'];?>
：</td>
	<td align="left">
		<select id="receiverType" name="receiverType">
			<option value="1" selected="selected"><?php echo $_smarty_tpl->getVariable('lang')->value['roleId'];?>
</option>
			<option value="2"><?php echo $_smarty_tpl->getVariable('lang')->value['roleName'];?>
</option>
		</select>
	</td>  
	</tr>
    <tr>
      <td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['receiver'];?>
：</td>
      <td align="left">	
	  	<input id="type" name="type" type="radio" value="1" checked="checked" onclick="changeSendType(this.value,'<?php echo $_smarty_tpl->getVariable('lang')->value['inputCaption'];?>
')"/>
		<?php echo $_smarty_tpl->getVariable('lang')->value['input'];?>
 &nbsp;
		<input id="type" name="type" type="radio" value="2" onclick="changeSendType(this.value,'<?php echo $_smarty_tpl->getVariable('lang')->value['uploadCaption'];?>
')"/>
		<?php echo $_smarty_tpl->getVariable('lang')->value['upload'];?>

		<br />	
		<input type="text" id="rids" name="rids" value="" style="width:250px"/>
		<input type="file" id="excleFile" name="excleFile"  value=""  style="display:none">
		<input type="submit" class="submit" name="is_check_role_name"  value="<?php echo $_smarty_tpl->getVariable('lang')->value['checkRoleName'];?>
">
		<span id="caption"><?php echo $_smarty_tpl->getVariable('lang')->value['inputCaption'];?>
</span>	
		</td>
    </tr>	
	<tr>
	 <td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['selectFile'];?>
：</td>
	 <td align="left"><input type="file" value="" id="propsFile" name="propsFile"></td>
	</tr>
	<!--<tr>
        <td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['awardType'];?>
：</td>
        <td align="left">
                <select id="awardType" name="awardType">
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('lang')->value['sendType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                        <option value="<?php echo $_smarty_tpl->getVariable('k')->value;?>
"><?php echo $_smarty_tpl->getVariable('v')->value;?>
</option>
			<?php }} ?>
                </select>
			</td>
		</tr>-->
		<tr>
			<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
：</td>
			<td align="left"><input type="text" name="title" value="<?php echo $_smarty_tpl->getVariable('title')->value;?>
" id="title" style="width:200px" /></td>  
		</tr>
		<tr>
			<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['content'];?>
：</td>
			<td align="left">
			<textarea id="contents" name="content" rows="8" cols="80"><?php echo $_smarty_tpl->getVariable('content')->value;?>
</textarea>
			</td>  
		</tr>
		<tr>
			<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['reason'];?>
：</td>
			<td align="left">
			<textarea id="reason" name="reason" rows="6" cols="40"><?php echo $_smarty_tpl->getVariable('reason')->value;?>
</textarea>
			</td>  
		</tr>
	<!--
	<tr>
         <td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['awardNum'];?>
：</td>
         <td align="left"><input type="text" value="" id="awardNum" name="awardNum"></td>
        </tr>
    <tr>
	-->
	<tr>
	<td></td>
	<td><input type="submit" class="submit"  value="<?php echo $_smarty_tpl->getVariable('lang')->value['Submit'];?>
"></td>
	</tr>
	</table>
  </form>
</div>
</div>
