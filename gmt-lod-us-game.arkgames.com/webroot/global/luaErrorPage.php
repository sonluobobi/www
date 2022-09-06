<?php
	//luaErrorPage.php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	$caption = '查看lua_error单服 --' . date('Y-m-d H:i');
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

	if (!empty($do_search))
	{
		if ($do_search == 'search')
		{
			//查询操作
			$filename = httpGetVal('filename');

			if (empty($filename))
			{
				echo '<font color="red">参数错误 -- filename</font>';exit;
			}

			$content_id = httpGetVal('content_id');
			$content_id = intval($content_id);

			if ($content_id < 1)
			{
				echo '<font color="red">参数错误 -- content_id</font>';exit;
			}

			$end_line = httpGetVal('end_line');
			$end_line = intval($end_line);
			$end_line < 1 && $end_line = 0;

			$params = array();
			$params['num'] = $lua_error_num; 
			$params['filename'] = $filename;
			$params['end_line'] = $end_line;

			$params_str = http_build_query($params);
			$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=ServerLog&a=LuaErrorFileLines&'.$params_str;
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);
			$result = func_requestUrl($url, true, 3);

			if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
			{
				$data = $result['data'];
				$begin_line = intval($data['begin_line']);

				foreach($data['data'] as $k => $detail)
				{
					$retmsg .= $detail . "<br>";
				}

				//生成more 链接
				if ($begin_line > 1)
				{
					$new_end_line = $begin_line - 1;
					$more_div_id = 'more_'.$content_id.'_'.$new_end_line;
					$retmsg .= '<div id="'.$more_div_id.'"><a class="btn btn-default btn-lg active" role="button" href="javascript:showLuaErrorMore('."'$content_id','$more_div_id','$filename','$new_end_line'".');"><font color="red" size="3">更多</font></a></div>';
				}
			}
			else
			{
				$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'no data';
			}

			die($retmsg);
		}
		else
		{
			//查询操作
			$curl_api = new KunlunRestClient(TOKENKEY, $server_url);
			$method = 'GameTools.getLuaError';
			$params = array();
			$result = $curl_api->call_method($method, $params);

			if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
			{
				$data = $result['data'];
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
		}
	}
	
	$smarty->assign('caption', $caption);
	$smarty->assign("server_id", $server_id, true);
	$smarty->assign("sysinfo", $sysinfo);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('luaErrorPage.tpl');