<?php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	require CURRENT_PATH . '/configs/config_gm_cmd.php';
	
	$desc_msg = '';
	$retmsg = '';
	$data_list = array();
	$player_id = httpGetVal('player_id');
	$command = httpGetVal('command');

	if (!empty($do_search) && $do_search == 'do')
	{
		try {
			if (empty($server_id) || !isset($server_list[$server_id]))
			{
				throw new Exception('请选择游戏服');
			}

			$player_id = intval($player_id);

			if (empty($player_id) || $player_id < 1)
			{
				throw new Exception('账号id，必须为正整数');
			}

			if (empty($command))
			{
				throw new Exception('命令不能为空');
			}

			$server_url_list = getAllServerListForSx();
			$server_url = $server_url_list[$server_id];

			$proto_data = array();
			$proto_data['player_id'] = $player_id;

			//去掉多余的空格
			$command = preg_replace ( "/\s(?=\s)/","\\1", $command );

			$command_arr = explode(' ', $command);
			$method = $command_arr[0];
			$method = trim($method, './');
			$params1 = isset($command_arr[1]) ? trim($command_arr[1]) : '';
			$params2 = isset($command_arr[2]) ? trim($command_arr[2]) : '';
			$params3 = isset($command_arr[3]) ? trim($command_arr[3]) : '';
			$params4 = isset($command_arr[4]) ? trim($command_arr[4]) : '';

			$proto_data['method'] = $method;

			$command = './'.$method;
			$params_arr = array();

			if ('' !== $params1)
			{
				$command .= ' '. $params1;
				$params_arr[] = $params1;
				
				if ('' !== $params2)
				{
					$command .= ' '. $params2;
					$params_arr[] = $params2;

					if ('' !== $params3)
					{
						$command .= ' '. $params3;
						$params_arr[] = $params3;

						if ('' !== $params4)
						{
							$command .= ' '. $params4;
							$params_arr[] = $params4;
						}
					}
				}
			}

			if (!empty($params_arr))
			{
				$proto_data['params_arr'] = $params_arr;
			}

			$result = rpcRequestWebProxy($server_url,'backendGM', $proto_data);
			//print_r($result);

			empty($result) && $result = array();
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '请重试';

		} catch (Exception $e) {
			$retmsg = $e->getMessage();
		}
	}

	$caption = 'GM指令';
	$smarty->assign('desc_msg', $retmsg, true);
	$smarty->assign('caption', $caption, true);
	$smarty->assign("player_id", $player_id);
	$smarty->assign("command", $command);
	$smarty->assign('data_list', $gm_func_list);

	$smarty->display('gm.tpl');

?>



