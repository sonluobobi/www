<?php
//公共用户配置
$_CONFIG_ACCOUNT = array();

$common_account_all['sanxiao'] = md5('kunlunmoyu');
$common_account_all['zlcs'] = md5('kunlunzl');

$platform_account_map = array();
//全大区公用账号列表
$platform_account_map['all'] = array('sanxiao', 'jianzhu','zlcs'); 


//***********************不同大区，不同后台账号配置列表
//国内安卓
$platform_account_map['zh'] = array();
$platform_account_map['zh']['all'] = array('jianzhu');
$platform_account_map['zh']['act'] = array('test1');
$platform_account_map['zh']['gmt'] = array('test2');
$platform_account_map['zh']['stats'] = array('test3');


if (!empty($common_account_all) && !empty($platform_account_map))
{
	if (!empty($platform_account_map['all']))
	{
		//全大区公用账号
		foreach($platform_account_map['all'] as $_name)
		{
			if (isset($common_account_all[$_name]))
			{
				$_CONFIG_ACCOUNT[$_name] = $common_account_all[$_name];
			}
		}

	}

	if (!empty($common_area_sign) && isset($platform_account_map[$common_area_sign]))
	{
		//本大区公用账号
		if (!empty($platform_account_map[$common_area_sign]['all']))
		{
			foreach($platform_account_map[$common_area_sign]['all'] as $_name)
			{
				if (isset($common_account_all[$_name]))
				{
					$_CONFIG_ACCOUNT[$_name] = $common_account_all[$_name];
				}
			}
		}

		//本地区后台账号
		if (defined('BACKEND_SIGN') && !empty($platform_account_map[$common_area_sign][BACKEND_SIGN]))
		{
			foreach($platform_account_map[$common_area_sign][BACKEND_SIGN] as $_name)
			{
				if (isset($common_account_all[$_name]))
				{
					$_CONFIG_ACCOUNT[$_name] = $common_account_all[$_name];
				}
			}
		}
	}
}

?>
