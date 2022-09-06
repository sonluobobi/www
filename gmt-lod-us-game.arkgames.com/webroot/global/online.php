<?php
	require 'common.php';
	require 'base.php';

	//获取pk服信息
	$pk_list = getPkList($domain);

	if (!empty($pk_list))
	{
		$server_list = array_merge($server_list, $pk_list);

		$smarty->assign("option_values", array_keys($server_list));
		$smarty->assign("option_output", array_values($server_list));
	}
	
	$begin_date = httpGetVal('begin_date');
	$cur_date = date('Y-m-d');
	empty($begin_date) && $begin_date = $cur_date;

	$online_list = array();
	$online_cnt = '';
	$retmsg = '';

	if (!empty($do_search) && $do_search == 'do')
	{
		//查询操作
		$curl_api = new KunlunRestClient(TOKENKEY, $server_url);
		$method = 'GameTools.getOnlineDataAll';
		$params = array();
		$params['date'] = $begin_date;
		$result = $curl_api->call_method($method, $params);

		if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
		{
			$data = $result['data'];
			$online_cnt = !empty($data['online_cnt']) ? $data['online_cnt'] : 0;

			if (!empty($data['online_data']))
			{
				$hour_data = array();
				$hour_limit = 23;

				if ($begin_date == $cur_date)
				{
					$hour_limit = date('H');
				}

				for($i=0; $i<=$hour_limit; $i++)
				{
					$hour_data[$i] = array('online_num' => 0, 'count' => 0);
				}

				foreach($data['online_data'] as $t => $num)
				{
					$hour = intval(date('H', $t));
					$hour_data[$hour]['online_num'] += $num;
					$hour_data[$hour]['count']++;
				}

				krsort($hour_data);

				foreach($hour_data as $h => $info)
				{
					$tmp = array();
					$tmp['t'] = $h;
					$tmp['cnt'] = 0;
					$info['count'] > 0 && $tmp['cnt'] = intval($info['online_num']/$info['count']);
					$online_list[] = $tmp;
				}
			}
		}
		else
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'try again';
		}
	}

	$smarty->assign("online_list", $online_list);
	$smarty->assign("online_cnt", $online_cnt, true);
	$smarty->assign("begin_date", $begin_date, true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('online.tpl');
?>
