<?php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	$platform_config_file  = CURRENT_PATH . '/configs/platform.php';

	if (file_exists($platform_config_file))
	{
		include $platform_config_file;
	}

	$caption = '代码发布检查 --' . date('Y-m-d H:i');

	$installed_type_map = array('server' => '游戏服', 'pk' => 'pk服');

	$type_selected = httpGetVal('type');
	empty($type_selected) && $type_selected = 'server';

	$log_folder = 'check_publish_sign';
	$retmsg = '';
	$list = array();
	$check_content = httpGetVal('content');

	if (!empty($do_search) && $do_search == 'do')
	{
		try {

			if (empty($check_content))
			{
				throw new Exception('请填写检查内容');
			}

			if (empty($type_selected) || !isset($installed_type_map[$type_selected]))
			{
				throw new Exception('请选择正式服类型');
			}

			if ($type_selected == 'pk')
			{
				$server_list = getPkList($domain);
				$global_pk_list = getGlobalPkList($domain);
				if (!empty($global_pk_list))
				{
					$server_list += $global_pk_list;
				}

				$smarty->assign("option_values", array_keys($server_list));
				$smarty->assign("option_output", array_values($server_list));
			}

			if ($type_selected == 'pk' && !empty($platform_pk_test_map) && !empty($platform_pk_test_map[$p]))
			{
				$server_list += $platform_pk_test_map[$p];
			}
			elseif ($type_selected == 'server' && !empty($platform_server_test_map) && !empty($platform_server_test_map[$p]))
			{
				$server_list += $platform_server_test_map[$p];
			}
			
			if (!empty($server_list))
			{
				foreach($server_list as $sx => $name)
				{
					$server_url = $sx . $domain. SERVER_FOR_BACKEND . '?c=CommCheck&a=PublishSign';
					$log_msg = 'server='. $server_name . ' -- url='. $server_url;
					do_log($log_msg, $log_folder, $log_folder);

					$result = func_requestUrl($server_url, false, 3);
					$tmp = array();
					$tmp['var'] = $name;

					if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
					{
						if (is_array($result['data']))
						{
							$data = isset($result['data']['data']) ? trim($result['data']['data']) : '';
						}
						else
						{
							$data = $result['data'];
						}

						if ($data != $check_content)
						{
							$data = '<span style="color:#f00;">'.$data.'</span>';
						}

						$txt = $data;
						!empty($result['data']['rsync_log']) && $tmp['rsync_log'] = '<span style="color:#f00;">'.$result['data']['rsync_log'].'</span>';
					}
					else
					{
						$txt = !empty($result['retmsg']) ? $result['retmsg'] : 'try again';
						$txt = '<span style="color:#f00;">'.$txt.'</span>';
					}

					$tmp['txt'] = $txt;
					$list[] = $tmp;
				}
			}
			else
			{
				$retmsg = '目前没有开服的服务器列表';
			}
		} catch (Exception $e) {
			$retmsg = $e->getMessage();
		}
	}

	$smarty->assign("type_map_values", array_keys($installed_type_map));
	$smarty->assign("type_map_output", array_values($installed_type_map));
	$smarty->assign("type_selected", $type_selected);

	$smarty->assign('content', $check_content);
	$smarty->assign('caption', $caption);
	$smarty->assign("base_list", $list);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('checkPublishSign.tpl');
?>
