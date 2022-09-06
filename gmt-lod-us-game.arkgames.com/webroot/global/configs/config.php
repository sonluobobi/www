:<?php

//大区对应关系
$platform_map = array(
//	'zh' => array('sign' => 'zh', 'title' => '国内安卓zh', 'domain' => '-kf-sanxiao-zh.game.kunlun.com', 'https_domain' => '-kf-sanxiao-zh.game.kunlun.com'),
//	'eu' => array('sign' => 'eu', 'title' => '欧美eu', 'domain' => '-sanxiao-eu.game.koramgame.com', 'https_domain' => '-sanxiao-eu.game.koramgame.com'),
//	'sgp' => array('sign' => 'sgp', 'title' => '东南亚sgp', 'domain' => '-sanxiao-sgp.game.koramgame.com', 'https_domain' => '-sanxiao-sgp.game.koramgame.com'),
    //'zh' => array('sign' => 'zh', 'title' => '国内zh', 'domain' => '-kf-sanxiao-zh.game.kunlun.com', 'https_domain' => 'kf-sanxiao-zh.game.kunlun.com'),
	'ru2' => array('sign' => 'ru2', 'title' => '俄罗斯ru2', 'domain' => '-sanxiao-ru2.game.koramgame.com', 'https_domain' => '-sanxiao-ru2.game.koramgame.com'),
    'ru9' => array('sign' => 'ru9', 'title' => '全球俄罗斯ru9', 'domain' => '-sanxiao9-ru.game-ark.com', 'https_domain' => '-sanxiao9-ru.game-ark.com'),
    'en9' => array('sign' => 'en9', 'title' => '全球北美en9', 'domain' => '-sanxiao9-en.game-ark.com', 'https_domain' => '-sanxiao9-en.game-ark.com'),
    'eu9' => array('sign' => 'eu9', 'title' => '全球欧洲eu9', 'domain' => '-sanxiao9-eu.game-ark.com', 'https_domain' => '-sanxiao9-eu.game-ark.com'),
    'br9' => array('sign' => 'br9', 'title' => '全球南美br9', 'domain' => '-sanxiao9-br.game-ark.com', 'https_domain' => '-sanxiao9-br.game-ark.com'),
    'sgp9' => array('sign' => 'sgp9', 'title' => '全球东南亚sgp9', 'domain' => '-sanxiao9-sgp.game-ark.com', 'https_domain' => '-sanxiao9-sgp.game-ark.com'),
	'zh' => array('sign' => 'zh', 'title' => '国内安卓zh', 'domain' => '-kf-sanxiao-zh.game.kunlun.com', 'https_domain' => '-kf-sanxiao-zh.game.kunlun.com'),
        'eu' => array('sign' => 'eu', 'title' => '欧美eu', 'domain' => '-sanxiao-eu.game.koramgame.com', 'https_domain' => '-sanxiao-eu.game.koramgame.com'),
        'sgp' => array('sign' => 'sgp', 'title' => '东南亚sgp', 'domain' => '-sanxiao-sgp.game.koramgame.com', 'https_domain' => '-sanxiao-sgp.game.koramgame.com'),


);

define('SERVER_CENTER_INI', '/data/syslog/serverlist/server_center.ini');
define('SERVER_LIST', '/data/syslog/serverlist/server_list.php');

$menu_map = array(
	array('title' => '搜索角色列表', 'sign' => 'searchRole'),
	//array('title' => '角色发送道具', 'sign' => 'addEquip'),	
	array('title' => 'gm指令', 'sign' => 'gm'),

	
	array('title' => 'dc获取游戏服日志', 'sign' => 'logToDC'),
	array('title' => '查看在线', 'sign' => 'online'),
	array('title' => '查看系统信息', 'sign' => 'sysinfo'),
	array('title' => '查看PK跨服配置', 'sign' => 'pkconfig'),
	array('title' => '查看已安装正式服列表', 'sign' => 'installedList'),
	array('title' => '查看dc配置的服务器列表', 'sign' => 'dcList'),
	array('title' => '查看ip对应游戏服', 'sign' => 'ipToServers'),
	array('title' => '查看lua_error单服', 'sign' => 'luaErrorPage'),
	array('title' => '查看lua_error全服', 'sign' => 'luaerrorAll'),
	array('title' => '查看lua_debug单服', 'sign' => 'luaDebugPage'),
	array('title' => '查看版本及服务器列表', 'sign' => 'servinfoAndList'),
	array('title' =>'闪退日志地址集合', 'sign' => 'crashIpList'),
	//array('title' => '查看表数据清理规则', 'sign' => 'cleanRule'),
	//array('title' => '查看游戏服map日志', 'sign' => 'mapServerLog'),
	array('title' => '查看游戏服功能开关列表', 'sign' => 'openFunc'),
	//array('title' => '查看竞技场异常数据', 'sign' => 'areaError'),
		
	array('title' => '合过服列表', 'sign' => 'checkHefu'),
	array('title' => '合服历史列表', 'sign' => 'hefuHistory'),
	//array('title' => '合服被清理数据查询', 'sign' => 'hefuClear'),

	array('title' => '检查今日游戏数据备份', 'sign' => 'checkDbBackup'),
	array('title' => '检查pk语音中心服连接', 'sign' => 'checkConnectOne'),
	array('title' => '检查代码发布', 'sign' => 'checkPublishSign'),
	//array('title' => '检查游戏服热更新', 'sign' => 'checkUpdate'),
	//array('title' => '检查PK服热更新', 'sign' => 'checkUpdatePk'),
	array('title' => '检查host', 'sign' => 'checkHosts'),
	array('title' => '检查crontab', 'sign' => 'checkCrontab'),
	array('title' => '检查平台服务器列表', 'sign' => 'checkPlatformServerList'),
	array('title' => '检查https连接', 'sign' => 'checkHttps'),
	//array('title' => '检查http连接', 'sign' => 'checkHttp'),
	array('title' => '检查http连接', 'sign' => 'checkHttp2'),
	array('title' => '检查单pk服conf', 'sign' => 'pkconf'),
	array('title' => '检查表信息', 'sign' => 'tablelist'),
	array('title' => '检查定时任务', 'sign' => 'crontab'),
	//array('title' => '测试gmt操作', 'sign' => 'gmt'),
	//array('title' => '测试补发', 'sign' => 'platformAddGold'),
	array('title' => '测试查询', 'sign' => 'sql'),
	//array('title' => '测试高版本白名单', 'sign' => 'highversion'),
	array('title' => '测试维护', 'sign' => 'weihu'),
	//array('title' => '测试角色丢失修复', 'sign' => 'importAndFix'),
	//
);

$_expire = 30 * 60; //过期时间30分钟

$login_key = 'g#m%t3';


//gmt 函数列表
$gmt_func_map = array(
	'moyuTest' => '测试',
	'move2MainCity' => '移动到主城',
	//'getOnlinePlayerNum' => '获取当前在线玩家',
	//'getOpeActivityFix' => '获取固化活动状态',
	//'checkUpdate' => '检查热更新文件',
);
