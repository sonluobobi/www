<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1399753751";a:2:{i:0;s:47:"../template/template/Notice.SendPropsEquip.html";i:1;i:1662457797;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-09 10:22:28
         compiled from "../template/template/Notice.SendPropsEquip.html" */ ?>
<div id="bodyTitle"><?php echo $_smarty_tpl->getVariable('lang')->value['sendPropsTitle'];?>
</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
	<iframe id="iframeload" name="iframeload" src="/img/1.gif" style="width:0px; height:0px; display:none" frameborder="0" scrolling="no"></iframe>
	<div class="bodyContentHead">

		<form  method="post"  target="iframeload"  id="myform" action="./?act=Notice.sendPropsEquip" enctype="multipart/form-data" >
			<input type="hidden" value="9900000" name="MAX_FILE_SIZE"/>
			<table align="center" cellspacing="1" cellpadding="0" class="userTable" style="width:80%;" id="tbl">
				<tr>
					<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['memo'];?>
：</td>
					<td align="left"><font color="red"><?php echo $_smarty_tpl->getVariable('lang')->value['notice_brief'];?>
</font></td>
				</tr>
				<tr>
					<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['SelectServers'];?>
：</td>
					<td align="left"><?php $_template = new Smarty_Template ("Common_server.list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 0; echo $_template->getRenderedTemplate();  unset($_template); ?></td>
				</tr>
				<tr>
					<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['receiverType'];?>
：</td>
					<td align="left">
						<select id="receiverType" name="receiverType">
							<option value="1" selected="selected"><?php echo $_smarty_tpl->getVariable('lang')->value['roleId'];?>
</option>
							<!--option value="2"><?php echo $_smarty_tpl->getVariable('lang')->value['roleName'];?>
</option-->
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['receiver'];?>
：</td>
					<td align="left">
						<input id="type" name="type" type="radio" value="1" checked="checked" onclick="changeSendType(this.value,'<?php echo $_smarty_tpl->getVariable('lang')->value['inputCaption'];?>
')"/>
						<?php echo $_smarty_tpl->getVariable('lang')->value['input'];?>
 &nbsp;
						<input id="type" name="type" type="radio" value="2" onclick="changeSendType(this.value,'<?php echo $_smarty_tpl->getVariable('lang')->value['uploadCaption'];?>
')"/>
						<?php echo $_smarty_tpl->getVariable('lang')->value['upload'];?>

						<br />
						<input type="text" id="rids" name="rids" value="" style="width:250px"/>
						<input type="file" id="excleFile" name="excleFile"  value=""  style="display:none">
						<!--input type="submit" class="submit" name="is_check_role_name"  value="<?php echo $_smarty_tpl->getVariable('lang')->value['checkRoleName'];?>
"-->
						<span id="caption"><?php echo $_smarty_tpl->getVariable('lang')->value['inputCaption'];?>
</span>
					</td>
				</tr>
				<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['total']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['name'] = 'total';
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['loop'] = is_array($_loop=4) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['total']);
?>
				<tr>
					<td align="right">&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['equipInfo']; echo $_smarty_tpl->getVariable('smarty')->value['section']['total']['index']+1;?>
:&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['equip_id'];?>
&nbsp;&nbsp;<input type="text" name="equip_id[]" id="equip_id_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['total']['index']+1;?>
" size="20" value="" />
						&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['equip_num'];?>
&nbsp;&nbsp;<input type="text" name="equip_num[]" id="equip_num_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['total']['index']+1;?>
" size="20" value="" /></td>
				</tr>
				<?php endfor; endif; ?>
				<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['total']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['name'] = 'total';
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['loop'] = is_array($_loop=4) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['total']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['total']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['total']['total']);
?>
				<tr>
					<td align="right">&nbsp;资源道具<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['total']['index']+1;?>
:&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;资源道具&nbsp;&nbsp;<input type="text" name="resou_id[]" id="equip_id_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['total']['index']+1;?>
" size="20" value="" />
						&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['equip_num'];?>
&nbsp;&nbsp;<input type="text" name="resou_num[]" id="equip_num_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['total']['index']+1;?>
" size="20" value="" /></td>
				</tr>
				<?php endfor; endif; ?>

				<tr>
					<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['expire'];?>
：</td>  <td align="left"><input type="text" name="endTime" style="width:200px" value="<?php echo $_smarty_tpl->getVariable('endTime')->value;?>
" id="endTime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="Wdate" >
				</td>
				</tr>
				<tr>
					<td align="right">邮件类型：</td>
					<td align="left">
						<input id="topType" name="topType" type="radio" value="0" checked="checked" />
						普通邮件 &nbsp;
						<input id="topType" name="topType" type="radio" value="1" />
						置顶邮件
						<input id="topType" name="topType" type="radio" value="2" />
						问卷邮件
					</td>
				</tr>

				<tr>
					<td align="right">通关章节：</td>
					<td align="left"><input type="text" name="chapter" value="<?php echo $_smarty_tpl->getVariable('chapter')->value;?>
" id="chapter" style="width:200px" /></td>
				</tr>

				<tr>
					<td align="right">主堡等级：</td>
					<td align="left"><input type="text" name="castle" value="<?php echo $_smarty_tpl->getVariable('castle')->value;?>
" id="castle" style="width:200px" /></td>
				</tr>


				<tr>
					<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
：</td>
					<td align="left"><input type="text" name="title" value="<?php echo $_smarty_tpl->getVariable('title')->value;?>
" id="title" style="width:200px" /></td>
				</tr>
				<tr>
					<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['memo'];?>
：</td>
					<td align="left"><font color="red">1、请勿使用单双引号'或者" 2、超链接使用  &lt;color=blue1&gt;&lt;link id=show_web|http://www.baidu.com&gt;描述&lt;/link&gt;&lt;/color&gt; 3、
						问卷邮件格式 &lt;color=blue1&gt;&lt;link id=question&id=b6ec354&gt;点击填写问卷&lt;/link&gt;&lt;/color&gt; 4、问卷日期20210421,20210504 5、问卷前置f8ff5e4,2433ee4用逗号隔开</font></td>
				</tr>
				<tr>
					<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['content'];?>
：</td>
					<td align="left">
						<textarea id="contents" name="content" rows="8" cols="80"><?php echo $_smarty_tpl->getVariable('content')->value;?>
</textarea>
					</td>
				</tr>
				<tr>
					<td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['reason'];?>
：</td>
					<td align="left">
						<textarea id="reason" name="reason" rows="6" cols="40"><?php echo $_smarty_tpl->getVariable('reason')->value;?>
</textarea>
					</td>
				</tr>
				<!--
                <tr>
                     <td align="right"><?php echo $_smarty_tpl->getVariable('lang')->value['awardNum'];?>
：</td>
                     <td align="left"><input type="text" value="" id="awardNum" name="awardNum"></td>
                     <textarea id="contents" name="content" rows="8" cols="80"><?php echo $_smarty_tpl->getVariable('content')->value;?>
</textarea>
                    </tr>
                <tr>
                -->
				<tr>
					<td></td>
					<td><input type="submit" class="submit"  value="<?php echo $_smarty_tpl->getVariable('lang')->value['Submit'];?>
"></td>
				</tr>
			</table>
		</form>
		<div style="width:50%;margin:auto;">
			<button  type="button" onclick="addEquipEn()">新增多语言内容</button>&nbsp;&nbsp;
		</div>
	</div>
</div>

