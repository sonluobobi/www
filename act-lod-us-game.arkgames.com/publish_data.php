<?php
/**
 * 活动后台数据发布统一入口
 */
ini_set('memory_limit', '612M');
require('common.php');
require_once('libs/mysql.config.inc.php');
require_once('libs/class_activity/ClsActivityCode.php');
require_once('libs/class_activity/ClsActivityCodeBatch.php');
require_once('class_mall/DiscountManage.php');
require_once 'libs/class_mall/MallManager.php';
require_once 'functions/Utils.php';
require_once('class_activity/ClsActivity.php');
require_once('class_activity/ClsActivityItem.php');
require_once('class_activity/ClsActivityPlunderPack.php');

$publish_type = $_REQUEST['publish_type']; //发布类型
$sync_type    = $_REQUEST['sync_type'];     //同步类型分测试服、正式服）

//检查当前是否开放数据发布
if ($sync_type !='test' && !isActDataPublishOpen()) 
{
	die('正式服数据发布时间：星期一至星期五的10点至18点，其它时间禁止发布。');
}

//记录发布日志
log2File("publish_data_".$publish_type,'sync_type='.$sync_type);

############################ 初始化数据 end #################################
if ($publish_type == "activity")
{
	$actObj = new ClsActivity($DB);
	$actItemObj = new ClsActivityItem($DB);
	$actPackObj = new ClsActivityPlunderPack($DB);
	
	$condition = ' AND (end_time > NOW() and activity_sort_id = ' . ACTIVITY_SORT_ID_OPERATION_FOR_FESTIVAL . ')';
	$activityList = $actObj->getActList($condition);  // tbl_activity
	
	if (count($activityList) == 0) {
		die('目前系统没有任何活动！');
	}
	
	//将SERVER ID统一小写
	$activityList_t0 = $activityList;
	foreach ($activityList_t0 as $key => $act) {
		$activityList[$key]['server_ids'] = strtolower($activityList[$key]['server_ids']);
	}
	
	$actIN = '0';
	if (count($activityList) > 0) {
		foreach ($activityList as $act) {
			$actIN = $actIN.','.$act['id'];
		}
	}
	
	//组装一个以活动ID为键值的数组
	$activityArr = array();
	foreach ($activityList as $activity_t) 
	{
		$activityArr[$activity_t['id']] = $activity_t;
	}
	
	//echo "<pre>"; print_r($activityListNew); die();	
	$activityItemArr = $actItemObj->getActItemList(' AND `activity_id` IN (' . $actIN . ')');
	$plunderPackArr = $actPackObj->getActPackList(' AND `activity_id` IN (' . $actIN . ')');
	//echo "<pre>"; print_r($activityItemArr ); die();	
	
	$arr_publish_data = array();		//所有当前有效的各个服务器的活动
	
	$opcode   = OPCODE_PUBLISH_DATA ;
	//echo "<pre>"; print_r($activityArr ); 
	$activity_data = formatActivityDataNew($activityArr,$activityItemArr,$sync_type);
		
	$arr_failed_server = array();
	
	if (is_array($activity_data) && count($activity_data) > 0)
	{
		//file_put_contents("/tmp/liao_data.log", var_export($activity_data,true));
		
		$arr_node = $activity_data;
		
		$ret_msg = "发布失败的游戏服：";
		$all_ok  = true;
		$results = multiple_request_handle($arr_node);
		foreach ($results as $server_id=>$item)
		{
			if ($item['retcode'] != 0)
			{
				$all_ok = false;
				$ret_msg .= $item['retmsg'].';';
			}
		}
		
		if (!$all_ok) {
			die($ret_msg);
		}else {
			die('数据发布完毕！');
		}
		
	}
	else 
	{
		die('目前无活动数据可供发布！');
	}
	
}
//发布激活码批次信息
elseif ($publish_type == "act_code")
{
	$obj_activity_code = new ClsActivityCode();
	$obj_activity_code_batch = new ClsActivityCodeBatch();

	//过滤掉过期的批次
	$condition = " AND DATE_FORMAT(`end_time`,'%Y%m%d') >=".date('Ymd');
	$code_batch_arr = $obj_activity_code_batch->getBatchList($condition);

	$arr_failed_server = array();
	if (count($code_batch_arr) > 0)
	{
		/*
		if (!empty($sync_act_code_to_pl) && !empty($common_area_sign) && !empty($common_second_domain))
		{
			if (isset($sync_act_code_to_pl[$common_area_sign]) && 1 == $sync_act_code_to_pl[$common_area_sign])
			{
				//同步到pl后台
				$author = $_SESSION['username'];
				$sync_pl_url = INTERFACE_SIGN. $common_second_domain . INTERFACE_FILE . '?c=ActCode&a=SyncBatchCodeToPl&author=' . $author;
				$tmp_content = 'SyncBatchCodeToPl';
				func_sendStreamFile($sync_pl_url, $tmp_content);
			}
		}
		//*/


		$activity_data = formatActivityDataForCode($code_batch_arr,$sync_type);

		//file_put_contents("/tmp/liao_data.log", var_export($activity_data,true));
		if (count($activity_data) > 0)
		{
			$arr_node = $activity_data;
			
			$ret_msg = "发布失败的游戏服：";
			$all_ok  = true;
			$results = multiple_request_handle($arr_node);

			foreach ($results as $server_id=>$item)
			{
				if ($item['retcode'] != 0)
				{
					$all_ok = false;
					$ret_msg .= $item['retmsg'].';';
				}
			}
			
			if (!$all_ok) {
				die($ret_msg);
			}else {
				die('数据发布完毕！');
			}
		}
		else 
		{
			die("目前没有激活码批次数据可发布2！\n");
		}
		
	}
	else 
	{
		die("目前没有激活码批次数据可发布1！\n");
	}
	
}
//发布打折信息（洗炼、商品折扣）
elseif ($publish_type == "discount")
{
	$chaosObj = new DiscountManage($DB);
	//$condition = " AND end_time > NOW() ";
	$discount_arr = $chaosObj->getDiscountList($condition);
	if (is_array($discount_arr) && count($discount_arr) > 0)
	{
		$arr_failed_server = array();
		
		$activity_data = formatActivityDataForDiscount($discount_arr,$sync_type);
		
		if (count($activity_data) > 0)
		{
			$arr_node = $activity_data;
			
			$ret_msg = "发布失败的游戏服：";
			$all_ok  = true;
			$results = multiple_request_handle($arr_node);
			foreach ($results as $server_id=>$item)
			{
				if ($item['retcode'] != 0)
				{
					$all_ok = false;
					$ret_msg .= $item['retmsg'].';';
				}
			}
			
			if (!$all_ok) {
				die($ret_msg);
			}else {
				die('数据发布完毕！');
			}
		}
		else
		{
			die("目前没有打折数据可发布！\n");
		}
		
	}
	else 
	{
		die("目前没有打折数据可发布！\n");
	}
	
}

//发布商城数据
elseif ($publish_type == "mall_data")
{
	$mallObj = new MallManager($DB);
	$condition = " DATE_FORMAT(`sale_end`,'%Y%m%d') >=".date('Ymd');
	$activity_arr = $mallObj->getMallData($condition);
		
	$activity_data = formatMallData($activity_arr,$sync_type);
		
	
	if (is_array($activity_data) && count($activity_data) > 0)
	{
		$arr_failed_server = array();
		
		$arr_node = $activity_data;
		$ret_msg = "发布失败的游戏服：";
		$all_ok  = true;
		//$results = multiple_request_handle($arr_node);
		$results = multiple_request_handle($arr_node);
		
		foreach ($results as $server_id=>$item)
		{
			if ($item['retcode'] != 0)
			{
				$all_ok = false;
				$ret_msg .= $item['retmsg'].';';
			}
		}
		
		if (!$all_ok) {
			die($ret_msg);
		}else {
			die('数据发布完毕！');
		}
		
	}
	else 
	{
		die("目前没有数据可发布！\n");
	}	
}
elseif ($publish_type == "i18n")
{

	$cur_date = date('Y-m-d H:i:s');
	//die('not open yet --' . $cur_date);

	if (empty($lang_map))
	{
		die('语言列表未定义--'.$cur_date);
	}

	$data = getI18nData();

	if (empty($data))
	{
		die('目前没有语言包可发布--'.$cur_date);
	}

	$arr_node = formatI18n($data, $sync_type);

	if (empty($arr_node))
	{
		die('目前没有游戏服可发布--'.$cur_date);
	}
	
	$ret_msg = "发布失败的游戏服：";
	$all_ok  = true;
	$results = multiple_request_handle($arr_node);
	foreach ($results as $server_id=>$item)
	{
		if ($item['retcode'] != 0)
		{
			$all_ok = false;
			$ret_msg .= $item['retmsg'].';';
		}
	}
	
	if (!$all_ok) {
		die($ret_msg.'--'. $cur_date);
	}else {
		die('数据发布完毕！--'. $cur_date);
	}
}
elseif ($publish_type == "test")
{

	$cur_date = date('Y-m-d H:i:s');
	//die('not open yet --' . $cur_date);

	if (empty($lang_map))
	{
		die('语言列表未定义--'.$cur_date);
	}

	$data = getI18nData();
	$arr_node = formatI18n($data, $sync_type);
	echo '<pre>';print_r($arr_node);exit;
}
elseif ($publish_type == 'gashapon_data')
{
	require_once('libs/mysql.medoo.php');
	//扭蛋活动
	$cur_date = date('Y-m-d H:i:s');
	//die('not open yet --' . $cur_date);
	
	$where_arr = array('end_time[>]' => $cur_date);
	$select_fields = array('id','item_id', 'start_time', 'end_time', 'server_ids');
	$data_arr = $medoo_db->select('activity_gashapon', $select_fields, $where_arr);
		
	$activity_data = formatGashaponData($data_arr,$sync_type);
	//print_r($activity_data);exit;
		
	
	if (is_array($activity_data) && count($activity_data) > 0)
	{
		$arr_failed_server = array();
		
		$arr_node = $activity_data;
		$ret_msg = "发布失败的游戏服：";
		$all_ok  = true;
		//$results = multiple_request_handle($arr_node);
		$results = multiple_request_handle($arr_node);
		
		foreach ($results as $server_id=>$item)
		{
			if ($item['retcode'] != 0)
			{
				$all_ok = false;
				$ret_msg .= $item['retmsg'].';';
			}
		}
		
		if (!$all_ok) {
			die($ret_msg);
		}else {
			die('数据发布完毕！');
		}
		
	}
	else 
	{
		die("目前没有数据可发布！\n");
	}	
}


//获取所有活动及活动项数据
function getActAndItemForI18n()
{
	global $DB;

	$ret = array();
	$arr_act = array();
	$arr_act_item = array();
	$actObj = new ClsActivity($DB);
	$actItemObj = new ClsActivityItem($DB);

	$where = 'published=1 and end_time > NOW() and activity_sort_id = ' . ACTIVITY_SORT_ID_OPERATION_FOR_FESTIVAL;
	$activityList = $actObj->getAllAct('id,title,intro', $where); 

	if (count($activityList) > 0) 
	{
		$actIN = '0';
		foreach ($activityList as $act_info) 
		{
			$act_id = $act_info['id'];
			$actIN = $actIN.','.$act_id;

			$arr_act[$act_id] = $act_info;
		}

		$where = '`activity_id` IN (' . $actIN . ')';
		$activityItemArr = $actItemObj->getAllActItem('id,title', $where);
		if (!empty($activityItemArr))
		{
			foreach ($activityItemArr as $activity_item)
			{
				$activity_item_id = $activity_item['id'];

				$arr_act_item[$activity_item_id] = $activity_item;
			}
		}
	}

	$ret['act'] = $arr_act;
	$ret['act_item'] = $arr_act_item;

	return $ret;
}

function getI18nData()
{
	global $lang_map;

	$ret = array();
	$cache_path = INCLUDE_PATH . '/data/i18n/lang/';

	$target_translation_map = array();
	$target_translation_file = INCLUDE_PATH . '/data/i18n/target_translation.php';

	if (file_exists($target_translation_file))
	{
		require $target_translation_file;
	}

	if (empty($target_translation_map))
	{
		//return $ret;
	}

	foreach($lang_map as $lang => $lang_title)
	{
		$ret[$lang] = array();
		$cache_file = $cache_path . 'i18n_act_' . $lang . '.php';
		$cache_list = array();

		if (file_exists($cache_file))
		{
			include $cache_file;
		}

		if (!empty($cache_list))
		{
			$tmp_ret = array();

			foreach($cache_list as $cache_info)
			{
				$field = $cache_info['key'];

				if (isset($cache_info['sign']) && !empty($target_translation_map))
				{
					$sign = trim($cache_info['sign']);

					if ($sign && isset($target_translation_map[$sign]))
					{
						$field = $target_translation_map[$sign];
					}
				}

				$value = $cache_info['value'];
				$ret[$lang][$field] = $value;
			}
		}
	}

	return $ret;
}

function formatI18n($data, $sync_type)
{
	global $ALL_CONFIG_SERVER;

	$act = array(
		'op' => OP_GMT_FIX_OPEACTIVITY_PUB_LANG_PACK,
		'activity_lang_packs' => $data,
	);
	
	$arr_node = array();

	foreach ($ALL_CONFIG_SERVER as $server_id=>$server_config)
	{
		$tmp_node = array();
		$tmp_node['server_id'] = $server_id;
		$tmp_node['server_domain'] = $server_config['server_name'];
		$tmp_node['act'] = $act;

		if ($sync_type == 'offical' && $server_config['is_offical'] == 1)
		{
			$arr_node[] = $tmp_node;
		}
		elseif ($sync_type == 'test' && $server_config['is_offical'] == 0)
		{
			$arr_node[] = $tmp_node;
		}
	}

	return $arr_node;
}

/**
 * 封装激活码批次活动数据
 * @param unknown_type $activity_arr 活动列表
 * @param unknown_type $activity_item_arr 活动项列表
 */
function formatActivityDataForCode($batch_code_arr,$sync_type="all")
{
	global $ALL_CONFIG_SERVER;
	
	$activity_data = array();
	
	foreach ($batch_code_arr as $key=>&$batch_item)
	{
		unset($batch_item['tbl_code_lib'],$batch_item['tbl_code_use']);
		if (isset($batch_item['batch_type'])) unset($batch_item['batch_type']);
		if (isset($batch_item['sync_status'])) unset($batch_item['sync_status']);
		
		//重新封装批次礼包
		$gift_pack_conent = $batch_item['gift_pack'];
		$gift_pack = "";
		if ($batch_item['gift_pack'])
		{
			$tmp_content_arr = explode("|", $batch_item['gift_pack']);
			foreach ($tmp_content_arr as $gift_item)
			{
				$tmp_gift_arr = explode(",", $gift_item);
				if (count($tmp_gift_arr) == 3)
				{
					$gift_pack .= $tmp_gift_arr[1].','.$tmp_gift_arr[2].'|';
				}
				elseif (count($tmp_gift_arr) == 2)
				{
					$gift_pack .= $tmp_gift_arr[0].','.$tmp_gift_arr[1].'|';
				}
			}			
			$gift_pack = substr($gift_pack, 0,-1);
			$batch_item['gift_pack'] = $gift_pack;
			
		}
		
		$server_ids = $batch_item['server_ids']; //服务器id
		$arr_server_id = explode(",",(string)$server_ids);
		
		foreach ($arr_server_id as $server_ids)
		{
			//发布所有服
			if ($server_ids == 'all_server' )
			{
				foreach ($ALL_CONFIG_SERVER as $server_id=>$server_config)
				{
					if ($server_config['is_offical'] == 0) continue;
			
					if (!isset($activity_data[$server_id]))
					{
						$activity_data[$server_id] = array();
						$activity_data[$server_id]['batch_arr'] = array();
					}
					$activity_data[$server_id]['batch_arr'][] = $batch_item;
				}
			}
			else
			{
				//适合一段范围的服务器，例如：s6_s55;s1-xunlei_s55-xunlei;
				if (is_integer(strpos($server_ids, '_')))
				{
					$server_id_list = array();
						
					$tmp_server_arr = explode('_', $server_ids);
					//联运服务器格式：s1-xunlei
					if (is_integer(strpos($tmp_server_arr[0], '-')))
					{
						$start_arr = explode('-',$tmp_server_arr[0]);
						$end_arr   = explode('-',$tmp_server_arr[1]);
						
						$start_index = preg_replace('/[a-zA-Z]/','',$start_arr[0]);
						$end_index   = preg_replace('/[a-zA-Z]/','',$end_arr[0]);
						
						$server_prefix = preg_replace('/[0-9]/','',$start_arr[0]); // s
						$server_suffix  = $start_arr[1]; //xunlei
						
						for($k = $start_index;$k<= $end_index;$k++)
						{
							$real_server_id = $server_prefix.$k.'-'.$server_suffix;
							$server_id_list[] = $real_server_id;
						}
					}
					//官服：s6_s55
					else
					{
						$start_index = preg_replace('/[a-zA-Z]/', '', $tmp_server_arr[0]);
						$end_index   = preg_replace('/[a-zA-Z]/', '', $tmp_server_arr[0]);
						
						$server_prefix = preg_replace('/[0-9]/', '', $tmp_server_arr[0]); // s
						
						for ($k = $start_index; $k<= $end_index;$k++) 
						{
							$server_id_list[] = $server_prefix.$k;
						}
					}
			
					if (count($server_id_list) > 0)
					{
						foreach ($server_id_list as $real_server_id)
						{
							if (!isset($activity_data[$real_server_id]))
							{
								$activity_data[$real_server_id] = array();
								$activity_data[$real_server_id]['batch_arr'] = array();
							}
							$activity_data[$real_server_id]['batch_arr'][] = $batch_item;
						}
					}
				}
				else
				{
					if (!isset($activity_data[$server_ids]))
					{
						$activity_data[$server_ids] = array();
						$activity_data[$server_ids]['batch_arr'] = array();
					}
					$activity_data[$server_ids]['batch_arr'][] = $batch_item;
				}
			}
		}
	}
		
	$arr_node = array();

	//测试服、正式服数据筛选
	foreach ($activity_data as $server_id=>$item_arr)
	{
		if (!isset($ALL_CONFIG_SERVER[$server_id]))
		{
			unset($activity_data[$server_id]);
			continue;
		}
				
		if ($sync_type == 'test') //测试服
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 1) {
				unset($activity_data[$server_id]);
				continue;
			}
		}
		elseif ($sync_type == 'offical') //官服
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0) 
			{
				unset($activity_data[$server_id]);
				continue;
			}
			
			if ($ALL_CONFIG_SERVER[$server_id]['type'] != 'jd')
			{
				unset($activity_data[$server_id]);
				continue;
			}
		}
		elseif ($sync_type == 'union') //联运
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0)
			{
				unset($activity_data[$server_id]);
				continue;
			}
				
			if ($ALL_CONFIG_SERVER[$server_id]['type'] == 'jd')
			{
				unset($activity_data[$server_id]);
				continue;
			}
		}
		
		$act = array(
				'op' => OPCODE_PUBLISH_DATA,
				'publish_type'  => PUBLISH_TYPE_FOR_ACTIVATION_CODE,
				'activity_data' => $item_arr['batch_arr'],
		);
			
		$server_domain = $ALL_CONFIG_SERVER[$server_id]['server_name'];
		if (!isset($arr_node[$server_id])) {
			$arr_node[$server_id] = array();
		}
		$arr_node[$server_id] = array('server_id'=>$server_id,'server_domain'=>$server_domain,'act'=>$act);
		
		
	}
	$arr_node = array_values($arr_node);
	
	return $arr_node;
	
}

/**
 * 封装打折活动数据
 * @param unknown_type $activity_arr 活动列表
 */
function formatActivityDataForDiscount($activity_arr,$sync_type="all")
{
	global $ALL_CONFIG_SERVER;
	
	$activity_data = array();
		
	foreach ($activity_arr as $id=>$activity)
	{
		$server_ids  = $activity['server_ids'];
		$activity_id = $activity['id'];
		$sort_id     = $activity['sort_id'];
		
		unset($activity['server_ids']);

		if ($server_ids == "all-all")
		{
			foreach ($ALL_CONFIG_SERVER as $server_id=>$item)
			{
				if (!isset($activity_data[$server_id]))
				{
					$activity_data[$server_id] = array();
				}
				$activity_data[$server_id][$activity_id] = $activity;
					
			}
		}
		else
		{
			$server_id_arr = explode(",",$server_ids);
			foreach ($server_id_arr as $server_id)
			{
				$tmp_data = explode('-', $server_id);
				if (count($tmp_data) == 2 && $tmp_data[1] == 'jd') 
				{
					$server_id = $tmp_data[0];
				}
				
				if (!isset($activity_data[$server_id]))
				{
					$activity_data[$server_id] = array();
				}
				$activity_data[$server_id][$activity_id] = $activity;
			}
		}
	}
	
	foreach ($activity_data as $server_id=>$item)
	{
		if (!isset($ALL_CONFIG_SERVER[$server_id]))
		{
			unset($activity_data[$server_id]);
			continue;
		}
		
		if ($sync_type == 'test') //测试服
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 1) {
				unset($activity_data[$server_id]);
				continue;
			}
		}
		elseif ($sync_type == 'offical') //官服
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0) 
			{
				unset($activity_data[$server_id]);
				continue;
			}
			
			if ($ALL_CONFIG_SERVER[$server_id]['type'] != 'jd')
			{
				unset($activity_data[$server_id]);
				continue;
			}
		}
		elseif ($sync_type == 'union') //联运
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0)
			{
				unset($activity_data[$server_id]);
				continue;
			}
				
			if ($ALL_CONFIG_SERVER[$server_id]['type'] == 'jd')
			{
				unset($activity_data[$server_id]);
				continue;
			}
		}
		
		$act = array(
				'op' => OPCODE_PUBLISH_DATA, //
				'publish_type'  => PUBLISH_TYPE_FOR_DISCOUNT, //
				'activity_data' => $item,//$item
		);
			
		$server_domain = $ALL_CONFIG_SERVER[$server_id]['server_name'];
		if (!isset($arr_node[$server_id])) {
			$arr_node[$server_id] = array();
		}
		$arr_node[$server_id] = array('server_id'=>$server_id,'server_domain'=>$server_domain,'act'=>$act);
	}
	$arr_node = array_values($arr_node);
	
	return $arr_node;
	
}


/**
 * 将活动数据记录到日志文件
 * @param unknown_type $server_id
 * @param unknown_type $data
 * @param unknown_type $data_dir
 */
function logActData2File($server_id,$data,$data_dir)
{
	$data_dir = $data_dir.'/'.$server_id;
	if (!is_dir($data_dir)) {
		mkdir($data_dir);
	}
	$act_file = $data_dir.'/activity_'.$server_id.'_'.date('YmdHis').'.inc';
	file_put_contents($act_file,"<?php\n return ");
	file_put_contents($act_file,var_export($data,true),FILE_APPEND);
	file_put_contents($act_file,";\n ?>",FILE_APPEND);
}


/**
 * 封装活动数据
 */
function formatActivityDataNew($activity_arr,$activity_item_arr,$sync_type = "test")
{
	global $ALL_CONFIG_SERVER;
	
	$activity_data = array();

	foreach ($activity_arr as $activity_id=>$activity)
	{
		$server_id_str = trim($activity['server_ids']);
		unset($activity['server_ids']);

		//发布到全服
		if ($server_id_str == 'all-all' )
		{
			foreach ($activity_item_arr as &$activity_item)
			{
				if ($activity_item['activity_id'] == $activity_id)
				{
					if (empty($activity_item['start_datetime']) || empty($activity_item['end_datetime']))
					{
						$error_msg = '请正确配置活动id='.$activity_id . ' 其子项id=' . $activity_item['id'] . ' 的开始结束时间';
						die($error_msg);
					}

					if (!isset($activity_data[$server_id][$activity_id]))
					{
						foreach ($ALL_CONFIG_SERVER as $server_id=>$item)
						{
							$activity_data[$server_id][$activity_id] = array();
							$activity_data[$server_id][$activity_id] = array();
							$activity_data[$server_id][$activity_id]['activity']      = $activity;
							$activity_data[$server_id][$activity_id]['activity_item_arr'] = array();
						}
					}
	
					//处理奖励项
					$tmp_arr = explode("|",$activity_item['reward_equip_ids']);
					if ($tmp_arr)
					{
						$tmp_reward_ids = "";
						foreach ($tmp_arr as $arr)
						{
							$data_arr = explode(",",$arr);
							if (count($data_arr) == 2)
							{
								$tmp_reward_ids .= $data_arr[1]."|";
							}
							else
							{
								$tmp_reward_ids .= $arr."|";
							}
						}
						$tmp_reward_ids = substr($tmp_reward_ids,0,-1);
						$activity_item['reward_equip_ids'] = $tmp_reward_ids;
					}
	
					//处理条件项
					$tmp_arr = explode("|",$activity_item['need_equip_ids']);
					if ($tmp_arr)
					{
						$tmp_need_ids = "";
						foreach ($tmp_arr as $arr)
						{
							$data_arr = explode(",",$arr);
							if (count($data_arr) == 2)
							{
								$tmp_need_ids .= $data_arr[1]."|";
							}
							else
							{
								$tmp_need_ids .= $arr."|";
							}
						}
						$tmp_need_ids = substr($tmp_need_ids,0,-1);
						$activity_item['need_equip_ids'] = $tmp_need_ids;
					}
	
					$activity_item['intro'] = htmlspecialchars_decode($activity_item['intro'], ENT_NOQUOTES);
					
					foreach ($ALL_CONFIG_SERVER as $server_id=>$item) {
						$activity_data[$server_id][$activity_id]['activity_item_arr'][] = $activity_item;
					}
				}
			}
		}
		else
		{
			$server_id_arr = explode(",",$server_id_str);
	
			foreach ($server_id_arr as $server_id)
			{
				if (!isset($ALL_CONFIG_SERVER[$server_id])) continue;
				
				foreach ($activity_item_arr as &$activity_item)
				{
					if ($activity_item['activity_id'] == $activity_id)
					{
						if (empty($activity_item['start_datetime']) || empty($activity_item['end_datetime']))
						{
							$error_msg = '请正确配置活动id='.$activity_id . ' 其子项id=' . $activity_item['id'] . ' 的开始结束时间';
							die($error_msg);
						}

						if (!isset($activity_data[$server_id][$activity_id])) {
							$activity_data[$server_id][$activity_id] = array();
							$activity_data[$server_id][$activity_id] = array();
							$activity_data[$server_id][$activity_id]['activity']      = $activity;
							$activity_data[$server_id][$activity_id]['activity_item_arr'] = array();
	
						}
	
						//处理奖励项
						$tmp_arr = explode("|",$activity_item['reward_equip_ids']);
						if ($tmp_arr)
						{
							$tmp_reward_ids = "";
							foreach ($tmp_arr as $arr)
							{
								$data_arr = explode(",",$arr);
								if (count($data_arr) == 2)
								{
									$tmp_reward_ids .= $data_arr[1]."|";
								}
								else
								{
									$tmp_reward_ids .= $arr."|";
								}
							}
							$tmp_reward_ids = substr($tmp_reward_ids,0,-1);
							
							$activity_item['reward_equip_ids'] = $tmp_reward_ids;
						}
	
						//处理条件项
						$tmp_arr = explode("|",$activity_item['need_equip_ids']);
						if ($tmp_arr)
						{
							$tmp_need_ids = "";
							foreach ($tmp_arr as $arr)
							{
								$data_arr = explode(",",$arr);
								if (count($data_arr) == 2)
								{
									$tmp_need_ids .= $data_arr[1]."|";
								}
								else
								{
									$tmp_need_ids .= $arr."|";
								}
							}
							$tmp_need_ids = substr($tmp_need_ids,0,-1);
							$activity_item['need_equip_ids'] = $tmp_need_ids;
						}
						
						$activity_item['intro'] = htmlspecialchars_decode($activity_item['intro'], ENT_NOQUOTES);
						$activity_data[$server_id][$activity_id]['activity_item_arr'][] = $activity_item;
						
						unset($activity_item);
					}
				}
			}
		}
	}
	
	$arr_node = array();
	
	//测试服、正式服检查
	foreach ($activity_data as $server_id=>$item)
	{
		if (!isset($ALL_CONFIG_SERVER[$server_id])) 
		{
			unset($activity_data[$server_id]);
			continue;
		}
				
		if ($sync_type == 'test') //测试服
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 1) {
				unset($activity_data[$server_id]);
				continue;
			}
		}
		elseif ($sync_type == 'offical') //官服
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0) 
			{
				unset($activity_data[$server_id]);
				continue;
			}
			
			if ($ALL_CONFIG_SERVER[$server_id]['type'] != 'jd')
			{
				unset($activity_data[$server_id]);
				continue;
			}
			
		}
		elseif ($sync_type == 'union') //联运
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0)
			{
				unset($activity_data[$server_id]);
				continue;
			}
				
			if ($ALL_CONFIG_SERVER[$server_id]['type'] == 'jd')
			{
				unset($activity_data[$server_id]);
				continue;
			}
		}
		
		$act = array(
				'op' => OPCODE_PUBLISH_DATA,
				'publish_type'  => PUBLISH_TYPE_FOR_ACTIVITY,
				'activity_data' => $item,
				'plunder_pack'  => array(),
		);
			
		$server_domain = $ALL_CONFIG_SERVER[$server_id]['server_name'];
		if (!isset($arr_node[$server_id])) {
			$arr_node[$server_id] = array();
		}
		
		//if ($server_id !='s4') continue;
		
		$arr_node[$server_id] = array('server_id'=>$server_id,'server_domain'=>$server_domain,'act'=>$act);
	}	
	
	$arr_node = array_values($arr_node);
	
	return $arr_node;

}

/**
 * 封装活动商城数据
 */
function formatMallData($activity_arr,$sync_type ='all')
{
	global $ALL_CONFIG_SERVER;
	
	$activity_data = array();
	foreach ($activity_arr as $activity)
	{
		$server_ids  = $activity['server_ids'];
		$activity_id = $activity['id'];
		
		unset($activity['server_ids']);
			
		if ($server_ids == 'all-all')
		{
			foreach ($ALL_CONFIG_SERVER as $server_id=>$item)
			{
				if (!isset($activity_data[$server_id]))
				{
					$activity_data[$server_id] = array();
				}
				$activity_data[$server_id][$activity_id] = $activity;
			}
		}
		else
		{
			$server_id_arr = explode(",",$server_ids);
			foreach ($server_id_arr as $server_id)
			{
				if (is_integer(strpos($server_id, 'jd'))) {
					$server_id = str_replace("-jd", '', $server_id);
				}
		
				if (!isset($ALL_CONFIG_SERVER[$server_id])) continue;
		
				if (!isset($activity_data[$server_id]))
				{
					$activity_data[$server_id] = array();
				}
				$activity_data[$server_id][$activity_id] = $activity;
			}
		}
	}
		
	$arr_node = array();
	//测试服、正式服检查
	foreach ($activity_data as $server_id=>$item)
	{
		if (!isset($ALL_CONFIG_SERVER[$server_id]))
		{
			unset($activity_data[$server_id]);
			continue;
		}
	
		if ($sync_type == 'test') //测试服
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 1) {
				unset($activity_data[$server_id]);
				continue;
			}
		}
		elseif ($sync_type == 'offical') //官服
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0) 
			{
				unset($activity_data[$server_id]);
				continue;
			}
			
			if ($ALL_CONFIG_SERVER[$server_id]['type'] != 'jd')
			{
				unset($activity_data[$server_id]);
				continue;
			}
			
		}
		elseif ($sync_type == 'union') //联运
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0)
			{
				unset($activity_data[$server_id]);
				continue;
			}
				
			if ($ALL_CONFIG_SERVER[$server_id]['type'] == 'jd')
			{
				unset($activity_data[$server_id]);
				continue;
			}
		}
		
		$act = array(
				'op' => OPCODE_PUBLISH_DATA,
				'publish_type'  => PUBLISH_TYPE_FOR_MALL,
				'activity_data' => $item,
		);
		
		/*
		$act = array(
				'op' => 1,
				'publish_type'  => 100,
				'activity_data' => $item,
				
		);*/
					
		$server_domain = $ALL_CONFIG_SERVER[$server_id]['server_name'];
		if (!isset($arr_node[$server_id])) {
			$arr_node[$server_id] = array();
		}
		$arr_node[$server_id] = array('server_id'=>$server_id,'server_domain'=>$server_domain,'act'=>$act);
	}
	$arr_node = array_values($arr_node);
	
	return $arr_node;
	
}

//封装扭蛋活动
function formatGashaponData($activity_arr,$sync_type ='all')
{
	global $ALL_CONFIG_SERVER;
	
	$activity_data = array();
	foreach ($activity_arr as $activity)
	{
		$server_ids  = $activity['server_ids'];
		$activity_id = $activity['id'];
		
		unset($activity['server_ids']);
			
		if ($server_ids == 'all_server')
		{
			foreach ($ALL_CONFIG_SERVER as $server_id=>$item)
			{
				if (!isset($activity_data[$server_id]))
				{
					$activity_data[$server_id] = array();
				}
				$activity_data[$server_id][$activity_id] = $activity;
			}
		}
		else
		{
			$server_id_arr = explode(",",$server_ids);
			foreach ($server_id_arr as $server_id)
			{
				if (!isset($ALL_CONFIG_SERVER[$server_id])) continue;
		
				if (!isset($activity_data[$server_id]))
				{
					$activity_data[$server_id] = array();
				}
				$activity_data[$server_id][$activity_id] = $activity;
			}
		}
	}
		
	$arr_node = array();
	//测试服、正式服检查
	foreach ($activity_data as $server_id=>$item)
	{
		if (!isset($ALL_CONFIG_SERVER[$server_id]))
		{
			unset($activity_data[$server_id]);
			continue;
		}
	
		if ($sync_type == 'test') //测试服
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 1) {
				unset($activity_data[$server_id]);
				continue;
			}
		}
		elseif ($sync_type == 'offical') //官服
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0) 
			{
				unset($activity_data[$server_id]);
				continue;
			}
			
			if ($ALL_CONFIG_SERVER[$server_id]['type'] != 'jd')
			{
				unset($activity_data[$server_id]);
				continue;
			}
			
		}
		elseif ($sync_type == 'union') //联运
		{
			if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0)
			{
				unset($activity_data[$server_id]);
				continue;
			}
				
			if ($ALL_CONFIG_SERVER[$server_id]['type'] == 'jd')
			{
				unset($activity_data[$server_id]);
				continue;
			}
		}
		
		$act = array(
				'op' => OP_GMT_GASHAPON,
				'data' => $item,
		);
		
		$server_domain = $ALL_CONFIG_SERVER[$server_id]['server_name'];
		if (!isset($arr_node[$server_id])) {
			$arr_node[$server_id] = array();
		}
		$arr_node[$server_id] = array('server_id'=>$server_id,'server_domain'=>$server_domain,'act'=>$act);
	}
	$arr_node = array_values($arr_node);
	
	return $arr_node;
	
}

/**
 * 多进程处理活动发布
 * @param array $nodes = array(
 * 								array('server_id'=>,'server_domain'=>,'act'=>),
 * 								array('server_id'=>,'server_domain'=>,'act'=>),
 * )
 * @return array 
 */
function multiple_request_handle($node_list)
{
	global $RPC_REQUEST_PORT;
	global $ALL_CONFIG_SERVER;
	
	$mh = curl_multi_init();

	//$node_list表的数据
	$dead_urls      = array();
	$results        = array();
		
	/***************** 处理返回结果 START *******************************************************/
	$retmsg = '';
	//$file_log = "/tmp/moyu_act_".date('Ym').".log"; //日志文件
	$file_log = OPERATION_LOG_DIR . '/moyu_act_' . date('Ymd') . '.log';
	
	file_put_contents($file_log,"------------------------------------- START -----------------------------------------------\n",FILE_APPEND);
	
	
	$len = 30;
	$offset = 0;
	$size = count($node_list);
		
	while ($offset < $size)
	{
		$nodes = array_slice($node_list, $offset,$len);  //30条30条的执行
		$offset += $len;
	
		$arr_ch = array();

		//遍历表数据
		foreach($nodes as $i => $item)
		{
			$arr_ch[$i] = curl_init();
	
			$act = $item['act'];

			$server_domain = $item['server_domain']; //t2.sm2.kunlun.com
			$port = 443;
			$i == 's5' && $port = 6443;

			$port = $port + 4;
			$func = $act['op'];  //activity
			unset($act['op']);
	
			$data = json_encode($act);
			//$url = "http://" . $server_domain . "/webproxy.php?act=$func&port=$port";
			$url = "http://" . $server_domain . "/webproxy.php?act=$func";
			file_put_contents($file_log,"url = $url \n",FILE_APPEND);
			//file_put_contents($file_log,"data = $data \n",FILE_APPEND);
	
			$options = array(CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_POST => 1,
					//CURLOPT_CONNECTTIMEOUT => 3,
					//CURLOPT_TIMEOUT  => 4,
					CURLOPT_POSTFIELDS => array(
							"data"     => gzcompress($data),
					),
			);
				
			curl_setopt_array($arr_ch[$i], $options);
			curl_multi_add_handle($mh, $arr_ch[$i]);
			
			//file_put_contents($file_log,"options=>".var_export($act,true)."\r\n",FILE_APPEND);
		}
		
		$running = NULL;
		
		do {
			usleep(10000);
			curl_multi_exec($mh,$running);
		} while($running > 0);
		
		
		foreach ($arr_ch as $handle)
		{
			$chinfo = curl_getinfo($handle);
				
			$cur_url   = $chinfo['url'];
			$http_code = $chinfo['http_code'];
				
			$arr_info = parse_url($cur_url);
			$server_domain = $arr_info['host'];
			$sx = strstr($server_domain, '.', true);
				
			$results[$server_domain] = array();
			$results[$server_domain]['retcode']   = 0;
			$results[$server_domain]['retmsg']    = 'OK';



				
			if ($http_code == 200)
			{
				//获取执行结果
				$ret_curl = curl_multi_getcontent($handle);
				
				file_put_contents($file_log,"-------------------------------------------------------------\r\n",FILE_APPEND);
				file_put_contents($file_log,$server_domain."\r\n",FILE_APPEND);
				file_put_contents($file_log,date('Y-m-d H:i:s')."\r\n",FILE_APPEND);
				file_put_contents($file_log,"result=>".var_export($ret_curl,true)."\r\n",FILE_APPEND);
			
				if (curl_errno($handle) > 0)
				{
					$msg = curl_error($mhinfo['handle']);
					$results[$server_domain]['retcode'] = -1;
					$results[$server_domain]['retmsg']  = $msg;
			
					file_put_contents($file_log, $msg."\r\n",FILE_APPEND);
				}
				else
				{
					$ret_curl = json_decode(trim($ret_curl),true);
					file_put_contents($file_log,"result_decode=>".var_export($ret_curl,true)."\r\n",FILE_APPEND);
					
					if(empty($ret_curl))
					{
						$results[$server_domain]['retcode'] = -1;
						$results[$server_domain]['retmsg']  = " 发布数据失败,数据包太大或者游戏服域名无效或者域名还未解析成功";
					}
			
					if ($ret_curl['retcode'] != 0)
					{
						$results[$server_domain]['retcode'] = -1;
						if (is_integer(strpos($ret_curl['retmsg'],'this ip is not allowed')))
						{
							$results[$server_domain]['retmsg']  = $ret_curl['retmsg']." ，请找莫吉林支持。";
						}
						else
						{
							$results[$server_domain]['retmsg']  = $ret_curl['retmsg'];
						}
					}
					elseif ($ret_curl['rsp_code_id'] != 0)
					{
						$results[$server_domain]['retcode'] = -1;
			
						if(is_integer(strpos($ret_curl['retmsg'],'connect to host')))
						{
							$results[$server_domain]['retmsg']  = " 连接目标服务器 ".$server_domain." 失败，请找莫吉林或者李蔷薇支持。";
						}
						elseif (is_integer(strpos($ret_curl['retmsg'],'this ip is not allowed')))
						{
							$results[$server_domain]['retmsg']  = $ret_curl['retmsg']." ，请找莫吉林支持。";
						}
						else
						{
							$results[$server_domain]['retmsg'] = $ret_curl['msg'];
						}
					}
			
				}

				if ($results[$server_domain]['retcode'] != 0 && !empty($ALL_CONFIG_SERVER[$sx]))
				{
					!empty($ALL_CONFIG_SERVER[$sx]['sname']) && $results[$server_domain]['retmsg'] = $ALL_CONFIG_SERVER[$sx]['sname'] . ' -- ' . $results[$server_domain]['retmsg']; 
				}
			
				file_put_contents($file_log,"retmsg==>".$results[$server_domain]['retmsg']."\r\n",FILE_APPEND);
				file_put_contents($file_log,"-------------------------------------------------------------\r\n\r\n",FILE_APPEND);
			}
			else 
			{
				$dead_urls[]= $chinfo;
			}
			
			// 12. 移除句柄
			curl_multi_remove_handle($mh, $handle);

			curl_close($handle);
		}
		
	}

	var_dump($results);

	if ($dead_urls)
	{
	    foreach ($dead_urls as $url)
	    {
	        $arr_parse = parse_url($url['url']);
	        $server_domain = $arr_parse['host'];
	        $sx = strstr($server_domain, '.', true);
			
	        $results[$server_domain]['retcode'] = -1;
	        $results[$server_domain]['retmsg'] = "连接游戏服失败";

	        if (!empty($ALL_CONFIG_SERVER[$sx]) && !empty($ALL_CONFIG_SERVER[$sx]['sname']))
			{
				$results[$server_domain]['retmsg'] = $ALL_CONFIG_SERVER[$sx]['sname'] . ' -- ' . $results[$server_domain]['retmsg']; 
			}
	    }
	    
		file_put_contents($file_log, "invalid_urls==>".var_export($dead_urls,true)."\r\n",FILE_APPEND);
	}
		
	//关闭连接句柄
	curl_multi_close($mh);
		
	return $results;
}

?>
