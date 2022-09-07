<?php
/******************************************************************************
Filename              : security.inc.php
Author                : suwin zhong
Date/time             : 2008-12-05
Purpose               : 安全控制
Description           : 
Revisions             :

******************************************************************************/
DEFINE('CONFIG_SECURITY_CODE_INFO', '%^#$%xIaofENgYun!@#');

//临时登录帐号列表
require_once('account.inc.php');

//公共安全验证，如ip限制,及上层弹窗
$common_security_file = '/data/moyu/www/common/security.php';
$common_security_file = str_replace('\\', '/', dirname(dirname(dirname(__FILE__)))) . '/common/security.php';

if (!file_exists($common_security_file))
{
	echo "you are not allowed!!!";exit;
}

require_once $common_security_file;

//介于部分员工在家办公，访问ip非固定，此处设置不限ip的账户名单
$check_ip_flag = false;

if (!empty($_SESSION['AuthCode']) && $_SESSION['AuthCode'] == CONFIG_SECURITY_CODE_INFO)
{
	//配置不受IP限制的账号
	$not_ip_limit_username = array(
			'moyu', //
	);

	if(empty($_SESSION['username']) || !in_array($_SESSION['username'], $not_ip_limit_username)) $check_ip_flag = true;
}

if ($check_ip_flag && function_exists('common_security_check_ip'))
{
	$allow_ips=array();
	//common_security_check_ip('act', $allow_ips);
}

if (!function_exists('common_security_check_auth'))
{
	echo "you are not allowed!!!";exit;
}

//上层弹窗验证,可单独自定义用户名及密码 如 common_security_check_auth('test', '098f6bcd4621d373cade4e832627b4f6');
common_security_check_auth();

$http_action = trim($_POST['opt_action']);

//活动后台公用日志类
function act_do_log($str, $folder='')
{
	if (function_exists('common_do_log'))
	{
		//记录登录日志
		common_do_log('act', $str, $_SESSION['username'], $folder);
	}
}

if ('login' == $http_action)
{
	$http_auth_code  = $_POST['AuthCode'];
	$sess_auth_code  = $_SESSION['imgRndNum'];
	
	if ($http_auth_code != $sess_auth_code)
		Redirect('index.php', '验证码错误！', '1');

	$flg_login_success = false; //是否登录成功

	$http_account = trim($_POST['account']);
	$http_passwd  = trim($_POST['passwd']);

	if (md5($http_passwd) == $_CONFIG_ACCOUNT[$http_account])
		$flg_login_success = true;
	
    if ($flg_login_success)
    {
    	$_SESSION['username'] = $http_account;
		$_SESSION['AuthCode'] = CONFIG_SECURITY_CODE_INFO;
		$_SESSION['accountname'] = $http_account;
		//记录登录日志
		act_do_log('login in act', 'login');
		Redirect('index.php', '登陆成功，现即将返回！', '1');
    }
    else
    {
		Redirect('index.php', '帐号密码错误！');
	}
}

$sess_AuthCode = $_SESSION['AuthCode']; //安全码
if ($sess_AuthCode != CONFIG_SECURITY_CODE_INFO)
{
	//显示登陆页面
	Display_login();
	exit;
}
?>
