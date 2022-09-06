<?php
	require 'common.php';
	require 'base.php';

	//包含测试服
	$server_list = getAllServerListForSelect();
	$retmsg = '';
	$list = array();
	$https_base_domain = !empty($platform_map[$p]['https_domain']) ? $platform_map[$p]['https_domain'] : '';
	//$https_base_domain = '-moyu-ios.game.kunlun.com';

	if ('' == $https_base_domain)
	{
		$retmsg = '未配置https 一级域名';
	}
	else
	{
		function do_get_checkhttps($url)
		{
			$try_num= 3;
			$cnt = 0;
		    while($cnt < $try_num && ($result = @file_get_contents($url)) === false)
		    {
		    	$cnt++;
		    }

			return $result; 
		}

		$check_sign = 'pl';
		$name = '服务器列表加载域名';
		$url = 'http://'. $check_sign . $https_base_domain . '/t.php';
		$result = do_get_checkhttps($url);
		$txt_str = $url . '<br/>' . $result;

		$do_warning = true;
	    $base_path = '/data/moyu/www/' . $check_sign;
	    stripos($result, $base_path) !== false && $do_warning = false;

		if ($do_warning || empty($result))
		{
			$txt_str = '<span style="color:#f00;">'.$txt_str.'</span>';
		}

		$tmp = array();
		$tmp['var'] = $name;
		$tmp['txt'] = $txt_str;

		$list[] = $tmp;

		$check_sign = 'stats';
		$name = '统计日志上报域名';
		$url = 'http://'. $check_sign . $https_base_domain . '/t.php';
		$result = do_get_checkhttps($url);
		$txt_str = $url . '<br/>' . $result;

		$do_warning = true;
	    $base_path = '/data/moyu/www/' . $check_sign;
	    stripos($result, $base_path) !== false && $do_warning = false;

		if ($do_warning || empty($result))
		{
			$txt_str = '<span style="color:#f00;">'.$txt_str.'</span>';
		}

		$tmp = array();
		$tmp['var'] = $name;
		$tmp['txt'] = $txt_str;

		$list[] = $tmp;


		$check_sign = 'res';
		$name = '测试版资源加载域名';
		$url = 'http://'. $check_sign . $https_base_domain . '/config.txt?t='.time();
		$result = do_get_checkhttps($url);
		$txt_str = $url . '<br/>' . substr($result, 4, 20);

		if (empty($result))
		{
			$txt_str = '<span style="color:#f00;">'.$txt_str.'</span>';
		}

		$tmp = array();
		$tmp['var'] = $name;
		$tmp['txt'] = $txt_str;

		$list[] = $tmp;


		if (!empty($server_list))
		{
			//加载分页
			//require 'subpage.php';
			$try_num = 3;

			foreach($server_list as $sx => $name)
			{
				$url = 'http://'. $sx . $https_base_domain . '/t.php';

				$cnt = 0;
			    while($cnt < $try_num && ($result = @file_get_contents($url)) === false)
			    {
			    	$cnt++;
			    }

			    $do_warning = true;
			    $base_path = '/data/moyu/' . $sx . '/www/';
			    stripos($result, $base_path) !== false && $do_warning = false;

			    $txt_str = $url . '<br/>' . $result;

			    if ($do_warning || empty($result))
				{
					$txt_str = '<span style="color:#f00;">'.$txt_str.'</span>';
				}

				$tmp = array();
				$tmp['var'] = $name;
				$tmp['txt'] = $txt_str;

				$list[] = $tmp;
			}
		}
		else
		{
			$retmsg = '目前没有开服的服务器列表';
		}
	}

	$smarty->assign('caption', 'http连接检查');
	$smarty->assign("base_list", $list);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('base_list.tpl');