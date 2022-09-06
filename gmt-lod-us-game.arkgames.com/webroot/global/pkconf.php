<?php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	$platform_config_file  = CURRENT_PATH . '/configs/platform.php';

	if (file_exists($platform_config_file))
	{
		include $platform_config_file;
	}

	$server_list = getPkList($domain);
	$global_pk_list = getGlobalPkList($domain);
	if (!empty($global_pk_list))
	{
		$server_list += $global_pk_list;
	}

	if (!empty($platform_pk_test_map) && !empty($platform_pk_test_map[$p]))
	{
		$server_list += $platform_pk_test_map[$p];
	}
				
	$smarty->assign("option_values", array_keys($server_list));
	$smarty->assign("option_output", array_values($server_list));
	
	$retmsg = '';
	$sysinfo = array();
	$content = '';
	$log_folder = 'pk_conf';

	if (!empty($do_search) && $do_search == 'do')
	{
		//查询操作
		$content = 'test';
		if (empty($server_id) || !isset($server_list[$server_id]))
		{
			throw new Exception('请选择游戏服');
		}

		$server_name = $server_list[$server_id];

		$server_url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=Pk&a=Conf';
		$log_msg = 'server='. $server_name . ' -- url='. $server_url;
		do_log($log_msg, $log_folder, $log_folder);

		$result = func_requestUrl($server_url, true, 3);

		if (!empty($result) && $result['retcode']==0)
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作成功';
			
			if (!empty($result['data']))
			{	
				$content = $result['data'];
				$content = str_replace("\t", '&nbsp;&nbsp;', $content);
				$content = str_replace("\r\n", '<br>', $content);
			}
		}
		else
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'no data';
		}
	}
	
	$caption = 'pk服conf';
	$smarty->assign('caption', $caption, true);

	$smarty->assign("server_id", $server_id, true);
	$smarty->assign("content", $content);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('pkconf.tpl');