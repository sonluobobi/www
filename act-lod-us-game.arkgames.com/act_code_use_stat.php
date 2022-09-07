<?php
/**
 * 激活码使用情况统计
 */


############################ 初始化数据 start ###############################
//模板文件
$template_name = 'act_code_use_stat.html';
require('common.php');
require_once('libs/class_activity/ClsActivityCode.php');
require_once('libs/class_activity/ClsActivityCodeBatch.php');

$obj_activity_code_batch = new ClsActivityCodeBatch();
$obj_activity_code       = new ClsActivityCode();

############################ 初始化数据 end #################################
$batch_title = isset($_POST['batch_title']) ? trim($_POST['batch_title']) :'';   //批次名称

if ($batch_title)
{
	$condition = " AND `title` LIKE '%".$batch_title."%'";
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

if ($batch_list)
{
	$used_code_list = array();
	
	foreach ($batch_list as &$batch)
	{
		
		if (!isset($used_code_list[$batch['id']]))
		{
			$tbl_code_use = $batch['tbl_code_use'];
			$used_code_list = $obj_activity_code->getUsedCodeList($tbl_code_use,$used_code_list);
			
		}
		
		if (!isset($used_code_list[$batch['id']])) {
			$batch['used_num'] = 0;
		}else {
			$batch['used_num'] = $used_code_list[$batch['id']]['used_num'];
		}
		
		$batch['remain_num'] = $batch['activation_code_total'] - $batch['used_num'];
					
	}
	
}


$tpl->assign(array(
		'batch_title' => $batch_title,
		'arr_invitation_code_list' => $batch_list,
		
));
/************* 获取帐号列表 end *****************/


$tpl->output();

?>