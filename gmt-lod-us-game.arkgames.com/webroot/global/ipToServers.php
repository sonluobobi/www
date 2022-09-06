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
	
	$log_folder = 'ip_to_servers';
	$retmsg = '';
	$sysinfo = array();
	$ip_to_servers = array();
	//格式化，获取ip,跟域名对应关系
	if (!empty($server_list))
	{
		foreach($server_list as $_sx => $_str)
		{
			$str_arr = explode('--', $_str);
			$cnt = count($str_arr);
			$_server_ip = $str_arr[$cnt-2];
			$_server_url = $str_arr[$cnt-1];
			!isset($ip_to_servers[$_server_ip]) && $ip_to_servers[$_server_ip] = array();
			$ip_to_servers[$_server_ip][] = $_server_url;
		}

		$cnt = 0;

		foreach($ip_to_servers as $_ip => $_servers)
		{
			$tmp = array();
			$tmp['id']=$cnt;
			$tmp['ip'] = $_ip;

			$server_cnt = count($_servers);
			$tmp['server_cnt'] = $server_cnt;
			$tmp['real_cnt'] = $server_cnt;
			$server_cnt >= 4 && $tmp['server_cnt'] = '<span style="color:#f00;">'.$server_cnt.'</span>';

			$cnt++;
			$sysinfo[] = $tmp;
		}

		//排序
		usort($sysinfo, function($a, $b){return $a['real_cnt'] <= $b['real_cnt'];});
	}

	//echo '<pre>';print_r($ip_to_servers);exit;
	
	if (!empty($do_search) && $do_search == 'do')
	{
		//查询操作
		$ip = httpGetVal('ip');

		if (empty($ip) || !isset($ip_to_servers[$ip]))
		{
			throw new Exception('对应ip没有配置信息 -- ' .$ip);
		}

		$servers = $ip_to_servers[$ip];
		$format_data_str = '<table class="table table-condensed table-bordered">';
		$format_data_str .= '<tr>';
		$format_data_str .= '<td>域名</td>';
		$format_data_str .= '<td>总角色数</td>';
		$format_data_str .= '<td>总帐号数</td>';
		$format_data_str .= '</tr>';


		foreach($servers as $_server_url)
		{
			$format_data_str .= '<tr>';
			$log_msg = 'ip='. $ip . ' -- url='. $_server_url;
			do_log($log_msg, $log_folder, $log_folder);

			$total = 0;
			$format_data_str .= '<td class="active">'.$_server_url.'</td>';
			$pid_cnt = '--';

			if (stripos($_server_url,'pk') === false)
			{
				$server_url = $_server_url. SERVER_FOR_BACKEND . '?c=Db&a=GameInfo';
				$result = func_requestUrl($server_url, false, 3);

				if (!empty($result) && $result['retcode']==0)
				{
					if (!empty($result['data']))
					{
						$data = $result['data'];
						$cid_cnt = isset($data['cid_cnt']) ? $data['cid_cnt'] : ' -- ';
						$retmsg = $cid_cnt;
						isset($data['pid_cnt']) && $pid_cnt = $data['pid_cnt'];
					}
					else
					{
						$retmsg = 'empty';
					}
				}
				else
				{
					$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'fail';
				}
			}
			else
			{
				$retmsg = '--';
			}

			$format_data_str .= '<td class="active">'.$retmsg.'</td>';
			$format_data_str .= '<td class="active">'.$pid_cnt.'</td>';

			$format_data_str .= '</tr>';
		}

		$format_data_str .= '</table>'; 
		die($format_data_str);
	}
	
	$smarty->assign("sysinfo", $sysinfo);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->assign("cnt", $cnt, true);
	$smarty->display('ipToServers.tpl');