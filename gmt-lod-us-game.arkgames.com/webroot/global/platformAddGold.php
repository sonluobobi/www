<?php 
	require 'common.php';
	require 'base.php';
	$php_self = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
	require 'checkLogin.php';

	$all_server_list = array('' => '全部') + $server_list;

	$smarty->assign("option_values", array_keys($all_server_list));
	$smarty->assign("option_output", array_values($all_server_list));

	$retmsg = '';
	$begin_date = httpGetVal('begin_date');
	empty($begin_date) && $begin_date = date('Y-m-d 00:00:00');

	$end_date = httpGetVal('end_date');
	empty($end_date) && $end_date = date('Y-m-d 23:59:59');

	$log_folder = 'platform_add_gold';

	$limit_date = '2016-12-20 00:00:00';
	$cur_date = date('Y-m-d H:i:s');

	if ($begin_date < $limit_date)
	{
		$retmsg = '开始日期不能小于 -- ' . $limit_date;
	}
	elseif ($begin_date >= $end_date)
	{
		$retmsg = '日期范围不正确';
	}
	elseif ($begin_date > $cur_date) 
	{
		$retmsg = '开始日期不能大于当前时间';
	}

	//验证日期格式
	$begin_date_time = @strtotime($begin_date);
	$end_date_time = @strtotime($end_date);

	if (!$begin_date_time)
	{
		$retmsg = '开始日期不正确';
	}

	if (!$end_date_time)
	{
		$retmsg = '结束日期不正确';
	}

	$begin_date = date('Y-m-d H:i:s', $begin_date_time);
	$end_date = date('Y-m-d H:i:s', $end_date_time);


	if ('' == $retmsg && !empty($do_search) && $do_search == 'do')
	{
		try {
			//追加指定时间内，不可重复执行,默认2分钟
			$cur_time = time();
			$limit_second = 3;

			$data_path = CURRENT_PATH. '/data/';
			!is_dir($data_path) && mkdir_recyle($data_path);

			$mark_file = $data_path . '/platform_add_gold_mark.php';
			$mark_time = 0;

			if (file_exists($mark_file))
			{
				$mark_time_int = include $mark_file;
				if (!empty($mark_time_int) && is_numeric($mark_time_int))
				{
					$mark_time = $mark_time_int;
				}
			}

			$limit_time = $mark_time + $limit_second*60;

			if ($cur_time < $limit_time)
			{
				throw new Exception("$limit_second 分钟内请勿重复执行");
			}
			else
			{
				$mark_msg = "<?php \r\n ";
				$mark_msg .= '//@' . $cur_date . "\r\n";
				$mark_msg .= "\r". ' return ' . $cur_time . ";\r\n";
				$mark_msg .= '?>';

				@file_put_contents($mark_file, $mark_msg);
				@chmod($mark_file, 0777);
			}

			if (!empty($server_id))
			{
				//单服
				$server_info = isset($server_list[$server_id]) ? $server_list[$server_id] : $server_id;
				$server_list = array();
				$server_list[$server_id] = $server_info;
			}
			
			$token = 's#2E1!m3Y';
			$t = time();
			$params = array();
			$params['begin_date'] = $begin_date;
			$params['end_date'] = $end_date;
			$params['t'] = $t;
			$params['s'] = md5($token.$t.$token); 
			$params['limit_second'] = $limit_second; //几分钟内不能重复执行
			$params_str = http_build_query($params);

			$log_msg = $auth_user .'--server_id='. $server_id. ' -- params='. $params_str;
			do_log($log_msg, $log_folder, $log_folder);

			foreach($server_list as $sx => $name)
			{
				$server_url = 'http://'.$sx . $domain.'/platform/platform_add_gold.php?' . $params_str;
				$log_msg = $auth_user .'--'. $server_url;
				do_log($log_msg, $log_folder, $log_folder);

				$content = @file_get_contents($server_url);
				$retmsg .= $name . ' -- ';
				$msg = '';

				if (!empty($content))
				{
					$result = json_decode($content, true);

					if (!empty($result))
					{
						$msg .= !empty($result['retmsg']) ? $result['retmsg'] : '';
						$msg .= ' -- ';

						if ($result['retcode']==0)
						{
							$msg .= '操作成功';
						}
						else
						{
							$msg .= '操作失败';
						}
					}
					else
					{
						$msg .= $content;
					}
				}
				else
				{
					$msg .= '没有回包';
				}

				$log_msg = $auth_user .'--'. $name . ' -- ' . $msg;
				do_log($log_msg, $log_folder, $log_folder);

				$retmsg .= $msg . '<br/>';
			}
			
		} catch (Exception $e) {
			$retmsg = $e->getMessage();
		}
	}
	
	//$smarty->assign('caption', '充值魔石获得失败补发');
	$smarty->assign('caption', '测试补发');
	
	$smarty->assign("begin_date", $begin_date, true);
	$smarty->assign("end_date", $end_date, true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('platformAddGold.tpl');