<?php
	//backupDb.php
	require 'common.php';
	require 'base.php';

	$caption = '查看备份数据库列表 --' . date('Y-m-d H:i');

	$desc_msg = '1、涉及时间,以游戏服时间为准<br>';
	$desc_msg .= '2、涉及测试服，指该大区对应测试服<br>';
	$desc_msg .= '3、请按顺序操作<br>';
	$desc_msg .= ' -- 1|复制数据库备份文件到测试服<br>';
	$desc_msg .= ' -- 2|导入复制的备份数据库到测试服<br>';
	$desc_msg .= ' -- 3|复制指定角色id数据到测试服<br>';

	$retmsg = '';
	$sysinfo = array();

	$log_folder = 'server_db';

	$platform_test_server = array(
		'zh' => 's1',
		'ios' => 's1',
		'yyb' => 's1',
		'quickios' => 's802',
		'ttzrios' => 's801',
		'sywj' => 's801',
		'sgp' => 's0',
		'na' => 's0',
		'en' => 's0',
		'eu' => 's801',
		'br' => 's801',
		'ru' => 's801',
		'kr' => 's801',
		'tw' => 's801',
		'tw2' => 's801',
		'th' => 's801',
		'jp' => 's801',
		'ar' => 's801',
	);

	if (!empty($do_search))
	{
		$test_server_id = 's1';
			
		if (isset($platform_test_server[$p]))
		{
			$test_server_id = $platform_test_server[$p];
		}
		else
		{
			echo '<font color="red">未配置对应测试服</font>';exit;
		}

		if ($do_search == 'download')
		{
			//下载文件
			$filename = httpGetVal('filename');
			$filename = intval($filename);

			if (empty($filename))
			{
				echo '<font color="red">参数错误 -- 备份日期</font>';exit;
			}

			//echo json_encode($_POST);exit;
			$params = array();
			$params['stat_date'] = $filename; 
			$params['server_sign'] = $server_id;

			$params_str = http_build_query($params);

			$url = $test_server_id . $domain. SERVER_FOR_BACKEND . '?c=BackupDb&a=DownloadDb&'.$params_str;
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);
			$result = func_requestUrl($url, false, 3);
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作失败或超时';

			die($retmsg);
		}
		elseif ($do_search == 'import')
		{
			//导入数据库文件
			$filename = httpGetVal('filename');
			$filename = intval($filename);

			if (empty($filename))
			{
				echo '<font color="red">参数错误 -- 备份日期</font>';exit;
			}

			//echo json_encode($_POST);exit;
			$params = array();
			$params['stat_date'] = $filename; 
			$params['server_sign'] = $server_id;

			$params_str = http_build_query($params);
			$url = $test_server_id . $domain. SERVER_FOR_BACKEND . '?c=BackupDb&a=ImportDb&'.$params_str;
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);
			$result = func_requestUrl($url, false, 3);
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作失败或超时';

			die($retmsg);
		}
		elseif ($do_search == 'copy')
		{
			//导入数据库文件
			$filename = httpGetVal('filename');
			$filename = intval($filename);

			if (empty($filename))
			{
				echo '<font color="red">参数错误 -- 备份日期</font>';exit;
			}

			$cid = httpGetVal('cid');
			$cid = intval($cid);

			if ($cid < 1037)
			{
				echo '<font color="red">请正确填写角色id</font>';exit;
			}

			//echo json_encode($_POST);exit;
			$params = array();
			$params['stat_date'] = $filename; 
			$params['server_sign'] = $server_id;
			$params['cid'] = $cid;

			$params_str = http_build_query($params);

			$url = $test_server_id . $domain. SERVER_FOR_BACKEND . '?c=BackupDb&a=CopyCh&'.$params_str;
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);
			$result = func_requestUrl($url, false, 3);
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作失败或超时';

			die($retmsg);
		}
		else
		{
			//查询操作
			$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=BackupDb&a=ChPartDbList';
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);
			$result = func_requestUrl($url, true, 3);

			if (!empty($result) && $result['retcode']==0 && !empty($result['data']))
			{
				$data = $result['data'];
				$i=1;

				foreach($data as $k => $detail)
				{
					$tmp = array();
					$tmp['id']=$i;
					$filename = $detail['filename'];
					$arr = explode('_', $filename);
					$tmp['filename'] = $arr[2];
					$tmp['size'] = $detail['size'];
					$tmp['update'] = $detail['update'];
					$i++;
					$sysinfo[] = $tmp;
				}
			}
			else
			{
				$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作失败或超时';
			}
		}
	}
	
	$smarty->assign('caption', $caption);
	$smarty->assign('desc_msg', $desc_msg, true);
	$smarty->assign("server_id", $server_id, true);
	$smarty->assign("sysinfo", $sysinfo);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('backupDb.tpl');