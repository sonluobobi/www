<?php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	$platform_config_file  = CURRENT_PATH . '/configs/platform.php';

	if (file_exists($platform_config_file))
	{
		include $platform_config_file;
	}
	
	//*
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
	
	$lua_error_num = 50; //查看文件条数
	$retmsg = '';
	$sysinfo = array();

	if (!empty($do_search) && $do_search == 'do')
	{
		//查询操作
		$filename = httpGetVal('filename');
		$curl_api = new KunlunRestClient(TOKENKEY, $server_url);
		$method = 'GameTools.getLuaError';
		$params = array();
		$params['num'] = $lua_error_num; 
		$filename && $params['filename'] = $filename;

		$result = $curl_api->call_method($method, $params);

		if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
		{
			$data = $result['data'];

			if ($filename)
			{
				$data = $filename. '<br>' . $data;
				die($data);
			}

			$i=1;

			foreach($data as $k => $detail)
			{
				$tmp = array();
				$tmp['id']=$i;
				$tmp['filename'] = $detail['filename'];
				$tmp['size'] = $detail['size'];
				$tmp['update'] = $detail['update'];
				$i++;
				$sysinfo[] = $tmp;
			}
		}
		else
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'no data';
		}

		if ($filename)
		{
			$retmsg = $filename. '<br>' . $retmsg;
			die($retmsg);
		}

	}
	
	$smarty->assign("server_id", $server_id, true);
	$smarty->assign("sysinfo", $sysinfo);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('luaerror.tpl');