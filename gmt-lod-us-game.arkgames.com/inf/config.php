<?php // -*-coding:utf-8; mode:php-mode;-*-
!defined('BACKEND_SIGN') && define('BACKEND_SIGN', 'gmt');

/**
 * 调试模式
 * @var int
 */
define("DEBUG_MODE", true);

/**
 * 数据库协议
 * 
 */
define("DB_PROTOCOL", "mysql");
/**
 * MySQL 数据库服务器
 *
 */
define('DB_HOST', COMFIG_DB_HOST);
define('DB_PORT', COMFIG_DB_PORT);
define('DB_USER', COMFIG_DB_USER);
define('DB_PASS', COMFIG_DB_PWD);
define('DB_LIBR', COMFIG_DB_NAME_GMT);


define('TOKENKEY','r1mJoMyquiyspM_BJ4BPs0');
/**
 * 跟UM通信KEY
 */
define('SOAPTOKENKEY','A34DF*&*9DFT@EF*$U');
define('UMTOKENKEY','UM@KunLun$SubSystem');  //新版um
/**
 * 调用游戏后缀名
 */
define('RESTSUFFIX','/webproxy.php');

//define('RESTSUFFIX','/webproxy.php');

/**
 * 调用大区主服务器
 */
define('RESTREGIONS','http://region.kunlun.com/index.php');
/**
 * 调用大区备份日志服务器
 */
define('RESTBAKREGIONS','http://dc.region.kunlun.com/index.php');
/**
 * 调用Passport地址
 */
define('PASSPORTURL','http://api.kunlun.com/index.php');
/**
 * UM地址
 */

define('UMURL','http://um2.kunlun.com/manage.php');

/**
 * 游戏类型
 */
define('GAME','moyu');

/**
 * 获取游戏服务器来源
 * 国内internal ,国外external
 */
define('NATION','internal');
/**
 * UM标识
 * UMGMSIGN GMT对应的游戏标识    UMOPERATSIGN 运营方标识前缀
 */
define('UMGMGAMESIGN','GMT_moyu');
//define('UMGMGAMESIGN','GMT_moyu');
define('UMGMGAMEOPERATSIGN','GDSS_business_operations_');

define('SERVERSYNEMAIL', 'hua.gao@kunlun-inc.com');

//设置 include_path 为绝对路径
//define('INCLUDE_PATH', '/data/moyu/www/gmttest.moyu.kunlun.com'); // 默认 include 路径
define("INCLUDE_PATH", str_replace('\\', '/', dirname(dirname(__FILE__))));

define('GMT_OEMARK_CONFIG_FILE','/data/syslog/serverlist/gmt_oemark.php');   //服务器配置文件
define('GMT_OPERATION_CONFIG_FILE','/data/syslog/serverlist/gmt_operation.php');  //服务器配置文件

ini_set('include_path', INCLUDE_PATH . '/lib'		. PATH_SEPARATOR . ini_get('include_path'));
ini_set('include_path', INCLUDE_PATH . '/classes'	. PATH_SEPARATOR . ini_get('include_path'));

?>
