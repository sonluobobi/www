<?php 
	//openFunc.php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	$log_folder = 'hefu_clear';
	$retmsg = '';
	$desc_msg = '备注:功能开放对应的任务id or等级。1000以上为任务，1000以下为等级';
	$data_list = array();
	
	if (!empty($do_search) && $do_search == 'do')
	{
		try {
			if (empty($server_id) || !isset($server_list[$server_id]))
			{
				throw new Exception('请选择游戏服');
			}

			$server_url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=Server&a=OpenFuncList';
			$result = func_requestUrl($server_url, true, 3);

			if (!empty($result) && $result['retcode']==0)
			{
				$data_list = $result['data'];
			}
			else
			{
				$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '请重试';
			}

		} catch (Exception $e) {
			$retmsg = $e->getMessage();
		}
	}
	
	$caption = '功能开关列表';
	$smarty->assign('desc_msg', $desc_msg, true);
	$smarty->assign('caption', $caption, true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->assign('sysinfo', $data_list);
	$smarty->display('openFunc.tpl');