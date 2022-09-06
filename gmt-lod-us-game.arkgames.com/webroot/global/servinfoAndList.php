<?php
	require 'common.php';
	$p = httpGetVal('p');

	if (empty($p) && !empty($common_area_sign))
	{
		$p = $common_area_sign;
	}

	if (empty($p) || empty($platform_map) || empty($platform_map[$p]))
	{
		show_error('param error -- p');
	}

	$platform_title = $platform_map[$p]['title'];
	$domain = $platform_map[$p]['domain'];
	$https_domain = isset($platform_map[$p]['https_domain']) ?$platform_map[$p]['https_domain'] : '';
	
	$home_url = 'http://'.WEB_SIGN.$domain.'/global/index.php?auth_user='.$auth_user.'&auth_sign='.$auth_sign;
	$main_url = 'http://'.WEB_SIGN.$domain.'/global/main.php?auth_user='.$auth_user.'&auth_sign='.$auth_sign;
	$smarty->assign("home_url", $home_url, true);
	$smarty->assign("main_url", $main_url, true);

	$ios_pl = 'pl';
	$ios_pl_map = array();
	$ios_pl_map['ios'] = 'pl2';
	$ios_pl_map['quickios'] = 'pl2';
	$ios_pl_map['ttzrios'] = 'pl2';
	$ios_pl_map['sywj'] = 'pl2';
	$ios_pl_map['yhzj'] = 'pl2';
	$ios_pl_map['lqcs'] = 'pl2';
	$ios_pl_map['lmqs'] = 'pl2';
	$ios_pl_map['qtld'] = 'pl2';

	$ios_pl_map['ru'] = 'pl2';
	$ios_pl_map['eu'] = 'pl2';
	$ios_pl_map['br'] = 'pl2';
	$ios_pl_map['sgp'] = 'pl2';
	$ios_pl_map['ar'] = 'pl2';
	$ios_pl_map['na'] = 'pl2';
	$ios_pl_map['kr'] = 'pl2';

	if (!empty($ios_pl_map) && isset($ios_pl_map[$p]))
	{
		$ios_pl = $ios_pl_map[$p];
	}

	$smarty->assign("ios_pl", $ios_pl, true);

	$smarty->assign("https_domain", $https_domain, true);
	$smarty->assign("domain", $domain, true);
	$smarty->assign("cur_date", date('Y-m-d H:i:s'), true);
	$smarty->assign("remote_ip", $_SERVER["REMOTE_ADDR"], true);
	$smarty->assign("name", '版本及服务器列表查看', true);
	$smarty->display('servinfoAndList.tpl');
?>
