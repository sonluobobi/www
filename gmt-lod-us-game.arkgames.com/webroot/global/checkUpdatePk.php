<?php
	require 'common.php';
	require 'base.php';

	$server_list = array();
	//获取pk服信息
	$server_list = getPkList($domain);

	//加载分页
	require 'subpage.php';
			
	$retmsg = '';
	$sysinfo = array();

	foreach($server_list as $sx => $name)
	{
		$server_url = 'http://'.$sx . $domain.'/webproxy.php';
		$curl_api = new KunlunRestClient(TOKENKEY, $server_url);
		//$method = 'getOnlinePlayerNum';
		$method = 'checkUpdate';
		$params = array();
		$result = $curl_api->call_method($method, $params);
		$tmp = array();
		$tmp['var'] = $name;

		if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
		{
			$data = $result['data'];
			$tmp['txt'] = $data;
		}
		else
		{
			$tmp['txt'] = !empty($result['retmsg']) ? $result['retmsg'] : 'try again';
		}

		$sysinfo[] = $tmp;
	}
	
	$smarty->assign("sysinfo", $sysinfo);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('checkUpdate.tpl');