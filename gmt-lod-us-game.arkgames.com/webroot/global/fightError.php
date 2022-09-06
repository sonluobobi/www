<?php
//mapServerLog.php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	$caption = '查看战斗错误日志 --' . date('Y-m-d H:i');
	$platform_config_file  = CURRENT_PATH . '/configs/platform.php';

	if (file_exists($platform_config_file))
	{
		include $platform_config_file;
	}
	
	/*
	//获取pk服信息
	$pk_list = getPkList($domain);

	if (!empty($pk_list))
	{
		$global_pk_list = getGlobalPkList($domain);
		if (!empty($global_pk_list))
		{
			$pk_list += $global_pk_list;
		}

		if (!empty($platform_pk_test_map) && !empty($platform_pk_test_map[$p]))
		{
			$pk_list += $platform_pk_test_map[$p];
		}

		$server_list = array_merge($server_list, $pk_list);

		$smarty->assign("option_values", array_keys($server_list));
		$smarty->assign("option_output", array_values($server_list));
	}
	//*/
	
	$retmsg = '';
	$log_folder = 'fight_error';
	$sysinfo = array();
	$total=0;

	if (!empty($do_search))
	{
		ini_set('memory_limit', '512M');

		//查询操作
		$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=ServerLog&a=FightError';
		$log_msg = 'url='. $url;
		do_log($log_msg, $log_folder, $log_folder);
		$result = func_requestUrl($url, true, 3);

		if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
		{
			$data = $result['data'];
			$file_sign_arr = array();

			foreach($data as $k => $detail)
			{
				$filename = trim($detail['filename']);
				$file_sign = strstr($filename, 'log', true);
				$file_sign = trim($file_sign, '.');
				$file_sign_arr[$file_sign][] = $detail;
				$total++;
			}

			ksort($file_sign_arr);

			foreach($file_sign_arr as $_file_sign => $_item)
			{
				$tmp_sign = str_replace('.', '', $_file_sign);
				$tmp = array();
				$tmp['id'] = $tmp_sign;
				$sysinfo[] = $tmp;

				foreach($_item as $detail)
				{
					$tmp = array();
					$tmp['pid'] = $tmp_sign;
					$tmp['filename'] = $detail['filename'];
					$tmp['size'] = $detail['size'];
					$tmp['update'] = $detail['update'];
					$sysinfo[] = $tmp;
				}
			}
		}
		else
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '没有数据';
		}

		$result = null;		
	}
	
	$smarty->assign("server_id", $server_id, true);
	$smarty->assign("sysinfo", $sysinfo);
	$smarty->assign("total", $total);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->assign('caption', $caption);
	$smarty->display('fightError.tpl');