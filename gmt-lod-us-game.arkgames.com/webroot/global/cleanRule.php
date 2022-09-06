<?php
	require 'common.php';
	require 'base.php';

	//cleanRule.php
	$caption = '游戏服时间周四(05:34)，表数据清理规则 --' . date('Y-m-d H:i');

	$retmsg = '';
	$list = array();

	$tmp = array();
	$tmp['var'] = 'tbl_log_chequip_trace(道具流向日志表)';
	$tmp['txt'] = '保留 21 天(created)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_log_exception(异常数据记录表)';
	$tmp['txt'] = '保留 60 天(created)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_reward(发奖日志表)';
	$tmp['txt'] = '保留 60 天(expire)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_log_chpet_baowu_chip';
	$tmp['txt'] = '保留 60 天(created)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_chequip_backup';
	$tmp['txt'] = '保留 60 天(created)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_chpet_baowu_chip';
	$tmp['txt'] = '保留 60 天(stack_num = 0 and created)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_log_arena_pk(竞技场日志表)';
	$tmp['txt'] = '保留 60 天(created)';
	$list[] = $tmp;


	$tmp = array();
	$tmp['var'] = 'tbl_stat_tollgate(关卡统计表)';
	$tmp['txt'] = '保留 60 天(created)';
	$list[] = $tmp;


	$tmp = array();
	$tmp['var'] = 'tbl_stat_pet(幻兽统计表)';
	$tmp['txt'] = '保留 60 天(is_free = 1 and updated)';
	$list[] = $tmp;


	$tmp = array();
	$tmp['var'] = 'tbl_stat_online(角色在线日志表)';
	$tmp['txt'] = '保留 60 天(created)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_stat_own_equip(宝物拥有日志表)';
	$tmp['txt'] = '保留 60 天(updated)';
	$list[] = $tmp;

	/*
	$tmp = array();
	$tmp['var'] = 'tbl_character_mall_buy_cnt';
	$tmp['txt'] = '保留 90 天(updated is not null and updated)';
	$list[] = $tmp;
	//*/

	$tmp = array();
	$tmp['var'] = 'tbl_log_character_upgrade(角色升级日志表)';
	$tmp['txt'] = '保留60天(created)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_log_gold_egg(砸蛋日志表)';
	$tmp['txt'] = '保留 30 天(created)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_log_report(错误日志上报表)';
	$tmp['txt'] = '保留 10 天(created)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_log_report_event(角色事件操作日志表)';
	$tmp['txt'] = '保留 30 天(created)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_character_actitem_reached';
	$tmp['txt'] = '保留 60 天(activity_item_start_time)';
	$list[] = $tmp;

	$tmp = array();
	$tmp['var'] = 'tbl_character_activity_item(运营活动参与表)';
	$tmp['txt'] = '已经不存在的非固化活动参与记录中，删除参与时间110天之前的数据';
	$list[] = $tmp;
	

	$smarty->assign('caption', $caption);
	$smarty->assign("base_list", $list);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('base_list.tpl');
?>
