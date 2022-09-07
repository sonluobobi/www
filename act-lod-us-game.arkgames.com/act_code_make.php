<?php
/**
 * 激活码生成系统
 * @author fuqian.liao
 */


############################ 初始化数据 start ###############################
//模板文件
//var_dump('in_1');
$template_name = 'act_code_make.html';
require('common.php');
require_once('libs/class_activity/ClsActivityCode.php');
require_once('libs/class_activity/ClsActivityCodeBatch.php');
require_once INCLUDE_PATH .'/config/auth.php';

$equip_file = ACTIVITY_DIR.'/equip.inc';

try{

    $code_batch_obj = new ClsActivityCodeBatch();
    $code_obj       = new ClsActivityCode();

    $opt = $_REQUEST['opt'];

    $can_make_code = 1;
    //获取服务器列表

    $http_server_ids_arr  = !empty($_POST['server_ids']) ? $_POST['server_ids'] : array();
    //$special_server_arr = array('all_server' => '所有正式服');
    $selected_server_arr = !empty($http_server_ids_arr) ? array_fill_keys($http_server_ids_arr, 1) : array();
    isset($selected_server_arr['all_server']) && $http_server_ids_arr = array('all_server');
    $arr_serv_list = getActServerList($selected_server_arr, $special_server_arr);
    //$arr_serv_list[] = array('server_name' => 'all_server', 'title' => '全服', 'select_state' => '', 'server_ids' => array('serv_id'=>'all_server','hit'=>0));
    //echo "<pre>";print_r($arr_serv_list);


    if ($opt == 'make_code')
    {
        $http_num               = trim($_POST['num']);				 //要生成的邀请码数量
        $http_title             = trim($_POST['title']);
        $http_start_time        = $_POST['start_time'];
        $http_end_time          = $_POST['end_time'];
        $http_gift_pack         = trim($_POST['gift_pack']);
        $http_character_level_max = intval($_POST['character_level_max']);
        $http_character_level_min = intval($_POST['character_level_min']);
        $http_use_num_pre         = intval($_POST['use_num_pre']);
        $http_is_limit_character  = intval($_POST['is_limit_character']);
        $http_is_global_use = intval($_POST['is_global_use']);
        $http_batch_type = intval($_POST['batch_type']);

        if (empty($sync_platform_map) || empty($common_area_sign) || empty($sync_platform_map[$common_area_sign]))
        {
            //判断是否有权限操作此类型批次
            $http_batch_type = 0;
        }

        $res_id = ($res_id == 'Y0004') ? $res_id : 'Y0004';
        $length   = empty($length) ? 15 : $length;

        if (empty($http_num) || !is_numeric($http_num))
        {
            throw new Exception("请先正确输入要生成的数量！");
        }

        if ($http_num > MAKE_CODE_MAX)
        {
            throw new Exception("生成激活码数量上限为:".MAKE_CODE_MAX);
        }

        //验证礼包内容正确性

        $equip_list = require_once $equip_file;
        $equip_id_list = array();
        foreach ($equip_list as $equip)
        {
            $equip_id_list[] = $equip['id'];
        }

        $arr_pack = explode('|', $http_gift_pack);
        foreach ($arr_pack as $pack)
        {
            $arr_gift = explode(',', $pack);
            if (count($arr_gift) != 3)
            {
                throw new Exception("礼包内容出错，请仔细检查.");
            }

            $equip_title  = $arr_gift[0];
            $equip_id  = $arr_gift[1];
            $equip_num = $arr_gift[2];

            if ($equip_num < 1)
            {
                throw new Exception("礼包内容出错，道具数量必须大于零.");
            }

            if (!in_array($equip_id, $equip_id_list))
            {
                //throw new Exception("礼包内容出错，(道具名:".$equip_title .',道具ID:'.$equip_id.')不存在');
            }
        }

        if (empty($http_server_ids_arr))
        {
            throw new Exception("请选择服务器！");
        }

        $http_server_ids = implode(',', $http_server_ids_arr);
        in_array('all_server', $http_server_ids_arr) && $http_server_ids = 'all_server';

        if ($http_batch_type == BATCH_TYPE_SYNC)
        {
            $check_has_privilege = auth_has_privilege(AUTH_ACT_CODE_SHARE);
            !$check_has_privilege && $http_batch_type = 1;
        }

        $prefix = $code_batch_obj->getCodeBatchPrefix($http_batch_type);
        if (!$prefix)
        {
            throw new Exception("获取激活码批次前缀出错.");
        }

        $channel = intval($_POST['channel']);
        $http_batch_type == BATCH_TYPE_SYNC && $channel = 0;
        $channel_title = '';

        if ($channel_map && !empty($channel_map[$channel]))
        {
            $channel_title = $channel_map[$channel];
        }

        $arr_params = array(
            'activation_code_total' => $http_num,
            'title'                 => $http_title,
            'activation_prefix'     => $prefix,
            'tbl_code_lib'          => CUR_TBL_CODE_LIB,
            'tbl_code_use'          => CUR_TBL_CODE_USE,
            'length'                => $length,
            'gift_pack'             => $http_gift_pack,
            'server_ids'            => $http_server_ids,
            'character_level_max'   => $http_character_level_max,
            'character_level_min'   => $http_character_level_min,
            'use_num_pre'           => $http_use_num_pre,
            'is_limit_character'    => $http_is_limit_character,
            'is_global_use'    		=> $http_is_global_use,
            'res_id'                => $res_id,
            'channel'				=> $channel,
            'channel_title'			=> $channel_title,
            'start_time'            => $http_start_time,
            'end_time'              => $http_end_time,
            'batch_type'			=> $http_batch_type,
            'intro'                 => '暂无',
            'updated'                => date('Y-m-d H:i:s'),
            'created'               => date('Y-m-d H:i:s')
        );

        $arr_data = insertFormat($arr_params);
        $batch_id = $code_batch_obj->addActivityBatch($arr_data);

        //同步批次到公用后台
        if ($batch_id > 0 && !empty($sync_batch_map) && !empty($common_area_sign) && !empty($sync_batch_map[$common_area_sign]))
        {
            $sync_platform_sign = $sync_batch_map[$common_area_sign];

            if (!empty($platform_domain_map) && !empty($platform_domain_map[$sync_platform_sign]))
            {
                $domain = $platform_domain_map[$sync_platform_sign];
                $sync_batch_prefix_url = INTERFACE_SIGN. $domain . INTERFACE_FILE . '?c=ActCode&a=ReceiveBatchPrefix&batch='. $prefix . '&platform_sign=' . $common_area_sign;
                $tmp_content = 'activation_prefix';

                echo '$sync_batch_prefix_url';
                //func_sendStreamFile($sync_batch_prefix_url, $tmp_content);
            }
        }



        $result = $code_obj->makeActivationCode( $prefix, $batch_id, $http_num, $length, $http_start_time, $http_end_time);

        if ($result == true)
        {
            // 记录操作日志
            log2File("act_code", "batch_id=".$batch_id."|title=".$http_title);

            /*
            if ($http_batch_type == BATCH_TYPE_SYNC && !empty($platform_domain_map) && !empty($sync_platform_map) && !empty($common_area_sign))
            {
                if (!empty($sync_platform_map[$common_area_sign]) && !empty($common_second_domain))
                {
                    $author = $_SESSION['username'];
                    $sync_batch_code_url = INTERFACE_SIGN. $common_second_domain . INTERFACE_FILE . '?c=ActCode&a=ShareBatch&batch_id='. $batch_id . '&author=' . $author;
                    $tmp_content = 'ShareBatch';
                    func_sendStreamFile($sync_batch_code_url, $tmp_content);

                    if (function_exists('act_do_log'))
                    {
                        $act_batch_share_msg = 'batch_id='.$batch_id.' -- activation_prefix='.$prefix;
                        act_do_log('act share batch -- ' . $act_batch_share_msg, 'act_batch_share');
                    }
                }
            }
            //*/

            throw new Exception("成功生成激活码");
        }
        else
        {
            throw new Exception("生成激活码失败");
        }

    }

}catch (Exception $e) {
    $retmsg = $e->getMessage();
}


$tpl->assign('num',$http_num);
$tpl->assign('title',$http_title);
$tpl->assign('start_time',$http_start_time);
$tpl->assign('end_time',$http_end_time);
$tpl->assign('server_ids',$http_server_ids);
$tpl->assign('gift_pack',$http_gift_pack);

$tpl->assign('code_max',MAKE_CODE_MAX);
$tpl->assign('can_make_code',$can_make_code);
$tpl->assign('use_code_limit',USE_CODE_LIMIT);

$tpl->assign('retmsg',$retmsg);

$channel_map && $tpl->assign('channel_map', format_map($channel_map));
$tpl->assign('batch_type_map', format_map($batch_type_map));
$tpl->assign('serv_list',$arr_serv_list);



$tpl->output();
