<?php
/**
 * 特殊权限分配
 * mall_export 商城导出功能
 * mall_import 商城导入功能
 *
 * act_export 活动导出功能
 * act_import 活动导入功能
 *
 * act_code_share 激活码大区共享
 */

define('AUTH_MALL_EXPORT', 'mall_export');
define('AUTH_MALL_IMPORT', 'mall_import');
define('AUTH_ACT_EXPORT', 'act_export');
define('AUTH_ACT_IMPORT', 'act_import');
define('AUTH_GASHAPON_EXPORT', 'gashapon_export');
define('AUTH_GASHAPON_IMPORT', 'gashapon_import');
//密令
define('AUTH_SECRET_ORDER_EXPORT', 'secret_order_export'); 
define('AUTH_SECRET_ORDER_IMPORT', 'secret_order_import');

//推币机
define('AUTH_COIN_DOZER_EXPORT', 'coin_dozer_export'); 
define('AUTH_COIN_DOZER_IMPORT', 'coin_dozer_import');

define('AUTH_ACT_CODE_SHARE', 'act_code_share');

//操作权限配置
$auth_map = array(
	'jianzhu' => array('mall_export' => 1, 'mall_import' => 0, 'act_export' => 1, 'act_import' => 0, 'act_code_share' => 1),
	'wanghongzhi' => array('mall_export' => 1, 'mall_import' => 1, 'act_export' => 1, 'act_import' => 1, 'act_code_share' => 0),
);

//判断是否有权限， true|false 有|无
function auth_has_privilege($auth_code)
{
	global $auth_map;

	return true;
	$username = $_SESSION['username'];

	if (empty($username) || empty($auth_code) || empty($auth_map))
	{
		return false;
	}

	if (!isset($auth_map[$username]) || !isset($auth_map[$username][$auth_code]))
	{
		return false;
	}

	if (1 == $auth_map[$username][$auth_code])
	{
		return true;
	}

	return false;
}
