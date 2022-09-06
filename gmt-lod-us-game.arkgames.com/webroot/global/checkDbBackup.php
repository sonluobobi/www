<?php
	require 'common.php';
	require 'base.php';

	$caption = '今日游戏数据备份 --' . date('Y-m-d H:i');

	$server_list = getOpenServerListForSelect();

	/*
	//获取pk服信息
	$pk_list = getPkList($domain);

	if (!empty($pk_list))
	{
		$server_list = array_merge($server_list, $pk_list);

	}
	//*/
	
	$smarty->assign("option_values", array_keys($server_list));
	$smarty->assign("option_output", array_values($server_list));
	
	$retmsg = '';
	$list = array();

	if (!empty($server_list))
	{
		//加载分页
		require 'subpage.php';

		foreach($server_list as $sx => $name)
		{
			$server_url = 'http://'.$sx . $domain.'/platform/index.php';
			$curl_api = new KunlunRestClient(TOKENKEY, $server_url);
			$method = 'GameTools.getDbBackup';
			$params = array();
			$result = $curl_api->call_method($method, $params);
			$tmp = array();
			$tmp['var'] = $name;

			if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
			{
				$data = $result['data'];
				$tmp['txt'] = str_replace('|', '<br>', $data);
			}
			else
			{
				$tmp['txt'] = !empty($result['retmsg']) ? $result['retmsg'] : 'try again';
			}

			$list[] = $tmp;
		}
	}
	else
	{
		$retmsg = '目前没有开服的服务器列表';
	}

	$smarty->assign('caption', $caption);
	$smarty->assign("base_list", $list);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('base_list.tpl');
?>
