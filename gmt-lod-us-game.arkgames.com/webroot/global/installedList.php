<?php
	require 'common.php';
	require 'base.php';

	$caption = '已安装正式服列表';
	$retmsg = '';
	$sysinfo = array();
	$installed_type_map = array('server' => '游戏服', 'pk' => 'pk服', 'center' => '中心服', 'vchat' => '语音服');

	$type_selected = httpGetVal('type');
	empty($type_selected) && $type_selected = 'server';
	$log_folder = 'installed_list';

	if (!empty($do_search) && $do_search == 'do')
	{
		try {

			//查询操作
			if (empty($type_selected) || !isset($installed_type_map[$type_selected]))
			{
				throw new Exception('请选择正式服类型');
			}

			$server_url = 'pkadmin' . $domain. '/interface_backend.php?type='.$type_selected;
			$log_msg = 'url='. $server_url;
			do_log($log_msg, $log_folder, $log_folder);

			$result = func_requestUrl($server_url, false, 3);
			$total = 0;

			if (!empty($result) && $result['retcode']==0)
			{
				//$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作成功';
				
				if (!empty($result['data']))
				{	
					$ret_data = array_values($result['data']);
					//echo '<pre>';print_r($ret_data);exit;
					$tmp_one = $ret_data[0];
					$keys = array_keys($tmp_one);
					$titles = array();

					foreach($keys as $key)
					{
						$tmp = array();
						$tmp['var'] = $key;
						$titles[] = $tmp;
					}

					$smarty->assign("titles", $titles);
					$smarty->assign("base_list", $ret_data);
					$total = count($ret_data);
				}
			}
			else
			{
				$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'no data';
			}

			$data_title = $caption . ' -- ' . $installed_type_map[$type_selected] . ' -- ' . $total;
			$smarty->assign('data_title', $data_title, true);
		} catch (Exception $e) {
			$retmsg = $e->getMessage();
		}
	}
	
	$smarty->assign("type_map_values", array_keys($installed_type_map));
	$smarty->assign("type_map_output", array_values($installed_type_map));
	$smarty->assign("type_selected", $type_selected);

	
	$smarty->assign('caption', $caption, true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('installedList.tpl');