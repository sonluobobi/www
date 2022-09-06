<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F2234821268";a:2:{i:0;s:37:"../template/template/Auth.action.html";i:1;i:1555559304;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-09-28 18:18:05
         compiled from "../template/template/Auth.action.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['ActionAuth'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
<div class="bodyContentHead" id="userActionList">
<form id="subform" name="subform" onsubmit="FS('subform',pt.writeBody); return false;" method="post" action="./?act=Auth.action"> 
<div style="height:30px">
<?php echo $_smarty_tpl->getVariable('lang')->value['accountName'];?>
 :<select name="account" id="account" onchange="auth_load(this)">
	<option value=""><?php echo $_smarty_tpl->getVariable('lang')->value['plaseClew'];?>
</option>
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('internal_account')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
	<option value="<?php echo $_smarty_tpl->getVariable('internal_account')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
" ><?php echo $_smarty_tpl->getVariable('internal_account')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
</option>
    <?php endfor; endif; ?>
</select>

</div>
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
 $_smarty_tpl->assign("root_it",$_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['id'],null,null);?>
<div style="height:20px;height:30px;"><b><?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['acttitle'];?>
</b>&nbsp;&nbsp;<input  id="<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['id'];?>
" pid="<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['pid'];?>
" type="checkbox" name="actions[]" value="<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['actkey'];?>
" onclick="do_check(this);"/></div>
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
</b></i>&nbsp;&nbsp;<input type="checkbox" id="<?php echo $_smarty_tpl->getVariable('id')->value;?>
" name="actions[]" pid="<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['id'];?>
" value="<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actkey'];?>
" onclick="do_check(this);"/></div>

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
&nbsp;&nbsp;<input type="checkbox" name="actions[]" id="<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['id'];?>
" pid="<?php echo $_smarty_tpl->getVariable('id')->value;?>
" value="<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['actkey'];?>
" onclick="do_check(this);"/>
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
&nbsp;&nbsp;<input id="<?php echo $_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('itt')->value][$_smarty_tpl->getVariable('smarty')->value['section']['itti']['index']]['id'];?>
" pid="<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['id'];?>
" type="checkbox" name="actions[]" value="<?php echo $_smarty_tpl->getVariable('menuItem')->value[$_smarty_tpl->getVariable('itt')->value][$_smarty_tpl->getVariable('smarty')->value['section']['itti']['index']]['actkey'];?>
"  onclick="do_check(this);"/>
				<?php endfor; endif;  }?></div>
			<?php endfor; endif; ?>

		<?php }else{ ?>
			<div style="padding-left:20px; height:30px;"><i><b><?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['acttitle'];?>
</b></i>&nbsp;&nbsp;<input type="checkbox" name="actions[]" pid="<?php echo $_smarty_tpl->getVariable('root_it')->value;?>
" value="<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actkey'];?>
"  onclick="do_check(this);"/>
			</div>
		<?php }?>

	<?php endfor; endif;  endfor; endif; ?>

<div style="width:50%;margin:auto;padding:20px;">  
<input name="submit" type="submit" class="submit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['Submit'];?>
" />&nbsp;&nbsp;
<input name="reset" type="reset" class="submit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['Reset'];?>
" />&nbsp;&nbsp;
</div> 

</form>
</div></div>