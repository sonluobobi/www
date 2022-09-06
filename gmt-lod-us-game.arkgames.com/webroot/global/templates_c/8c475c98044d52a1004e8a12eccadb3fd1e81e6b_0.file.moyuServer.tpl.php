<?php
/* Smarty version 3.1.29, created on 2021-08-27 10:16:05
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/moyuServer.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_61284ae50c8232_92387236',
  'file_dependency' => 
  array (
    '8c475c98044d52a1004e8a12eccadb3fd1e81e6b' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/moyuServer.tpl',
      1 => 1611641542,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_61284ae50c8232_92387236 ($_smarty_tpl) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="container">


    <fieldset>
        <legend>魔域一各大区对应IP地址映射</legend>

        <table class="table table-hover">
            <tr>
                <td class="success">域名</td>
            </tr>
            <?php
$__section_sec_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_sec']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec'] : false;
$__section_sec_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data_list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_sec_0_total = $__section_sec_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_sec'] = new Smarty_Variable(array());
if ($__section_sec_0_total != 0) {
for ($__section_sec_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] = 0; $__section_sec_0_iteration <= $__section_sec_0_total; $__section_sec_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']++){
?>
                <tr>
                    <td class="active"><?php echo $_smarty_tpl->tpl_vars['data_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] : null)];?>
</td>
                </tr>
            <?php
}
}
if ($__section_sec_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_sec'] = $__section_sec_0_saved;
}
?>
        </table>
    </fieldset>

</div>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
