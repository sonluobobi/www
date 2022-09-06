<?php

require ROOT_PATH . '/lib/restClient/kunlunapi_php5_restlib.php';
$hide_test = true;
!empty($config_show_test) && $hide_test = false;

if ($do_format_ip)
{
	$server_list = getServerListForSelectPerIp($hide_test);
}
else
{
	$server_list = getServerListForSelect($hide_test);
}

if (empty($server_list))
{
	show_error('SERVER_CENTER_INI is not right');
}

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

$home_url = 'http://'.WEB_SIGN.$domain.'/global/index.php?auth_user='.$auth_user.'&auth_sign='.$auth_sign;
$main_url = 'http://'.WEB_SIGN.$domain.'/global/main.php?auth_user='.$auth_user.'&auth_sign='.$auth_sign;

$server_id = httpGetVal('server_id');

if ($server_id)
{
	$server_url = 'http://'.$server_id . $domain.'/platform/index.php';
}

$do_search = httpGetVal('do_search');

$smarty->assign("name", $platform_title, true);
$smarty->assign("home_url", $home_url, true);
$smarty->assign("main_url", $main_url, true);
$smarty->assign("domain", $domain, true);
$smarty->assign("option_values", array_keys($server_list));
$smarty->assign("option_output", array_values($server_list));
$smarty->assign("option_selected", $server_id, true);

$server_selected = !empty($server_list[$server_id]) ? $server_list[$server_id] : '';
$smarty->assign("server_selected", $server_selected, true);
