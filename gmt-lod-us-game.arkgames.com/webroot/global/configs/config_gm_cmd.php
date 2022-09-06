<?php
//config_gm_cmd.php  gm指令列表

$gm_func_list = array();

$gm_func_list[] = array('cmd' => './role_reset','desc' => '角色数据全部重置,还原到创建初始状态, 需重启客户端');

$gm_func_list[] = array(
	'cmd' => './equip_add 21020002 1',
	'desc' => '添加道具,见EquipDJBase.csv表中id字段',
);

$gm_func_list[] = array(
	'cmd' => './package_clear',
	'desc' => '清空包裹',
);

$gm_func_list[] = array(
	'cmd' => './ch_attrib game_gold 9999',
	'desc' => '修改角色属性 -- 魔石数',
);

$gm_func_list[] = array(
	'cmd' => './ch_attrib silver 9999',
	'desc' => '修改角色属性 -- 金币',
);

$gm_func_list[] = array(
	'cmd' => './ch_attrib iron 9999',
	'desc' => '修改角色属性 -- 矿石数',
);

$gm_func_list[] = array(
	'cmd' => './ch_attrib honor 9999',
	'desc' => '修改角色属性 -- 荣誉',
);

$gm_func_list[] = array(
	'cmd' => './ch_attrib vit 20',
	'desc' => '修改角色属性 -- 体力',
);

$gm_func_list[] = array('cmd' => './ch_save','desc' => '角色变更的数据立即保存到数据库,可用于操作重启客户端之前或需要查看数据库数据校验时操作');
$gm_func_list[] = array('cmd' => './hero_list_clear','desc' => '清空伙伴列表, 需重启客户端');
$gm_func_list[] = array('cmd' => './hero_add 11401 1','desc' => '添加伙伴, 参数1:英雄id|见HeroBase.csv表中id字段, 参数2:初始星级(不配置则默认0)');
$gm_func_list[] = array('cmd' => './shop_reset','desc' => '商店数据重置,涉及基础商店商品每日购买次数,限时商店每日刷新次数');
$gm_func_list[] = array('cmd' => './tollgate_finish','desc' => '通关当前关卡');
$gm_func_list[] = array('cmd' => './tollgate_set 101080','desc' => '设置通关id,见TollgateBase.csv表中id字段');
$gm_func_list[] = array('cmd' => './jianzhu_reset','desc' => '建筑系统数据重置,操作后要重启客户端');
