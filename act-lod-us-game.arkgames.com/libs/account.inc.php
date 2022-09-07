<?php
//公共账号配置文件
!defined('BACKEND_SIGN') && define('BACKEND_SIGN', 'act');
$common_account_file = '/data/sanxiao/www/common/account.inc.php';
$common_account_file = str_replace('\\', '/', dirname(dirname(dirname(__FILE__)))) . '/common/account.inc.php';

$_CONFIG_ACCOUNT = array();
if (file_exists($common_account_file))
{
	require_once $common_account_file;
}

//以这种格式添加账号
//$_CONFIG_ACCOUNT['moyu'] = '407257209de8f69d70cdb90c2a65cff6'; 

?>
