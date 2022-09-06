<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:10:"F642237054";a:2:{i:0;s:37:"../template/template/Log.Voucher.html";i:1;i:1483004878;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-07-21 15:56:43
         compiled from "../template/template/Log.Voucher.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['voucherLogQuery'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  <div class="bodyContentBody">
  <div class="bodyContentHead" style="text-align:center">
	<form method="post" id="myform" name="myform" action="?act=Log.LogVoucherList" onsubmit="pageGo(1);return false;">
		&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
：<?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?> &nbsp;
		<?php echo $_smarty_tpl->getVariable('lang')->value['selectUserType'];?>
：<select id="user_type" name="user_type">
		<?php $_smarty_tpl->assign('t',$_POST['user_type'],null,null);?>
			<option value="0" <?php if ($_smarty_tpl->getVariable('t')->value=='0'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['plaseClew'];?>
</option>
			<option value="1" <?php if ($_smarty_tpl->getVariable('t')->value=='1'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['accountId'];?>
</option>
						
		</select>
		<input id="user_value" name="user_value" type="text" value="<?php echo $_POST['user_value'];?>
" />
		&nbsp;<?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
		<br><br>
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
		<table width="98%" class="tableContent" align="center" id="myTable">
  <thead>
			<tr>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['voucher_id'];?>
</th>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['voucher_history_id'];?>
</th>
              <th>history_id_ext</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['voucher_player_id'];?>
</th>
			  <!-- 
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['voucher_character_id'];?>
</th>
			   -->
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['voucher_account'];?>
</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['voucher_order_amount'];?>
</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['voucher_order_coins'];?>
</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['voucher_ip'];?>
</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['voucher_vouch_time'];?>
</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['voucher_created'];?>
</th>
          </tr>
		</thead>
		<tbody>
        <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['name'] = "ii";
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['loop'] = is_array($_loop=$_smarty_tpl->getVariable('dataList')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["ii"]['total']);
?>
		<tr align="center">
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['id'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['history_id'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['history_id_ext'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['player_id'];?>
</td>
			<!--  
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['character_id'];?>
</td>
			-->
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['account'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['order_amount'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['order_coins'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ip'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['vouch_time'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['created'];?>
</td>
        </tr>
		<?php endfor; endif; ?>
		</tbody>
		</table>
  </div>
<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
</div>
