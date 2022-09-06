<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F3832905231";a:2:{i:0;s:42:"../template/template/Player.DataQuery.html";i:1;i:1662373312;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-09-05 13:21:58
         compiled from "../template/template/Player.DataQuery.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['playerDataTitle'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  	<div class="bodyContentBody">
  	<div class="bodyContentHead" style="text-align:left">
	<form method="POST" name="myform" id="myform" action="./?act=Player.DataQuery" onsubmit="pageGo(1);return false;">
		<?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
：<?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>&nbsp;&nbsp;
		<?php $_template = new Smarty_Template ("User_Type.Select.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
		
		<br /><br />
		<?php echo $_smarty_tpl->getVariable('lang')->value['level_range_search'];?>
：<input id="level_begin" name="level_begin" type="text" value="<?php echo $_POST['level_begin'];?>
" /> - <input id="level_end" name="level_end" type="text" value="<?php echo $_POST['level_end'];?>
" />&nbsp;&nbsp;

	  	<?php echo $_smarty_tpl->getVariable('lang')->value['lastLoginIp'];?>
：<input id="lastLoginIp" name="lastLoginIp" type="text" value="<?php echo $_POST['lastLoginIp'];?>
" />	
	  	&nbsp;&nbsp;unique_key: <input id="unique_key" name="unique_key" type="text" value="<?php echo $_POST['unique_key'];?>
" />	
    	
    	<?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
	  	
	  	<!--
	  	<?php echo $_smarty_tpl->getVariable('lang')->value['lastLoginTime'];?>
：<?php $_template = new Smarty_Template ("Date.Select.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?> &nbsp;&nbsp;		
	       -->
  		<!-- p 为分页页码 -->
	  	<input id="p" name="p" type="hidden" value="<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('default',array($_POST['p'],1),true);?>
" />
  		&nbsp;&nbsp;
  		<input name="search" type="submit" class="submit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
" />
  	</form>
</div>
<table width="98%" class="tableContent" align="center">
    <thead>
    <tr align="center">
	<th><input id="checkAll" name="checkAll" type="checkbox" value="" onclick="checkAlls();"/></th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['passportId'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['passportName'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['roleId'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['roleName'];?>
</th>

	<th><?php echo $_smarty_tpl->getVariable('lang')->value['userStat'];?>
</th>	
	<th>战力</th>
	<th>钻石</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['created_time'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['lastLoginTime'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['lastLoginIp'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['logout_time'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['isGm'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['getDetail'];?>
</th>
	<!--<th><?php echo $_smarty_tpl->getVariable('lang')->value['createTime'];?>
</th>-->
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
	<td><input name="select[]" id="select[]" type="checkbox" value="<?php echo $_smarty_tpl->getVariable('v')->value['roleId'];?>
" onclick="checkOne()"/></td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['player_id'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['account'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
</td>
	<td>
		<?php if ($_smarty_tpl->getVariable('v')->value['is_ban']==2){?>
			<font color="red"><?php echo $_smarty_tpl->getVariable('lang')->value['gag'];?>
</font>
		<?php }elseif($_smarty_tpl->getVariable('v')->value['is_ban']==1){?>
			<font color="red"><?php echo $_smarty_tpl->getVariable('lang')->value['block'];?>
(<?php echo $_smarty_tpl->getVariable('v')->value['ban_expire'];?>
)</font>
		<?php }else{ ?>
			<?php echo $_smarty_tpl->getVariable('lang')->value['normal'];?>
</font>
	    <?php }?>
	</td>	
	<td><?php echo $_smarty_tpl->getVariable('v')->value['fightPower'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['game_gold'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['created'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['now_login_time'];?>
</td>	
	<td><?php echo $_smarty_tpl->getVariable('v')->value['now_login_ip'];?>
</td>	
	<td><?php echo $_smarty_tpl->getVariable('v')->value['logout_time'];?>
</td>
	<?php if ($_smarty_tpl->getVariable('v')->value['is_gm']<1){?>
	<td><?php echo $_smarty_tpl->getVariable('lang')->value['no'];?>
</td>	
	<?php }else{ ?>
	<td><?php echo $_smarty_tpl->getVariable('lang')->value['yes'];?>
</td>	
	<?php }?>
	<td><a href="javascript:void(0);" onclick="RQ('./?act=Player.getChDetail&server_id=<?php echo $_REQUEST['server_id'];?>
&roleId=<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
&roleName=<?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
',getChDetail,'',0);"><?php echo $_smarty_tpl->getVariable('lang')->value['getDetail'];?>
</a></td>	
	<!--<td><?php echo $_smarty_tpl->getVariable('v')->value['createTime'];?>
</td>-->
	<td>
		
		<?php if ($_smarty_tpl->getVariable('v')->value['is_ban']==1){?>
		    <a href="javascript:void(0);" onclick="undoBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',1,<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['undoBlock'];?>
</a> 
		
		<?php }elseif($_smarty_tpl->getVariable('v')->value['is_forbid_talk']==1){?>
			<a href="javascript:void(0);" onclick="subBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',1,<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['block'];?>
</a> 
			<a href="javascript:void(0);" onclick="undoBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',2,<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['undoGag'];?>
</a> 
		<?php }else{ ?>
			<a href="javascript:void(0);" onclick="subBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',1,<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['block'];?>
</a> 
			<a href="javascript:void(0);" onclick="subBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',2,<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['gag'];?>
</a>
		<?php }?>
		
		<?php if ($_smarty_tpl->getVariable('v')->value['is_gm']<1){?>
		<a href="javascript:void(0);" onclick="RQ('./?act=Player.setGm&single=1&isGm=1&server_id=<?php echo $_REQUEST['server_id'];?>
&roleId=<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
&roleName=<?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
',setGm,'',0);"><?php echo $_smarty_tpl->getVariable('lang')->value['setGm'];?>
</a>
		<?php }else{ ?>
		<a href="javascript:void(0);" onclick="RQ('./?act=Player.setGm&single=1&isGm=0&server_id=<?php echo $_REQUEST['server_id'];?>
&roleId=<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
&roleName=<?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
',setGm,'',0);"><?php echo $_smarty_tpl->getVariable('lang')->value['unsetGm'];?>
</a>
		<?php }?>

		<a href="javascript:void(0);" onclick="RQ('./?act=Player.setOffLine&server_id=<?php echo $_REQUEST['server_id'];?>
&roleId=<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
&roleName=<?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
',setGm,'',0);"><?php echo $_smarty_tpl->getVariable('lang')->value['setOffLine'];?>
</a>

		<?php if ($_smarty_tpl->getVariable('v')->value['is_gm']<0){?>
		<a href="javascript:void(0);" onclick="RQ('./?act=Player.setOffRank&isOff=0&server_id=<?php echo $_REQUEST['server_id'];?>
&roleId=<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
&roleName=<?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
',setGm,'',0);"><?php echo $_smarty_tpl->getVariable('lang')->value['setOnRank'];?>
</a>
		<?php }else{ ?>
		<a href="javascript:void(0);" onclick="RQ('./?act=Player.setOffRank&isOff=1&server_id=<?php echo $_REQUEST['server_id'];?>
&roleId=<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
&roleName=<?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
',setGm,'',0);"><?php echo $_smarty_tpl->getVariable('lang')->value['setOffRank'];?>
</a>
		<?php }?>
		<!--
		<a href="javascript:void(0);" onclick="RQ('./?act=Notice.sendMail&single=1&server_id=<?php echo $_REQUEST['server_id'];?>
&roleId=<?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
&roleName=<?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
',singleSendMail,'',0);">发邮件</a>
		-->
		
		<!--  
		<a href="javascript:void(0);" onclick="subBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',1,<?php echo $_smarty_tpl->getVariable('v')->value['roleId'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['block'];?>
</a> 
		<a href="javascript:void(0);" onclick="undoBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',1,<?php echo $_smarty_tpl->getVariable('v')->value['roleId'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['undoBlock'];?>
</a>
		-->
				
		
		<!--  
		<?php if ($_smarty_tpl->getVariable('v')->value['status']==0){?><a href="javascript:void(0);" onclick="subBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',1,<?php echo $_smarty_tpl->getVariable('v')->value['roleId'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['block'];?>
</a> <a href="javascript:void(0);" onclick="subBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',2,<?php echo $_smarty_tpl->getVariable('v')->value['roleId'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['gag'];?>
</a>
		<?php }elseif($_smarty_tpl->getVariable('v')->value['status']==1){?><a href="javascript:void(0);" onclick="undoBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',1,<?php echo $_smarty_tpl->getVariable('v')->value['roleId'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['undoBlock'];?>
</a>
		<?php }elseif($_smarty_tpl->getVariable('v')->value['status']==2){?><a href="javascript:void(0);" onclick="undoBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',2,<?php echo $_smarty_tpl->getVariable('v')->value['roleId'];?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['undoGag'];?>
</a><?php }?> 
		
		-->
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
<input type="button" onclick="subBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',1)" value="<?php echo $_smarty_tpl->getVariable('lang')->value['block'];?>
" />&nbsp;&nbsp;
<input type="button" onclick="subBlockGag('<?php echo $_smarty_tpl->getVariable('lang')->value['nocheck'];?>
',2)" value="<?php echo $_smarty_tpl->getVariable('lang')->value['gag'];?>
" />
</div>
<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
<?php }?>
</div>
</div>
