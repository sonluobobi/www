<?php
//公共安全验证，如ip限制,及上层弹窗
!defined('BACKEND_SIGN') && define('BACKEND_SIGN', 'gmt');
//$common_security_file = '/data/sanxiao/www/common/security.php';
$common_security_file = str_replace('\\', '/', dirname(dirname(dirname(__FILE__)))) . '/common/security.php';

if (!file_exists($common_security_file))
{
	echo "you are not allowed!!!";exit;
}

require_once $common_security_file;

//介于部分员工在家办公，访问ip非固定，此处设置不限ip的账户名单
$check_ip_flag = false;

if (!empty($_SESSION['infoUser']['userName']))
{
	//配置不受IP限制的账号
	$not_ip_limit_username = array(
			'moyu', //
			'liujianzhu',
	);

	//!in_array($_SESSION['infoUser']['userName'], $not_ip_limit_username) && $check_ip_flag = true;
}

if ($check_ip_flag && function_exists('common_security_check_ip'))
{
	$allow_ips=array();
	common_security_check_ip('gmt', $allow_ips);
}

if (!function_exists('common_security_check_auth'))
{
	echo "you are not allowed!!!";exit;
}

//上层弹窗验证,可单独自定义用户名及密码 如 common_security_check_auth('test', '098f6bcd4621d373cade4e832627b4f6');
common_security_check_auth();

//活动后台公用日志类
function gmt_do_log($str, $folder='')
{
	if (function_exists('common_do_log'))
	{
		//记录登录日志
		common_do_log('gmt', $str, $_SESSION['infoUser']['userName'], $folder);
	}
}
