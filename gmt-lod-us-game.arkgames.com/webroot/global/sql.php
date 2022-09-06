<?php 
	require 'common.php';
	require 'base.php';
	$php_self = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
	require 'checkLogin.php';

	//获取pk服信息
	//*
	$pk_list = getPkList($domain);

	if (!empty($pk_list))
	{
		$server_list = array_merge($server_list, $pk_list);

		$smarty->assign("option_values", array_keys($server_list));
		$smarty->assign("option_output", array_values($server_list));
	}
	//*/

	$log_folder = 'sql';
	$retmsg = '';
	//$params_str = httpGetVal('params');
	$params_str = isset($_REQUEST['params']) ? trim($_REQUEST['params']) : '';

	if (!empty($do_search) && $do_search == 'do')
	{
		try {

			//查询操作

			if (empty($params_str))
			{
				throw new Exception('参数sql不能为空');
			}

			$params_str = trim($params_str, ';；');
			$params_str = str_replace('"', "'", $params_str);
			//验证sql语句格式，严格只限制单表select语句
			$allowed_command_word = array('select');

			$arr_temp_sql_word = explode(' ', $params_str);
			$first_word = trim($arr_temp_sql_word[0]);
			$first_word = strtolower($first_word);

			if (!in_array($first_word, $allowed_command_word))
			{
				throw new Exception('sql中不支持命令 --' . $first_word);
			}

			//屏蔽点，以免链表查询
			if (strpos($params_str, '.') !== false)
			{
				throw new Exception('sql中不能包含字符点 .');
			}

			//关键字屏蔽
			$filter_world = array('delete', 'update', 'as', 'join', 'insert', 'alter', 'truncate', 'union', 'drop', 'create');
			$has_contain_from = false;
			$cnt_from = 0;

			foreach($arr_temp_sql_word as $sql_word)
			{
				$tmp_sql_word = strtolower(trim($sql_word));

				if (in_array($tmp_sql_word, $filter_world))
				{
					throw new Exception('sql中不能包含关键字 --' . $tmp_sql_word);
				}

				if ($tmp_sql_word == 'from')
				{
					$has_contain_from = true;
					$cnt_from++;
				}
			}

			if (!$has_contain_from)
			{
				throw new Exception('sql中未包含from');
			}

			if ($cnt_from != 1)
			{
				throw new Exception('sql中只能包含1个from 关键字');
			}

			//throw new Exception('test');

			if (empty($server_id) || !isset($server_list[$server_id]))
			{
				throw new Exception('请选择游戏服');
			}

			$server_name = $server_list[$server_id];
			$data_title = $server_name . ' -- ';

			$log_msg = $auth_user .' -- server='. $server_name . ' -- sql='. html_entity_decode($params_str);
			do_log($log_msg, $log_folder, $log_folder);

			$sql = urlencode($params_str);
			$server_url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=Db&a=StatSql&sql=' . $sql;
			$log_msg = $auth_user .' -- server='. $server_name . ' -- url='. $server_url;
			do_log($log_msg, $log_folder, $log_folder);

			$total = 0;
			$result = func_requestUrl($server_url, true, 1);

			if (!empty($result) && $result['retcode']==0)
			{
				$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作成功';
				
				if (!empty($result['data']))
				{	
					$ret_data = $result['data'];
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

			$data_title .= $total;
			$smarty->assign('data_title', $data_title, true);
			
		} catch (Exception $e) {
			$retmsg = $e->getMessage();
		}
	}
	
	$caption = '测试查询';
	$smarty->assign('params', $params_str, true);
	$smarty->assign('caption', $caption, true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('sql.tpl');