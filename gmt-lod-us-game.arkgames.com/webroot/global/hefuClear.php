<?php 
	require 'common.php';
	require 'base.php';

	/*
	$server_id = 's5';
	$server_list['s5'] = 'S5 --23.236.119.83--s5.hoctv.siamgame.in.th';
	$smarty->assign("option_values", array_keys($server_list));
	$smarty->assign("option_output", array_values($server_list));
	$server_selected = !empty($server_list[$server_id]) ? $server_list[$server_id] : '';
	$smarty->assign("server_selected", $server_selected, true);
	//*/


	$log_folder = 'hefu_clear';
	$retmsg = '';
	//$params_str = httpGetVal('params');
	$level_begin = 30;
	$level_end = 180;
	$min_level = isset($_REQUEST['min_level']) ? trim($_REQUEST['min_level']) : $level_begin;
	$min_level = intval($min_level);

	$vip_begin = 1;
	$vip_end = 12;
	$min_vip = isset($_REQUEST['min_vip']) ? trim($_REQUEST['min_vip']) : $vip_begin;
	$min_vip = intval($min_vip);
	$min_vip < 1 && $min_vip = 1;

	$desc_msg = '合服角色清理规则:<br>';
	$desc_msg .= '-- 一个月未登录 <br>';
	$desc_msg .= '-- 且非gm角色 <br>';
	$desc_msg .= '-- 且非军团长 <br>';
	$desc_msg .= "-- 且等级小于一个值，默认是$level_begin,支持$level_begin - $level_end 之间配置 <br>";
	$desc_msg .= "-- 且vip小于一个值，默认是$vip_begin,支持$vip_begin - $vip_end 之间配置 <br>";
	$desc_msg .= '<br>';
	$desc_msg .= '此页面查询结果根据查询等级及vip按天缓存<br>';

	$info = '';

	if (!empty($do_search) && $do_search == 'do')
	{
		try {

			//查询操作
			if (empty($min_level) || $min_level < $level_begin || $min_level > $level_end)
			{
				throw new Exception("参数错误 -- 保留最低角色等级(范围 $level_begin - $level_end )");
			}

			if (empty($min_vip) || $min_vip < $vip_begin || $min_vip > $vip_end)
			{
				throw new Exception("参数错误 -- 保留最低角色vip(范围 $vip_begin - $vip_end )");
			}

			if (empty($server_id) || !isset($server_list[$server_id]))
			{
				throw new Exception('请选择游戏服');
			}

			//$server_name = $server_list[$server_id];
			$server_url = $server_id . $domain. SERVER_FOR_BACKEND . '?c=Db&a=HefuInfo&min_level=' . $min_level . "&min_vip=$min_vip";
			$result = func_requestUrl($server_url, false, 3);

			if (!empty($result) && $result['retcode']==0)
			{
				if (!empty($result['data']))
				{	
					$ret_data = $result['data'];
					$cid_clear_cnt = intval($ret_data['cid_clear_cnt']);
					$cid_cnt = intval($ret_data['cid_cnt']);
					$total_gang_master = intval($ret_data['total_gang_master']);

					$info = "总角色数=$cid_cnt    合服被清理角色数=$cid_clear_cnt 其中军团长数=$total_gang_master";
				}
				else
				{
					$info = '返回数据为空';
				}
			}
			else
			{
				$info = !empty($result['retmsg']) ? $result['retmsg'] : '请重试';
			}

		} catch (Exception $e) {
			$retmsg = $e->getMessage();
		}
	}
	
	$caption = '合服被清理数据查询';
	$smarty->assign('min_level', $min_level, true);
	$smarty->assign('desc_msg', $desc_msg, true);
	$smarty->assign('info', $info, true);
	$smarty->assign('caption', $caption, true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->assign("level_begin", $level_begin, true);
	$smarty->assign("level_end", $level_end, true);

	$smarty->assign("min_vip", $min_vip, true);
	$smarty->assign("vip_begin", $vip_begin, true);
	$smarty->assign("vip_end", $vip_end, true);

	$smarty->display('hefuClear.tpl');