<?php 
	require 'common.php';
	require 'base.php';
	require 'checkLogin.php';

	//获取pk服信息
	/*
	$pk_list = getPkList($domain);

	if (!empty($pk_list))
	{
		$server_list = array_merge($server_list, $pk_list);

		$smarty->assign("option_values", array_keys($server_list));
		$smarty->assign("option_output", array_values($server_list));
	}
	//*/

	$retmsg = '';

	if (!empty($do_search) && $do_search == 'do')
	{
		try {
			//查询操作
			$func = httpGetVal('func');
			$params_str = httpGetVal('params');

			if (empty($func) || empty($params_str))
			{
				throw new Exception('参数错误');
			}

			if (empty($gmt_func_map) || empty($gmt_func_map[$func]))
			{
				throw new Exception('该函数名目前不支持--',$func);
			}
			
			$params = explode(' ', $params_str);
			$rpc_url = $server_id . $domain;
			$rpc_params = array();

			if ($func == 'move2MainCity')
			{
				$rpc_params['nicks'] = $params;
			}
			else
			{
				$rpc_params['data'] = $params;
			}
			$result = rpcRequestWebProxy($rpc_url, $func, $rpc_params);

			if (!empty($result) && $result['retcode']==0)
			{
				$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作成功';
				!empty($result['data']) && $retmsg .= '--data-- <pre>'. var_export($result['data'], true);
			}
			else
			{
				$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'no data';
			}
			
			die($retmsg);
		} catch (Exception $e) {
			$retmsg = $e->getMessage();
			die($retmsg);
		}
	}
	
	empty($gmt_func_map) && $gmt_func_map = array('' => 'no data');
	$smarty->assign("func_values", array_keys($gmt_func_map));
	$smarty->assign("func_output", array_values($gmt_func_map));
	$smarty->assign("func_selected", '', true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('gmt.tpl');