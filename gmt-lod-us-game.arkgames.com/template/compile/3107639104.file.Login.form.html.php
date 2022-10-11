<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1628108389";a:2:{i:0;s:36:"../template/template/Login.form.html";i:1;i:1662457797;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-09 11:03:15
         compiled from "../template/template/Login.form.html" */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="zh-CN">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>魔域 | KunLun.com</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script type="text/javascript" src="js/mootools-1.2.1-core.js"></script>
	<script type="text/javascript" src="js/mootools-1.2-more.js"></script>
	<script type="text/javascript" src="js/core.js"></script>
  </head>
  <body>
	<div class="header">
		<img class="logo" src="img/logo.gif" >
		<span class="link"><br /><br /><br />
		</span>
	</div>

	<div class="bar"></div>
	<div class="form">
		<b class="round_border">
			<b class="round_border_layer3"></b>
			<b class="round_border_layer2"></b>
			<b class="round_border_layer1"></b>
		</b>
		<div class="round_border_content">
			<b class="controlbar_border">

				<b class="controlbar_border_layer3"></b>
				<b class="controlbar_border_layer2"></b>
				<b class="controlbar_border_layer1"></b>
			</b>
			<div class="controlbar_border_content">
				
			  <form method="post" style="margin:0px;" id="loginForm" action="?act=Login.post">
				<div align="center">
				<br><b>登陆到您的帐户</b><br>

				账 号：<input type="text" class="input" name="username" value="" /><br />
				密 码：<input type="password" class="input" name="password" value="" /><br />
				<?php if ($_SESSION['OPERACTIONSIGN']){?>
					<input type="hidden" name="group" value="<?php echo $_SESSION['OPERACTIONSIGN'];?>
" />	
				<?php }else{ ?>
				选择平台：<select name="group">
					<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('GroupList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
?>
					<option value="<?php echo $_smarty_tpl->getVariable('group')->value['gupId'];?>
|<?php echo $_smarty_tpl->getVariable('group')->value['Langage'];?>
|<?php echo $_smarty_tpl->getVariable('group')->value['gupFlag'];?>
|<?php echo $_smarty_tpl->getVariable('group')->value['productId'];?>
"><?php echo $_smarty_tpl->getVariable('group')->value['productName'];?>
</option>
					<?php }} ?>
				</select>
				<?php }?>
				<input type="hidden" name="loginVerify" value="" />
				<br>
				<table><tr><td><a class="button" onclick="FS('loginForm', pt.location.bind(pt, './'),1)" href="javascript:void(0);"><b><b><b>登　录</b></b></b></a></td></tr></table>
				</div>
				</form>

			</div>
			<b class="controlbar_border">
				<b class="controlbar_border_layer1"></b>
				<b class="controlbar_border_layer2"></b>
				<b class="controlbar_border_layer3"></b>
			</b>
		</div>

		<b class="round_border">
			<b class="round_border_layer1"></b>
			<b class="round_border_layer2"></b>
			<b class="round_border_layer3"></b>
		</b>
	</div>
	<div class="foot">&copy; 2010  Power By KunLun.com<br /><br /></div>
	<div id="pageMask"></div>
	<div id="pageLoad" onclick="pt.pageLoading('none');">Loading...</div>
	<div id="pageAlert" class="popDiv" style="width: 400px;">
	  <center>
		<div class="popHead">提示信息</div>
		<div id="pageAlert_popBody" class="popBody"></div>
		<table><tr><td>
			  <a class="button" id="pageAlert_popOk" href="javascript:void(0);"><b><b><b>确　定</b></b></b></a>
		</td></tr></table>
		<div style="height:10px;"></div>
	  </center>
	</div>
	<script language="javascript">
	<!--
	window.addEvent('domready', function(){
	    new PageInit();
	});
	//-->
	</script>		  
  </body>
</html>
