<?php
	//dcList.php
	require 'common.php';
	require 'base.php';

	$caption = 'dc配置的服务器列表';
	$retmsg = '';
	$desc_msg = "每个5分钟从dc同步一次游戏服列表<br>";
	$desc_msg .= '运营状态 -- 0:准备开服, 1:运营中, 3:停运';
	$desc_msg .= '<br>合服过程中,可以根据大区id,游戏服名称,运营状态,判断dc修改,游戏服这边是否同步成功';

	empty($common_product_id) && $common_product_id = 0;
	$platform_tableinfo_file = '/data/syslog/serverlist/platform_tableinfo_'.$common_product_id.'.php';
	$ret = array();

	if (file_exists($platform_tableinfo_file))
	{
		$tableInfo = array();
		require $platform_tableinfo_file;

		if (!empty($tableInfo))
		{
			$data = array();

			$field_title_map = array(
					//'product_id' => '产品id',
					'server_id' => '大区id',
					'server_name' => '游戏服名称',
					'server_status' => '运营状态',
					'server_ip' => '游戏服ip',
					'server_date' => '开服时间',
					'vouch_status' => '充值状态',
					'login_url' => '登录url',
					'show_seque' => '展示顺序',
					'is_recommend' => '是否推荐'
				);

			$voucher_id = floor($common_voucher_id / 1000);

			foreach($tableInfo as $sid => $info)
			{
				if ($info['product_id'] != $common_product_id) continue;

				$server_id = $info['server_id'];
				if (floor($server_id / 1000) != $voucher_id) continue;
				
				$tmp = array();

				foreach($field_title_map as $field => $title)
				{
					$tmp[$field] = $info[$field];

					if ($field == 'server_status' && $info[$field] == 3)
					{
						$tmp[$field] = '<span style="color:#f00;">' . $info[$field]. '</span>';
					}
				}

				$data[] = $tmp;
			}

			$titles = array();

			foreach($field_title_map as $field => $title)
			{
				$tmp = array();
				$tmp['var'] = $field;
				$tmp['txt'] = $title;
				$titles[] = $tmp;
			}

			$smarty->assign("titles", $titles);
			$smarty->assign("base_list", $data);
		}
		else
		{
			$retmsg = '没有服务器列表 -- product_id=' . $common_product_id;
		}
	}
	else
	{
		$retmsg = '产品配置文件不存在 -- product_id=' . $common_product_id;
	}
	
	$smarty->assign('caption', $caption, true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->assign("desc_msg", $desc_msg, true);
	$smarty->display('share.tpl');