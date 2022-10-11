<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:10:"F244477538";a:2:{i:0;s:37:"../template/template/Action.Edit.html";i:1;i:1662457797;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-09 10:31:53
         compiled from "../template/template/Action.Edit.html" */ ?>
<div  id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['systemHandleUpdate'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
<div class="bodyContentHead">

	<form method="post"  id="myform" action="?act=Action.ActionSaveEdit" onsubmit="FS('myform',pt.writeBody); return false;" >
	<table width="100%">
    <tr>
	<td colspan="3">
	<?php if ($_smarty_tpl->getVariable('isadd')->value==0){?><input type="hidden" name="id" value="<?php echo $_smarty_tpl->getVariable('action')->value->id;?>
"><?php }else{ ?><input type="hidden" name="pid" value="<?php echo $_smarty_tpl->getVariable('pid')->value;?>
"><?php }?><input type="hidden" name="isadd" value="<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('default',array($_smarty_tpl->getVariable('isadd')->value,0),true);?>
">
	</td>
	</tr>
    <?php if ($_smarty_tpl->getVariable('isadd')->value==0){?>
	<tr>
	<td width="120" align="right">ID：</td>
	<td align="left" colspan="2"><?php echo $_smarty_tpl->getVariable('action')->value->id;?>
</td>
	</tr>
	<?php }?>
    <tr>
	<td width="120" align="right">上级菜单：</td>
	<td align="left" colspan="2"><?php echo $_smarty_tpl->getVariable('upname')->value;?>
</td>
	</tr>
    <tr>
	<td align="right">排序：</td>
	<td align="left" colspan="2">
    <input type="text" class="input" name="orderid" value="<?php echo $_smarty_tpl->getVariable('action')->value->orderid;?>
">
	</td>
	</tr>
    <tr><td align="right">动作类型：</td><td align="left" colspan="2">
    <input type="radio" class="myCheckBox" name="acttype" value="-1"  <?php if ($_smarty_tpl->getVariable('action')->value->acttype=='-1'){?>checked="checked"<?php }?> > -1 <input type="radio" class="myRadio" name="acttype" value="0"  <?php if ($_smarty_tpl->getVariable('action')->value->acttype=='0'){?>checked="checked"<?php }?> > 0 <input type="radio" class="myCheckBox" name="acttype" value="1"  <?php if ($_smarty_tpl->getVariable('action')->value->acttype=='1'){?>checked="checked"<?php }?> > 1</td></tr>
    <tr><td align="right">图标：</td><td align="left" colspan="2">
	<select name="actico"><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('acticodb')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><option value="<?php echo $_smarty_tpl->getVariable('v')->value;?>
"<?php if ($_smarty_tpl->getVariable('action')->value->actico==$_smarty_tpl->getVariable('v')->value){?> selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('k')->value;?>
</option><?php }} ?></select></td></tr>
    <tr><td align="right">URL：</td><td align="left" colspan="2">
    <input type="text" class="input" name="actcode" value="<?php echo $_smarty_tpl->getVariable('action')->value->actcode;?>
"></td></tr>
    <tr><td align="right">名称：</td><td align="left" colspan="2">
    <input type="text" class="input" name="acttitle" value="<?php echo $_smarty_tpl->getVariable('action')->value->acttitle;?>
"></td></tr>
    <tr><td align="right">是否显示在列表中：</td><td align="left" colspan="2">
     <input type="radio" class="myCheckBox" name="actdisplay" value="block"  <?php if ($_smarty_tpl->getVariable('action')->value->actdisplay=='block'){?>checked="checked"<?php }?> > 是 <input type="radio" class="myCheckBox" name="actdisplay" value="none"  <?php if ($_smarty_tpl->getVariable('action')->value->actdisplay=='none'){?>checked="checked"<?php }?> > 否</td></tr>

    </table>

	<table><tr><td style="padding-left: 60px;">
	<input type="submit" name="submit" class="submit" value="<?php if ($_smarty_tpl->getVariable('isadd')->value==0){?>修改<?php }else{ ?>添加<?php }?>" />
	</td></tr></table>
	</form>

</div></div>
