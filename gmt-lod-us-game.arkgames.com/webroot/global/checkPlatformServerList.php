<?php
	require 'common.php';
	require 'base.php';

	$caption = '今日平台服务器列表检查 --' . date('Y-m-d H:i');
	$caption .= '-- 正确的配置如 <br>';
	$caption .= '游戏服命名规则，T|s+数字+空格+游戏名<br>';
	$caption .= '游戏服登录链接规则，http://s+大区id取模1000+基础域名<br>';
	$caption .= '游戏服充值接口规则，http://game-serv-s+大区id取模1000+基础域名+/web/web_app/index.php<br>';

	$server_list = array();
	
	if (defined('SERVER_LIST') && file_exists(SERVER_LIST))
	{
		$server_list = require SERVER_LIST;
	}
	
	$retmsg = '';
	$list = array();

	if (!empty($server_list))
	{
		foreach($server_list as $_server_id => $_info)
		{
			$tmp_server_id = intval($_server_id % 1000);
			$tmp_url = !empty($_info['server_url']) ? trim($_info['server_url']) : '';
			'' == $tmp_url && $tmp_url = 's'.$tmp_server_id.$domain;
			
			$server_date = !empty($_info['server_date']) ? trim($_info['server_date']) : '';

			$ret_tmp = array();
			$ret_tmp['server_id'] = $_server_id;
			$ret_tmp['server_date'] = $server_date;
			$ret_tmp['base_domain'] = $tmp_url;
			$info = array();

			//检查游戏名称
			$server_name = !empty($_info['server_name']) ? trim($_info['server_name']) : '';
			$tmp = array();
			$tmp['var'] = '游戏名[server_name]';
			$tmp_server_name_arr = explode(' ',$server_name);

			if (empty($tmp_server_name_arr) || count($tmp_server_name_arr) < 2)
			{
				$server_name = '<span style="color:#f00;">'.$server_name.'</span>';
			}
			else
			{
				$tmp_sx = ucfirst(substr($tmp_server_name_arr[0], 0 ,1));

				if (!('T' == $tmp_sx || 'S' == $tmp_sx))
				{
					$server_name = '<span style="color:#f00;">'.$server_name.'</span>';
				}
			}
			
			$tmp['txt'] = $server_name;
			$info[] = $tmp;

			//检查充值接口
			$interface_url = 'http://game-serv-'.$tmp_url.'/web/web_app/index.php';
			$server_interface_url = !empty($_info['server_interface_url']) ? trim($_info['server_interface_url']) : '';
			$tmp = array();
			$tmp['var'] = '充值接口[server_interface_url]';

			if ($server_interface_url != $interface_url)
			{
				$server_interface_url = '<span style="color:#f00;">'.$server_interface_url.'</span>';
			}

			$tmp['txt'] = $server_interface_url;
			$info[] = $tmp;

			$region_interface_url = !empty($_info['region_interface_url']) ? trim($_info['region_interface_url']) : '';
			$tmp = array();
			$tmp['var'] = '充值接口[region_interface_url]';

			if ($region_interface_url != $interface_url)
			{
				$region_interface_url = '<span style="color:#f00;">'.$region_interface_url.'</span>';
			}

			$tmp['txt'] = $region_interface_url;
			$info[] = $tmp;

			//检查ip
			$server_ip = !empty($_info['server_ip']) ? trim($_info['server_ip']) : '';
			$real_ip = gethostbyname($tmp_url);

			if('127.0.0.1' == $real_ip || stripos($real_ip,'10.') === 0 || stripos($real_ip,'192.168.') === 0)
			{
				$real_ip = $_SERVER['SERVER_ADDR'];
			}

			$tmp = array();
			$tmp['var'] = '游戏服ip[server_ip]';

			if ($server_ip != $real_ip)
			{
				$server_ip = '<span style="color:#f00;">platform='.$server_ip.'|check='.$real_ip.'</span>';
			}

			$tmp['txt'] = $server_ip;
			$info[] = $tmp;

			$region_ip = !empty($_info['region_ip']) ? trim($_info['region_ip']) : '';
			$tmp = array();
			$tmp['var'] = '游戏服ip[region_ip]';

			if ($region_ip != $real_ip)
			{
				$region_ip = '<span style="color:#f00;">platform='.$region_ip.'|check='.$real_ip.'</span>';
			}

			$tmp['txt'] = $region_ip;
			$info[] = $tmp;

			//检查登录url
			$server_login_url = !empty($_info['login_url']) ? trim($_info['login_url']) : '';
			$real_login_url = 'http://'.$tmp_url;

			$tmp = array();
			$tmp['var'] = '游戏服登录url[login_url]';
			
			if ($server_login_url != $real_login_url)
			{
				$server_login_url = '<span style="color:#f00;">'.$server_login_url.'</span>';
			}

			$tmp['txt'] = $server_login_url;
			$info[] = $tmp;

			//游戏服及充值状态
			$tmp = array();
			$tmp['var'] = '游戏服及充值状态';
			$check_status = 'server_status='.$_info['server_status'].'|vouch_status='.$_info['vouch_status'].'|active_status='.$_info['active_status'];

			$tmp['txt'] = $check_status;
			$info[] = $tmp;

			//其他
			$tmp = array();
			$tmp['var'] = '其他';
			$check_other = 'show_seque='.$_info['show_seque'].'|is_recommend='.$_info['is_recommend'];

			$tmp['txt'] = $check_other;
			$info[] = $tmp;

			$ret_tmp['info'] = $info;

			$list[] = $ret_tmp;
		}
	}
	else
	{
		$retmsg = '目前没有开服的服务器列表';
	}

	$smarty->assign('caption', $caption);
	$smarty->assign("list", $list);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('checkPlatformServerList.tpl');
?>
