<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1356772323";a:2:{i:0;s:35:"../template/template/Page.Show.html";i:1;i:1662457797;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-09 10:21:59
         compiled from "../template/template/Page.Show.html" */ ?>
<?php echo $_smarty_tpl->getVariable('lang')->value['showPage'];?>
：<select id="pagecount" name="pagecount">
			<!--<option value="10" <?php if ($_REQUEST['pagecount']==10){?>selected="true"<?php }?>>10</option>
			<option value="20" <?php if ($_REQUEST['pagecount']==20){?>selected="true"<?php }?>>20</option> -->
			<option value="30" <?php if ($_REQUEST['pagecount']==30){?>selected="true"<?php }?>>30</option>
			<option value="50" <?php if ($_REQUEST['pagecount']==50){?>selected="true"<?php }?>>50</option>
			<option value="100" <?php if ($_REQUEST['pagecount']==100){?>selected="true"<?php }?>>100</option>																
	   </select>
