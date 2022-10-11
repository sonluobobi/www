<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F3257843394";a:2:{i:0;s:43:"../template/template/Log.OperationList.html";i:1;i:1662457797;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-09 10:21:59
         compiled from "../template/template/Log.OperationList.html" */ ?>
<div  id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['SystemUserLogManage'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  <div class="bodyContentBody">
  <div class="bodyContentHead" style="text-align:center">
  <form name="myform" id="myform" action="?act=Log.LogOperationList" method="post" onsubmit="FS('myform',pt.writeBody); return false;" >
 	<?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
：<?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>&nbsp;&nbsp;
 	<?php echo $_smarty_tpl->getVariable('lang')->value['ActkeyTitle'];?>
：<?php $_template = new Smarty_Template ("Common_actkey.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>&nbsp;&nbsp;
	<?php echo $_smarty_tpl->getVariable('lang')->value['ManageName'];?>
：<input type="text" name="fullname" value="<?php echo $_POST['fullname'];?>
" />
  <?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
  <br><br>
    <?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：<input id="sdate" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $_POST['beginDate'];?>
" style="width: 200px;" name="beginDate" realvalue=""/>
  <?php echo $_smarty_tpl->getVariable('lang')->value['endDate'];?>
：<input id="sdate" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $_POST['endDate'];?>
" style="width: 200px;" name="endDate" realvalue=""/>
  <input id="p" name="p" type="hidden" value="1" />
  <input name="submit" type="submit" class="submit"  value="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
" />
  </form>
</div>
		<table class="tableContent">
		<thead>
			<tr>
              <th width="6%"><?php echo $_smarty_tpl->getVariable('lang')->value['servers'];?>
</th>
              <th width="6%"><?php echo $_smarty_tpl->getVariable('lang')->value['logActtitle'];?>
</th>
              <th width="6%"><?php echo $_smarty_tpl->getVariable('lang')->value['affectObj'];?>
</th>
			  <th width="25%"><?php echo $_smarty_tpl->getVariable('lang')->value['handleContent'];?>
</th>
		      <th width="10%"><?php echo $_smarty_tpl->getVariable('lang')->value['handPerson'];?>
</th>
			  <th width="8%"><?php echo $_smarty_tpl->getVariable('lang')->value['handUser'];?>
</th>
			  <th width="8%">IP</th>
              <th width="13%"><?php echo $_smarty_tpl->getVariable('lang')->value['DateTime'];?>
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
          <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['serverName'];?>
</td>
          <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['acttitle'];?>
</td>
          <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['affectObj'];?>
</td>
		  <td title="<?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['content'];?>
"><?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('mb_substr',array($_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['content'],0,100),true);?>
</td>
		  <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['fullname'];?>
</td>
		  <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['username'];?>
</td>
		  <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ip'];?>
</td>
          <td><?php echo $_smarty_tpl->getVariable('dataList')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['logDate'];?>
</td>
        </tr>
		<?php endfor; endif; ?>
		</tbody>
		</table>

<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
  </div>
</div>