<?php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	/*
	$server_list = getAllServerListForSelect();

	$smarty->assign("option_values", array_keys($server_list));
	$smarty->assign("option_output", array_values($server_list));
	$server_selected = !empty($server_list[$server_id]) ? $server_list[$server_id] : '';
	$smarty->assign("server_selected", $server_selected, true);
	//*/

	$retmsg = '';
	$list = array();

	if (!empty($do_search) && $do_search == 'do')
	{
		$rpc_url = $server_id . $domain;
		$func = 'serverTest';
		$rpc_params = array();

		$result = rpcRequestWebProxy($rpc_url, $func, $rpc_params);

		if (!empty($result) && $result['retcode']==0)
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作成功';

			if (!empty($result['data']))
			{
				foreach($result['data'] as $_k => $_v)
				{
					$tmp = array();
					$tmp['var'] = $_k;

					if ('timestamp' == $_k)
					{
						$tmp['txt'] = date('Y-m-d H:i:s', $_v);
					}
					else
					{
						$flag = '<span style="color:#f00;">off</span>';
						$_v && $flag = 'on';

						$tmp['txt'] = $flag;
					}	

					$list[] = $tmp;
				}
			}
			else
			{
				$retmsg .= '-- no data';
			}

		}
		else
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'fail';
		}
	}

	$smarty->assign("list", $list);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('checkConnect.tpl');