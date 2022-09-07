<?php
/**
 * 运营活动激活码管理
 * 
 * @author Andy Cai(huayi.cai@kunlun-inc.com)
 * @since 2009-10-29
 * @filesource activity_code_manage.php
 * @version $Id: activity_code_manage.php,v 1.2 2010/12/09 10:08:30 mjl-xx Exp $
 *
 */


############################ 初始化数据 start ###############################
//模板文件
$template_name = 'activity_code_batch.html';
require('common.php');
require_once('libs/class_activity/ClsActivityCode.php');
require_once('libs/class_activity/ClsActivityCodeBatch.php');
$obj_activity_code = new ClsActivityCode();
$obj_activity_code_batch = new ClsActivityCodeBatch();

$http_batch_title = trim($_POST['batch_title']);   //卡号
$http_code	  = trim($_POST['code']);   //卡号

############################ 初始化数据 end #################################

$is_edit = 0;

/************* 创建邀请码 start ***************/
$http_opt = trim($_POST['opt']);
$http_opt = !$http_opt ? trim($_GET['opt']) : $http_opt;

//保存批次信息修改
if ('save' == $http_opt)
{
	$batch_id               = trim($_POST['batch_id']); 
	$http_title             = trim($_POST['title']); 
	$http_start_time        = $_POST['start_time']; 
	$http_end_time          = $_POST['end_time']; 
	$http_gift_pack_id      = trim($_POST['gift_pack_id']); 
	$http_server_ids        = trim($_POST['server_ids']); 
	$http_server_ids        = trim($http_server_ids, ',');
	$http_server_ids_arr  = !empty($http_server_ids) ? explode(',', $http_server_ids) : array();
	in_array('all_server', $http_server_ids_arr) && $http_server_ids = 'all_server';

	$http_character_level_max = intval($_POST['character_level_max']); 
	$http_character_level_min = intval($_POST['character_level_min']); 
	$http_use_num_pre         = intval($_POST['use_num_pre']); 
	$http_is_limit_character  = intval($_POST['is_limit_character']); 
	$http_is_global_use = intval($_POST['is_global_use']);
	$res_id                   = $_POST['res_id']; 
	$channel = intval($_POST['channel']);
	$channel_title = '';

	if ($channel_map && !empty($channel_map[$channel]))
	{
		$channel_title = $channel_map[$channel];
	}
		
	$arr_params = array(
				
				'title'                 => $http_title,
				'gift_pack'             => $http_gift_pack_id,
			 	'server_ids'            => $http_server_ids,
				'character_level_max'   => $http_character_level_max,
				'character_level_min'   => $http_character_level_min,
				'use_num_pre'           => $http_use_num_pre,
				'is_limit_character'    => $http_is_limit_character,
				'is_global_use'    		=> $http_is_global_use,
				'channel'     => $channel,
				'channel_title'			=> $channel_title,
				//'res_id'                => $res_id,
				'start_time'                => $http_start_time,
				'end_time'                => $http_end_time,
				'updated'               => date('Y-m-d H:i:s')
					);
	//$arr_data = updateFormat($arr_params);
	
	if ($obj_activity_code_batch->update($batch_id,$arr_params))
	{
		die('sucessed');
	}
	else 
	{
		die('false');
	}
	
	// 记录操作日志
	operationLog(formatLog('激活码批次：'.$batch_id, '创建'));
}

elseif ($http_opt =='edit')
{
	$id = trim($_GET['id']);	
	$condition = " AND id=".$id;
	$batch_list = $obj_activity_code_batch->getBatchList($condition);
	
	$pack_list = array();
	if ($batch_list[0]['gift_pack'])
	{
		
		$pack_arr  = explode("|",$batch_list[0]['gift_pack']);
		foreach ($pack_arr as $key=> $item)
		{
			$tmp_arr = explode(",",$item);
			if (count($tmp_arr) == 2)
			{
				$equip_id  = $tmp_arr[0];
				$equip_num = $tmp_arr[1];
			}
			elseif (count($tmp_arr) == 3)
			{
				$equip_id  = $tmp_arr[0].','.$tmp_arr[1];
				$equip_num = $tmp_arr[2];
			}
			
			$pack_list[] = array('id'=>$key+1,'equip_id'=>$equip_id,'equip_num'=>$equip_num);
		}
		
	}
	$batch_item = $batch_list[0];
	
	foreach ($batch_list as &$batch)
	{
		$batch['is_limit_character'] = $batch['is_limit_character'] == 0 ? "帐号" : "角色";
		$batch['server_ids'] = $batch['server_ids'] == 0 ? '全服' : $batch['server_ids'];
	}
		
	$tpl->assign(array(
			'pack_list' => $pack_list,
			'pack_num' => count($pack_list),
	        'batch_item' =>$batch_item,
	        
		));	

	//获取服务器列表
	$selected_server  = !empty($batch_item['server_ids']) ? explode(',',$batch_item['server_ids']) : array();
	$special_server_arr = array('all_server' => '所有正式服');
	$selected_server_arr = !empty($selected_server) ? array_fill_keys($selected_server, 1) : array();
	isset($selected_server_arr['all_server']) && $http_server_ids_arr = array('all_server');
	$arr_serv_list = getActServerList($selected_server_arr, $special_server_arr);
	
	$channel_id = intval($batch_item['channel']);
	$select_channel_arr = array();
	$channel_id && $select_channel_arr[$channel_id] = 1;

	$tpl->assign('channel_map', format_map($channel_map, $select_channel_arr));
	$tpl->assign('serv_list',$arr_serv_list);
	$is_edit = 1;
}


$condition = "";
if ('' != $http_batch_title)
{
	$condition .= " AND `title` LIKE '%".$http_batch_title."%' ";
	$tpl->assign('batch_title_value', $http_batch_title);
}

$http_activation_prefix = trim($_POST['activation_prefix']); 
if ('' != $http_activation_prefix)
{
	$condition .= " AND `activation_prefix` = '$http_activation_prefix' ";
	$tpl->assign('activation_prefix', $http_activation_prefix);
}

$all_batch = $obj_activity_code_batch->getBatchList($condition);


//激活码批次总记录
$batch_total = count($all_batch);

/*********** 翻页 start ***********/
$arr_params = array(
		'total' => $batch_total,
		'perpage' => 20
);

$pager = new pager($arr_params);
$tpl->assign($pager->result);

$limit  = $pager->perpage;
$offset = $pager->offset;
/*********** 翻页 end *************/

$order_by = " id ";
$batch_list = $obj_activity_code_batch->getBatchList($condition,$order_by,$limit,$offset);
$cur_data_str = date('Y-m-d H:i:s');

foreach ($batch_list as &$batch)
{
	$batch['is_limit_character'] = $batch['is_limit_character'] == 0 ? "帐号" : "角色";
	$batch['server_ids'] = (!$batch['server_ids']) ? '全服' : $batch['server_ids'];
	$batch_type = intval($batch['batch_type']);
	$batch_type == 0 && $batch_type = 1;
	isset($batch_type_map[$batch_type]) && $batch['batch_type'] = $batch_type_map[$batch_type];
	$sync_status = intval($batch['sync_status']);
	$end_time = $batch['end_time'];

	if ($batch_type == BATCH_TYPE_SYNC && $sync_status != 1 && $end_time > $cur_data_str) 
	{
		if (!empty($sync_platform_map) && !empty($common_area_sign) && !empty($sync_platform_map[$common_area_sign]))
		{
			$batch['sync_status'] = 2;
		}
	}
}

$t = time();
$s = md5(INTERFACE_TOKEN.$t.INTERFACE_TOKEN);
$tpl->assign(array(
		'arr_invitation_code_list' => $batch_list,
		'pic_res_list' => $PIC_RESOURCE_CONFIG,
		'gift_pack' => 0,
		'is_edit' => $is_edit,
		't' => $t,
		's' => $s,
		'author' => $_SESSION['username'],
));
/************* 获取帐号列表 end *****************/


$tpl->output();

?>