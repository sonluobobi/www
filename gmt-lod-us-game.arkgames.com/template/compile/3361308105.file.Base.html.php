<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1723876319";a:2:{i:0;s:30:"../template/template/Base.html";i:1;i:1555559304;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-07-21 15:56:44
         compiled from "../template/template/Base.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value[$_smarty_tpl->getVariable('lang_title')->value];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  <div class="bodyContentBody">
  <div class="bodyContentHead" style="text-align:center">
	<form method="post" id="myform" name="myform" action="?act=<?php echo $_smarty_tpl->getVariable('act')->value;?>
" onsubmit="pageGo(1);return false;">
		<?php $_template = new Smarty_Template ($_smarty_tpl->getVariable('tpl_query')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
		<!-- p 为分页页码 -->
		<input id="p" name="p" type="hidden" value="<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('default',array($_POST['p'],1),true);?>
" />
		&nbsp;&nbsp;&nbsp;<input type="submit" class="submit" name="search" id="search" value="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
" />
	</form>
	</div>
	
	<?php $_template = new Smarty_Template ($_smarty_tpl->getVariable('tpl_data')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
  	</div>
	<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
</div>
