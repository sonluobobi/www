<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:9:"F19742711";a:2:{i:0;s:41:"../template/template/Notice.addLocal.html";i:1;i:1578893985;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-01-13 14:31:29
         compiled from "../template/template/Notice.addLocal.html" */ ?>
<div id="bodyTitle">
<?php if ($_GET['id']>0){?>
	<?php echo $_smarty_tpl->getVariable('lang')->value['noticeEditTitle'];?>

<?php }else{ ?>
	<?php echo $_smarty_tpl->getVariable('lang')->value['noticeAddTitle'];?>

<?php }?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
<div class="bodyContentHead" style="text-align:left">
<iframe id="iframeload" name="iframeload" src="/img/1.gif" style="width:0px; height:0px; display:none" frameborder="0" scrolling="no">
</iframe>	
<form id="subform" name="subform" method="post" action="./?act=Notice.add" target="iframeload">  
<table align="center" cellspacing="1" cellpadding="0" class="userTable" style="width:80%;" id="tbl">  
<tr>  
<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['ServerName'];?>
：</td>  
<td align="left">
<?php if (false&&$_GET['id']>0){?>
<span id='servername'><?php echo $_smarty_tpl->getVariable('server_names')->value;?>
</span>
<input type="hidden" id="id" name="id" value="<?php echo $_smarty_tpl->getVariable('id')->value;?>
" />
<input type="hidden" id="act" name="act" value="edit" />
<input type="hidden" id="server_id_str" name="server_id_str" value="<?php echo $_smarty_tpl->getVariable('server_ids')->value;?>
" />
<input type="hidden" id="server_ids[]" name="server_ids[]" value="<?php echo $_smarty_tpl->getVariable('server_id')->value;?>
" /> 
<?php }else{  $_template = new Smarty_Template ("Common_server.Checkbox.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template);  }?>
</td>
</tr>
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
：</td>  
	<td align="left"><input type="text" name="title" value="<?php echo $_smarty_tpl->getVariable('title')->value;?>
" id="title" style="width:200px" /></td>  
</tr>
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['sender'];?>
：</td>  <td align="left"><input type="text" name="author" id="author"  readonly style="width:100px" value=" <?php echo $_SESSION['infoUser']['fullname'];?>
">	</td>  
</tr>  
<tr>
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['noticeType'];?>
：</td>  
	<td align="left"><select name="type" id="type" onchange="changePopNotice(this.value,'NoticeDIV')">  
						<option value="1" <?php if ($_smarty_tpl->getVariable('type')->value=='1'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['scrollNotice'];?>
</option> <!-- 
						<option value="0"><?php echo $_smarty_tpl->getVariable('lang')->value['Select'];?>
</option>  
						<option value="2" <?php if ($_smarty_tpl->getVariable('type')->value=='2'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['talkNotice'];?>
</option>  
						<option value="3" <?php if ($_smarty_tpl->getVariable('type')->value=='3'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['scrollAndTalkNotice'];?>
</option>  
						-->
					</select>
	</td>  
</tr>
<tr>
<td align="left" colspan="2"><font color="red"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['timeNotice'];?>
</strong></font></td> 
</tr>
<tr>
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：</td>  
	<td align="left"><input type="text" name="begTime" style="width:200px" value="<?php echo $_smarty_tpl->getVariable('begTime')->value;?>
" id="begTime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="Wdate" >
	</td>  
</tr>  
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['endDate'];?>
：</td>  <td align="left"><input type="text" name="endTime" style="width:200px" value="<?php echo $_smarty_tpl->getVariable('endTime')->value;?>
" id="endTime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="Wdate" >
	</td>  
</tr>  
<tr style="display:none" id="NoticeDIV">  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['picUrl'];?>
：</td>  <td align="left"><input type="text" name="pictureUrl" style="width:200px" value="<?php echo $_smarty_tpl->getVariable('pictureUrl')->value;?>
" id="pictureUrl"/></td>  
</tr> 

<tr>
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['cycle'];?>
：</td>  
	<td align="left"><select name="cycle" id="cycle" onchange="changePopNotice(this.value,'NoticeDIV')">  
						<option value="15" <?php if ($_smarty_tpl->getVariable('cycle')->value=='15'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['second_15'];?>
</option>  
						<option value="30" <?php if ($_smarty_tpl->getVariable('cycle')->value=='30'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['second_30'];?>
</option>  
						<option value="60" <?php if ($_smarty_tpl->getVariable('cycle')->value=='60'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['second_60'];?>
</option>  
						<option value="110" <?php if ($_smarty_tpl->getVariable('cycle')->value=='110'){?>selected="true"<?php }?>>110秒</option>
						<option value="170" <?php if ($_smarty_tpl->getVariable('cycle')->value=='170'){?>selected="true"<?php }?>>170秒</option>
						<option value="300" <?php if ($_smarty_tpl->getVariable('cycle')->value=='300'){?>selected="true"<?php }?>>300秒</option>
					    <option value="1800" <?php if ($_smarty_tpl->getVariable('cycle')->value=='1800'){?>selected="true"<?php }?>>30分钟</option>
                        <option value="2400" <?php if ($_smarty_tpl->getVariable('cycle')->value=='2400'){?>selected="true"<?php }?>>40分钟</option>
                        <option value="3600" <?php if ($_smarty_tpl->getVariable('cycle')->value=='3600'){?>selected="true"<?php }?>>1小时</option>
                        <option value="5436" <?php if ($_smarty_tpl->getVariable('cycle')->value=='5436'){?>selected="true"<?php }?>>1.51小时</option>
                        <option value="7560" <?php if ($_smarty_tpl->getVariable('cycle')->value=='7560'){?>selected="true"<?php }?>>2.1小时</option>
                        <option value="9036" <?php if ($_smarty_tpl->getVariable('cycle')->value=='9036'){?>selected="true"<?php }?>>2.51小时</option>
                        <option value="11160" <?php if ($_smarty_tpl->getVariable('cycle')->value=='11160'){?>selected="true"<?php }?>>3.1小时</option>
                        <option value="12636" <?php if ($_smarty_tpl->getVariable('cycle')->value=='12636'){?>selected="true"<?php }?>>3.51小时</option>
					</select>
	</td>  
</tr>

<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['tollgate_id'];?>
：</td>  <td align="left"><input type="text" name="tollgate_id" style="width:200px" value="<?php echo $_smarty_tpl->getVariable('tollgate_id')->value;?>
" id="tollgate_id"/></td>  
</tr>
<tr>
	<td></td>
	<td><font color="red"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['contentNotice'];?>
</strong></font></td>
</tr>
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['content'];?>
：</td>  
	<td align="left">
	<textarea id="contents" name="contents" rows="6" cols="40"><?php echo $_smarty_tpl->getVariable('content')->value;?>
</textarea>
	</td>  
</tr>  
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
：</td>  
	<td align="left">
		<input type="radio" name="status" <?php if ($_smarty_tpl->getVariable('status')->value=='1'||$_smarty_tpl->getVariable('status')->value==''){?>checked="checked"<?php }?> value="1" /><?php echo $_smarty_tpl->getVariable('lang')->value['normal'];?>
 &nbsp;
		<input type="radio" name="status" <?php if ($_smarty_tpl->getVariable('status')->value=='2'){?>checked="checked"<?php }?> value="2" /><?php echo $_smarty_tpl->getVariable('lang')->value['pause'];?>
&nbsp;
	</td>  
</tr>  
</table>  
<div style="width:50%;margin:auto;padding:20px;">  
<input name="submit" type="button" class="button" value="<?php echo $_smarty_tpl->getVariable('lang')->value['Submit'];?>
" onclick="noticeAdd('sadasd')" />&nbsp;&nbsp;
<input name="reset" type="reset" class="submit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['Reset'];?>
" />&nbsp;&nbsp;
</div> 
</form> 
</div>
</div>
