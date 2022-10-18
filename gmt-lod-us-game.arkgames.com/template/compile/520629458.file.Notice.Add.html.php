<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F3342341623";a:2:{i:0;s:36:"../template/template/Notice.Add.html";i:1;i:1666081721;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-18 16:28:45
         compiled from "../template/template/Notice.Add.html" */ ?>
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
<input type="hidden" id="id" name="id" value="<?php echo $_smarty_tpl->getVariable('id')->value;?>
" />
</tr>
<tr>  
<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['ServerName'];?>
：</td>   
<td align="left">全服</td>
</tr>
<tr> 
	<td align="right">语言：</td>  
	<td align="left"><select name="contents_language" id="contents_language" value = "<?php echo $_smarty_tpl->getVariable('contents_language')->value;?>
" > 
	     <option value="cn" <?php if ($_smarty_tpl->getVariable('contents_language')->value=='cn'){?> selected="selected"<?php }?>>cn </option> ' +
		'<option value="en" <?php if ($_smarty_tpl->getVariable('contents_language')->value=='en'){?> selected="selected"<?php }?> >en </option> ' +
		'<option value="ru" <?php if ($_smarty_tpl->getVariable('contents_language')->value=='ru'){?> selected="selected"<?php }?> >ru </option> ' +
		'<option value="de" <?php if ($_smarty_tpl->getVariable('contents_language')->value=='de'){?> selected="selected"<?php }?> >de </option> ' +
		'<option value="fr" <?php if ($_smarty_tpl->getVariable('contents_language')->value=='fr'){?> selected="selected"<?php }?> >fr </option> ' +
		'<option value="it" <?php if ($_smarty_tpl->getVariable('contents_language')->value=='it'){?> selected="selected"<?php }?> >it </option> ' +
		'<option value="pt" <?php if ($_smarty_tpl->getVariable('contents_language')->value=='pt'){?> selected="selected"<?php }?> >pt </option> ' +
		'<option value="es" <?php if ($_smarty_tpl->getVariable('contents_language')->value=='es'){?> selected="selected"<?php }?> >es </option> ' +
		'<option value="tr" <?php if ($_smarty_tpl->getVariable('contents_language')->value=='tr'){?> selected="selected"<?php }?> >tr </option> ' +
		'</select>'</td> 
</tr>		
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
：</td>  
	<td align="left"><input type="text" name="title" value="<?php echo $_smarty_tpl->getVariable('title')->value;?>
" id="title" style="width:200px" /></td>  
</tr>
<tr>  
	<td align="right">副标题：</td>  
	<td align="left"><input type="text" name="second_title" value="<?php echo $_smarty_tpl->getVariable('second_title')->value;?>
" id="second_title" style="width:200px" /></td> 
</tr>
<tr>  
	<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['sender'];?>
：</td>  <td align="left"><input type="text" name="author" id="author"  readonly style="width:100px" value=" <?php echo $_SESSION['infoUser']['fullname'];?>
">	</td>  
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
					<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['memo'];?>
：</td>
					<td align="left"><font color="red">
					 1.图片（文件发前端上传）
                    &ltimage&gt文件名&lt/image&gt
                    示例： &ltimage&gtgonggao1012&lt/image&gt<br />
                    2.超链接
                    &ltlink _ id=链接&gt&ltcolor=色值&gt文案&lt/color&gt&lt/link&gt
                    示例： &ltlink _ id=https://discord.gg/XEFA98Zrsu&gt&ltcolor=#ff6100&gt加入discord&lt/color&gt&lt/link&gt<br />
                    3.换行
                    \n<br />
                    4.文字颜色
                    &ltcolor=色值&gt文案&lt/color&gt
                    示例：&ltcolor=#ff6100&gt加入discord&lt/color&gt 
					</font></td>
				</tr>
<tr>  
	<td>内容：</td>
	<td align="left">
	<textarea id="contents" name="contents" rows="15" cols="80"><?php echo $_smarty_tpl->getVariable('content')->value;?>
</textarea>
	</td>  
</tr>
</tr>
	<tr>
	<td align="right">按钮显示：</td>  
	<td align="left">
	    <input type="radio" name="button_show" <?php if ($_smarty_tpl->getVariable('button_show')->value=='1'){?>checked="checked"<?php }?> value="1" />显示 &nbsp;
		<input type="radio" name="button_show" <?php if ($_smarty_tpl->getVariable('button_show')->value=='2'||$_smarty_tpl->getVariable('button_show')->value==''){?>checked="checked"<?php }?> value="2" />不显示&nbsp;
	</td>  
</tr> 
<tr>  
	<td align="right">按钮内容：</td>  
	<td align="left"><input type="text" name="button_title" value="<?php echo $_smarty_tpl->getVariable('button_title')->value;?>
" id="button_title" style="width:200px" /></td>  
</tr>
<tr>  
	<td align="right">按钮链接：</td>  
	<td align="left"><input type="text" name="button_url" value="<?php echo $_smarty_tpl->getVariable('button_url')->value;?>
" id="button_url" style="width:200px" /></td>  
</tr>

  
</table>
<div style="width:50%;margin:auto;padding:20px;">  
<input name="submit" type="button" class="button" value="<?php echo $_smarty_tpl->getVariable('lang')->value['Submit'];?>
" onclick="noticeAdd('sadasd')" />&nbsp;&nbsp;
<!--<input name="reset" type="reset" class="submit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['Reset'];?>
" />&nbsp;&nbsp;-->
</div>
</form> 
</div>
</div>


