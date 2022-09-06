<?php
/* Smarty version 3.1.29, created on 2019-11-08 10:23:38
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5dc4d1aa830d54_79483579',
  'file_dependency' => 
  array (
    '359e57c4e75e07a72f8bae008c5814a0a3d5ab4f' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/index.tpl',
      1 => 1573178578,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5dc4d1aa830d54_79483579 ($_smarty_tpl) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="jumbotron">
    <div class="container">
        <?php
$__section_platform_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_platform']) ? $_smarty_tpl->tpl_vars['__smarty_section_platform'] : false;
$__section_platform_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['platform_map']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_platform_0_total = $__section_platform_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_platform'] = new Smarty_Variable(array());
if ($__section_platform_0_total != 0) {
for ($__section_platform_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_platform']->value['index'] = 0; $__section_platform_0_iteration <= $__section_platform_0_total; $__section_platform_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_platform']->value['index']++){
?>
            <p><a class="btn btn-primary btn-lg" href="http://<?php echo $_smarty_tpl->tpl_vars['web_sign']->value;
echo $_smarty_tpl->tpl_vars['platform_map']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_platform']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_platform']->value['index'] : null)]['domain'];?>
/global/main.php?p=<?php echo $_smarty_tpl->tpl_vars['platform_map']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_platform']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_platform']->value['index'] : null)]['sign'];?>
&auth_user=<?php echo $_smarty_tpl->tpl_vars['auth_user']->value;?>
&auth_sign=<?php echo $_smarty_tpl->tpl_vars['auth_sign']->value;?>
" role="button"><?php echo $_smarty_tpl->tpl_vars['platform_map']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_platform']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_platform']->value['index'] : null)]['title'];?>
</a></p>
        <?php
}
}
if ($__section_platform_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_platform'] = $__section_platform_0_saved;
}
?>
    </div>
</div>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
