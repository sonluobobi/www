<?php
	require 'common.php';
	//$config_show_test = 1;
	require 'base.php';

	$retmsg = '';
	$list = array();

	if (!empty($server_list))
	{
		//加载分页
		require 'subpage.php';

		foreach($server_list as $sx => $name)
		{
			$rpc_url = $sx . $domain;
			$func = 'serverTest';
			$rpc_params = array();

			$result = rpcRequestWebProxy($rpc_url, $func, $rpc_params);
			$tmp = array();
			$tmp['var'] = $name;

			if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
			{
				$content = '';

				foreach($result['data'] as $_k => $_v)
				{
					if ('timestamp' == $_k)
					{
						$content .= $_k . '=>' .date('Y-m-d H:i:s', $_v) . '<br>';
					}
					else
					{
						$flag = '<span style="color:#f00;">off</span>';
						$_v && $flag = 'on';
						$content .= $_k . '=>' . $flag . '<br>';
					}
				}

				$tmp['txt'] = $content;
			}
			else
			{
				$tmp['txt'] = !empty($result['retmsg']) ? $result['retmsg'] : 'fail';
			}

			$list[] = $tmp;
		}
	}
	else
	{
		$retmsg = '目前没有开服的服务器列表';
	}

	$smarty->assign('caption', 'pk语音中心服连接检查');
	$smarty->assign("base_list", $list);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('base_list.tpl');