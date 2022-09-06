<?php
	require 'common.php';
	require 'base.php';

	//*
	//获取pk服信息
	$pk_list = getPkList($domain);

	if (!empty($pk_list))
	{
		$server_list = array_merge($server_list, $pk_list);
		$global_pk_list = getGlobalPkList($domain);
		if (!empty($global_pk_list))
		{
			$server_list += $global_pk_list;
		}
		
		$smarty->assign("option_values", array_keys($server_list));
		$smarty->assign("option_output", array_values($server_list));
	}
	//*/
	
	$retmsg = '';
	$sysinfo = array();
	$content = '';
	$log_folder = 'pk_conf';

	if (!empty($do_search) && $do_search == 'do')
	{
		//查询操作
		//$content = 'test';
		if (empty($server_id) || !isset($server_list[$server_id]))
		{
			throw new Exception('请选择游戏服');
		}

		$server_name = $server_list[$server_id];

		$server_url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=Pk&a=Crontab';
		$log_msg = 'server='. $server_name . ' -- url='. $server_url;
		do_log($log_msg, $log_folder, $log_folder);

		$result = func_requestUrl($server_url, true, 3);

		if (!empty($result) && $result['retcode']==0)
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作成功';
			
			if (!empty($result['data']))
			{	
				$content = $result['data'];
				$content = implode("<br>", $content);
				$content = str_replace("\r\n", '<br>', $content);
			}
		}
		else
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'no data';
		}
	}
	
	$caption = '查看定时任务';
	$smarty->assign('caption', $caption, true);

	$smarty->assign("server_id", $server_id, true);
	$smarty->assign("content", $content);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('pkconf.tpl');