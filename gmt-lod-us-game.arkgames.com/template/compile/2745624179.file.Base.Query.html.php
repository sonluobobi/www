<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F2073485142";a:2:{i:0;s:36:"../template/template/Base.Query.html";i:1;i:1555559304;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-07-21 15:56:48
         compiled from "../template/template/Base.Query.html" */ ?>

&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
：<?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?> &nbsp;
<?php if ($_smarty_tpl->getVariable('query_user_type')->value){ echo $_smarty_tpl->getVariable('lang')->value['selectUserType'];?>
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
<?php }?>
&nbsp;<?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template);  if ($_smarty_tpl->getVariable('query_date_config')->value){?>
<br><br>
 <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['name'] = "qdc";
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['loop'] = is_array($_loop=$_smarty_tpl->getVariable('query_date_config')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["qdc"]['total']);
?>
 	<?php if ($_smarty_tpl->getVariable('query_date_config')->value[$_smarty_tpl->getVariable('smarty')->value['section']['qdc']['index']]=='beginDate'){?>
	<?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：<input id="beginDate" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php if ($_POST['beginDate']){ echo $_POST['beginDate']; }else{  echo $_smarty_tpl->smarty->plugin_handler->executeModifier('date_format',array(time(),'%Y-%m-%d'),true);?>
 00:00:00<?php }?>" style="width: 200px;" name="beginDate" realvalue=""/> 
	<?php }?>

	<?php if ($_smarty_tpl->getVariable('query_date_config')->value[$_smarty_tpl->getVariable('smarty')->value['section']['qdc']['index']]=='endDate'){?>
	<?php echo $_smarty_tpl->getVariable('lang')->value['endDate'];?>
：<input type="text" class="Wdate" name="endDate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" style="width: 200px;" value="<?php if ($_POST['endDate']){ echo $_POST['endDate']; }else{  echo $_smarty_tpl->smarty->plugin_handler->executeModifier('date_format',array(time(),'%Y-%m-%d'),true);?>
 23:59:59<?php }?>" realvalue="" />
	<?php } endfor; endif;  }?>


