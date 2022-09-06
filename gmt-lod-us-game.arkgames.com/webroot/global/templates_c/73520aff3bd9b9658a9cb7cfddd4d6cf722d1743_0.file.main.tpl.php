<?php
/* Smarty version 3.1.29, created on 2019-11-08 11:53:14
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/main.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5dc4e6aa30f8c0_43911612',
  'file_dependency' => 
  array (
    '73520aff3bd9b9658a9cb7cfddd4d6cf722d1743' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/main.tpl',
      1 => 1573185173,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5dc4e6aa30f8c0_43911612 ($_smarty_tpl) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="jumbotron">
    <div class="container">
    	<p><a class="btn btn-default" href="<?php echo $_smarty_tpl->tpl_vars['home_url']->value;?>
" role="button">选大区</a> | 魔域2之<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</p>
    	<p>
    		当前请求ip -- <?php echo $_smarty_tpl->tpl_vars['remote_ip']->value;?>

    	</p>
        <p>
            当前游戏服时间 -- <?php echo $_smarty_tpl->tpl_vars['cur_date']->value;?>

        </p>
        <?php
$__section_sec_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_sec']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec'] : false;
$__section_sec_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['menu_map']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_sec_0_total = $__section_sec_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_sec'] = new Smarty_Variable(array());
if ($__section_sec_0_total != 0) {
for ($__section_sec_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] = 0; $__section_sec_0_iteration <= $__section_sec_0_total; $__section_sec_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']++){
?>
            <p><a class="btn btn-primary btn-lg" href="http://<?php echo $_smarty_tpl->tpl_vars['web_sign']->value;
echo $_smarty_tpl->tpl_vars['domain']->value;?>
/global/<?php echo $_smarty_tpl->tpl_vars['menu_map']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] : null)]['sign'];?>
.php?p=<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
&auth_user=<?php echo $_smarty_tpl->tpl_vars['auth_user']->value;?>
&auth_sign=<?php echo $_smarty_tpl->tpl_vars['auth_sign']->value;?>
" role="button"><?php echo $_smarty_tpl->tpl_vars['menu_map']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] : null)]['title'];?>
</a></p>
        <?php
}
}
if ($__section_sec_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_sec'] = $__section_sec_0_saved;
}
?>
    </div>
</div>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
