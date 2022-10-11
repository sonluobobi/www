<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F4204400232";a:2:{i:0;s:37:"../template/template/Action.List.html";i:1;i:1665299892;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-09 10:20:58
         compiled from "../template/template/Action.List.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['systemHandleManage'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
<div class="bodyContentHead" id="userActionList">
<div style="height:30px"><a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionAdd',pt.writeBody)">[添加首级操作]</a></div>
<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['name'] = 'ii';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('menuTree')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total']);
?>
<div style="height:20px;height:30px;"><b><?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['acttitle'];?>
</b>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionEdit&id=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['id'];?>
',pt.writeBody)">修改</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionDel&id=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['id'];?>
',pt.writeBody)"><font color="#FF0000">删除</font></a></a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionAdd&pid=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['id'];?>
',pt.writeBody)">添加子类</a></div>
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['mm']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['name'] = 'mm';
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['total']);
?>

		<?php $_smarty_tpl->assign("id",$_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['id'],null,null);?>

		<?php if ($_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value]!=''){?>
			<div style="padding-left:20px;height:30px;"><i><b><?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['acttitle'];?>
</b></i>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionEdit&id=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['id'];?>
',pt.writeBody)">修改</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionDel&id=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['id'];?>
',pt.writeBody)"><font color="#FF0000">删除</font></a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionAdd&pid=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['id'];?>
',pt.writeBody)">添加子类</a></div>

			<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['nn']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['name'] = 'nn';
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['nn']['total']);
?>
				<div style="padding-left:40px; height:25px"><?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['acttitle'];?>
&nbsp;&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionEdit&id=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['id'];?>
',pt.writeBody)">修改</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionDel&id=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['id'];?>
',pt.writeBody)"><font color="#FF0000">删除</font></a>
				<?php $_smarty_tpl->assign("itt",$_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['id'],null,null);?>
				<?php if ($_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('itt')->value]!=''){ unset($_smarty_tpl->tpl_vars['smarty']->value['section']['itti']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['name'] = 'itti';
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('itt')->value]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['itti']['total']);
?>
				&nbsp;&nbsp; <?php echo $_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('itt')->value][$_smarty_tpl->getVariable('smarty')->value['section']['itti']['index']]['acttitle'];?>
&nbsp;&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionEdit&id=<?php echo $_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('itt')->value][$_smarty_tpl->getVariable('smarty')->value['section']['itti']['index']]['id'];?>
',pt.writeBody)">修改</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionDel&id=<?php echo $_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('itt')->value][$_smarty_tpl->getVariable('smarty')->value['section']['itti']['index']]['id'];?>
',pt.writeBody)"><font color="#FF0000">删除</font></a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionAdd&pid=<?php echo $_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('itt')->value][$_smarty_tpl->getVariable('smarty')->value['section']['itti']['index']]['id'];?>
',pt.writeBody)">添加子类</a>
				<?php endfor; endif;  }?></div>
			<?php endfor; endif; ?>

		<?php }else{ ?>
			<div style="padding-left:20px; height:30px;"><i><b><?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['acttitle'];?>
</b></i>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionEdit&id=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['id'];?>
',pt.writeBody)">修改</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionDel&id=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['id'];?>
',pt.writeBody)"><font color="#FF0000">删除</font></a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionAdd&pid=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['id'];?>
',pt.writeBody)">添加子类</a>
			<?php $_smarty_tpl->assign("it",$_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['id'],null,null);?>
			<?php if ($_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('it')->value]!=''){ unset($_smarty_tpl->tpl_vars['smarty']->value['section']['iti']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['name'] = 'iti';
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('it')->value]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['iti']['total']);
?>
				&nbsp;&nbsp; <?php echo $_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('it')->value][$_smarty_tpl->getVariable('smarty')->value['section']['iti']['index']]['acttitle'];?>
&nbsp;&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionEdit&id=<?php echo $_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('it')->value][$_smarty_tpl->getVariable('smarty')->value['section']['iti']['index']]['id'];?>
',pt.writeBody)">修改</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionDel&id=<?php echo $_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('it')->value][$_smarty_tpl->getVariable('smarty')->value['section']['iti']['index']]['id'];?>
',pt.writeBody)"><font color="#FF0000">删除</font></a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="RQ('./?act=Action.ActionAdd&pid=<?php echo $_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('it')->value][$_smarty_tpl->getVariable('smarty')->value['section']['iti']['index']]['id'];?>
',pt.writeBody)">添加子类</a>
			<?php endfor; endif;  }?></div>
		<?php }?>

	<?php endfor; endif;  endfor; endif; ?>
</div></div>