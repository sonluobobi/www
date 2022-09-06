<?php
	require 'common.php';
	require 'base.php';

	$server_list = array();
	//获取pk服信息
	$server_list = getPkList($domain);

	$smarty->assign("option_values", array_keys($server_list));
	$smarty->assign("option_output", array_values($server_list));
	$smarty->assign('server_list', format_map($server_list));

	$retmsg = '';
	$sysinfo = array();

	$server_url = 'http://pkadmin' . $domain.'/interface_mobile.php';
	$curl_api = new KunlunRestClient(TOKENKEY, $server_url);
	//$method = 'getOnlinePlayerNum';
	$method = 'pkconfig';
	$params = array();
	$result = $curl_api->call_method($method, $params);
	$tmp = array();
	$tmp['var'] = $name;

	if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
	{
		$data = $result['data'];
		foreach($data as $detail)
		{
			$info = $detail['info'];
			$id = $detail['id'];
			$ip = $detail['ip'];
			$title = $detail['title'];
		}
	}
	else
	{
		$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'try again';
	}

	$smarty->assign("list", $data);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('pkconfig.tpl');