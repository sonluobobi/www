<?php
	require 'common.php';
	//$do_format_ip = true;
	require 'base.php';

	$caption = '今日crontab检查 --' . date('Y-m-d H:i');
	$caption .= '-- 正确的配置如 <br>';
	$caption .= '00 05 * * 4 root /data/moyu/s11/bin/exit_servers.lua <br>';
	$caption .= '55 05 * * 4 root /data/moyu/s11/bin/run_servers.lua <br>';


	//获取pk服信息
	$pk_list = getPkList($domain);

	if (!empty($pk_list))
	{
		$server_list = array_merge($server_list, $pk_list);

		$smarty->assign("option_values", array_keys($server_list));
		$smarty->assign("option_output", array_values($server_list));
	}
	
	
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
			$method = 'GameTools.checkCrontab';
			$params = array();
			$result = $curl_api->call_method($method, $params);
			$tmp = array();
			$tmp['var'] = $name;

			if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
			{
				$data = $result['data'];
				$base_str_one = '00 05 * * 4 root /data/moyu/'.$sx.'/bin/exit_servers.lua';
				$base_str_two = '55 05 * * 4 root /data/moyu/'.$sx.'/bin/run_servers.lua';

				$do_warning = false;
				$ret_one = stripos($data, $base_str_one);

				$ret_one === false && $do_warning = true;

				if (!$do_warning)
				{
					$ret_two = stripos($data, $base_str_two);
					$ret_two === false && $do_warning = true;
				}

				if ($do_warning)
				{
					$data = '<span style="color:#f00;">'.$data.'</span>';
				}

				$tmp['txt'] = $data;
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
