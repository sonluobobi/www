<?php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	$desc_msg = '';
	$retmsg = '';
	$data_list = array();
	$cid = httpGetVal('cid');
	$equip_id = httpGetVal('equip_id');
	$equip_num = httpGetVal('equip_num');
	
	$equip_num = intval($equip_num);
	$equip_num < 1 && $equip_num = 1;

	if (!empty($do_search) && $do_search == 'do')
	{
		try {
			if (empty($server_id) || !isset($server_list[$server_id]))
			{
				throw new Exception('请选择游戏服');
			}

			$cid = intval($cid);

			if (empty($cid) || $cid < 1)
			{
				throw new Exception('角色id，必须为正整数');
			}

			$equip_id = intval($equip_id);

			if (empty($equip_id) || $equip_id < 1)
			{
				throw new Exception('道具id，必须为正整数');
			}

			$server_url_list = getAllServerListForSx();
			$server_url = $server_url_list[$server_id];

			$server_url = $server_url. SERVER_FOR_BACKEND . '?c=ToolsEquip&a=addEquip';
			$server_url = $server_url . "&cid=$cid&equip_id=$equip_id&equip_num=$equip_num";
			$result = func_requestUrl($server_url, false, 1);

			if (!empty($result) && $result['retcode']==0)
			{
				$retmsg = '操作成功';
			}
			else
			{
				$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '请重试';
			}

		} catch (Exception $e) {
			$retmsg = $e->getMessage();
		}
	}

	$caption = '角色发道具';
	$smarty->assign('desc_msg', $retmsg, true);
	$smarty->assign('caption', $caption, true);
	$smarty->assign("cid", $cid);
	$smarty->assign("equip_id", $equip_id);
	$smarty->assign("equip_num", $equip_num);

	$smarty->display('addEquip.tpl');

?>



