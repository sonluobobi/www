<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F3447151315";a:2:{i:0;s:46:"../template/template/Notice.SendPropsList.html";i:1;i:1662457797;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-09 12:10:54
         compiled from "../template/template/Notice.SendPropsList.html" */ ?>
<div  id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['SendPropsList'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  <div class="bodyContentBody" style="height:500px; overflow:scroll; ">
  <div class="bodyContentHead" style="text-align:center">
  <form name="myform" id="myform" action="?act=Notice.sendPropsList" method="post" onsubmit="FS('myform',pt.writeBody); return false;" >
  <!--<input type='radio' name='type' value='1' <?php if ($_POST['type']==1){?>checked<?php }?>>已发送&nbsp;&nbsp; -->
  <input type='radio' name='type' value='3' <?php if ($_POST['type']==3){?>checked<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['noSendPropsInfo'];?>
&nbsp;&nbsp;
  <input type='radio' name='type' value='2' <?php if ($_POST['type']==2){?>checked<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['SentPropsInfo'];?>
&nbsp;&nbsp;
  <input type='radio' name='type' value='1' <?php if ($_POST['type']==1){?>checked<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['propsSendFail'];?>
&nbsp;&nbsp;
   <input type='radio' name='type' value='4' <?php if ($_POST['type']==4){?>checked<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['propsSendRecall'];?>
&nbsp;&nbsp;
  <?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
  <input id="p" name="p" type="hidden" value="1" />
  <input name="submit" type="submit" class="submit"  value="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
" />
  </form>
</div>
<table width="98%" class="tableContent" align="center">
    <thead>
    <tr>
    <th><input id="checkAll" name="checkAll" type="checkbox" value="" onclick="checkAlls();"/></th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['gameServerList'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['reason'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['author'];?>
</th>
	<th>queue_id</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['expire'];?>
</th>
	</tr>
    </thead>
    <tbody>
<?php if ($_smarty_tpl->getVariable('list')->value){?>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
    <tr>
    <td><input name="select[]" id="select[]" type="checkbox" value="<?php echo $_smarty_tpl->getVariable('v')->value['queue_id'];?>
" onclick="checkOne()"/></td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['severlist'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['title'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['reason'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['author'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['queue_id'];?>

		<?php if ($_smarty_tpl->getVariable('v')->value['status']<3){?>
		(<input type="button" onclick="confirmClew('<?php echo $_smarty_tpl->getVariable('lang')->value['confirmRecall'];?>
','RQ(\'./?act=Notice.sendPropsRecal&queue_id=<?php echo $_smarty_tpl->getVariable('v')->value['queue_id'];?>
\',pt.writeBody)')" value="<?php echo $_smarty_tpl->getVariable('lang')->value['recall'];?>
"/>)
		<?php }?>
	</td>
	<td><font color="red"><?php echo $_smarty_tpl->getVariable('v')->value['expire'];?>
</font></td>
	
	</tr>
	<tr>
	<td><?php echo $_smarty_tpl->getVariable('lang')->value['receiver'];?>
</td>
	<td colspan="8" style="text-align:left;"><?php echo $_smarty_tpl->getVariable('v')->value['receiver'];?>
</td>
	<!--
	<?php if ($_smarty_tpl->getVariable('v')->value['status']==3){?>
		<td><input type="button" onclick="confirmClew('<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeSend'];?>
','RQ(\'./?act=Notice.sendPropsConfirm&queue_id=<?php echo $_smarty_tpl->getVariable('v')->value['queue_id'];?>
\',pt.writeBody)')" value="<?php echo $_smarty_tpl->getVariable('lang')->value['ConfirmSendProps'];?>
"/>&nbsp;&nbsp;
	        <input type="button" onclick="confirmClew('<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeDel'];?>
','RQ(\'./?act=Notice.sendPropsDel&queue_id=<?php echo $_smarty_tpl->getVariable('v')->value['queue_id'];?>
\',pt.writeBody)')" value="<?php echo $_smarty_tpl->getVariable('lang')->value['drop'];?>
"/>&nbsp;&nbsp;
	    </td>
	<?php }else{ ?>
		<td>
		 <input type="button" onclick="confirmClew('<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeDel'];?>
','RQ(\'./?act=Notice.sendPropsDel&queue_id=<?php echo $_smarty_tpl->getVariable('v')->value['queue_id'];?>
\',pt.writeBody)')" value="<?php echo $_smarty_tpl->getVariable('lang')->value['drop'];?>
"/>&nbsp;&nbsp;
	    </td>
	<?php }?>
	-->
	</tr>
	<tr>
	<td><?php echo $_smarty_tpl->getVariable('lang')->value['content'];?>
</td>
	<td colspan="7" style="text-align:left;"><?php echo $_smarty_tpl->getVariable('v')->value['content'];?>
</td>
	</tr>
	<tr>
	<td><?php echo $_smarty_tpl->getVariable('lang')->value['SendPropsInfo'];?>
</td>
	<td colspan="7" style="text-align:left;"><?php echo $_smarty_tpl->getVariable('v')->value['SendPropsInfo'];?>
</td>
	</tr>
	<?php if ($_POST['type']!=3){?>
	<tr>
	<td><?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
</td>
	<td colspan="7" style="text-align:left;"><?php echo $_smarty_tpl->getVariable('v')->value['description'];?>
</td>
	</tr>
	<?php }?>
	<tr>
	<td colspan="8"></td>
	</tr>

    <?php }}  }?>
    </tbody>
</table>

<?php if ($_smarty_tpl->getVariable('list')->value){?>
	<?php if ($_POST['type']==3){?>
		<div>
		&nbsp;&nbsp;
		<td><input type="button" onclick="confirmClew('<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeSend'];?>
','sendPropsConfirm()')" value="批量确认发送"/>&nbsp;&nbsp;
			 <input type="button" onclick="confirmClew('<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeDel'];?>
','sendPropsDel()')" value="批量确认删除"/>&nbsp;&nbsp;
		</td>
		</div>
	
	<?php }elseif($_POST['type']==1){?>
		<div>
		&nbsp;&nbsp;
		<td><input type="button" onclick="confirmClew('<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeSend'];?>
','sendPropsConfirm()')" value="批量确认发送"/>&nbsp;&nbsp;
			 <input type="button" onclick="confirmClew('<?php echo $_smarty_tpl->getVariable('lang')->value['confirmNoticeDel'];?>
','sendPropsDel()')" value="批量确认删除"/>&nbsp;&nbsp;
		</td>
		</div>
	<?php } }?>	

<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
</div>
</div>
