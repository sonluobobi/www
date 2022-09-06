<?php
	require 'common.php';
	$config_show_test = 1;
	$do_format_ip = true;
	require 'base.php';

	//获取pk服信息
	$pk_list = getPkList($domain);

	if (!empty($pk_list))
	{
		$server_list = array_merge($server_list, $pk_list);

		$smarty->assign("option_values", array_keys($server_list));
		$smarty->assign("option_output", array_values($server_list));
	}
	
	$retmsg = '';
	$sysinfo = array();
	$sysinfo_map = array(
			'load_average' => 'load_average',
			'hd_file' => '磁盘路径',
			'hd_size' => '磁盘总大小',
			'hd_used' => '磁盘已使用',
			'hd_avail' => '磁盘可用空间大小',
			'hd_usage' => '磁盘使用百分比',
			'cur_date' => '系统时间',
			'cpu' => 'cpu',
			'mem' => '内存',
			'disk' => '硬盘',
			//'db_backup' => '今日备份信息',
		);

	$free_info = array();

	if (!empty($do_search) && $do_search == 'do')
	{
		//查询操作
		$curl_api = new KunlunRestClient(TOKENKEY, $server_url);
		$method = 'GameTools.getSysInfo';
		$params = array();
		$result = $curl_api->call_method($method, $params);

		if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
		{
			$data = $result['data'];
			$free_data = !empty($data['free']) ? $data['free'] : array();

			if (!empty($free_data))
			{
				$free_fields = array_shift($free_data);
				empty($free_fields[0]) && $free_fields[0] = '---';
				$cnt = count($free_fields);

				$free_info[] = $free_fields;

				foreach($free_data as $free_key => $free_detail)
				{
					if (empty($free_detail)) continue;
					$tmp = array();
					$tmp = $free_detail;
					$cnt = count($tmp);
					for($i = 1; $i< $cnt; $i++)
					{
						$free_value = isset($tmp[$i]) ? trim($tmp[$i]) : '';

						if (is_numeric($free_value))
						{
							if ($free_value >= 1024)
							{
								$tmp[$i] = floor($free_value /1024) . 'G';
							}
							else
							{
								$free_value >0 && $tmp[$i] = $free_value . 'M';
							}
						}
					}

					$free_info[] = $tmp;
				}
			}

			foreach($sysinfo_map as $k => $t)
			{
				$tmp = array();
				$tmp['var'] = $t;
				$tmp['txt'] = isset($data[$k]) ? $data[$k] : '--';
				$sysinfo[] = $tmp;
			}

		}
		else
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'try again';
		}
	}
	
	$smarty->assign("free_info", $free_info);

	$smarty->assign("sysinfo", $sysinfo);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('sysinfo.tpl');