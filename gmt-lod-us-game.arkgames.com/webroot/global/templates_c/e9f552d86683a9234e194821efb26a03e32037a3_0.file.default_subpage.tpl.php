<?php
/* Smarty version 3.1.29, created on 2021-08-27 09:47:24
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/default_subpage.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_6128442c727925_88380428',
  'file_dependency' => 
  array (
    'e9f552d86683a9234e194821efb26a03e32037a3' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/default_subpage.tpl',
      1 => 1478070144,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6128442c727925_88380428 ($_smarty_tpl) {
?>
<nav>
  <ul class="pager">
  	<?php if ($_smarty_tpl->tpl_vars['pre_pageid']->value) {?>
    <li class="previous"><a href="?p=<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
&auth_user=<?php echo $_smarty_tpl->tpl_vars['auth_user']->value;?>
&auth_sign=<?php echo $_smarty_tpl->tpl_vars['auth_sign']->value;?>
&pageid=<?php echo $_smarty_tpl->tpl_vars['pre_pageid']->value;?>
">Previous</a></li>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['next_pageid']->value) {?>
    <li class="next"><a href="?p=<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
&auth_user=<?php echo $_smarty_tpl->tpl_vars['auth_user']->value;?>
&auth_sign=<?php echo $_smarty_tpl->tpl_vars['auth_sign']->value;?>
&pageid=<?php echo $_smarty_tpl->tpl_vars['next_pageid']->value;?>
">Next</a></li>
    <?php }?>
  </ul>
</nav>

<?php }
}
