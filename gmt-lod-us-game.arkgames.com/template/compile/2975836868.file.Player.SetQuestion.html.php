<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F2160923970";a:2:{i:0;s:44:"../template/template/Player.SetQuestion.html";i:1;i:1662457797;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-09 11:20:24
         compiled from "../template/template/Player.SetQuestion.html" */ ?>
<div id="bodyTitle">问卷设置</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
	<iframe id="iframeload" name="iframeload" src="/img/1.gif" style="width:0px; height:0px; display:none" frameborder="0" scrolling="no"></iframe>
	<div class="bodyContentHead">

		<form  method="post"  target="iframeload"  id="myform" action="./?act=Notice.sendPropsEquip" enctype="multipart/form-data" >
			<input type="hidden" value="9900000" name="MAX_FILE_SIZE"/>
			<table align="center" cellspacing="1" cellpadding="0" class="userTable" style="width:80%;" id="tbl">
				<tr>
					<td align="right">问卷id：</td>
					<td align="left"><input type="text" name="chargecancel_wenjuan_id" value="<?php echo $_smarty_tpl->getVariable('chargecancel_wenjuan_id')->value;?>
" id="chargecancel_wenjuan_id" style="width:200px" /></td>
				</tr>
				<tr>
					<td align="right">问卷cd(秒)：</td>
					<td align="left"><input type="text" name="chargecancel_wenjuan_cd" value="<?php echo $_smarty_tpl->getVariable('chargecancel_wenjuan_cd')->value;?>
" id="chargecancel_wenjuan_cd" style="width:200px" /></td>
				</tr>
				<tr>
					<td align="right">vk_url：</td>
					<td align="left"><input type="text" name="vk_url" value="<?php echo $_smarty_tpl->getVariable('vk_url')->value;?>
" id="vk_url" style="width:200px" /></td>
				</tr>
				<tr>
					<td align="right">facebook_url：</td>
					<td align="left"><input type="text" name="facebook_url" value="<?php echo $_smarty_tpl->getVariable('facebook_url')->value;?>
" id="facebook_url" style="width:200px" /></td>
				</tr>
				<tr>
					<td align="right">google_question_url：</td>
					<td align="left"><input type="text" name="google_question_url" value="<?php echo $_smarty_tpl->getVariable('google_question_url')->value;?>
" id="google_question_url" style="width:200px" /></td>
				</tr>
				<tr>
					<td align="right">twitter_url：</td>
					<td align="left"><input type="text" name="twitter_url" value="<?php echo $_smarty_tpl->getVariable('twitter_url')->value;?>
" id="twitter_url" style="width:200px" /></td>
				</tr>
				<tr>
					<td align="right">google_play_url：</td>
					<td align="left"><input type="text" name="google_play_url" value="<?php echo $_smarty_tpl->getVariable('google_play_url')->value;?>
" id="google_play_url" style="width:200px" /></td>
				</tr>
				<tr>
					<td align="right">app_store_url：</td>
					<td align="left"><input type="text" name="app_store_url" value="<?php echo $_smarty_tpl->getVariable('app_store_url')->value;?>
" id="app_store_url" style="width:200px" /></td>
				</tr>
				<tr>
					<td align="right">social_url：</td>
					<td align="left"><input type="text" name="social_url" value="<?php echo $_smarty_tpl->getVariable('social_url')->value;?>
" id="social_url" style="width:200px" /></td>
				</tr>
				<tr>
					<td align="right">social_panelname：</td>
					<td align="left"><input type="text" name="social_panelname" value="<?php echo $_smarty_tpl->getVariable('social_panelname')->value;?>
" id="social_panelname" style="width:200px" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" class="submit"  value="<?php echo $_smarty_tpl->getVariable('lang')->value['Submit'];?>
"></td>
				</tr>
			</table>
		</form>
	</div>
</div>





