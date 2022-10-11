<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:10:"F386253632";a:2:{i:0;s:47:"../template/template/Player.equipFlowStats.html";i:1;i:1662457797;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-10 09:53:22
         compiled from "../template/template/Player.equipFlowStats.html" */ ?>
<div  id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['equipFlowStatsTitle'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  <div class="bodyContentBody">
  <div class="bodyContentHead" style="text-align:center">
	<form method="POST" name="myform" id="myform" action="./?act=Player.getEquipFlowStats" onsubmit="pageGo(1);return false;">

 	<?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
：<?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>&nbsp;&nbsp;
	<input id="p" name="p" type="hidden" value="<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('default',array($_POST['p'],1),true);?>
" />
	<?php $_template = new Smarty_Template ("User_Type.Select.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
	<?php echo $_smarty_tpl->getVariable('lang')->value['equip_id'];?>
：<input type="text" name="equipId" value="<?php echo $_POST['equipId'];?>
" />
	<?php echo $_smarty_tpl->getVariable('lang')->value['equipTitle'];?>
：<input type="text" name="equipTitle" value="<?php echo $_POST['equipTitle'];?>
" />
  <br><br>
	<?php echo $_smarty_tpl->getVariable('lang')->value['op_id'];?>
：<?php $_template = new Smarty_Template ("Common_logOpId.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>&nbsp;&nbsp;
	<?php echo $_smarty_tpl->getVariable('lang')->value['sourceDirect'];?>
：<select name="source_direct" id="source_direct">
	<?php $_smarty_tpl->assign('source_direct_v',$_REQUEST['source_direct'],null,null);?>
		<option value="1" <?php if ($_smarty_tpl->getVariable('source_direct_v')->value=='1'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['sourceGet'];?>
</option>
		<option value="2" <?php if ($_smarty_tpl->getVariable('source_direct_v')->value=='2'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['sourceLose'];?>
</option>	
	</select>
	<br><br>
    <?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：<input id="sdate" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $_POST['beginDate'];?>
" style="width: 200px;" name="beginDate" realvalue=""/>
  <?php echo $_smarty_tpl->getVariable('lang')->value['endDate'];?>
：<input id="sdate" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $_POST['endDate'];?>
" style="width: 200px;" name="endDate" realvalue=""/>
 &nbsp;&nbsp; <input name="search" type="submit" class="submit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
" />
	<br><br>
	<?php echo $_smarty_tpl->getVariable('lang')->value['equipFlowStatsDesc'];?>


  </form>
</div>
		<table class="tableContent">
		<thead>
			<tr>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['DateTime'];?>
</th>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['pid'];?>
</th>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['roleId'];?>
</th>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['roleName'];?>
</th>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['equip_id'];?>
</th>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['equip_title'];?>
</th>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['equipNum'];?>
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
		<tr>
			  <td><a href="javascript:void(0);" onclick="RQ('./?act=Player.getEquipFlowDetail&server_id=<?php echo $_REQUEST['server_id'];?>
&roleId=<?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['master_cid'];?>
&equip_id=<?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['equip_id'];?>
&source_direct=<?php echo $_REQUEST['source_direct'];?>
&op_id=<?php echo $_REQUEST['op_id'];?>
&date_time=<?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['date_time'];?>
',getChDetail,'',0);"><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['date_time'];?>
</a></td>	

			  <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['master_pid'];?>
</td>
	          <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['master_cid'];?>
</td>
	          <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['master_nick'];?>
</td>
	          <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['equip_id'];?>
</td>
	          <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['equip_title'];?>
</td>
	          <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['equip_num'];?>
</td>
			  <td></td>
        </tr>
		<?php endfor; endif; ?>
		</tbody>
		</table>

	<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
</div>
</div>
