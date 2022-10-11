<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F2986555014";a:2:{i:0;s:38:"../template/template/Log.Consumer.html";i:1;i:1483431747;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-03-13 11:26:47
         compiled from "../template/template/Log.Consumer.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['consumerLogQuery'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  <div class="bodyContentBody">
  <div class="bodyContentHead" style="text-align:center">
	<form method="post" id="myform" name="myform" action="?act=Log.LogConsumerList" onsubmit="pageGo(1);return false;">
		&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
：<?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?> &nbsp; 
		<?php echo $_smarty_tpl->getVariable('lang')->value['selectUserType'];?>
：<select id="user_type" name="user_type">
		<?php $_smarty_tpl->assign('t',$_POST['user_type'],null,null);?>
			<option value="0" <?php if ($_smarty_tpl->getVariable('t')->value=='0'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['plaseClew'];?>
</option>
			<option value="1" <?php if ($_smarty_tpl->getVariable('t')->value=='1'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['pid'];?>
</option>
			<option value="2" <?php if ($_smarty_tpl->getVariable('t')->value=='2'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['roleId'];?>
</option>			
		</select>
		<input id="user_value" name="user_value" type="text" value="<?php echo $_POST['user_value'];?>
" />
		<?php echo $_smarty_tpl->getVariable('lang')->value['consumer_service_id_title'];?>
：<?php $_template = new Smarty_Template ("Common_consumerServerId.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>&nbsp;&nbsp;
		&nbsp;<?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
		<br><br>
		<?php echo $_smarty_tpl->getVariable('lang')->value['equip_id'];?>
：<input id="equip_id" name="equip_id" type="text" value="<?php echo $_POST['equip_id'];?>
" />&nbsp;&nbsp;
		<?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：<input id="begTime" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php if ($_POST['begTime']){ echo $_POST['begTime']; }else{  echo $_smarty_tpl->smarty->plugin_handler->executeModifier('date_format',array(time(),'%Y-%m-%d'),true);?>
 00:00:00<?php }?>" style="width: 200px;" name="begTime" realvalue=""/>
                <?php echo $_smarty_tpl->getVariable('lang')->value['endDate'];?>
：<input type="text" class="Wdate" name="endTime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" style="width: 200px;" value="<?php if ($_POST['endTime']){ echo $_POST['endTime']; }else{  echo $_smarty_tpl->smarty->plugin_handler->executeModifier('date_format',array(time(),'%Y-%m-%d'),true);?>
 23:59:59<?php }?>" realvalue="" />
<!-- p 为分页页码 -->
<input id="p" name="p" type="hidden" value="<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('default',array($_POST['p'],1),true);?>
" />
		&nbsp;&nbsp;&nbsp;<input type="submit" class="submit" name="search" id="search" value="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
" />
	</form>
	</div>
	<table width="98%" class="tableContent" align="center">
    <thead>
    <tr align="center">
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_player_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_character_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_gold_type'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_use_gold'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_old_gold'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_new_gold'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_equip_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_equip_num'];?>
</th>
		<!-- 
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_service_id'];?>
</th>
		 -->
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_memo'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_ip'];?>
</th>
		<!--  
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_is_reported'];?>
</th>
		-->
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_created'];?>
</th>
    </thead>
    <tbody>
    <?php if ($_smarty_tpl->getVariable('sum')->value!=0){?>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dataList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
    <tr align="center">
		<td><?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['player_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['moneyTypeIntro'][$_smarty_tpl->getVariable('v')->value['gold_type']];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['use_gold'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['old_gold'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['new_gold'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['equip_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['equip_num'];?>
</td>
		<!--  
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['consumer_service_id_ex'][$_smarty_tpl->getVariable('v')->value['service_id']];?>
</td>
		-->
		<td><?php echo $_smarty_tpl->getVariable('v')->value['memo'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['ip'];?>
</td>
		<!--  
		<td><?php if ($_smarty_tpl->getVariable('v')->value['is_reported']==1){?>是<?php }else{ ?>否<?php }?></td>
		-->
		<td><?php echo $_smarty_tpl->getVariable('v')->value['created'];?>
</td>
	</tr>
    <?php }} ?>
    <tr><td colspan="8">消耗元宝总数: <font color="#FF0000"><?php echo $_smarty_tpl->getVariable('all_use_gold')->value;?>
</font></td></tr>
    <!--  
    <tr align="center"><td colspan="8"><?php echo $_smarty_tpl->getVariable('lang')->value['nowQueueUserConsumer'];?>
<font color="#FF0000"><?php echo $_smarty_tpl->getVariable('sum')->value;?>
</font></td></tr>
    -->
    <?php }?>
    </tbody>
</table>
<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
  </div>
</div>
