<?php
/******************************************************************************
Filename              : server.inc.php
Author                : fuqian.liao
Date/time             : 2012-12-05
Purpose               : 游戏服配置文件
Description           : 
Revisions             :

******************************************************************************/

//所有游戏服配置
$ALL_CONFIG_SERVER = array();

/**
 * 获取保存游戏服列表的INI文件内容
 * @return multitype:unknown
 */
function getPublishServerList()
{
	global $ALL_CONFIG_SERVER;
	
	$ALL_CONFIG_SERVER = require_once ALL_CONFIG_SERVER_FILE;
	
	//file_put_contents("/tmp/server_list.log", var_export($ALL_CONFIG_SERVER,true));
	
}

getPublishServerList();

?>