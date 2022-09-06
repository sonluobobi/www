<?php
/* Smarty version 3.1.29, created on 2019-11-08 11:40:30
  from "/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/addEquip.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5dc4e3ae5aecd4_52595121',
  'file_dependency' => 
  array (
    'f329d317c766760f06c5662222e04d065d15a48d' => 
    array (
      0 => '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/webroot/global/templates/addEquip.tpl',
      1 => 1573184415,
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
function content_5dc4e3ae5aecd4_52595121 ($_smarty_tpl) {
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
            <label for="cid" class="col-md-2 control-label">角色id</label>
            <div class="col-md-5" >
                <input type="text" id="cid" name="cid" value="<?php echo $_smarty_tpl->tpl_vars['cid']->value;?>
" />
            </div>
          </div>

           <div class="form-group">
            <label for="equip_id" class="col-md-2 control-label">道具id</label>
            <div class="col-md-5" >
                <input type="text" id="equip_id" name="equip_id" value="<?php echo $_smarty_tpl->tpl_vars['equip_id']->value;?>
" />
            </div>
          </div>

           <div class="form-group">
            <label for="equip_num" class="col-md-2 control-label">道具数量</label>
            <div class="col-md-5" >
                <input type="text" id="equip_num" name="equip_num" value="<?php echo $_smarty_tpl->tpl_vars['equip_num']->value;?>
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

    
    
</div>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
