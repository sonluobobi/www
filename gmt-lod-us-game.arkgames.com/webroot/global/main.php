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
	$home_url = 'http://'.WEB_SIGN.$domain.'/global/index.php?auth_user='.$auth_user;

	$smarty->assign("cur_date", date('Y-m-d H:i:s'), true);
	$smarty->assign("remote_ip", $_SERVER["REMOTE_ADDR"], true);
	$smarty->assign("home_url", $home_url, true);
	$smarty->assign("name", $platform_title, true);
	$smarty->assign("domain", $domain, true);
	$smarty->assign("p", $p, true);
	$smarty->assign("web_sign", WEB_SIGN, true);
	$smarty->assign("menu_map", array_values($menu_map));
	$smarty->display('main.tpl');
?>