<?php 

class AuthTools
{
	//12: 操作管理  15: 权限分配 11: 日志管理
	//公用需要过滤的权限
	public static $comm_power_filter_map = array(12, 15, 11);

	//配置用户需要过滤的权限
	public static $power_filter_map = array (
		//'test' => array(7, 74, 86, 88, 94),
		'sanxiao' => 'default',
	);

	//判断是否没有权限，bool, true 没有权限
	public static function has_no_auth($username, $actionId)
	{
		$ret = false;

		$power_filter_map = self::$power_filter_map;

		if (!empty($power_filter_map) && isset($power_filter_map[$username]))
		{
			$power_filter_list = $power_filter_map[$username];

			if (is_string($power_filter_list) && 'default' == $power_filter_list)
			{
				$power_filter_list = self::$comm_power_filter_map;
			}

			if (in_array($actionId,$power_filter_list))
			{
			 	$ret = true;
			}
		}

		return $ret;
	}
}
