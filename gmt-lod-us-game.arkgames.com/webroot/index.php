<?php // -*-coding:utf-8; mode:php-mode;-*-
ini_set("display_errors", "On");

// 设定报错级别
error_reporting(E_ALL &~( E_STRICT | E_WARNING | E_NOTICE ));


use framework\mvc\view\smarty;
use framework\data\pdo;

session_start();


use framework\mvc\dispatcher\HTTPRequestDispatcher;
use framework\core\Context;
use framework\manager\PDOManager;

$common_config_file = str_replace('\\', '/', dirname(dirname(dirname(__FILE__)))) . '/common/config.php';

if (file_exists($common_config_file))
{
	require_once $common_config_file;
}
else
{
	echo 'common config file is not exists';
	exit;
}


if (empty($_SERVER['argv'][1]))
{
	require_once 'security.php'; //上层权限验证
}



!defined('BACKEND_SIGN') && define('BACKEND_SIGN', 'gmt');
define('GMT_WEB_ROOT', dirname(__FILE__));
define('GMT_PATH_ROOT', dirname(GMT_WEB_ROOT));

$common_account_file = str_replace('\\', '/', dirname(dirname(dirname(__FILE__)))) . '/common/account.inc.php';

if (file_exists($common_account_file))
{
	require_once $common_account_file;
}

//print_r($_CONFIG_ACCOUNT);exit;
(empty($_CONFIG_ACCOUNT) || !is_array($_CONFIG_ACCOUNT)) && $_CONFIG_ACCOUNT = array();

$_LANG = $init = '';
$pathRoot = realpath(dirname(__FILE__)."/../");

include_once($pathRoot."/lib/framework/setup.php");
Context::setRootPath($pathRoot);
Context::initialize();
unset ($pathRoot);
//Context::ipLimit();
/* 定义时区 */
$timeZone = !empty(\oemark::$oeMark["{$_SESSION['gup']}_{$_SESSION['productId']}"]['timeZone']) ? \oemark::$oeMark["{$_SESSION['gup']}_{$_SESSION['productId']}"]['timeZone'] : 'Asia/Shanghai';
ini_set('date.timezone',$timeZone);

$smartyConfig = new smarty\SmartyConfiguration();
$smartyConfig->smartyPath = "../lib/smarty";
$smartyConfig->cacheDir = "../template/cache";
$smartyConfig->compileDir = "../template/compile";
$smartyConfig->templateDir = "../template/template";
$smartyConfig->configDir = "../template/config";

//将管理组写入session
if($_SERVER['REQUEST_METHOD']=="POST" && array_key_exists("group",$_POST)){
	$GupArr = explode('|',$_POST['group']);

	$_SESSION['gup'] = $GupArr[0];
	$_SESSION['Langage'] = $GupArr[1];
	$_SESSION['gupFlag'] = $GupArr[2];
	$_SESSION['productId'] = $GupArr[3];
}

$_SESSION['gup'] = COMFIG_PRODUCT_ID;
$_SESSION['productId'] = COMFIG_PRODUCT_ID;


if(isset($_SESSION['Langage'])){
	//调公用语言包
	include_once ("../data/languages/".$_SESSION['Langage']."/common.php");
	if(array_key_exists("act", $_GET)){
	
		if (preg_match ( '/^([a-z_]+)\.([a-z_]+)$/i', $_GET['act'], $matLang ))
			{
				if(file_exists("../data/languages/".$_SESSION['Langage']."/{$matLang[1]}.php"))
				include_once ("../data/languages/".$_SESSION['Langage']."/{$matLang[1]}.php");
			}
	}
	clearstatcache();
}

if(array_key_exists("act", $_GET))
{
        
	if (preg_match ( '/^([a-z_]+)\.([a-z_]+)$/i', $_GET['act'], $matLang ))
        {
		if(file_exists("../data/cache/cache_".strtolower($matLang[1]).".php"))
                include_once ("../data/cache/cache_".strtolower($matLang[1]).".php");
        }
}

if ($_SESSION['Langage']) {
	include_once ("../data/languages/".$_SESSION['Langage']."/Log.php");
}else {
	include_once ("../data/languages/zh/Log.php");
}


$smartyConfig->GMT_CACHE=$GMT_CACHE;
$smartyConfig->Langage = $_LANG;



$smartyConfig->ServerList = $init;
smarty\SmartyView::setSmartyConfiguration($smartyConfig);
$pdoConfig = new pdo\PDOConfiguration();
$pdoConfig->protocol = DB_PROTOCOL;
$pdoConfig->host = DB_HOST;
$pdoConfig->port = DB_PORT;
$pdoConfig->user = DB_USER;
$pdoConfig->pass = DB_PASS;
$pdoConfig->dbname = DB_LIBR;
pdo\PDOManager::addConfigration("default", $pdoConfig);
class MyHTTPRequestDispatcher extends HTTPRequestDispatcher
{
	public function getCtrlClassName()
	{
		return parent::getCtrlClassName() . "Ctrl";
	}
}
$dispatcher = new \MyHTTPRequestDispatcher();
$dispatcher->dispatch();

