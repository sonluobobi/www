<?php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	$desc_msg = '';
	$retmsg = '';
	$data_list = array();
	$player_id = httpGetVal('player_id');

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

			$server_url_list = getAllServerListForSx();
			$server_url = $server_url_list[$server_id];

			$server_url = $server_url. SERVER_FOR_BACKEND . '?c=Search&a=PlayerBase&pid='.$player_id;
			$result = func_requestUrl($server_url, true, 3);

			//echo "<pre>";print_r($result);

			if (!empty($result) && $result['retcode']==0)
			{
				$data_list = $result['data'];
			}
			else
			{
				$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '请重试';
			}

		} catch (Exception $e) {
			$retmsg = $e->getMessage();
		}
	}

	$caption = '查询角色';
	$smarty->assign('desc_msg', $retmsg, true);
	$smarty->assign('caption', $caption, true);
	$smarty->assign('data_list', $data_list);
	$smarty->assign("player_id", $player_id);

	$smarty->display('searchRole.tpl');

?>



