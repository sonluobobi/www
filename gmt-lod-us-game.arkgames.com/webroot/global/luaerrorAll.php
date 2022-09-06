<?php
	require 'common.php';
	require 'base.php';

	//*
	//获取pk服信息
	$pk_list = getPkList($domain);

	if (!empty($pk_list))
	{
		$server_list = array_merge($server_list, $pk_list);

		$smarty->assign("option_values", array_keys($server_list));
		$smarty->assign("option_output", array_values($server_list));
	}
	//*/
	
	$lua_error_num = 2; //最近几天有修改的
	$retmsg = '';
	$sysinfo = array();

	if (!empty($server_list))
	{
		$j = 1;

		foreach($server_list as $sx => $name)
		{
			$server_url = 'http://'.$sx . $domain.'/platform/index.php';
			$curl_api = new KunlunRestClient(TOKENKEY, $server_url);
			$method = 'GameTools.getLuaErrorFile';
			
			$params = array();
			$params['num'] = $lua_error_num; 
			$result = $curl_api->call_method($method, $params);

			if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
			{
				$data = $result['data'];

				if (count($data) > 1)
				{
					usort($data, function($a, $b){
						return $a['update'] < $b['update'];
					});
				}

				$tmp = array();
				$tmp['id'] = $j;
				$tmp['server_id'] = $sx;
				$tmp['server_name'] = $name;
				$tmp['info'] = $data;
				$j++;
				$sysinfo[] = $tmp;
			}
		}
	}
	
	$smarty->assign("server_id", $server_id, true);
	$smarty->assign("list", $sysinfo);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('luaerrorAll.tpl');