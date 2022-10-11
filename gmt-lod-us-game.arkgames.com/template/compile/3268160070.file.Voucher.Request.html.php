<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:10:"F725915550";a:2:{i:0;s:41:"../template/template/Voucher.Request.html";i:1;i:1555559304;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-07-21 15:56:44
         compiled from "../template/template/Voucher.Request.html" */ ?>

&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
：<?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?> 

&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：<input id="statDate" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?php if ($_POST['statDate']){ echo $_POST['statDate']; }else{  echo $_smarty_tpl->smarty->plugin_handler->executeModifier('date_format',array(time(),'%Y-%m-%d'),true); }?>" style="width: 200px;" name="statDate" realvalue=""/> 
