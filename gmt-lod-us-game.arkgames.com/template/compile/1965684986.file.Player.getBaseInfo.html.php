<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1153124220";a:2:{i:0;s:44:"../template/template/Player.getBaseInfo.html";i:1;i:1480390609;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-01-13 11:56:49
         compiled from "../template/template/Player.getBaseInfo.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['playerBaseInfoTitle'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  	<div class="bodyContentBody">
  	<div class="bodyContentHead" style="text-align:left">
	<form method="POST" name="myform" id="myform" action="./?act=Player.getBaseInfo" onsubmit="pageGo(1);return false;">
		<?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
(servers)：<?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>&nbsp;&nbsp;
		<?php $_template = new Smarty_Template ("User_Type.Select.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
    	<?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
	  	
  		<!-- p 为分页页码 -->
	  	<input id="p" name="p" type="hidden" value="<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('default',array($_POST['p'],1),true);?>
" />
  		&nbsp;&nbsp;
  		<input name="search" type="submit" class="submit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
(search)" />
  	</form>
</div>
<table width="98%" class="tableContent" align="center">
    <thead>
    <tr align="center">
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['passportId'];?>
(UID)</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['passportName'];?>
(login way and username)</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['roleId'];?>
(character id)</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['roleName'];?>
(ign)</th>
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
	<td><?php echo $_smarty_tpl->getVariable('v')->value['player_id'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['account'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['character_id'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
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
</div>
<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
<?php }?>
</div>
</div>
