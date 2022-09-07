<?php
if (!defined('KUNLUN_COM'))
{
        header('http/1.0 404 not found');
        die();
}

class ActCodeService extends Base
{
	public $sign = 'act_code';
	public $receive_batch_code = 'receive_batch_code';
	public $tbl_activation_code_batch = 'activation_code_batch';

	public function ShareBatch()
	{
		global $sync_platform_map, $common_area_sign;

		$sign = $this->sign;
		$func_name = strtolower(__FUNCTION__);
		$log_folder = $sign;
		$log_file_name = $func_name;
		$cur_date_str = date('Y-m-d H:i:s');

		$msg = '';
		$batch_id = intval(httpGetVal('batch_id'));

		if (empty($batch_id))
		{
			$msg = '参数错误';
			$this->ShowAjaxMsg($msg);
		}

		if (empty($common_area_sign))
		{
			$msg = '未配置大区标识';
			$this->ShowAjaxMsg($msg);
		}

		if (empty($sync_platform_map) || empty($sync_platform_map[$common_area_sign]))
		{
			$msg = '没有配置可同步的大区 -- ' . $common_area_sign;
			$this->ShowAjaxMsg($msg);
		}

		$batch_data = $this->getBatchByBatchId($batch_id);

		if (empty($batch_data))
		{
			$msg = '批次数据不存在 -- '.$batch_id;
			$this->ShowAjaxMsg($msg);
		}

		if (empty($batch_data))
		{
			$msg = '批次详细数据不存在 -- ' . $batch_id;
			$this->ShowAjaxMsg($msg);
		}

		$batch_type = intval($batch_data['batch_type']);
		$sync_status = intval($batch_data['sync_status']);
		$end_time = $batch_data['end_time'];

		if ($batch_type != BATCH_TYPE_SYNC)
		{
			$msg = '该批次非多区共享 -- ' . $batch_id;
			$this->ShowAjaxMsg($msg);
		}

		if ($sync_status == 1)
		{
			$msg = '该批次曾经同步过，如需再次同步，请联系后台研发同事 -- ' . $batch_id;
			$this->ShowAjaxMsg($msg);
		}

		if ($end_time < $cur_date_str)
		{
			$msg = '该批次已过期，不可多区共享 -- ' . $batch_id;
			$this->ShowAjaxMsg($msg);
		}

		$tbl_code_lib = $batch_data['tbl_code_lib'];

		if (empty($tbl_code_lib))
		{
			$msg = '该批次数据 tbl_code_lib 有误 -- ' . $batch_id;
			$this->ShowAjaxMsg($msg);
		}

		$code_data = $this->getBatchCodeByBatchId($batch_id, $tbl_code_lib);

		if (empty($code_data))
		{
			$msg = '该批次激活码未成功生成 -- ' . $batch_id;
			$this->ShowAjaxMsg($msg);
		}

		$author = httpGetVal('author');
		$activation_prefix = $batch_data['activation_prefix'];
		$log_msg = '['.$func_name.'] -- author='.$author.' -- batch_id=' . $batch_id . ' -- activation_prefix='. $activation_prefix .' ---------------------------- [begin]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		$batch_code_data = array();
		$batch_code_data['batch'] = $batch_data;
		$batch_code_data['code'] = $code_data;

		$content = json_encode($batch_code_data);
		$sub_url = INTERFACE_FILE . '?c=ActCode&a=ReceiveBatchCode';

		//查找同步配置
		foreach($sync_platform_map[$common_area_sign] as $platform_sign)
		{
			$domain = $this->getDomainByPlatform($platform_sign);

			if (!empty($domain))
			{
				$url = INTERFACE_SIGN . $domain . $sub_url;
				$this->Log($url, $log_file_name, $log_folder);
				$retmsg = $this->sendStreamFile($url, $content);
				//$msg .= $url . "\r\n";
				'succ' != $retmsg && $msg .= $platform_sign . '--'.$retmsg . "\r\n";
				$log_msg = $platform_sign . ' -- ' . $retmsg;
				$this->Log($log_msg, $log_file_name, $log_folder);
			}
			else
			{
				$log_msg = $platform_sign . ' -- not define the domain';
				$this->Log($log_msg, $log_file_name, $log_folder);
			}
		}

		$log_msg = '['.$func_name.'] -- author='.$author.' -- batch_id=' . $batch_id . ' -- activation_prefix='.$activation_prefix;

		if ('' == $msg)
		{
			$db = $this->getDb();
			$msg = '操作成功';
			//记录已经分享成功
			$update_arr = array('sync_status' => 1);
			$cond = array('id' => $batch_id);
			$tbl_activation_code_batch = $this->tbl_activation_code_batch;
			$db->update($tbl_activation_code_batch, $update_arr, $cond);
			$log_msg .= ' -- succ';
		}
		else
		{
			$log_msg .= ' -- fail';
		}

		$log_msg .= '---------------------------- [end]';
		$this->Log($log_msg, $log_file_name, $log_folder);
		$this->ShowAjaxMsg($msg);
	}

	//获取批次数据
	public function getBatchByBatchId($batch_id)
	{
		$tbl_activation_code_batch = $this->tbl_activation_code_batch;

		$ret = array();
		$db = $this->getDb();
		$cond = array('id' => $batch_id);
		$batch_data = $db->get($tbl_activation_code_batch, '*', $cond);

		if (!empty($batch_data))
		{
			$ret = $batch_data;
		}

		return $ret;
	}	

	//获取激活码
	public function getBatchCodeByBatchId($batch_id, $tbl_code_lib)
	{
		$tbl_code_lib = trim($tbl_code_lib, 'tbl_');
		$ret = array();
		$db = $this->getDb();
		$cond_code = array('batch_id' => $batch_id);
		$select_arr = array('activation_code_sort_id','batch_id','code','start_time','end_time');
		$code_data = $db->select($tbl_code_lib, $select_arr, $cond_code);

		if (!empty($code_data))
		{
			$ret = $code_data;
		}

		return $ret;
	}

	//接收批次激活码数据
	public function ReceiveBatchCode()
	{
		$sign = $this->sign;
		$func_name = strtolower(__FUNCTION__);
		$log_folder = $sign;
		$log_file_name = $func_name;
		$cur_date_int = date('YmdH');
		$cur_date_str = date('Y-m-d H:i:s');
		$log_msg = '['.$func_name.']  ---------------------------- [begin]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		$stream_data = $this->getPostStreamData();

		if (!empty($stream_data))
		{
			//$this->Log($stream_data, $log_file_name.'_data', $log_folder);
			$batch_code_data = json_decode($stream_data, true);

			if (!empty($batch_code_data) && !empty($batch_code_data['batch']))
			{
				$batch_data = $batch_code_data['batch'];
				$code_data = $batch_code_data['code'];

				$activation_prefix = $batch_data['activation_prefix'];
				$base_path = PATH_LOGS .$sign.'/'.$func_name.'/'; 
				mkdir_recyle($base_path);

				//保存数据
				$file = $base_path . 'batch_' . $activation_prefix . '_' . $cur_date_int . '.php';
				$content = "<?php \r\n ";
				$content .= '//@' . $cur_date_str . '-- activation_prefix=' . $activation_prefix . "\r\n";
				$content .= 'return '. var_export($batch_code_data, true) . "\r\n";

				@file_put_contents($file, $content);
				@chmod($file, 0777);

				//判断是否已经存在
				$has_exists = $this->checkExists($activation_prefix);

				if (!$has_exists)
				{
					//导入db
					$batch_id = $this->ImportBatch($batch_data);
					$log_msg = 'activation_prefix = '. $activation_prefix . ' -- batch_id=' . $batch_id;
					$this->Log($log_msg, $log_file_name, $log_folder);

					if ($batch_id > 0)
					{
						$tbl_code_lib = $batch_data['tbl_code_lib'];
						$import_ret = $this->ImportBatchCode($batch_id, $code_data, $tbl_code_lib);

						$import_msg = $import_ret ? 'succ' : 'fail';
						$log_msg = 'activation_prefix = '. $activation_prefix . ' -- batch_id=' . $batch_id. ' -- ' . $import_msg;
						$this->Log($log_msg, $log_file_name, $log_folder);
					}
				}
				else
				{
					$log_msg = 'activation_prefix = '. $activation_prefix . ' has exists';
					$this->Log($log_msg, $log_file_name, $log_folder);
				}
			}
			else
			{
				$log_msg = 'no data ';
				$this->Log($log_msg, $log_file_name, $log_folder);
			}
		}

		$log_msg = '['.$func_name.'] ---------------------------- [end]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		echo 'succ';
		exit;
	}

	//验证批次是否存在
	public function checkExists($activation_prefix)
	{
		$db = $this->getDb();
		$tbl_activation_code_batch = $this->tbl_activation_code_batch;
		$cond_arr = array('activation_prefix' => $activation_prefix);
		return $db->has($tbl_activation_code_batch, $cond_arr);
	}

	//导入批次
	public function ImportBatch($batch_data)
	{
		$sign = $this->sign;
		$func_name = strtolower(__FUNCTION__);
		$log_folder = $sign;
		$log_file_name = $this->receive_batch_code;
		
		$db = $this->getDb();
		$tbl_activation_code_batch = $this->tbl_activation_code_batch;
		$tmp = $batch_data;
		unset($tmp['id']);
		$tmp['server_ids'] = 'all_server';
		$tmp['channel'] = 0;
		$tmp['channel_title'] = '';
		$tmp['sync_status'] = 1;

		$last_user_id = $db->insert($tbl_activation_code_batch, $tmp);
		$log_msg = '['.$func_name.']  -- last_user_id -- ' . $last_user_id;
		$this->Log($log_msg, $log_file_name, $log_folder);

		return $last_user_id;
	}

	//导入激活码
	public function ImportBatchCode($batch_id, $code_data, $tbl_code_lib)
	{
		$sign = $this->sign;
		$func_name = strtolower(__FUNCTION__);
		$log_folder = $sign;
		$log_file_name = $this->receive_batch_code;

		$base_log_msg = '['.$func_name.']  -- ';
		$log_msg = $base_log_msg . 'batch_id='.$batch_id . ' -- tbl_code_lib='. $tbl_code_lib;
		$this->Log($log_msg, $log_file_name, $log_folder);

		$sql_prefix = " INSERT INTO `$tbl_code_lib` (activation_code_sort_id,batch_id,code,start_time,end_time) VALUES " ;
		$sql_str = '';
		$sql_file = '/tmp/act_import_batch_code_sql_'.$batch_id.'.sql';
		$base_path = PATH_LOGS .$sign.'/'; 
		mkdir_recyle($base_path);
		//$sql_file = $base_path . 'batch_code_sql_' . $batch_id . '.sql';

		$sql_log_file = $base_path . $func_name.'_' . date('Ym') . '.log';
		@file_put_contents($sql_file, $sql_prefix);
		@chmod($sql_file, 0777);

		$size = count($code_data);
		$cnt = 0;
		$code_list = array();

		foreach($code_data as $detail)
		{
			$cnt++;
			$activation_code_sort_id = isset($detail['activation_code_sort_id']) ? intval($detail['activation_code_sort_id']) : 1;
			$act_code = $detail['code'];
			$start_date = $detail['start_time'];
			$end_date = $detail['end_time'];
			$code_list[] = array('code'=>$act_code);
			$sql_str = "($activation_code_sort_id,$batch_id,'$act_code','$start_date', '$end_date')";

			if ($cnt < $size) {
				$sql_str .= ",\r\n";
			}else {
				$sql_str .= ";\r\n";
			}
						
			@file_put_contents($sql_file, $sql_str, FILE_APPEND);
			//@chmod($sql_file, 0777);
		}

		$log_msg = $base_log_msg . 'cnt='.$cnt;
		$this->Log($log_msg, $log_file_name, $log_folder);

		//将激活码导入数据库操作放到后台执行
		if (!file_exists($sql_file))
		{
			return false;
		}
		
		$cmd = '/bin/sh /data/syslog/serverlist/import_code.sh '.$sql_file.' >> '.$sql_log_file.' 2>&1 &';

		//$log_msg = $base_log_msg . 'cmd='.$cmd;
		//$this->Log($log_msg, $log_file_name, $log_folder);

		$handle = popen($cmd, 'r');
		if ($handle) 
		{
			//将激活码写入日志文件,方便以后提取使用。
			$act_code_dir = ACT_CODE_DIR.'/'.$batch_id;
			mkdir_recyle($act_code_dir);

			$act_code_file = $act_code_dir.'/act_code.php';
			$code_content  = "<?php \r\n";
			$code_content .= '//@' . date('Y-m-d H:i:s') . ' -- batch_id=' . $batch_id . "\r\n";
			$code_content .= 'return ' . var_export($code_list,true) . ";\r\n";
			$code_content .= "?>";
			
			@file_put_contents($act_code_file, $code_content);
			@chmod($act_code_file, 0777);

			$log_msg = $base_log_msg . 'ret=succ';
			$this->Log($log_msg, $log_file_name, $log_folder);

			pclose($handle);
			return true;
		}

		$log_msg = $base_log_msg . 'ret=fail';
		$this->Log($log_msg, $log_file_name, $log_folder);

		return false;
	}

	//接收批次前缀数据
	public function ReceiveBatchPrefix()
	{
		$sign = $this->sign;
		$func_name = strtolower(__FUNCTION__);
		$log_folder = $sign;
		$log_file_name = $this->receive_batch_code;
		$cur_date_int = date('YmdH');
		$cur_date_str = date('Y-m-d H:i:s');
		$log_msg = '['.$func_name.']  ---------------------------- [begin]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		$batch = httpGetVal('batch');
		$platform_sign = httpGetVal('platform_sign');

		if (!empty($batch) && !empty($platform_sign))
		{
			$my_sign = 'platform_batch_prefix';
			$base_path = PATH_DATA . $my_sign . '/';
			mkdir_recyle($base_path);
			
			$file = $base_path . 'batch_' . $platform_sign . '.php';

			if (!file_exists($file))
			{
				$str_log  = "<?php \r\n";
				$str_log .= '//@' . $cur_date_str . "\r\n";
				$str_log .= '$platform_batch_prefix  = array();'. "\r\n";
				@file_put_contents($file, $str_log);
				@chmod($file, 0777);
			}

			$str_log = "\r\n" . '//@' . $cur_date_str . "\r\n";
			$str_log .= '$platform_batch_prefix["'.$batch.'"] = 1 ;'. "\r\n";
			@file_put_contents($file, $str_log, FILE_APPEND);
			@chmod($file, 0777);

			$log_msg = $platform_sign . ' -- batch_prefix=' . $batch . ' -- succ';
			$this->Log($log_msg, $log_file_name, $log_folder);
		}

		$log_msg = '['.$func_name.'] ---------------------------- [end]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		echo 'succ';
		exit;
	}

	//同步到pl
	public function SyncBatchCodeToPl()
	{
		global $sync_act_code_to_pl, $common_area_sign,$common_second_domain;
		ini_set('memory_limit', '612M');

		$msg = '';
		$sign = $this->sign;
		$func_name = strtolower(__FUNCTION__);
		$need_sync = false;
		$log_folder = $sign;
		$log_file_name = $func_name;

		if (!empty($sync_act_code_to_pl) && !empty($common_area_sign) && !empty($common_second_domain))
		{
			if (isset($sync_act_code_to_pl[$common_area_sign]) && 1 == $sync_act_code_to_pl[$common_area_sign])
			{
				$need_sync = true;
			}
		}

		if (!$need_sync)
		{
			$err_msg = 'this platform not suport -- ' . $func_name;
			$this->ShowErrorMsg($err_msg);
		}

		$author = httpGetVal('author');

		$cur_date_int = date('YmdH');
		$cur_date_str = date('Y-m-d H:i:s');
		$log_msg = '['.$func_name.'] -- author='.$author.' ---------------------------- [begin]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		//获取所有有效批次数据
		$tbl_activation_code_batch = $this->tbl_activation_code_batch;

		$code_result = array();
		$db = $this->getDb();
		$select_arr = array('id', 'tbl_code_lib');
		$cond_arr = array();
		$cond_arr['end_time[>]'] = $cur_date_str;
		$batch_data = $db->select($tbl_activation_code_batch, $select_arr);

		if (!empty($batch_data))
		{
			$arr_tbl_code_lib = array();

			foreach($batch_data as $detail)
			{
				$batch_id = $detail['id'];
				$tbl_code_lib = $detail['tbl_code_lib'];
				!isset($arr_tbl_code_lib[$tbl_code_lib]) && $arr_tbl_code_lib[$tbl_code_lib] = array();
				$arr_tbl_code_lib[$tbl_code_lib][] = $batch_id;
			}

			foreach ($arr_tbl_code_lib as $_tbl_code_lib => $batch_id_arr) 
			{
				$cond_arr = array();
				$cond_arr['batch_id'] = $batch_id_arr;
				$tbl_code_lib = trim($_tbl_code_lib, 'tbl_');
				$code_data = $db->select($tbl_code_lib, 'code', $cond_arr);

				if (!empty($code_data))
				{
					foreach($code_data as $code_detail)
					{
						$code = $code_detail['code'];
						$code_result[$code] = 1;
					}
				}
			}

			if (!empty($code_result))
			{
				$content = "<?php \r\n ";
				$content .= '//@' . $cur_date_str . "\r\n";
				$content .= "\r". '$act_code_map = ' . var_export($code_result,true) . ";\r\n";
				$content .= '?>';
				$base_url = 'pl'.$common_second_domain;
				$url = $base_url.'/act_gift/receive_act_code.php?t='.time();
				$response = $this->sendStreamFile($url, $content);
				empty($response) && $response = 'fail';
				$log_msg = $url . ' -- ' . $response;
				$this->Log($log_msg, $log_file_name, $log_folder);
			}
			else
			{
				$log_msg = 'no code data to sync';
				$this->Log($log_msg, $log_file_name, $log_folder);
			}
		}
		else
		{
			$log_msg = 'no batch data to sync';
			$this->Log($log_msg, $log_file_name, $log_folder);
		}

		
		$log_msg = '['.$func_name.'] -- author='.$author.'---------------------------- [end]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		echo 'succ';
		exit;
	}

	//////////供后台主动调用
	//同步所有的激活码批次
	//php interface.php ActCode SyncAllBatchPrefix
	public function SyncAllBatchPrefix()
	{
		global $sync_batch_map, $common_area_sign, $platform_domain_map;

		$msg = '';
		$sign = $this->sign;
		$func_name = strtolower(__FUNCTION__);
		$log_folder = $sign;
		$log_file_name = $func_name;
		$domain = '';

		if (!empty($sync_batch_map) && !empty($common_area_sign) && !empty($platform_domain_map))
		{
			$sync_platform_sign = $sync_batch_map[$common_area_sign];

			if (!empty($platform_domain_map[$sync_platform_sign]))
			{
				$domain = $platform_domain_map[$sync_platform_sign];
			}
		}

		if ('' == $domain)
		{
			$err_msg = 'this platform not suport -- ' . $func_name;
			$this->ShowErrorMsg($err_msg);
		}

		$cur_date_int = date('YmdH');
		$cur_date_str = date('Y-m-d H:i:s');
		$log_msg = '['.$func_name.']  ---------------------------- [begin]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		//获取所有有效批次数据
		$tbl_activation_code_batch = $this->tbl_activation_code_batch;

		$platform_batch_prefix = array();
		$db = $this->getDb();
		$cond_arr = array();
		$batch_data = $db->select($tbl_activation_code_batch, 'activation_prefix');

		if (!empty($batch_data))
		{
			$arr_tbl_code_lib = array();

			foreach($batch_data as $detail)
			{
				$activation_prefix = $detail['activation_prefix'];
				$platform_batch_prefix[$activation_prefix] = 1;
			}

			if (!empty($platform_batch_prefix))
			{
				$str_log  = "<?php \r\n";
				$str_log .= '//@' . $cur_date_str . "\r\n";
				$str_log .= '$platform_batch_prefix  = '. var_export($platform_batch_prefix, true). ";\r\n";

				$url = INTERFACE_SIGN. $domain . INTERFACE_FILE . '?c=ActCode&a=ReceiveAllBatchPrefix&platform_sign=' . $common_area_sign;
				$response = $this->sendStreamFile($url, $str_log);
				empty($response) && $response = 'fail';
				$log_msg = $url . ' -- ' . $response;
				$this->Log($log_msg, $log_file_name, $log_folder);
			}
			else
			{
				$log_msg = 'no batch_prefix data to sync';
				$this->Log($log_msg, $log_file_name, $log_folder);
			}
		}
		else
		{
			$log_msg = 'no batch data to sync';
			$this->Log($log_msg, $log_file_name, $log_folder);
		}
		
		$log_msg = '['.$func_name.'] ---------------------------- [end]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		echo 'succ';
		exit;
	}

	public function ReceiveAllBatchPrefix()
	{
		$sign = $this->sign;
		$func_name = strtolower(__FUNCTION__);
		$log_folder = $sign;
		$log_file_name = $func_name;
		$cur_date_int = date('YmdH');
		$cur_date_str = date('Y-m-d H:i:s');
		$log_msg = '['.$func_name.']  ---------------------------- [begin]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		$platform_sign = httpGetVal('platform_sign');

		if (!empty($platform_sign))
		{
			$my_sign = 'platform_batch_prefix';
			$base_path = PATH_DATA . $my_sign . '/';
			mkdir_recyle($base_path);
			
			$file = $base_path . 'batch_' . $platform_sign . '.php';

			$ret = $this->receiveStreamFile($file);
			$retmsg = $ret ? 'succ' : 'fail';

			$log_msg = $platform_sign . ' -- ' . $retmsg;
			$this->Log($log_msg, $log_file_name, $log_folder);
		}

		$log_msg = '['.$func_name.'] ---------------------------- [end]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		echo $retmsg;
		exit;
	}
}
