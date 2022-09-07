<?php
/**
 * 激活码处理入口
 * @author fuqian.liao
 */

define('WX_KUNLUN_COM', '#$wx%^@Kunlun@');

require_once '../config/config.php'; 
require_once 'ActivationCodeService.php'; //合服处理

// 数据库配置
/*
 
$config_server	 = '58.83.172.7:3306';	//数据库服务器
$config_database = 'gulong_activity';	//数据库
$config_user	 = 'suwin'; 			//用户帐号
$config_password = 'iamsuwin';			//密码

*/

$config_server	 = '42.62.23.158:3306';	//数据库服务器
$config_database = 'gulong_activity';	//数据库
$config_user	 = 'gulong'; 			//用户帐号
$config_password = 'e3v8pVQEYMMS3Tva';	//密码

try {
	
	$act = $_GET['act'];
	
	if (is_integer(strpos($act,'ActivationCodeService')))
	{
		$arr_act = explode('.', $act);
		if (is_array($arr_act) && count($arr_act) == 2)
		{
			$action = $arr_act[1];
			$ActivationCodeService = new ActivationCodeService();
			$ActivationCodeService->$action();
		}
	}
	else 
	{
		throw new Exception("未知操作类型.\r\n");
	}
	
}catch (Exception $e) {
	echo $e->getMessage();
}
?>