<?php
/* Smarty version 3.1.29, created on 2019-11-08 10:23:38
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/header.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5dc4d1aa844688_54540112',
  'file_dependency' => 
  array (
    'ad4629cd11b63e4a497272740183f5ec103d8033' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/header.tpl',
      1 => 1493083170,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc4d1aa844688_54540112 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
	<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-1.8.3.min.js" charset="UTF-8"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 type="text/javascript" src="js/bootstrap-datetimepicker.min.js" charset="UTF-8"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 type="text/javascript" src="js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 type="text/javascript" src="js/tools.js" charset="UTF-8"><?php echo '</script'; ?>
>
  </head>
  <body>
  <header class="bs-docs-nav navbar navbar-static-top" id="top"></header>
  <?php if ($_smarty_tpl->tpl_vars['retmsg']->value) {?>
  <div class="alert alert-warning" role="alert"><?php echo $_smarty_tpl->tpl_vars['retmsg']->value;?>
</div>
  <?php }
}
}
