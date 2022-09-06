<?php
	require 'common.php';
	require 'base.php';

	$caption = '合过服的服务器列表 --' . date('Y-m-d H:i');

	$server_list = getOpenServerList();
	
	$retmsg = '';
	$list = array();

	if (!empty($server_list))
	{
		foreach($server_list as $_server_id => $_info)
		{
			$tmp_server_id = intval($_server_id % 1000);
			$tmp_sx = 's'.$tmp_server_id;
			$server_url = !empty($_info['server_url']) ? trim($_info['server_url']) : '';
			$sx = strstr($server_url, '.', true);

			if (ucfirst(substr($_info['server_name'], 0 ,1)) != 'T' && $sx != $tmp_sx)
			{
				$tmp = array();
				$tmp['var'] = $_info['server_name']. ' -- ' . $_server_id;
				$msg_txt =  $_info['server_date'] . ' -- ' .  $_info['server_url'] . ' -- '. $_info['server_ip'];
				$tmp['txt'] = $msg_txt;

				$list[] = $tmp;
			}
		}
	}

	empty($list) && $retmsg = '目前合过服的服务器列表';

	$smarty->assign('caption', $caption);
	$smarty->assign("base_list", $list);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('base_list.tpl');
?>
