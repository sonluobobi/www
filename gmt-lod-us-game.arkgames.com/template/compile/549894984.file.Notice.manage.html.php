<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:10:"F907903629";a:2:{i:0;s:39:"../template/template/Notice.manage.html";i:1;i:1578894387;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-01-13 13:58:02
         compiled from "../template/template/Notice.manage.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['noticeListTitle'];?>
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
</option> 
						<!--
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
<input name="reset" type="reset" class="button" value="<?php echo $_smarty_tpl->getVariable('lang')->value['Reset'];?>
" />&nbsp;&nbsp;
</div> 
</form> 
</div>
</div>




<div class="bodyContent"  style="border-top: 2px solid #666;">
  	<div class="bodyContentBody">
  	<div id="bodyContentHead" class="bodyContentHead" style="text-align:left">
  	
  	<form method="POST" name="myform" id="myform" action="./?act=Notice.manage<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('capitalize',array($_smarty_tpl->getVariable('type')->value),true);?>
" onsubmit="pageGo(1);return false;">
  	
  	标题:<input id="title" name="title" value="<?php echo $_POST['title'];?>
" />	&nbsp;&nbsp;			
	<?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：<input id="begTime" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php if ($_POST['begTime']){ echo $_POST['begTime']; }?>" style="width: 200px;" name="begTime" realvalue=""/> 
  	<?php echo $_smarty_tpl->getVariable('lang')->value['endDate'];?>
：<input id="endTime" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php if ($_POST['endTime']){ echo $_POST['endTime']; }?>" style="width: 200px;" name="endTime" realvalue=""/> 
	&nbsp;&nbsp;<?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
	&nbsp;&nbsp;
	  <!-- p 为分页页码 -->
  	<input id="p" name="p" type="hidden" value="<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('default',array($_POST['p'],1),true);?>
" />
  	<input name="search" type="submit" class="submit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
" />
  </form>
</div>
<table width="98%" class="tableContent" align="center">
    <thead>
    <tr align="center">
	<th><input id="checkAll" name="checkAll" type="checkbox" value="" onclick="checkAlls();"/></th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['notice'];?>
ID</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['notice']; echo $_smarty_tpl->getVariable('lang')->value['title'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['period'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['tollgate_id'];?>
</th>
	<th>游戏服</td>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['author'];?>
</th>		
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['noticeType'];?>
</td>	
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
</td>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['putTime'];?>
</td>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['handler'];?>
</td>	
	</tr>
    </thead>
    <tbody>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
    <tr align="center">
	<td><input name="select[]" id="select[]" type="checkbox" value="<?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
" onclick="checkOne()"/></td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['title'];?>
</td>
	<td><font color=blue><?php echo $_smarty_tpl->getVariable('v')->value['begTime'];?>
—<?php echo $_smarty_tpl->getVariable('v')->value['endTime'];?>
</font></td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['tollgate_id'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['server_names'];?>
</td>	
	<td><?php echo $_smarty_tpl->getVariable('v')->value['author'];?>
</td>	
	<td><?php if ($_smarty_tpl->getVariable('v')->value['type']=='1'){ echo $_smarty_tpl->getVariable('lang')->value['scrollNotice']; }elseif($_smarty_tpl->getVariable('v')->value['type']=='2'){ echo $_smarty_tpl->getVariable('lang')->value['talkNotice']; }elseif($_smarty_tpl->getVariable('v')->value['type']=='3'){ echo $_smarty_tpl->getVariable('lang')->value['scrollAndTalkNotice']; }?></td>
	<td><?php if ($_smarty_tpl->getVariable('v')->value['status']=='1'){ echo $_smarty_tpl->getVariable('lang')->value['normal']; }elseif($_smarty_tpl->getVariable('v')->value['status']=='2'){ echo $_smarty_tpl->getVariable('lang')->value['pause']; }?></td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['created'];?>
</td>			
	<td>
		<a href="javascript:void(0);" onclick="editLocalNotice(<?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
,'<?php echo $_smarty_tpl->getVariable('v')->value['title'];?>
')"><?php echo $_smarty_tpl->getVariable('lang')->value['modify'];?>
</a>
		&nbsp;&nbsp;
		<a href="javascript:void(0);" onclick="deleteNotice('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
','<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeDel'];?>
',<?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['drop'];?>
</a>
	</td>	
	</tr>
	<?php }} else { ?>
	<tr align="center"><td colspan="10"><?php echo $_smarty_tpl->getVariable('lang')->value['noResult'];?>
</td></tr>
    <?php } ?>
    </tbody>
</table>
<?php if ($_smarty_tpl->getVariable('list')->value){?>
<div>
&nbsp;&nbsp;
<input type="button" onclick="deleteNotice('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
','<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeDel'];?>
')" value="<?php echo $_smarty_tpl->getVariable('lang')->value['allDrop'];?>
" />
</div>
<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
<?php }?>
</div>
</div>
<div id="listForm" style="display:none"></div>
<script type="text/javascript">

</script>