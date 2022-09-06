<?php
	require 'common.php';
	require 'base.php';

	$begin_date = httpGetVal('begin_date');
	$cur_date = date('Y-m-d');
	empty($begin_date) && $begin_date = $cur_date;

	$online_list = array();
	$online_cnt = '';
	$retmsg = '';

	$log_map_selected = httpGetVal('log_type');
	empty($log_map_selected) && $log_map_selected = 'active';
	//$log_map = array('active' => '新增', 'login' => '登录', 'online' => '在线', 'usergrade' => '升级', 'activesuccess' => '激活');
	$log_map = array('active' => '新增', 'login' => '登录', 'online' => '在线', 'activesuccess' => '激活');

	$smarty->assign("log_map_values", array_keys($log_map));
	$smarty->assign("log_map_output", array_values($log_map));
	$smarty->assign("log_map_selected", $log_map_selected);

	$smarty->assign('domain', $domain);
	$smarty->assign("begin_date", $begin_date, true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('logToDC.tpl');
?>
