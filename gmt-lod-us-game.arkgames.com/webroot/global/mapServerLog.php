<?php
//mapServerLog.php
	require 'common.php';
	$config_show_test = 1;
	require 'base.php';

	$caption = '查看游戏服map日志 --' . date('Y-m-d H:i');
	$platform_config_file  = CURRENT_PATH . '/configs/platform.php';

	if (file_exists($platform_config_file))
	{
		include $platform_config_file;
	}
	
	/*
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
	$log_folder = 'map_server_log';
	$sysinfo = array();
	$total=0;

	if (!empty($do_search))
	{
		ini_set('memory_limit', '512M');

		if ($do_search == 'download')
		{
			//下载
			$cid = httpGetVal('cid');
			$cid = intval($cid);

			if ($cid < 1037)
			{
				echo '<font color="red">参数错误 -- 角色id</font>';exit;
			}

			$filename = $log_folder.'_'.$cid . '.txt';
			$cache_file = CURRENT_PATH . '/data/'. $log_folder . '/'.$filename;
			$filesize=filesize($cache_file);
			header('Content-Description:File Transfer');
			header("Content-Type:application/octet-stream");
			header('Content-Transfer-Encoding:binary');
			header("Accept-Ranges: bytes");
			header('Expires:0');
			header('Cache-Control:must-revalidate');
			header('Pragma:public');
			header("Content-Length:$filesize");
			header("Content-Disposition:attachment;filename=$filename");

			//打开文件 
			$fp = fopen($cache_file, "rb"); 
			//设置指针位置 
			fseek($fp,0); 
			//虚幻输出 
			while (!feof($fp)) { 
			    //设置文件最长执行时间 
			    set_time_limit(0); 
			    print (fread($fp, 1024 * 8)); //输出文件 
			    flush(); //输出缓冲 
			    ob_flush(); 
			} 
			fclose($fp); 
			exit ();
		}
		elseif ($do_search == 'search')
		{
			$cid = httpGetVal('cid');
			$cid = intval($cid);
			$filenames = isset($_POST['filenames']) ? $_POST['filenames'] : '';

			if ($cid < 1037)
			{
				echo '<font color="red">请正确填写角色id</font>';exit;
			}

			if (empty($filenames))
			{
				echo '<font color="red">请勾选需要统计的文件名</font>';exit;
			}

			$filenames_arr = explode(',', $filenames);

			if (empty($filenames_arr))
			{
				echo '<font color="red">文件名参数错误</font>';exit;
			}

			$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=ServerLog&a=MapLogDetail';
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);

			$params= array();
			$params['cid'] = $cid;
			$params['filenames'] = $filenames_arr;
			$params_str = json_encode($params);
			$result = func_requestUrlPost($url, true, 3, $params_str);

			//构造table
			if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
			{
				$data = $result['data'];

				//排序及备份文件,用于下载
				//*
				usort($data, function($a, $b){
					return $a['date_time'] < $b['date_time'];
				});
				//*/

				$fields = array();
				$fields[] = 'date_time';
				$fields[] = 'opcode';
				$fields[] = 'pid';
				$fields[] = 'cid';
				$fields[] = 'exp';
				$fields[] = 'silver';
				$fields[] = 'vit';
				$fields[] = 'naili';
				$fields[] = 'vgold';
				$fields[] = 'ggold';	
				$fields[] = 'fc';
				$fields[] = 'pfc';
				$fields[] = 'params';	

				//*
				$path = CURRENT_PATH . '/data/'. $log_folder . '/';
				mkdir_recyle($path);
				$cache_file = $path . $log_folder.'_'.$cid . '.txt';

				$file_msg = '';
				foreach($fields as $field)
				{
					$file_msg .= $field. "\t";
				}

				$file_msg .= "\r\n";
				@file_put_contents($cache_file, $file_msg);
				@chmod($cache_file, 0777);
				//*/

				$format_data_str = '<a class="btn btn-default btn-lg active" role="button" target="_blank" href="mapServerLog.php?do_search=download&cid='.$cid.'"><font color="red" size="3">下载</font></a>';
				$format_data_str .= '<table class="table table-condensed table-bordered">';
				$format_data_str .= '<tr>';
				$format_data_str .= '<td>时间</td>';
				$format_data_str .= '<td>协议名</td>';
				$format_data_str .= '<td>帐号id</td>';
				$format_data_str .= '<td>角色id</td>';
				$format_data_str .= '<td>exp</td>';
				$format_data_str .= '<td>silver</td>';
				$format_data_str .= '<td>vit</td>';
				$format_data_str .= '<td>naili</td>';
				$format_data_str .= '<td>vgold</td>';
				$format_data_str .= '<td>ggold</td>';
				$format_data_str .= '<td>fc</td>';
				$format_data_str .= '<td>pfc</td>';
				$format_data_str .= '</tr>';

				foreach($data as $k => $detail)
				{
					$format_data_str .= '<tr>';
					$file_msg = '';

					foreach($fields as $field)
					{
						$tmp_value = isset($detail[$field]) ? trim($detail[$field]) : '--';
						$field != 'params' && $format_data_str .= '<td class="active">'.$tmp_value.'</td>';

						$file_msg .= $tmp_value . "\t";
					}

					$file_msg .= "\r\n";
					@file_put_contents($cache_file, $file_msg, FILE_APPEND);
					
					$format_data_str .= '</tr>';
				}

				$data = null;
				$format_data_str .= '</table>'; 
				echo $format_data_str;exit;
			}
			else
			{
				$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '没有数据';
				$retmsg = '<font color="red">'.$retmsg.'</font>';
				$result = null;
				echo $retmsg;exit;
			}
		}

		//查询操作
		$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=ServerLog&a=MapLogFileList';
		$log_msg = 'url='. $url;
		do_log($log_msg, $log_folder, $log_folder);
		$result = func_requestUrl($url, true, 3);

		if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
		{
			$data = $result['data'];
			$file_sign_arr = array();

			foreach($data as $k => $detail)
			{
				$filename = trim($detail['filename']);
				$file_sign = strstr($filename, 'log', true);
				$file_sign = trim($file_sign, '.');
				$file_sign_arr[$file_sign][] = $detail;
				$total++;
			}

			ksort($file_sign_arr);

			foreach($file_sign_arr as $_file_sign => $_item)
			{
				$tmp_sign = str_replace('.', '', $_file_sign);
				$tmp = array();
				$tmp['id'] = $tmp_sign;
				$sysinfo[] = $tmp;

				foreach($_item as $detail)
				{
					$tmp = array();
					$tmp['pid'] = $tmp_sign;
					$tmp['filename'] = $detail['filename'];
					$tmp['size'] = $detail['size'];
					$tmp['update'] = $detail['update'];
					$sysinfo[] = $tmp;
				}
			}
		}
		else
		{
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '没有数据';
		}

		$result = null;		
	}
	
	$smarty->assign("server_id", $server_id, true);
	$smarty->assign("sysinfo", $sysinfo);
	$smarty->assign("total", $total);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->assign('caption', $caption);
	$smarty->display('mapServerLog.tpl');