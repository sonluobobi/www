<?php
	//importAndFix.php
	require 'common.php';
	require 'base.php';
	$php_self = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
	require 'checkLogin.php';
	
	$caption = '备份数据库导入及修复丢失角色 --' . date('Y-m-d H:i');

	$desc_msg = '1、涉及时间,以游戏服时间为准<br>';
	$desc_msg .= '2、导入备份数据后，数据库名称规则backup_moyu_ + 游戏服标识 + 备份日期 如 backup_moyu_s20_20180126<br>';

	$retmsg = '';
	$sysinfo = array();

	$log_folder = 'import_and_fix';

	if (!empty($do_search))
	{
		if ($do_search == 'doImport')
		{
			//导入备份数据库
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
			$params['op_type'] = 'import';

			$params_str = http_build_query($params);

			$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=BackupDb&a=ImportAndFix&'.$params_str;
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);
			$result = func_requestUrl($url, false, 1);
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作失败或超时';

			if (!empty($result) && $result['retcode']==0)
			{
				$retmsg = '操作成功';
			}

			$retmsg = '1、导入备份数据库 -- ' . $filename . ' -- '. $retmsg;

			die($retmsg);
		}
		elseif ($do_search == 'doFix')
		{
			//导入并修复丢失角色
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
			$params['op_type'] = 'fix';

			$params_str = http_build_query($params);
			$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=BackupDb&a=ImportAndFix&'.$params_str;
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);
			$result = func_requestUrl($url, false, 1);
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作失败或超时';

			if (!empty($result) && $result['retcode']==0)
			{
				$retmsg = '操作成功';
			}

			$retmsg = '2、导入并修复丢失角色 -- ' . $filename . ' -- '. $retmsg;

			die($retmsg);
		}
		elseif ($do_search == 'showRoleRose')
		{
			//检查丢失角色列表
			$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=BackupDb&a=CheckRoleRose';
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);
			$result = func_requestUrl($url, true, 3);
			$format_data_str = '查询中';

			if (!empty($result) && $result['retcode']==0)
			{
				if (!empty($result['data']))
				{
					$format_data_str = '<table class="table table-condensed table-bordered">';
					$format_data_str .= '<tr>';
					$format_data_str .= '<td>角色id</td>';
					$format_data_str .= '<td>帐号id</td>';
					$format_data_str .= '<td>角色名</td>';
					$format_data_str .= '<td>创建日期</td>';
					$format_data_str .= '</tr>';
					$format_data_str .= '<tr>';
					$format_data_str .= '<td class="active" colspan="4">共计丢失角色数'.count($result['data']).'</td>';
					$format_data_str .= '</tr>';

					foreach($result['data'] as $_k => $info)
					{
						$format_data_str .= '<tr>';
						$format_data_str .= '<td class="active">'.$info['id'].'</td>';
						$format_data_str .= '<td class="active">'.$info['player_id'].'</td>';
						$format_data_str .= '<td class="active">'.$info['nick'].'</td>';
						$format_data_str .= '<td class="active">'.$info['created'].'</td>';

						$format_data_str .= '</tr>';
					}
				}
				else
				{
					$format_data_str = '没有角色丢失';
				}
			}
			else
			{
				$format_data_str = !empty($result['retmsg']) ? $result['retmsg'] : '操作失败或超时';
			}

			die($format_data_str);
		}
		elseif ($do_search == 'showDbImported')
		{
			//查看当前已经导入的备份库列表
			$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=BackupDb&a=DbNameList';
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);
			$result = func_requestUrl($url, true, 3);
			$format_data_str = '查询中';

			if (!empty($result) && $result['retcode']==0)
			{
				if (!empty($result['data']))
				{
					$format_data_str = '';
					$j = 0;
					foreach($result['data'] as $_j => $_info)
					{
						$format_data_str .= $_info['db_name'] . '  |  ';
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
					$format_data_str = '没有导入过备份数据';
				}
			}
			else
			{
				$format_data_str = !empty($result['retmsg']) ? $result['retmsg'] : '操作失败或超时';
			}

			die($format_data_str);
		}
		elseif ($do_search == 'doBack')
		{
			//导入数据库文件
			$filename = httpGetVal('filename');
			$filename = intval($filename);

			if (empty($filename))
			{
				echo '参数错误 -- 备份日期';exit;
			}

			$cid = httpGetVal('cid');
			$cid = intval($cid);

			if ($cid < 1037)
			{
				echo '请正确填写角色id';exit;
			}

			//echo json_encode($_POST);exit;
			$params = array();
			$params['stat_date'] = $filename; 
			$params['server_sign'] = $server_id;
			$params['op_type'] = 'back';
			$params['cid'] = $cid;

			$params_str = http_build_query($params);
			$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=BackupDb&a=RoleBack&'.$params_str;
			$log_msg = 'url='. $url;
			do_log($log_msg, $log_folder, $log_folder);
			$result = func_requestUrl($url, false, 1);
			$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作失败或超时';

			if (!empty($result) && $result['retcode']==0)
			{
				$retmsg = '操作成功';
			}

			$retmsg = '3、角色id( '.$cid.' )回档 -- 回档日期: ' . $filename . ' -- '. $retmsg;

			die($retmsg);
		}
		else
		{
			//查询操作
			$url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=BackupDb&a=BackupList';
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
	$smarty->display('importAndFix.tpl');