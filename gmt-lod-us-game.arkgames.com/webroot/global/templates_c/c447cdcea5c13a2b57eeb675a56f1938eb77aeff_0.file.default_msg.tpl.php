<?php
/* Smarty version 3.1.29, created on 2019-11-08 10:25:34
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/default_msg.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5dc4d21e693447_90342635',
  'file_dependency' => 
  array (
    'c447cdcea5c13a2b57eeb675a56f1938eb77aeff' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/default_msg.tpl',
      1 => 1469014092,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc4d21e693447_90342635 ($_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['server_selected']->value) {?>
<div class="alert alert-success" role="alert"><?php echo $_smarty_tpl->tpl_vars['server_selected']->value;?>
</div>
<?php }
}
}
