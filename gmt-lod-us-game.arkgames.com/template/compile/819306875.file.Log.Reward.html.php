<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F3907360862";a:2:{i:0;s:36:"../template/template/Log.Reward.html";i:1;i:1488160723;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-03-23 18:02:16
         compiled from "../template/template/Log.Reward.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['awardDesc'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  <div class="bodyContentBody">
  <div class="bodyContentHead" style="text-align:center">
	<form method="post" id="myform" name="myform" action="?act=Log.getRewardList" onsubmit="pageGo(1);return false;">
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
			<option value="3" <?php if ($_smarty_tpl->getVariable('t')->value=='3'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['roleName'];?>
</option>			
		</select>
		<input id="user_value" name="user_value" type="text" value="<?php echo $_POST['user_value'];?>
" />
		&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['awardStatus'];?>
：<select name="status" id="status">
		<?php $_smarty_tpl->assign('status_val',$_REQUEST['status'],null,null);?>
			<option value=""><?php echo $_smarty_tpl->getVariable('lang')->value['plaseClew'];?>
</option>
			<option value="1" <?php if ($_smarty_tpl->getVariable('status_val')->value=='1'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['status_get'];?>
</option>
			<option value="2" <?php if ($_smarty_tpl->getVariable('status_val')->value=='2'){?>selected="true"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['status_no_get'];?>
</option>	
		</select>

		&nbsp;<?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
		<br><br>
		<?php echo $_smarty_tpl->getVariable('lang')->value['module_id'];?>
：<?php $_template = new Smarty_Template ("Common_logModuleId.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>&nbsp;&nbsp;
		<?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：<input id="begTime" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $_POST['begTime'];?>
" style="width: 200px;" name="begTime" realvalue=""/> 
		<?php echo $_smarty_tpl->getVariable('lang')->value['endDate'];?>
：<input type="text" class="Wdate" name="endTime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" style="width: 200px;" value="<?php echo $_POST['endTime'];?>
" realvalue="" />
<!-- p 为分页页码 -->
<input id="p" name="p" type="hidden" value="<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('default',array($_POST['p'],1),true);?>
" />
		&nbsp;&nbsp;&nbsp;<input type="submit" class="submit" name="search" id="search" value="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
" />
	</form>
	</div>
		<table width="98%" class="tableContent" style="text-align:left" id="myTable">
  <thead>
			<tr style="text-align:left">
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['handler'];?>
</th>
              <th style="text-align:left"><?php echo $_smarty_tpl->getVariable('lang')->value['pid'];?>
</th>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['roleId'];?>
</th>
              <th><?php echo $_smarty_tpl->getVariable('lang')->value['roleName'];?>
</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['awardRes'];?>
</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['awardStatus'];?>
</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['awardTime'];?>
</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['updated'];?>
</th>
			  <th><?php echo $_smarty_tpl->getVariable('lang')->value['expire'];?>
</th>
          </tr>
		</thead>
		<tbody>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dataList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
		<tr style="text-align:left">
			<td>
				<?php if ($_smarty_tpl->getVariable('v')->value['has_expire']==1&&$_smarty_tpl->getVariable('v')->value['status']!=1){?>
				<a href="javascript:void(0);" onclick="rewardExtendExpire(<?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
, <?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
, '<?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
', 1);"><?php echo $_smarty_tpl->getVariable('lang')->value['extend_expire'];?>
</a>
			  	<?php }?>
			  	<?php if ($_smarty_tpl->getVariable('v')->value['mid']==22&&$_smarty_tpl->getVariable('v')->value['status']!=1){?>
				&nbsp;&nbsp;<a href="javascript:void(0);" onclick="rewardExtendExpire(<?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
, <?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
, '<?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
', 2);"><?php echo $_smarty_tpl->getVariable('lang')->value['drop'];?>
</a>
			  	<?php }?>
			</td>
			<td><?php echo $_smarty_tpl->getVariable('v')->value['player_id'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('v')->value['module_id'];?>
</td>
			<td>	
			  	<?php if ($_smarty_tpl->getVariable('v')->value['status']==1){?> <?php echo $_smarty_tpl->getVariable('lang')->value['status_get'];?>

			  	<?php }else{  echo $_smarty_tpl->getVariable('lang')->value['status_no_get'];?>

			  	<?php }?>
			</td>

			<td><?php echo $_smarty_tpl->getVariable('v')->value['timestamp'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('v')->value['updated'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('v')->value['expire'];?>
</td>
			</tr>
			<tr style="text-align:left">
			<td></td>
			<td><?php echo $_smarty_tpl->getVariable('lang')->value['awardContent'];?>
</td>
			<td colspan="7"><?php echo $_smarty_tpl->getVariable('v')->value['incomes'];?>
</td>
        </tr>
        <?php }} else { ?>
		<tr align="center"><td colspan="10"><?php echo $_smarty_tpl->getVariable('lang')->value['noResult'];?>
</td></tr>
		<?php } ?>
		</tbody>
		</table>
  </div>
<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
</div>
