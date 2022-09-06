<?php
	require 'common.php';
	$do_format_ip = true;
	require 'base.php';

	$default_hosts = array('140.143.179.64 region.kunlun.com', '140.143.217.143 api.kunlun.com');

	$platform_hosts_map = array(
		'sgp' => array('52.76.31.35 sgp.global.region.koramgame.com', '34.233.222.53 en.api.koramgame.com'),
		'eu' => array('52.28.156.98 eu.global.region.koramgame.com','34.233.222.53 en.api.koramgame.com'),
		'tw' => array('203.75.148.214 region.kimi.com.tw','184.173.135.201 tw.api.koramgame.com'),
		'tw2' => array('203.75.148.214 region.kimi.com.tw','184.173.135.201 tw.api.koramgame.com'),
		'en' => array('34.232.143.239 en.global.region.koramgame.com','34.233.222.53 en.api.koramgame.com'),
		'na' => array('184.173.135.205 en1.global.region.koramgame.com','34.233.222.53 en.api.koramgame.com'),
		'kr' => array('121.78.63.250 korea.region.koramgame.com','34.233.222.53 en.api.koramgame.com'),
		'ru' => array('52.28.156.98 ru.global.region.koramgame.com','34.233.222.53 en.api.koramgame.com'),
		'zh' => $default_hosts,
		'ios' => $default_hosts,
		'yyb' => $default_hosts,
		'ttzrios' => $default_hosts,
		'lqcs' => $default_hosts,
		'lmqs' => $default_hosts,
		'br' => array('54.94.185.145 br.global.region.koramgame.com', '34.233.222.53 en.api.koramgame.com'),
		'th' => array('103.29.189.182 region.siamgame.in.th', '103.29.189.38 api.siamgame.in.th'),
		'na' => array('34.232.143.239 en.global.region.koramgame.com', '34.233.222.53 en.api.koramgame.com'),
		'jp' => array('52.193.126.136 region.koramgame.co.jp','52.193.126.136 api.m.koramgame.co.jp'),
		'ar' => array('52.28.156.98 eu.global.region.koramgame.com', '34.233.222.53 en.api.koramgame.com'),
	);

	$p = httpGetVal('p');

	if (empty($p) && !empty($common_area_sign))
	{
		$p = $common_area_sign;
	}

	if (empty($p) || empty($platform_map) || empty($platform_map[$p]))
	{
		show_error('param error -- p');
	}

	$platform_hosts = isset($platform_hosts_map[$p]) ? $platform_hosts_map[$p] : '';
	$caption = '今日host检查 --' . date('Y-m-d H:i');
	$base_str_one = $base_str_two = '';

	if (!empty($platform_hosts))
	{
		$base_str_one = $platform_hosts[0];
		$base_str_two = $platform_hosts[1];
		$caption .= ' -- 正确的配置如 <br>';
		$caption .= $base_str_one . '<br>';
		$caption .= $base_str_two . '<br>';
	}
	else
	{
		$caption .= ' -- 还未配置正确的hosts';
	}

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
			$method = 'GameTools.checkHosts';
			$params = array();
			$result = $curl_api->call_method($method, $params);
			$tmp = array();
			$tmp['var'] = $name;

			if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
			{
				$data = $result['data'];
				$do_warning = true;
				$ret_one = stripos($data, $base_str_one);

				$ret_one !== false && $do_warning = false;

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
