<?php
	require 'common.php';
	require 'base.php';

	$caption = '合服历史列表 --' . date('Y-m-d H:i');
	$retmsg = '';
	$history = array();

 	$all_servers = getAllServerIncludeHefu();
 	
 	if (!empty($all_servers))
 	{
 		$tmp_server = $all_servers;

 		foreach($all_servers as $server_id => $detail)
 		{
 			if (!empty($detail['to_region_id']))
 			{
 				$max_cnt = 50;
 				$cnt = 1;
 				$msg_txt = '';
 				$parent_list = array();
 				$tmp_server_id = $server_id;

 				while ($cnt < $max_cnt) {
	 				$tmp_ret = get_hefu_parent($tmp_server_id, $tmp_server);
 					
	 				if (!empty($tmp_ret))
	 				{
	 					$tmp_server_id = $tmp_ret['server_id'];

	 					if (isset($parent_list[$tmp_server_id]))
	 					{
	 						$msg_txt .= ' -> 出现死循环 -- ' .$tmp_server_id;
	 						break;
	 					}

	 					$parent_list[$tmp_server_id] = 1;
	 					$msg_txt .= ' -> '. $tmp_ret['server_name'] . '('.$tmp_server_id.'|'.$tmp_ret['server_date'].')';
	 				}
	 				else
	 				{
	 					break;
	 				}

 					$cnt++;
 				}

 				if ($msg_txt)
 				{
 					$tmp = array();
 					$tmp['var'] = $detail['server_name'] . '('.$server_id.'|'.$detail['server_date'].')';
 					$tmp['txt'] = $msg_txt;
 					$history[] = $tmp;
 				}
 			}
 		}
 	}

	empty($history) && $retmsg = '目前没有合服记录';

	$smarty->assign('caption', $caption);
	$smarty->assign("base_list", $history);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('base_list.tpl');

?>
