<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:10:"F681425707";a:2:{i:0;s:38:"../template/template/Notice.Lists.html";i:1;i:1666078782;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-18 15:40:26
         compiled from "../template/template/Notice.Lists.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['noticeListTitle'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  	<div class="bodyContentBody">
  	<div id="bodyContentHead" class="bodyContentHead" style="text-align:left">
  	<form method="POST" name="myform" id="myform" action="./?act=Notice.lists<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('capitalize',array($_smarty_tpl->getVariable('type')->value),true);?>
" onsubmit="pageGo(1);return false;">
  <!--	<?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
：<?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>&nbsp;&nbsp;-->
	<?php echo $_smarty_tpl->getVariable('lang')->value['consType'];?>
 : <select id="opType" name="opType">
							<option value=""><?php echo $_smarty_tpl->getVariable('lang')->value['Select'];?>
</option>
							<option value="1" <?php if ($_POST['opType']=='1'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
</option>
							<option value="2" <?php if ($_POST['opType']=='2'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['content'];?>
</option>
						 </select>
	<input id="opValue" name="opValue" value="<?php echo $_POST['opValue'];?>
" />					 
	&nbsp;&nbsp;			
	<?php echo $_smarty_tpl->getVariable('lang')->value['notice'];?>
ID:
	<input id="id" name="id" value="<?php echo $_POST['id'];?>
" />
	&nbsp;&nbsp;
<!--	<?php echo $_smarty_tpl->getVariable('lang')->value['noticeType'];?>
 : <select id="type" name="type">
							<option value=""><?php echo $_smarty_tpl->getVariable('lang')->value['Select'];?>
</option>
							<option value="1" <?php if ($_POST['type']=='1'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['scrollNotice'];?>
</option>
							<option value="2" <?php if ($_POST['type']=='2'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['talkNotice'];?>
</option>
							<option value="3" <?php if ($_POST['type']=='3'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['scrollAndTalkNotice'];?>
</option>							
						 </select>
	&nbsp;&nbsp;	-->					 
  	<?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>					
<!--	<br />-->
  	<?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：<input id="begTime" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php if ($_POST['begTime']){ echo $_POST['begTime']; }?>" style="width: 200px;" name="begTime" realvalue=""/> 
  	<?php echo $_smarty_tpl->getVariable('lang')->value['endDate'];?>
：<input id="endTime" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php if ($_POST['endTime']){ echo $_POST['endTime']; }?>" style="width: 200px;" name="endTime" realvalue=""/> 
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
	<th>语言</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['notice']; echo $_smarty_tpl->getVariable('lang')->value['title'];?>
</th>
	
	<th>内容</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['period'];?>
</th>
	
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['author'];?>
</th>		
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['putTime'];?>
</td>	
	
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
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
    <tr align="center" height="150">
	<td><input name="select[]" id="select[]" type="checkbox" value="<?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
" onclick="checkOne()"/></td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['contents_language'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['title'];?>
</td>
	<td width="300" ><?php echo $_smarty_tpl->getVariable('v')->value['content'];?>
</td>	
	<td width="150"><?php echo $_smarty_tpl->getVariable('v')->value['begTime'];?>
<br/><?php echo $_smarty_tpl->getVariable('v')->value['endTime'];?>
</td>
		
	<td><?php echo $_smarty_tpl->getVariable('v')->value['author'];?>
</td>	
	<td><?php echo $_smarty_tpl->getVariable('v')->value['created'];?>
</td>		
	<td><?php if ($_smarty_tpl->getVariable('v')->value['begTime']<=$_smarty_tpl->getVariable('nowdate')->value){?><font color=green>生效<?php }else{ ?><font color=red>未生效<?php }?></td>	
	<td>
		<a href="javascript:void(0);" onclick="editNotice(<?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
,'<?php echo $_smarty_tpl->getVariable('v')->value['title'];?>
')"><?php echo $_smarty_tpl->getVariable('lang')->value['modify'];?>
</a>
		&nbsp;&nbsp;
		<a href="javascript:void(0);" onclick="delNotice('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
','<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeDel'];?>
',<?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['drop'];?>
</a>
		&nbsp;&nbsp;
		<a href="javascript:void(0);" onclick="topNotice('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
','是否要置顶改公告',<?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
)">置顶</a>
	</td>	
	</tr>
	<?php }} else { ?>
	<tr align="center"><td colspan="10"><?php echo $_smarty_tpl->getVariable('lang')->value['noResult'];?>
</td></tr>
    <?php } ?>
    </tbody>
</table>
<?php if ($_smarty_tpl->getVariable('list')->value){?>
<!--<div>
&nbsp;&nbsp;
<input type="button" onclick="delNotice('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
','<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeDel'];?>
')" value="<?php echo $_smarty_tpl->getVariable('lang')->value['allDrop'];?>
" />
&nbsp;&nbsp;<input type="button" onclick="startNotice('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
','<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeStart'];?>
')" value="<?php echo $_smarty_tpl->getVariable('lang')->value['allStart'];?>
" />
&nbsp;&nbsp;<input type="button" onclick="pauseNotice('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
','<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticePause'];?>
')" value="<?php echo $_smarty_tpl->getVariable('lang')->value['allPause'];?>
" />
</div>-->
<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
<?php }?>
</div>
</div>
<div id="listForm" style="display:none"></div>
<script type="text/javascript">
</script>