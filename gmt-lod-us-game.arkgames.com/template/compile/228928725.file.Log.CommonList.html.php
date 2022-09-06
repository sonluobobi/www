<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F3871195603";a:2:{i:0;s:40:"../template/template/Log.CommonList.html";i:1;i:1434357610;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-09-28 18:32:33
         compiled from "../template/template/Log.CommonList.html" */ ?>
<div  id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['systemLogManage'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  <div class="bodyContentBody">
  <div class="bodyContentHead" style="text-align:center">
  <form name="myform" id="myform" action="?act=Log.LogCommonList" method="post" onsubmit="FS('myform',pt.writeBody); return false;" >
 	<?php echo $_smarty_tpl->getVariable('lang')->value['ManageName'];?>
：<input type="text" name="fullname" value="<?php echo $_POST['fullname'];?>
" />
  <?php echo $_smarty_tpl->getVariable('lang')->value['beginDate'];?>
：<input id="sdate" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $_POST['beginDate'];?>
" style="width: 200px;" name="beginDate" realvalue=""/>
  <?php echo $_smarty_tpl->getVariable('lang')->value['endDate'];?>
：<input id="sdate" class="Wdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $_POST['endDate'];?>
" style="width: 200px;" name="endDate" realvalue=""/>
  <?php $_template = new Smarty_Template ("Page.Show.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?>
  <input id="p" name="p" type="hidden" value="1" />
  <input name="submit" type="submit" class="submit"  value="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
" />
  </form>
</div>
<table width="98%" class="tableContent" align="center">
    <thead>
    <tr align="center">
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['ID'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['ManageName'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['ManageLoginName'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['handler'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['Ip'];?>
</th>
	<th><?php echo $_smarty_tpl->getVariable('lang')->value['DateTime'];?>
</th>
	</tr>
    </thead>
    <tbody>
<?php if ($_smarty_tpl->getVariable('dataList')->value){?>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dataList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
    <tr align="center">
	<td><?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['fullname'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['username'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['content'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['ip'];?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('v')->value['logDate'];?>
</td>
	</tr>
    <?php }}  }?>
    </tbody>
</table>
<div class="pages"><?php echo $_smarty_tpl->getVariable('pages')->value;?>
</div>
</div>
</div>
