<?php 
	require 'common.php';
	require 'base.php';
	$php_self = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
	require 'checkLogin.php';

	$caption = '测试维护';
	$log_folder = 'weihu';
	$retmsg = '';

	$tmp_server_list = array('' => '所有') + $server_list;
	$smarty->assign("option_values", array_keys($tmp_server_list));
	$smarty->assign("option_output", array_values($tmp_server_list));

	if (!empty($do_search) && $do_search == 'do')
	{
		try {
			$handle = 'view';

			//查询操作

			if (!empty($server_id) && !isset($server_list[$server_id]))
			{
				throw new Exception('请选择游戏服');
			}

			$smarty->assign('show_set', true, true);

			if (($do_set = httpGetVal('do_set')) == 'do_set')
			{
				$handle = 'set';
			}

			//维护周期
			$param_week = httpGetVal('week');
			!is_numeric($param_week) && $param_week = 4;
			$week_map = array('星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');
			$smarty->assign("option_values_week", array_keys($week_map));
			$smarty->assign("option_output_weeek", array_values($week_map));
			$smarty->assign("option_selected_week", $param_week, true);

			//起止小时
			$hour_map = range(0,23);
			$smarty->assign("option_values_hour", array_keys($hour_map));
			$smarty->assign("option_output_hour", array_values($hour_map));

			$param_begin_hour = httpGetVal('begin_hour');
			//empty($param_begin_hour) && $param_begin_hour = 5;
			$smarty->assign("option_selected_begin_hour", $param_begin_hour, true);

			$param_end_hour = httpGetVal('end_hour');
			empty($param_end_hour) && $param_end_hour = 6;
			$smarty->assign("option_selected_end_hour", $param_end_hour, true);

			//起止分钟
			$minute_map = range(0,59);
			$smarty->assign("option_values_minute", array_keys($minute_map));
			$smarty->assign("option_output_minute", array_values($minute_map));

			$param_begin_minute = httpGetVal('begin_minute');
			empty($param_begin_minute) && $param_begin_minute = 0;
			$smarty->assign("option_selected_begin_minute", $param_begin_minute, true);

			$param_end_minute = httpGetVal('end_minute');
			empty($param_end_minute) && $param_end_minute = 0;
			$smarty->assign("option_selected_end_minute", $param_end_minute, true);

			$is_tmp_weihu = httpGetVal('is_tmp_weihu');
			if ($is_tmp_weihu)
			{
				$smarty->assign("is_tmp_weihu", $is_tmp_weihu, true);
			}

			if ('set' == $handle)
			{
				if ($param_begin_hour > $param_end_hour)
				{
					$error_msg = '参数错误 维护开始小时['.$param_begin_hour.'] > 维护结束小时['.$param_end_hour.']';
					throw new Exception($error_msg);
				}
				elseif ($param_begin_hour == $param_end_hour && $param_begin_minute >= $param_end_minute)
				{
					$error_msg = '参数错误 维护开始分钟['.$param_begin_minute.'] > 维护结束分钟['.$param_end_minute.']';
					throw new Exception($error_msg);
				}
			}


			$real_serverlist = array();

			if ($server_id)
			{
				$server_name = $server_list[$server_id];
				$real_serverlist[$server_id] = $server_name;
			}
			else
			{
				$server_name = 'all';
				$real_serverlist = $server_list;
			}

			$weihu_comm_url = $domain. SERVER_FOR_BACKEND . '?c=Config&a=WeiHu&handle='.$handle.'&auth='.$auth_user;

			if ('set' == $handle)
			{
				$param_str = '';
				$param_str .= '&weihu_week=' .$param_week;
				$param_str .= '&begin_hour=' .$param_begin_hour;
				$param_str .= '&end_hour=' .$param_end_hour;
				$param_str .= '&begin_minute=' .$param_begin_minute;
				$param_str .= '&end_minute=' .$param_end_minute;
				$is_tmp_weihu_str = $is_tmp_weihu ? 1 : 0;
				$param_str .= '&is_tmp_weihu=' . $is_tmp_weihu_str;

				$log_msg = $auth_user .' -- server='. $server_name . ' -- param_str='. $param_str;
				do_log($log_msg, $log_folder, $log_folder);

				$weihu_comm_url .= $param_str;
			}

			$data_list = array();
			foreach($real_serverlist as $_sign => $_server_name)
			{
				$server_url = $_sign . $weihu_comm_url;

				if ('set' == $handle)
				{
					$log_msg = $auth_user .' -- server='. $_server_name . ' -- url='. $server_url;
					do_log($log_msg, $log_folder, $log_folder);
				}

				$result = func_requestUrl($server_url, false, 3);

				if (!empty($result) && $result['retcode']==0)
				{
					$log_msg = !empty($result['retmsg']) ? $result['retmsg'] : '操作成功';
					
					if (!empty($result['data']))
					{	
						$ret_data = $result['data'];
						$ret_data['server'] = $_server_name;
						$data_list[] = $ret_data;
					}

					if ('set' == $handle)
					{
						$retmsg .= $_server_name . ' -- ' . $log_msg . "<br>";
					}
				}
				else
				{
					$log_msg = !empty($result['retmsg']) ? $result['retmsg'] : 'no ret';
					$retmsg .= $_server_name . ' -- ' . $log_msg . "<br>";
				}
			}

			if (!empty($data_list))
			{
				$titles = array();
				$tmp_one = $data_list[0];
				$keys = array_keys($tmp_one);

				foreach($keys as $key)
				{
					$tmp = array();
					$tmp['var'] = $key;
					$titles[] = $tmp;
				}

				$smarty->assign("titles", $titles);
				$smarty->assign("base_list", $data_list);
			}

			$data_title = $caption . ' -- ' . $server_name . ' -- ' . $handle;
			$smarty->assign('data_title', $data_title, true);
			
		} catch (Exception $e) {
			$retmsg = $e->getMessage();
		}
	}
	
	
	$smarty->assign('caption', $caption, true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('weihu.tpl');