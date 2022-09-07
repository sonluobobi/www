<?php
/**
 * 运营活动激活码管理
 */


############################ 初始化数据 start ###############################
//模板文件


$template_name = 'activity_code_manage.html';
require('common.php');
require_once('libs/class_activity/ClsActivityCode.php');
require_once('libs/class_activity/ClsActivityCodeBatch.php');

$obj_activity_code = new ClsActivityCode();
$obj_activity_code_batch = new ClsActivityCodeBatch();

$arr_code_list = array();

$http_code	  = trim($_POST['code']);   //卡号

############################ 初始化数据 end #################################
$batch_list = $obj_activity_code_batch->getBatchList();

/************* 创建邀请码 start ***************/
$http_opt = trim($_POST['opt']);

//创建新的激活码
if ('createInvitationCode' == $http_opt)
{
	
	$http_num               = trim($_POST['num']);				 //要生成的邀请码数量
	$http_title             = trim($_POST['title']); 
	$http_activation_prefix = trim($_POST['activation_prefix']); 
	$http_start_time        = $_POST['start_time']; 
	$http_end_time          = $_POST['end_time']; 
	$http_gift_pack_id      = trim($_POST['gift_pack_id']); 
	$http_server_ids        = trim($_POST['server_ids']); 
	$http_character_level_max = intval($_POST['character_level_max']); 
	$http_character_level_min = intval($_POST['character_level_min']); 
	$http_use_num_pre         = intval($_POST['use_num_pre']); 
	$http_is_limit_character  = intval($_POST['is_limit_character']); 
	$length                   = intval($_POST['activate_code_length']); 
	$res_id                   = $_POST['res_id']; 
	
	$res_id = ($res_id == 'Y0004') ? $res_id : 'Y0004';
		
	$length   = empty($length) ? 12 : $length;
	
	if ($http_num > MAKE_CODE_MAX)
	{
		die('通过活动后台生成批次激活码上限为:'.MAKE_CODE_MAX);
	}
		
	// 创建批次
	if ($obj_activity_code_batch) 
	{	
		
		foreach($batch_list as $batch)
		{
			if($batch['title'] == $http_title || $batch['activation_prefix'] == $http_activation_prefix)
			{			
				$batch_id = $batch['id'];
				die("操作失败! 激活码批次名称、激活码前缀不能重复, 请输入其它批次名称、激活码前缀或者使用追加功能!");
			}
		}
		
		$arr_params = array(
				'activation_code_total' => $http_num,
				'title'                 => $http_title,
				'activation_prefix'     => $http_activation_prefix,
				'tbl_code_lib'          => CUR_TBL_CODE_LIB,
				'tbl_code_use'          => CUR_TBL_CODE_USE,
				'length'                => $length,
			 	'gift_pack'             => $http_gift_pack_id,
			 	'server_ids'            => $http_server_ids,
				'character_level_max'   => $http_character_level_max,
				'character_level_min'   => $http_character_level_min,
				'use_num_pre'           => $http_use_num_pre,
				'is_limit_character'    => $http_is_limit_character,
				'res_id'                => $res_id,
				'start_time'            => $http_start_time,
				'end_time'              => $http_end_time,
				'created'               => date('Y-m-d H:i:s')
					);
		$arr_data = insertFormat($arr_params);
		$batch_id = $obj_activity_code_batch->addActivityBatch($arr_data);
		
		// 记录操作日志
		log2File("act_code", "batch_id=".$batch_id);
				
		// 批次创建成功
		if ($batch_id) 
		{ 
			//创建邀请码
			$existed_code_arr = array();
			if ($obj_activity_code->createNewInvitationCode($batch_id, $http_activation_prefix, $http_num, $http_start_time, $http_end_time,$existed_code_arr,$length)) {
				die('sucessed');
			} else {
				die('false');
			}
		} else {	// 批次创建失败
			die('false');
		}
		
	}
}

//激活码查询
elseif ($http_opt == 'search')
{
	$code_prefix = substr($http_code, 0,2);
	
	foreach ($batch_list as $batch)
	{
		if ($batch['activation_prefix'] == $code_prefix)
		{
			$tbl_code_lib = $batch['tbl_code_lib'];
			$tbl_code_use = $batch['tbl_code_use'];
			break;
		}
	}
	
	if ($tbl_code_lib && $tbl_code_use)
	{
		$sql = "SELECT * FROM `".$tbl_code_lib."` WHERE `code`='".$http_code."' LIMIT 1";
		$code_log = $obj_activity_code->fetchOneRecord($sql);
		
		if (is_array($code_log) && $code_log['id'] > 0)
		{
			$sql = "SELECT * FROM `".$tbl_code_use."` 
					WHERE `batch_id`= ".$code_log['batch_id'].
					" AND `act_code_id`=".$code_log['id']." LIMIT 1";
		
			$use_log = $obj_activity_code->fetchOneRecord($sql);
			if (is_array($use_log) && $use_log['id'] > 0)
			{
				$code_log['user_player_id']    = $use_log['player_id'];
				$code_log['user_character_id'] = $use_log['character_id'];
				$code_log['user_serv_id']      = $use_log['serv_id'];
			}
		
			$code_log['start_time'] = $batch['start_time'];
			$code_log['end_time']   = $batch['end_time'];
		
			$code_log['batch_title'] = $batch['title'];
			$code_log['character_level_min'] = $batch['character_level_min'];
			$code_log['character_level_max'] = $batch['character_level_max'];
			$code_log['use_num_pre']         = $batch['use_num_pre'];
			$code_log['is_limit_character']  = $batch['is_limit_character'] == 0 ? "帐号" : "角色";
			$code_log['gift_pack']           = $batch['gift_pack'];
			$code_log['serverlist']          = !$batch['server_ids'] ? '全服' : $batch['server_ids'];
		
			$code_log['gift_pack']       = $batch['gift_pack'];
		
			$arr_code_list[] = $code_log;
		}
		else 
		{
			$arr_code_list = array();
		}
	}
}
else
{
	//获取邀请码总数
    try {
        $invitation_code_total = $obj_activity_code->getInvitationCodeCount($condition);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

	/*********** 翻页 start ***********/
	$_GET['is_used'] = $http_is_used;
	$arr_params = array(
			'total' => $invitation_code_total,
			'perpage' => 20
	);
	
	$pager = new pager($arr_params);
	$tpl->assign($pager->result);
	
	$limit  = $pager->perpage;
	$offset = $pager->offset;
	/*********** 翻页 end *************/
	
	//获取玩家列表
	$order_by = 'id';
	$arr_code_list = $obj_activity_code->getInvitationCodeList($condition, $order_by, $limit, $offset);
	
	$arr_code_batch = array();
	foreach ($batch_list as $batch)
	{
		$arr_code_batch[$batch['id']] = $batch;
	}
	
	foreach ($arr_code_list as &$item)
	{
		$code_batch = $arr_code_batch[$item['batch_id']];
		if ($code_batch)
		{
			$item['start_time'] = $code_batch['start_time'];
			$item['end_time']   = $code_batch['end_time'];
	
			$item['batch_title'] = $code_batch['title'];
			$item['character_level_min'] = $code_batch['character_level_min'];
			$item['character_level_max'] = $code_batch['character_level_max'];
			$item['use_num_pre']         = $code_batch['use_num_pre'];
			$item['is_limit_character']  = $code_batch['is_limit_character'] == 0 ? "帐号" : "角色";
			$item['gift_pack']           = $code_batch['gift_pack'];
			$item['serverlist']          = !$code_batch['server_ids'] ? '全服' : $code_batch['server_ids'];
	
			$item['gift_pack']       = $code_batch['gift_pack'];
		}
	}
}
var_dump('in_333c');
$tpl->assign(array(
		'arr_invitation_code_list' => $arr_code_list,
		//'pic_res_list' => $PIC_RESOURCE_CONFIG,
		'code_value' => $http_code,
				));
/************* 获取帐号列表 end *****************/

$t = time();
$s = md5(INTERFACE_TOKEN.$t.INTERFACE_TOKEN);
$sync_pl = '';

if (!empty($sync_act_code_to_pl) && !empty($common_area_sign) && !empty($common_second_domain))
{
	if (isset($sync_act_code_to_pl[$common_area_sign]) && 1 == $sync_act_code_to_pl[$common_area_sign])
	{
		$sync_pl = 'do';
	}
}

$tpl->assign(array(
	't' => $t,
	's' => $s,
	'sync_pl' => $sync_pl,
	'author' => $_SESSION['username'],
));

$tpl->output();

?>