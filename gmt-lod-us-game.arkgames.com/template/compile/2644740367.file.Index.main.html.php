<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1167306794";a:2:{i:0;s:36:"../template/template/Index.main.html";i:1;i:1565169627;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2020-01-02 18:20:48
         compiled from "../template/template/Index.main.html" */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="zh-CN">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $_smarty_tpl->getVariable('lang')->value['app_name'];?>
 | <?php echo $_smarty_tpl->getVariable('lang')->value['cp_home'];?>
</title>
	<link rel="stylesheet" href="/css/style.css" type="text/css" />
	<script type="text/javascript" src="/js/mootools-1.2.1-core.js"></script>
	<script type="text/javascript" src="/js/mootools-1.2-more.js"></script>
	<script type="text/javascript" src="/js/core.js?ver=1.2"></script>
	<script type="text/javascript" src="/js/calendar/calendar.js"></script>
	<script type="text/javascript" src="/js/calendar/calendar-setup.js"></script>
	<script type="text/javascript" src="/js/calendar/lang/cn_utf8.js"></script>
	<script type="text/javascript" src="/js/my97/WdatePicker.js"></script>
	<script type="text/javascript" src="/js/fckeditor/fckeditor.js"></script>	
	<script type="text/javascript" src="/js/gmtfunc.js"></script>
	<style type="text/css">@import url("/js/calendar/skins/aqua/theme.css");</style>	
  </head>
  <body>
	<div class="header">
		<img class="logo" src="/img/logo.gif">
		<span class="link">
		您好 <?php echo $_SESSION['infoUser']['fullname'];?>

		&nbsp;|&nbsp; 
		<a href="?act=Login.quit">退出登录</a>&nbsp;&nbsp;&nbsp;
		<br /><br /><br />
		</span>
	</div>
	<div class="bar" id="nowDayTime" rev="-" rel="<?php echo $_smarty_tpl->getVariable('theTime')->value['nowDateTime'];?>
"><?php echo $_smarty_tpl->getVariable('theTime')->value['nowDateTime'];?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
	<div class="body">
		<div class="bodyLeft">
			<div>
				<b class="round_border">
					<b class="round_border_layer3"></b>
					<b class="round_border_layer2"></b>
					<b class="round_border_layer1"></b>
				</b>
				<div class="round_border_content">
				<!-- Menu 1  Begin -->
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
					<a class="menuLink" href="javascript:void(0);"><div class="menuImage0 <?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['actico'];?>
"><?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['acttitle'];?>
</div></a>
					<?php if (!empty($_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'])){?> <!-- neq ""} > -->
					<div class="menuDiv" style="display:<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['actdisplay'];?>
">
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
							<?php if (!empty($_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value])){?> <!-- neq ""} > -->
								<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['name'] = 'tt';
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['tt']['total']);
?>
                                                                        <!--if $menuTree[ii].ActSecond[$id][tt].actcode|substr:7|in_array:$smarty.session.userRank-->
																		<?php if ($_smarty_tpl->smarty->plugin_handler->executeModifier('in_array',array($_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['actkey'],$_SESSION['userRank']),true)){?>
                                                                        <?php $_smarty_tpl->assign("status",$_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['tt']['index']]['actcode'],null,null);?>
                                                                        <?php }?> 
                                                                <?php endfor; endif; ?>
							<?php if ($_smarty_tpl->getVariable('status')->value){?>
							<a class="menuLink" href="javascript:void(0);"><div class="menuImage1 menuRight"><?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['acttitle'];?>
</div></a>
							<div class="menuDiv" style="display:<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actdisplay'];?>
">
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
<!--									if $menuTree[ii].ActSecond[$id][nn].actcode|substr:7|in_array:$smarty.session.userRank-->
									<?php if ($_smarty_tpl->smarty->plugin_handler->executeModifier('in_array',array($_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['actkey'],$_SESSION['userRank']),true)){?>
								<?php if ($_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['acttype']!=-1){?><a class="menuLink" href="javascript:void(0);" onclick="RQ('<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['actcode'];?>
&actkey=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['actkey'];?>
',pt.writeBody)"><div class="menuImage2"><?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActSecond'][$_smarty_tpl->getVariable('id')->value][$_smarty_tpl->getVariable('smarty')->value['section']['nn']['index']]['acttitle'];?>
</div></a><?php }?>
									<?php }?>
								<?php endfor; endif; ?>
							</div>
								<?php }?>
                                                        <?php $_smarty_tpl->assign("status",'',null,null);?>
							<?php }else{ ?>
<!--								if $menuTree[ii].ActFirst[mm].actcode|substr:7|in_array:$smarty.session.userRank-->
								<?php if ($_smarty_tpl->smarty->plugin_handler->executeModifier('in_array',array($_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actkey'],$_SESSION['userRank']),true)){?>
							<a class="menuLink" href="javascript:void(0);" onclick="RQ('<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actcode'];?>
&actkey=<?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actkey'];?>
',pt.writeBody)"><div class="menuImage1"><?php echo $_smarty_tpl->getVariable('menuTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['acttitle'];?>
</div></a>
								<?php }?>
							<?php }?>
						<?php endfor; endif; ?>
					</div>
					<?php }?>
				<?php endfor; endif; ?>
				<!-- Menu 1  End -->
				</div>
				<b class="round_border">
					<b class="round_border_layer1"></b>
					<b class="round_border_layer2"></b>
					<b class="round_border_layer3"></b>
				</b>
			</div>
			<div style="margin-top: 15px">
				<b class="round_border">
					<b class="round_border_layer3"></b>
					<b class="round_border_layer2"></b>
					<b class="round_border_layer1"></b>
				</b>
				<div class="round_border_content">

					<!-- Menu 2  Begin -->
					<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['name'] = 'ii';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('setupTree')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
					<div class="menu0"><?php echo $_smarty_tpl->getVariable('setupTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActRoot']['acttitle'];?>
</div>
						<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['mm']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['name'] = 'mm';
$_smarty_tpl->tpl_vars['smarty']->value['section']['mm']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('setupTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<!--							if $setupTree[ii].ActFirst[mm].actcode|substr:7|in_array:$smarty.session.userRank-->
							<?php if ($_smarty_tpl->smarty->plugin_handler->executeModifier('in_array',array($_smarty_tpl->getVariable('setupTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actkey'],$_SESSION['userRank']),true)){?>
							<a class="menuLink" href="javascript:void(0);" onclick="RQ('<?php echo $_smarty_tpl->getVariable('setupTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actcode'];?>
&actkey=<?php echo $_smarty_tpl->getVariable('setupTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actkey'];?>
',pt.writeBody)"><div class="menuImage1 <?php echo $_smarty_tpl->getVariable('setupTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actico'];?>
" style="display:<?php echo $_smarty_tpl->getVariable('setupTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['actdisplay'];?>
"><?php echo $_smarty_tpl->getVariable('setupTree')->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['ActFirst'][$_smarty_tpl->getVariable('smarty')->value['section']['mm']['index']]['acttitle'];?>
</div></a>
							<?php }?>
						<?php endfor; endif; ?>
					<?php endfor; endif; ?>
					<!-- Menu 2  End -->

					</div>
				<b class="round_border">
					<b class="round_border_layer1"></b>
					<b class="round_border_layer2"></b>
					<b class="round_border_layer3"></b>
				</b>
			</div>
		</div>
		<div class="bodyRight">
			<div>
				<b class="round_border">
					<b class="round_border_layer3"></b>
					<b class="round_border_layer2"></b>
					<b class="round_border_layer1"></b>
				</b>
				<div class="round_border_content">
					<b class="controlbar_border">
						<b class="controlbar_border_layer3"></b>
						<b class="controlbar_border_layer2"></b>
						<b class="controlbar_border_layer1"></b>
					</b>
					<div class="controlbar_border_content">
						<div class="floatLeft">
							<a id="ctrlBarDumpAct" class="button menu floatLeft" href="javascript:pt.buttonToggle('ctrlBarDump', 'div.ctrlBar');"><b><b><b style="color:#888">导出</b></b></b></a>
							<a class="button email floatLeft" href="javascript:void(0);"><b><b><b style="color:#888">站内信</b></b></b></a>
						</div>
						<div class="floatRight">
						  <a class="button ptmain floatLeft" href="./"><b><b><b>回到首页</b></b></b></a>
						</div>

						<div class="ctrlBar" id="ctrlBarDump">
							<div class="dumpBody">
								<a class="imglink bgdcsv" href="javascript:void(0)" onClick="downloadExcel()">EXCEL</a>
							</div>
						</div>

					</div>
					<b class="controlbar_border">
						<b class="controlbar_border_layer1"></b>
						<b class="controlbar_border_layer2"></b>
						<b class="controlbar_border_layer3"></b>
					</b>
					
					<div style="position: relative; height: 0px; top: 4px; right: 5px; float: right;">
					<div id="linkReload" href="javascript:void(0);" class="jumpReload" style="background-image: url('img/jump_flush_1.png');"></div>
					<div id="linkNext" href="javascript:void(0);" class="jumpNext" style="background-image: url('img/jump_right_0.png');"></div>
					<div id="linkPre" href="javascript:void(0);" class="jumpPrev" style="background-image: url('img/jump_left_0.png');"></div>
					</div>
					
					<div id="bodyContents">
					<!-- bodyContents Begin -->
						<div id="bodyTitle">欢迎登录</div>
						<div class="bodyContent" id="bodyContentAuthCtrl" style="border-top: 2px solid #666;">
							<div class="bodyContentHead">
								<br /><b>IE6下效果较差</b>，傲游 和 TT 等类型浏览器，可能会屏蔽弹出层。 建议使用 Firefox
								</div>
						</div>
						
					<!-- bodyContents End -->
					</div>
					<div id="bodyContentFoot"></div>
					<b class="controlbar_border">
						<b class="controlbar_border_layer2"></b>
						<b class="controlbar_border_layer3"></b>
					</b>
				</div>
				<b class="round_border">
					<b class="round_border_layer1"></b>
					<b class="round_border_layer2"></b>
					<b class="round_border_layer3"></b>
				</b>
			</div>
			<div style="margin-top: 15px">
				<b class="round_border">
					<b class="round_border_layer3"></b>
					<b class="round_border_layer2"></b>
					<b class="round_border_layer1"></b>
				</b>
				<div id="debug"></div>
				<div class="round_border_content">
							<a href="javascript: void(0);"><b><b><b>调试 显示/隐藏</b></b></b></a>
							<br /><span id="debugDiv" style="display: none;"></span></div>
				<b class="round_border">
					<b class="round_border_layer1"></b>
					<b class="round_border_layer2"></b>
					<b class="round_border_layer3"></b>
				</b>
			</div>
		</div>
	</div>

	<div class="foot">&copy; 2010  Power By KunLun.com<br /><br /></div>
	<div id="pageMask"></div>
	<div id="pageLoad" onclick="pt.pageLoading('none');">Loading...</div>

	<div id="pageAlert" class="popDiv" style="width: 400px; z-index:999">
	  <center>
		<div id="pageAlertHead" class="popHead">提示信息</div>
		<div id="pageAlert_popBody" class="popBody"></div>
		<table><tr><td><a class="button" id="pageAlert_popOk" href="javascript:void(0);"><b><b><b>确　定</b></b></b></a></td></tr></table>
		<div style="height:10px;"></div>
	  </center>
	</div>

	<div id="pageConfirm" class="popDiv" style="width: 400px;">
	  <center>
		<div id="pageConfirmHead" class="popHead">提示信息</div>
		<div id="pageConfirm_popBody" class="popBody"></div>
		<table><tr><td>
			  <a class="button" id="pageConfirm_popOk" href="javascript:void(0);"><b><b><b>确　定</b></b></b></a>
			  &nbsp;　&nbsp;　&nbsp;　&nbsp;　&nbsp;　&nbsp;
			  <a class="button" id="pageConfirm_popNo" href="javascript:void(0);"><b><b><b>取　消</b></b></b></a>
		</td></tr></table>
		<div style="height:10px;"></div>
	  </center>
	</div>

	<div id="passPopCtrl" class="popDiv" align="center">
		<div id="passPopCtrlHeader" class="popHead"> 用户修改密码 </div>
		<a class="button popCancel"><b><b><b>X</b></b></b></a>
		<div id="gamePopBody" class="popBody">
			<form id="edpassform" method="post" action="/auths/changePassword">
			&nbsp;&nbsp;
			用户名: <input type="text" name="real_name" class="input" style="width:80px" value="<?php echo $_smarty_tpl->getVariable('userSession')->value['real_name'];?>
" readonly/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			新密码: <input type="password" name="password" class="input" style="width:110px" value="" />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			重复密码: <input type="password" name="repassword" class="input" style="width:110px" value="" />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" class="submit" value="修改密码" onclick="KQ('edpassform');"/>
			</form>
		</div>
	</div>

	<input type="hidden" id="mainActFormAct" value="/portals/defaults" />
	<form id="mainActForm">
	<input type="hidden" name="bgtm" value="<?php echo $_smarty_tpl->getVariable('theTime')->value['begin'];?>
" />
	<input type="hidden" name="edtm" value="<?php echo $_smarty_tpl->getVariable('theTime')->value['end'];?>
" />
	</form>
	<div id="debug"></div>
  </body>
  <script language="javascript">
  <!--
  window.addEvent('domready', function(){
	 new PageInit();
  });
  
  //-->
  -->
  </script>
</html>
