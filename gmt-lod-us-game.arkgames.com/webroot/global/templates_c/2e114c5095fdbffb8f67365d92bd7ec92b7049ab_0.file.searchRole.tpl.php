<?php
/* Smarty version 3.1.29, created on 2019-12-12 09:55:32
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/searchRole.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5df19e146d96c9_50932235',
  'file_dependency' => 
  array (
    '2e114c5095fdbffb8f67365d92bd7ec92b7049ab' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/searchRole.tpl',
      1 => 1576115677,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:default_top.tpl' => 1,
    'file:server.tpl' => 1,
    'file:default_hidden.tpl' => 1,
    'file:default_msg.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5df19e146d96c9_50932235 ($_smarty_tpl) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="container">
    <form action="" class="form-horizontal"  role="form" method="post">
        <fieldset>
            <legend><?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:default_top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
|<?php echo $_smarty_tpl->tpl_vars['caption']->value;?>
</legend>

            <div class="alert alert-success" role="alert"><?php echo $_smarty_tpl->tpl_vars['desc_msg']->value;?>
</div>
			     <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:server.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


           <div class="form-group">
            <label for="player_id" class="col-md-2 control-label">账号id(player_id)</label>
            <div class="col-md-5" >
		<input type="text" id="player_id" name="player_id" value="<?php echo $_smarty_tpl->tpl_vars['player_id']->value;?>
" />
            </div>
          </div>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:default_hidden.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<button type="submit" class="btn btn-success" id="btn_submit">提交</button>
            </div>
        </fieldset>
	</form>

    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:default_msg.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    
    <fieldset>
        <legend>列表</legend>

        <table class="table table-hover">
            <tr>
              <td class="success">角色id</td>
              <td class="success">账号id</td>
              <td class="success">创建时间</td>
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
              <td class="active"><?php echo $_smarty_tpl->tpl_vars['data_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] : null)]['id'];?>
</td>
              <td class="active"><?php echo $_smarty_tpl->tpl_vars['data_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] : null)]['player_id'];?>
</td>
              <td class="active"><?php echo $_smarty_tpl->tpl_vars['data_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_sec']->value['index'] : null)]['created'];?>
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
