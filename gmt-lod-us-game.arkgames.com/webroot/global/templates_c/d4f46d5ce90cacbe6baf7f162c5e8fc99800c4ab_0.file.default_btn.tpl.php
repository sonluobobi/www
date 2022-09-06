<?php
/* Smarty version 3.1.29, created on 2019-11-08 10:25:34
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/default_btn.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5dc4d21e68d365_36438056',
  'file_dependency' => 
  array (
    'd4f46d5ce90cacbe6baf7f162c5e8fc99800c4ab' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/default_btn.tpl',
      1 => 1469013834,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc4d21e68d365_36438056 ($_smarty_tpl) {
?>
<button type="submit" class="btn btn-success">查询当前服</button>
<button type="submit" class="btn btn-success" onclick="queryNextServer();" >下一台服</button>
<button type="submit" class="btn btn-success" onclick="queryUpServer();" >上一台服</button><?php }
}
