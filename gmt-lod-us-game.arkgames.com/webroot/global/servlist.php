<?php
	require 'common.php';
	require 'base.php';

	$begin_microtime = microtime(true);
	$caption = '请求开始时间 -- ' . date('Y-m-d H:i');

	$retmsg = '';
	$list = array();
	$server_url = 'http://pl'. $domain.'/servlist.php';
	$result = @file_get_contents($server_url);

	$end_microtime = microtime(true);
	$distance = $end_microtime - $begin_microtime;
	$distance = round($distance, 5);
	$caption .= '<br> 请求结束时间 -- ' . date('Y-m-d H:i');
	$caption .= '<br> 耗时(秒) -- ' . $distance;
	$caption .= '<br> 获得内容 -- '. $result;

	$smarty->assign('caption', $caption);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('servlist.tpl');
?>
