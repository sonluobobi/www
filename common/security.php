<?php

/**
 * 公共安全验证,可以包括ip,密钥
 * @param string $filename_sign  文件名称标识,如 platform, stats_entrance
 * @param array $allow_ips 允许的ip列表
 * @param string $client_ip   来源ip
 * @return boolean  true:通过	false:未通过
 */
function common_security_check_ip($filename_sign='',$allow_ips=array(),$client_ip='')
{
	empty($client_ip) && $client_ip = $_SERVER['REMOTE_ADDR'];
	$filepath = str_replace('\\', '/', dirname(__FILE__)) . '/data/log_ip/';
	@mkdir($filepath, 0777);
	$log_ip_str = $client_ip . ' - - ['.date('Y-m-d H:i:s') . '] ' . json_encode($_REQUEST) . "\r\n";
	
	//@file_put_contents($filepath. $filename_sign . '_access_ip.txt', $log_ip_str, FILE_APPEND);
	
	if (empty($allow_ips) || !is_array($allow_ips)) $allow_ips = array();
	
	$allow_ips[] = '127.0.0.1';
	
	if(!in_array($client_ip,$allow_ips))
	{
		if(stripos($client_ip,'10.251.') !== 0 and stripos($client_ip,'192.168.') !== 0 )
		{
			//写入日志
			@file_put_contents($filepath. $filename_sign . '_forbiden_ip.txt', $log_ip_str, FILE_APPEND);
			header('http/1.0 404 not found');
			echo "this ip ($client_ip) is not allowed!!!";
			exit;
		}
	}
	
	return true;
}

/**
 * 浏览器上层弹窗验证
 * @param $name 验证用户名
 * @param $pwd 验证密码  md5 加密后字符串
 */
function common_security_check_auth($name='', $pwd='')
{
	$_CONFIG_LOGIN_ACCOUNT = empty($name) ? 'zlcs' : $name;
	$_CONFIG_LOGIN_PASSWD  = empty($pwd) ? md5('kunlunzl') : $pwd;
	
	/* 检查$PHP_AUTH_USER和$PHP_AUTH_PW中的值 */
	if ((!isset($_SERVER['PHP_AUTH_USER'])) || (!isset($_SERVER['PHP_AUTH_PW']))) 
	{
		/* 如果没有值，则发送一个能够引发对话框出现的头部 */
		header('WWW-Authenticate: Basic realm="My Private Stuff"'); 
		header('HTTP/1.0 401 Unauthorized'); 
		echo 'Authorization Required.'; 
		exit;
	} 
	else if ((isset($_SERVER['PHP_AUTH_USER'])) && (isset($_SERVER['PHP_AUTH_PW'])))
	{
		/* 变量中有值，检查它们是否正确*/
		if (($_SERVER['PHP_AUTH_USER'] != $_CONFIG_LOGIN_ACCOUNT) || (md5($_SERVER['PHP_AUTH_PW']) != $_CONFIG_LOGIN_PASSWD)) 
		{
			/* 如果输入的用户名和口令中有一个不正确，则发送一个能够引发对话框出现的头部*/
			header('WWW-Authenticate: Basic realm="My Private Stuff"'); 
			header('HTTP/1.0 401 Unauthorized'); 
			echo 'Authorization Required.';
			exit;
		}
	}
}

/**
 * 公用日志记录
 * @param  [string] $type   [后台类型如 gmt,act,stats]
 * @param  [string|array] $str    [日志数据，支持数组]
 * @param  [string] $auth   [操作者]
 * @param  string $folder [二级目录]
 */
function common_do_log($type, $str, $auth, $folder='')
{
	if (empty($type) || empty($str) || empty($auth)) return false;
	$client_ip = $_SERVER['REMOTE_ADDR'];
	$filepath = str_replace('\\', '/', dirname(__FILE__)) . '/data/' . $type . '/';
	!empty($folder) && $filepath .= $folder . '/';
	@mkdir($filepath, 0777, true);
	$msg = $str;
	is_array($str) && $msg = json_encode($str);
	$log_str = $client_ip . ' -- ['.date('Y-m-d H:i:s') . '] -- ' . $auth . ' -- ' . $msg . "\r\n";
	$cur_date = date('Ymd');
	$filename = $filepath . 'common_log_'. $cur_date . '.log';
	@file_put_contents($filename, $log_str, FILE_APPEND);
}

