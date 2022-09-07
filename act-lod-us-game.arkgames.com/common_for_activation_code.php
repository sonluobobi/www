<?php
/******************************************************************************
Filename              : common.php
Author                : suwin zhong
Date/time             : 2008-12-05
Purpose               : 管理公共页面
Description           : 
Revisions             :

******************************************************************************/
error_reporting(7);
//error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
session_start();

// 删除因 register_globals = on 所产生的变量
if (ini_get("register_globals")) 
{
	while (list($k,$v) = each($_REQUEST))
		unset(${$k});
}

//常量文件
require_once('./config/config.php');		//系统常量(尽量不要修改)
require_once('./config/server.inc.php');	//游戏服配置文件
require_once('./config/static_config.php'); //基本常量

//带图片按钮,分页导航类
require_once('./libs/class.pager.php');

//包含各函数文件
require_once('functions/func_for_common.inc.php'); //公用函数
require_once('functions/func_for_html.inc.php');	 //html方面
require_once('functions/func_for_db.inc.php');	 //数据库辅助函数
require_once('functions/Utils.php');	 //数据库辅助函数

//require_once('functions/func_for_common.php'); //公用函数

require_once('libs/mysql.config.inc.php');

//smarttemplate模板
require_once('libs/class.mySmartTemplate.php');
if ('' == $template_name)
	$template_name = 'index.html';
$tpl = new MySmartTemplate($template_name);

$module_header = setHeaderModule();
$module_footer = setFooterModule();

$tpl->assign(array(
		'module_header' => $module_header,
		'module_footer' => $module_footer
			)
		);
?>
