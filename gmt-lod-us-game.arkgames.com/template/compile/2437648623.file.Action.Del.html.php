<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1232841162";a:2:{i:0;s:36:"../template/template/Action.Del.html";i:1;i:1662457797;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-09 10:22:09
         compiled from "../template/template/Action.Del.html" */ ?>
<div  id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['systemHandleDel'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
<div class="bodyContentHead">
	<form id="myform" method="post" action="?act=Action.ActionSaveDel" onsubmit="FS('myform',pt.writeBody); return false;"><table width="100%">
    <tr><td colspan="3"><input type="hidden" name="id" value="<?php echo $_smarty_tpl->getVariable('action')->value->id;?>
"></td></tr>
    <tr><td colspan="3" align="left">此操作为<b>不</b>可逆操作,您确定要删除<font color="#FF0000"><?php echo $_smarty_tpl->getVariable('action')->value->acttile; if ($_smarty_tpl->getVariable('isfather')->value){?>及下属操作<?php }?></font>吗?</td></tr>
    

    </table>
	</form>

	<table><tr><td style="padding-left: 60px;">
		<a class="button" href="javascript: void(0);" onclick="FS('myform',pt.writeBody)"><b><b><b>确定删除</b></b></b></a>
	</td></tr></table>
</div>
</div>
