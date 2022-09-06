<?php

namespace service;

use framework\core;
use entity;
use dao;
use framework\util;
use common;
use ctrl\LogCtrl;

class ToplistService extends ServersAbs
{
	private $dao;
	private $pagecount; //每页显示的条数
	private $pageCurrent; //当前页数
	private $result = array();
	private $list = array();

	/**
	 * @desc 初始化父类构造函数，实例化NoticeDao对象
	 */
	public function __construct()
	{
		parent::__construct();
	}

	//全服战力
	public function GlobalFC($stat_date)
	{
		$dataList = array();

		$common_config_file = '/data/moyu/www/common/config.php';

		if (file_exists($common_config_file))
		{
			require_once $common_config_file;

			if ($common_second_domain && $common_area_sign)
			{
				$center_num = 1;
				$common_area_sign == 'zh' && $center_num = 11;
				$server_url = 'center'.$center_num.$common_second_domain;
				//throw new \Exception($server_url);
				$url = "http://".$server_url. '/for_backend/index.php?c=Center&a=GlobalFC&stat_date=' . $stat_date;

				$token = 's#2E1!m3Y';
				$params = array();
				$t = time();
				$params['t'] = $t;
				$params['s'] = md5($token.$t.$token);

				$url .='&'.http_build_query($params);

				$cnt = 0;
			    while($cnt < 2 && ($result = @file_get_contents($url)) === false)
			    {
			    	$cnt++;
			    }

				$bak_result = $result;
			    $result = @gzuncompress($result);
			    $arr = json_decode($result, true);
			    $msg = '';

			    if (!empty($arr))
			    {
			    	if (isset($arr['data']))
			    	{
				   		$data = $arr['data'];
				    	foreach ($data as $k => $detail)
				    	{
				    		$tmp = $detail;

				    		$server_id = $detail['server_id'];
				    		$serverName = common\Functions::getServerUrl($server_id, 'serverName');

				    		$tmp['server_id'] = $serverName.'('.$server_id.')';

				    		$dataList[] = $tmp;
				    	}
			    	}
			    	else
			    	{
			    		$msg = !empty($arr['retmsg']) ? $arr['retmsg'] : '';
			    	}
			    }
			    else
			    {
					$arr = json_decode($bak_result, true);
					$msg = !empty($arr['retmsg']) ? $arr['retmsg'] : '';
			    }

			    if ($msg)
			    {
			    	throw new \Exception($msg);
			    }
			}
		}

		return $dataList;
	}
}