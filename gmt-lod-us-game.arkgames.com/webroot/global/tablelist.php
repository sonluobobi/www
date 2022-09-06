<?php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	$platform_config_file  = CURRENT_PATH . '/configs/platform.php';

	if (file_exists($platform_config_file))
	{
		include $platform_config_file;
	}

	//*
	//获取pk服信息
	$pk_list = getPkList($domain);

	if (!empty($pk_list))
	{
		$global_pk_list = getGlobalPkList($domain);
		if (!empty($global_pk_list))
		{
			$pk_list += $global_pk_list;
		}

		if (!empty($platform_pk_test_map) && !empty($platform_pk_test_map[$p]))
		{
			$pk_list += $platform_pk_test_map[$p];
		}
		
		$server_list = array_merge($server_list, $pk_list);


		$smarty->assign("option_values", array_keys($server_list));
		$smarty->assign("option_output", array_values($server_list));
	}
	//*/
	
	$retmsg = '';
	$sysinfo = array();
	$log_folder = 'table_list';

	if (!empty($do_search) && $do_search == 'do')
	{
		//查询操作
		if (empty($server_id) || !isset($server_list[$server_id]))
		{
			throw new Exception('请选择游戏服');
		}

		$server_name = $server_list[$server_id];
		$tablename = httpGetVal('tbl');

		$action_type = httpGetVal('type');
		empty($action_type) && $action_type = 'List';
		$action_type = ucfirst($action_type);

		$allowed_action_type_map = array('List' => '表列表', 'Fields' => '表字段', 'Desc' => '表结构');

		//查询操作
		if (!isset($allowed_action_type_map[$action_type]))
		{
			throw new Exception('type 参数错误');
		}

		$server_url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=Table&a=Table'.$action_type.'&tbl='.$tablename;
		$log_msg = 'server='. $server_name . ' -- url='. $server_url;
		do_log($log_msg, $log_folder, $log_folder);

		$do_gz = false;
		$tablename && $do_gz = true;

		$result = func_requestUrl($server_url, $do_gz, 3);
		$total = 0;

		if (!empty($result) && $result['retcode']==0)
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作成功';

			if (!empty($result['data']))
			{
				$data = $result['data'];

				if ($tablename)
				{
					$data = $data[$tablename];
					if ('Fields' == $action_type)
					{
						$j = 0;
						$format_data_str = '';
						foreach($data as $_i => $_field)
						{
							$format_data_str .= $_field . ', ';
							if ($j !=0 && $j % 5 == 0)
							{
								//$format_data_str = trim($format_data_str, ',');
								$format_data_str .= '<br/ >';
							}

							$j++;
						}

						$format_data_str .= '<br /> -- total=' . $j;
					}
					else
					{
						$format_data_str = '<table class="table table-condensed table-bordered">';
						foreach($data as $_k => $_info)
						{
							$format_data_str .= '<tr>';

							foreach($_info as $_j => $_desc)
							{
								$format_data_str .= '<td class="active">'.$_desc.'</td>';
							}

							$format_data_str .= '</tr>';
						}
						$format_data_str .= '</table>'; 
					}

					die($format_data_str);
				}

				$i=1;

				foreach($data as $k => $tbl)
				{
					$tmp = array();
					$tmp['id']=$i;
					$tmp['tbl'] = $tbl;
					$i++;
					$sysinfo[] = $tmp;
					$total++;
				}

				$retmsg .= ' -- total='.$total;
			}
			else
			{
				$retmsg .= 'empty';
			}
		}
		else
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'no data';
		}

		if ($tablename)
		{
			$retmsg = $retmsg;
			die($retmsg);
		}
	}
	
	$smarty->assign("server_id", $server_id, true);
	$smarty->assign("sysinfo", $sysinfo);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('tablelist.tpl');
