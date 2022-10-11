<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F2235249029";a:2:{i:0;s:39:"../template/template/User.userlist.html";i:1;i:1665398857;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-10 13:57:58
         compiled from "../template/template/User.userlist.html" */ ?>
<div id="bodyTitle">用户列表</div>

<div class="bodyContent"  style="border-top: 2px solid #666;">
<div class="bodyContentHead" style="text-align:left">
	
<table width="98%" class="tableContent" align="center">
    <thead>
    <tr align="center">
	<th>用户名</th>		
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['handler'];?>
</td>	
	</tr>
    </thead>
    <tbody>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
    <tr align="center">
	<td><?php echo $_smarty_tpl->getVariable('k')->value;?>
</td>	
	<td>
		<a href="javascript:void(0);" onclick="deleteUser('删除','确定要删除此用户吗','<?php echo $_smarty_tpl->getVariable('k')->value;?>
')"><?php echo $_smarty_tpl->getVariable('lang')->value['drop'];?>
</a>
	</td>	
	</tr>
	<?php }} else { ?>
	<tr align="center"><td colspan="10"><?php echo $_smarty_tpl->getVariable('lang')->value['noResult'];?>
</td></tr>
    <?php } ?>
    </tbody>
</table>
<?php if ($_smarty_tpl->getVariable('list')->value){?>
<div>
&nbsp;&nbsp;
</div>
<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
<?php }?>
</div>
</div>
<div id="listForm" style="display:none"></div>
<script type="text/javascript">
reload = function(time) {
    time = time *1000;
     setTimeout('document.location.reload()',time);
}

</script>