<?php
/******************************************************************************
Filename              : config.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2008-12-03
Purpose               : 配置文件
Description           : 
Revisions             :

******************************************************************************/
error_reporting(7);
!defined('BACKEND_SIGN') && define('BACKEND_SIGN', 'act');

//$common_config_file = '/data/sanxiao/www/common/config.php';
$common_config_file = str_replace('\\', '/', dirname(dirname(dirname(__FILE__)))) . '/common/config.php';


if (!file_exists($common_config_file))
{
	echo "common config file is not exists !!!";exit;
}

require_once $common_config_file;

define("OFFICIAL_PID",$common_product_id); //魔域官服产品ID
	
//设置 include_path 为绝对路径
define("INCLUDE_PATH", str_replace('\\', '/', dirname(dirname(__FILE__))));

ini_set('include_path', INCLUDE_PATH . '/libs' . PATH_SEPARATOR . ini_get('include_path'));
ini_set('include_path', INCLUDE_PATH . '/config' . PATH_SEPARATOR . ini_get('include_path'));
ini_set('include_path', INCLUDE_PATH . '/functions' . PATH_SEPARATOR . ini_get('include_path'));
ini_set('unserialize_callback_func','Utils::unserializeCallbackFunc');

/**
 * 访问服务器的URL
 */
define('GAME_SERVER_URL', "http://server.moyu.kunlun.com/index.php");

/**
 * 日志存放目录
 */
define('LOGS_DIR', INCLUDE_PATH."/logs");

// 存放活动配置文件目录
define('ACTIVITY_DIR', INCLUDE_PATH . '/data/activity');

// 存放激活码文件目录
define('ACT_CODE_DIR', INCLUDE_PATH . '/data/act_code');

// 存放固化活动游戏服文件目录
define('SERVER_DATA_DIR', INCLUDE_PATH . '/data/static_act');

// 固化活动游戏服列表缓存文件
define('SERVER_LIST_CACHE_FILE', INCLUDE_PATH . '/data/static_act/server_list_cache.php');

// 游戏服数据列表文件
define('SERVER_LIST_DATA_FILE', '/data/syslog/serverlist/server_list.php');

// 游戏服数据列表文件
define('SERVER_CENTER_LIST_FILE', '/data/syslog/serverlist/server_center_list.php');

//服务器列表配置文件
define('SERVER_LIST_FILE', '/data/syslog/serverlist/server_list.ini');

// 游戏服数据列表文件
define('ALL_CONFIG_SERVER_FILE', '/data/syslog/serverlist/all_config_server.php');

// 存放后台操作日志目录
define('OPERATION_LOG_DIR', INCLUDE_PATH . '/data/logs');

//*********************** 图片上传 start ************************/
//图片上传根路径
define('SERVER_RESOURCE_UPLOAD_BASE_DIR', '/data/vhost/test.moyu.kunlun.com/game_resource/');

//图片访问根域名
define('SERVER_RESOURCE_DOMAIN', 'http://local_r1.moyu.kunlun.com');
//*********************** 图片上传 end **************************/

/************** 数据库相关配置 start ********/

define(DB_HOST, COMFIG_DB_HOST);
define(DB_PORT, COMFIG_DB_PORT);
define(DB_USER, COMFIG_DB_USER);
define(DB_PASS, COMFIG_DB_PWD);
define(DB_LIBR, COMFIG_DB_NAME_ACT);

$config_server=COMFIG_DB_HOST.':'.COMFIG_DB_PORT;
$config_user=COMFIG_DB_USER;
$config_password=COMFIG_DB_PWD;
$config_database=DB_LIBR;


/************** 数据库相关配置 end **********/

//memcache 相关
define('CONFIG_MEMCACHE_SERVER_IP', '42.62.23.158'); //IP
define('CONFIG_MEMCACHE_SERVER_PORT', '12321');		 //端口
	
define('MAKE_CODE_MAX', 200000); //定义通过活动后台生成批次激活码个数上限
define('USE_CODE_LIMIT', 500);	 //每个批次的激活码使用个数
define('ACT_CODE_TOKEN', '&@!gss*s#$@6$#sd^sd@fh#$d#h#f&s*@@#f&*#$#@4!f@d@s!#$#s#@!@@#fhgsdfg');

define('IMPORT_CODE_SQL_FILE', '/tmp/import_code_file.sql'); //定义激活码导入文件

/******************** 每个星期检查一次  start ********************************************/
define('CUR_TBL_CODE_LIB', 'tbl_activation_code');     //定义当前存储激活码的表
define('CUR_TBL_CODE_USE', 'tbl_activation_code_use');//定义当前记录激活码使用的表
/******************** 每个星期检查一次 end ********************************************/

?>
