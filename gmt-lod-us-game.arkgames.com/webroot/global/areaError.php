<?php
	require 'common.php';
	require 'base.php';

	$caption = '竞技场异常数据';
	$retmsg = '';

	$op_map_selected = httpGetVal('op_type');
	empty($op_map_selected) && $op_map_selected = 0;
	$op_map = array('去重','不去重');

	$smarty->assign("op_map_values", array_keys($op_map));
	$smarty->assign("op_map_output", array_values($op_map));
	$smarty->assign("op_map_selected", $op_map_selected);
	$data_list = array();

	if (!empty($do_search))
	{
		//查询操作
		$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=ServerLog&a=AreaError&op_type='.$op_map_selected;
		$log_msg = 'url='. $url;
		do_log($log_msg, $log_folder, $log_folder);
		$result = func_requestUrl($url, true, 3);

		if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
		{
			$data = $result['data'];
			$i=1;

			foreach($data as $k => $detail)
			{
				$tmp = $detail;
				$tmp['id']=$i;

				$date_time = $detail['date_time'];


				$is_win = $detail['is_win'];
				$is_win = strtolower($is_win);
				if ($is_win == 'false')
				{
					$tmp['is_win_title'] = '失败';
				}
				else
				{
					$tmp['is_win_title'] = '胜利';
				}
				$i++;
				$data_list[] = $tmp;
			}
		}
		else
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作失败或超时';
		}		
	}

	$desc_msg = '每个30分钟缓存一次数据';

	$smarty->assign("desc_msg", $desc_msg, true);
	$smarty->assign("data_list", $data_list);
	$smarty->assign('domain', $domain);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->assign('caption', $caption, true);
	$smarty->display('areaError.tpl');
?>
