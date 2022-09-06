<?php

namespace service;
use common;

class SearchService extends CommonService
{
	//幻兽查询
	public function Pet()
	{
		$this->check_date_flag = false;
		return $this->comm();
	}

	public function format_Pet($arr_data)
	{
		$ret = array();

		foreach ($arr_data as $data)
		{
			$tmp = array();
			$tmp = $data;
			$is_free = $tmp['is_free']; //断交、闲置
			$is_fight = $tmp['is_fight']; //出战
			$is_heti_in = $tmp['is_heti_in'];//内层合体
			$is_heti_out = $tmp['is_heti_out'];//外层合体
			$status = '';

			if ($is_free == 1)
			{
				$status = '闲置';
			}
			elseif($is_fight == 1)
			{
				$status = '出战';
			}
			elseif($is_heti_in == 1)
			{
				$status = '内层合体';
			}
			elseif($is_heti_out == 1)
			{
				$status = '外层合体';
			}

			$tmp['status'] = $status;

			$ret[] = $tmp;
		}

		return $ret;
	}

	//角色交易查询
	public function Trade()
	{
		return $this->comm();
	}

	//军团仓库查询
	public function GangStorage()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	//军团仓库查询参数验证
	public function check_params_GangStorage()
	{
		$gang_title = $this->httpGetVal('gang_title');

		if (empty($gang_title))
		{
			//$this->show_error($this->_LANG['no_gang_tiltle']);
			//return false;
		}

		return true;
	}

	public function format_GangStorage($arr_data)
	{
		$gangStorageLogTypeMap = common\Statics::$gangStorageLogTypeMap;
		$ret = array();

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			$log_type = $tmp['log_type'];

			$tmp['log_type'] = isset($gangStorageLogTypeMap[$log_type]) ? $gangStorageLogTypeMap[$log_type] : $log_type;

			$ret[] = $tmp;
		}

		return $ret;
	}

	//元宝共用数据格式化，汇总元宝总数
	public function comm_gold_format($arr_data, $key)
	{
		$ret = array();
		$all_gold_num = 0;

		foreach ($arr_data as $data)
		{
			$num = isset($data[$key]) ? intval($data[$key]) : 0;
			$all_gold_num += $num;
			$ret[] = $data;
		}

		$tmp_data = $ret[0];

		//构造key
		foreach ($tmp_data as $i => $value) {
			$tmp_data[$i] = '';
		}

		$tmp_data[$key] = $all_gold_num;
		$ret[] = $tmp_data;

		return $ret;
	}
	
	//格式化化赠送金额，汇总总新增元宝数
	public function format_AddGameGold($arr_data)
	{
		return $this->comm_gold_format($arr_data, 'add_num');
	}

	//赠送元宝
	public function AddGameGold()
	{
		return $this->comm();
	}

	//删除赠送元宝
	public function DelGameGold()
	{
		return $this->comm();
	}

	public function format_DelGameGold($arr_data)
	{
		return $this->comm_gold_format($arr_data, 'del_num');
	}

	//充值元宝
	public function VoucherGold()
	{
		return $this->comm();
	}

	public function format_VoucherGold($arr_data)
	{
		return $this->comm_gold_format($arr_data, 'add_num');
	}

	//删除元宝
	public function DelVoucherGold()
	{
		return $this->comm();
	}

	public function format_DelVoucherGold($arr_data)
	{
		return $arr_data;
		//return $this->comm_gold_format($arr_data, 'del_num');
	}

	public function MoneyAdd()
	{
		return $this->comm();
	}

	public function format_MoneyAdd($arr_data)
	{
		return $this->format_comm_money($arr_data, 'add');
	}

	public function format_comm_money($arr_data, $key)
	{
		$money_use_gold_type_map = common\Statics::$money_use_gold_type_map;
		$silver_type_map = common\Statics::$silver_type_map;
		$ret = array();

		foreach ($arr_data as $data)
		{
			$gold_type = isset($data['gold_type']) ? intval($data['gold_type']) : 0;
			!empty($money_use_gold_type_map[$gold_type]) && $data['gold_type'] = $money_use_gold_type_map[$gold_type];
			
			if ($key= 'use')
			{
				$service_id = isset($data['service_id']) ? intval($data['service_id']) : 0;
				!empty($silver_type_map[$service_id]) && $data['service_id'] = $silver_type_map[$service_id];
			}

			$ret[] = $data;
		}

		return $ret;
	}

	public function MoneyUse()
	{
		return $this->comm();
	}

	public function format_MoneyUse($arr_data)
	{
		return $this->format_comm_money($arr_data, 'use');
	}

	//聊天记录
	public function ChatLog()
	{
		$this->check_date_flag = false;
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_ChatLog($arr_data)
	{
		$chat_type_map = $this->_LANG['chat_type_map'];
		$ret = array();

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			$chat_type = $tmp['chat_type'];

			$tmp['chat_type'] = isset($chat_type_map[$chat_type]) ? $chat_type_map[$chat_type] : $chat_type;

			$ret[] = $tmp;
		}

		return $ret;
	}

	//创角总数日志
	public function RoleCreatedLog()
	{
		$this->check_date_flag = false;
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	//改名日志
	public function RenameLog()
	{
		$this->check_date_flag = false;
		return $this->comm();
	}

	//登录日志
	public function LoginLog()
	{
		return $this->comm();
	}

	//军团成员仓库查询
	public function GangMemberStorages()
	{
		$this->check_date_flag = false;
		return $this->comm();
	}

	public function format_GangMemberStorages($arr_data)
	{
		$chat_type_map = $this->_LANG['chat_type_map'];
		$ret = array();

		$equip_file = INCLUDE_PATH . '/data/equip.php';
		$equip_map = include $equip_file;

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			$equip_id = $tmp['equip_id'];
			
			if (!empty($equip_map) && isset($equip_map[$equip_id]))
			{
				$equip_info = $equip_map[$equip_id];
				$tmp['equip_title'] = $equip_info['title'];
			}

			//$tmp['equip_json'] = json_encode($data['equip_json']);
			$ret[] = $tmp;
		}

		return $ret;
	}

	//角色活动参与日志
	public function ActivityLog()
	{
		$this->check_date_flag = false;
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	//当前后台活动列表
	public function ActivityList()
	{
		$this->check_date_flag = false;
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	//排行榜查询
	public function TopList()
	{
		$this->check_date_flag = false;
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function check_params_TopList()
	{
		$toplist_type = $this->httpGetVal('toplist_type');

		if (empty($toplist_type))
		{
			$this->show_error($this->_LANG['error_no_toplist_type']);
			return false;
		}

		return true;
	}

	//交易双方汇总信息查询
	public function TradeSucc()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function check_params_TradeSucc()
	{
		$min_gold = $this->httpGetVal('min_gold');
		$master_cid = $this->httpGetVal('master_cid');
		$slave_cid = $this->httpGetVal('slave_cid');
		$equip_id = $this->httpGetVal('equip_id');

		if (!empty($equip_id) && !is_numeric($equip_id))
		{
			$error_msg = $this->_LANG['argvError'] . ' -- '. $this->_LANG['equip_id'];
			$this->show_error($error_msg);
			return false;
		}

		if (!empty($slave_cid) && !is_numeric($slave_cid))
		{
			$error_msg = $this->_LANG['argvError'] . ' -- '. $this->_LANG['slave_cid'];
			$this->show_error($error_msg);
			return false;
		}

		if (!empty($master_cid) && !is_numeric($master_cid))
		{
			$error_msg = $this->_LANG['argvError'] . ' -- '. $this->_LANG['master_cid'];
			$this->show_error($error_msg);
			return false;
		}

		$search_limit_min_gold = 100;

		if (empty($master_cid) && empty($slave_cid) && empty($equip_id))
		{
			if (empty($min_gold) || !is_numeric($min_gold) || $min_gold < $search_limit_min_gold)
			{
				$error_msg = sprintf($this->_LANG['error_trade_succ_min_gold'],$search_limit_min_gold);
				$this->show_error($error_msg);
				return false;
			}
		}

		return true;
	}

	//历史密令
	public function SecretOrder()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_SecretOrder($arr_data)
	{
		return $this->SecretOrder_format_comm($arr_data);
	}

	//成功破解查询
	public function SecretOrderCracked()
	{
		return $this->comm();
	}

	public function format_SecretOrderCracked($arr_data)
	{
		return $this->SecretOrder_format_comm($arr_data);
	}


	//参与破解查询
	public function SecretOrderJoined()
	{
		return $this->comm();
	}

	public function format_SecretOrderJoined($arr_data)
	{
		$secret_order_type_map = $this->_LANG['secret_order_type_map'];
		$ret = array();

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			$secret_order_type = intval($tmp['type']);

			$tmp['type'] = isset($secret_order_type_map[$secret_order_type]) ? $secret_order_type_map[$secret_order_type] : $secret_order_type;
			
			for($I=1; $i<=6; $i++)
			{
				$key = 'grid'.$i;

				if (!empty($tmp[$key]))
				{
					$tmp[$key] = date('Y-m-d H:i:s', $tmp[$key]);
				}
			}

			$ret[] = $tmp;
		}

		return $ret;
	}

	//密令库列表
	public function SecretOrderList()
	{
		$this->check_date_flag = false;
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_SecretOrderList($arr_data)
	{
		return $this->SecretOrder_format_comm($arr_data);
	}

	public function SecretOrder_format_comm($arr_data)
	{
		$secret_order_type_map = $this->_LANG['secret_order_type_map'];
		$ret = array();

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			$secret_order_type = intval($tmp['type']);

			$tmp['type'] = isset($secret_order_type_map[$secret_order_type]) ? $secret_order_type_map[$secret_order_type] : $secret_order_type;
			
			$ret[] = $tmp;
		}

		return $ret;
	}

	//军团信息查询
	public function Gang()
	{
		$this->check_date_flag = false;
		//$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_Gang($arr_data)
	{
		$ret = array();

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			$gang_type = intval($tmp['type']);

			$tmp['type'] = $gang_type == 1 ? $this->_LANG['gang_type_vip'] : $this->_LANG['gang_type_normal'];
			
			$ret[] = $tmp;
		}

		return $ret;
	}

	//最强战队下注
	public function BestTeamSupport()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_BestTeamSupport($arr_data)
	{
		$is_win_map = $this->_LANG['is_win_map'];
		$ret = array();

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			$is_win = intval($tmp['is_win']);

			$tmp['is_win'] = isset($is_win_map[$is_win]) ? $is_win_map[$is_win] : $is_win;
			
			$ret[] = $tmp;
		}

		return $ret;
	}

	//冲值请求列表
	public function VoucherRequest()
	{
		$this->pagecount = 10000;
		$this->check_date_flag = false;
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	//角色操作备注
	public function BriefDesc()
	{
		$this->check_date_flag = false;
		return $this->comm();
	}

	public function format_BriefDesc($arr_data)
	{
		$brief_desc_sort_map = $this->_LANG['brief_desc_sort_map'];
		$ret = array();

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			$sort = intval($tmp['sort']);

			$tmp['sort'] = isset($brief_desc_sort_map[$sort]) ? $brief_desc_sort_map[$sort] : $sort;
			
			$ret[] = $tmp;
		}

		return $ret;
	}

	//定向礼包
	public function DirectionalGift()
	{
		return $this->comm();
	}

	public function format_DirectionalGift($arr_data)
	{
		$ret = array();

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			$gift_info = '';
			$db_gift_info = trim($tmp['gift_info']);

			if (!empty($db_gift_info) && strlen($db_gift_info) > 4)
			{
				$db_gift_arr = json_decode($db_gift_info, true);

				if (!empty($db_gift_arr) && is_array($db_gift_arr))
				{
					foreach($db_gift_arr as $_gift_id => $_info)
					{
						$gift_id = $_info['gift_id'];
						$msg = $this->_LANG['directional_gift_id'] . ':' .$gift_id . ' ,';

						if (isset($_info['purchased_time']) && $_info['purchased_time'] > 0)
						{
							$msg .= $this->_LANG['directional_gift_purchased_date'] . ':' .date('Y-m-d H:i:s', $_info['purchased_time']) . ' ,';
						}

						if (isset($_info['reward_time']) && $_info['reward_time'] > 0)
						{
							$msg .= $this->_LANG['directional_gift_reward_date'] . ':' .date('Y-m-d H:i:s', $_info['reward_time']) . ' ,';
						}

						$gift_info .= ' [' . trim($msg, ',') . "] |";
					}
				}
			}

			$tmp['gift_info'] = trim($gift_info, '|');
			
			$ret[] = $tmp;
		}

		return $ret;
	}

	//神兵洗练日志
	public function ShenBingLog()
	{
		return $this->comm();
	}

	public function format_ShenBingLog($arr_data)
	{
		$ret = array();
		$effect_owner_map = $this->_LANG['effect_owner_map'];
		$effect_type_map = $this->_LANG['effect_type_map'];

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			
			$old_effect_type = trim($tmp['old_effect_type']);
			isset($effect_type_map[$old_effect_type]) && $tmp['old_effect_type'] = $effect_type_map[$old_effect_type];

			$old_effect_owner = intval($tmp['old_effect_owner']);
			isset($effect_owner_map[$old_effect_owner]) && $tmp['old_effect_owner'] = $effect_owner_map[$old_effect_owner];

			$new_effect_type = trim($tmp['new_effect_type']);
			isset($effect_type_map[$new_effect_type]) && $tmp['new_effect_type'] = $effect_type_map[$new_effect_type];

			$new_effect_owner = intval($tmp['new_effect_owner']);
			isset($effect_owner_map[$new_effect_owner]) && $tmp['new_effect_owner'] = $effect_owner_map[$new_effect_owner];

			$ret[] = $tmp;
		}

		return $ret;
	}

	//许愿树日志
	public function WishingTree()
	{
		$this->check_date_flag = false;
		return $this->comm();
	}

	public function format_WishingTree($arr_data)
	{
		$ret = array();
		$wishing_tree_op_type_map = $this->_LANG['wishing_tree_op_type_map'];

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			
			$op_type = intval($tmp['op_type']);
			isset($wishing_tree_op_type_map[$op_type]) && $tmp['op_type'] = $wishing_tree_op_type_map[$op_type];

			$ret[] = $tmp;
		}

		return $ret;
	}

	//背包道具赠送日志
	public function PresentEquip()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	//圣域争霸战况猜想
	public function ShenYuGuess()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_ShenYuGuess($arr_data)
	{
		$ret = array();
		$shenyu_guess_state_map = $this->_LANG['shenyu_guess_state_map'];

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			
			for($i=1;$i<4;$i++)
			{
				$field = 'top'.$i;
				
				if (isset($data[$field]))
				{
					$value = $data[$field];
					$value_arr = json_decode($value, true);

					if (!empty($value_arr) && is_array($value_arr))
					{
						$ch_nick = isset($value_arr['ch_nick']) ? trim($value_arr['ch_nick']) : '';
						$unique_key = isset($value_arr['unique_key']) ? trim($value_arr['unique_key']) : '';
						$tmp[$field] = $ch_nick.'('.$unique_key.')';
					}
				}
			}

			$state = intval($tmp['state']);
			isset($shenyu_guess_state_map[$state]) && $tmp['state'] = $shenyu_guess_state_map[$state];

			$ret[] = $tmp;
		}

		return $ret;
	}

	//少数派
	public function ChoiceQuestion()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_ChoiceQuestion($arr_data)
	{
		$ret = array();
		$choice_question_state_map = $this->_LANG['choice_question_state_map'];

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			
			$state = intval($tmp['state']);
			isset($choice_question_state_map[$state]) && $tmp['state'] = $choice_question_state_map[$state];

			$ret[] = $tmp;
		}

		return $ret;
	}

	//积分狂揽,转盘
	public function RotaryJiFen()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_RotaryJiFen($arr_data)
	{
		$ret = array();
		$rotary_jifen_sort_id_map = $this->_LANG['rotary_jifen_sort_id_map'];
		$rotary_jifen_op_type_map = $this->_LANG['rotary_jifen_op_type_map'];

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			
			$sort_id = intval($tmp['sort_id']);
			isset($rotary_jifen_sort_id_map[$sort_id]) && $tmp['sort_id'] = $rotary_jifen_sort_id_map[$sort_id];

			$op_type = intval($tmp['op_type']);
			isset($rotary_jifen_op_type_map[$op_type]) && $tmp['op_type'] = $rotary_jifen_op_type_map[$op_type];


			$ret[] = $tmp;
		}

		return $ret;
	}

	//积分狂揽,积分获得
	public function RotaryJiFenGet()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	//积分狂揽,积分使用
	public function RotaryJiFenUse()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	//军团图腾，登记列表
	public function GangTotemRegister()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_GangTotemRegister($arr_data)
	{
		$ret = array();
		$gang_totem_register_type_id_map = $this->_LANG['gang_totem_register_type_id_map'];

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			
			$type_id = intval($tmp['type_id']);
			isset($gang_totem_register_type_id_map[$type_id]) && $tmp['type_id'] = $gang_totem_register_type_id_map[$type_id];

			$ret[] = $tmp;
		}

		return $ret;
	}


	//军团图腾, 排行榜
	public function GangTotemToplist()
	{
		$this->check_user_type_flag = false;
		$this->check_date_flag = false;
		return $this->comm();
	}

	public function format_GangTotemToplist($arr_data)
	{
		$ret = array();

		$gang_totem_register_type_id_map = $this->_LANG['gang_totem_register_type_id_map'];
		$ret['gen_date'] = isset($arr_data['gen_date']) ? $arr_data['gen_date'] : '';

		$type_toplist_data = array();

		if (!empty($arr_data['type_toplist_data']))
		{
			foreach ($arr_data['type_toplist_data'] as $_key => $_data)
			{
				$type_id = $_key + 1;
				$type_name = isset($gang_totem_register_type_id_map[$type_id]) ? $gang_totem_register_type_id_map[$type_id] : $type_id;
				$tmp_data = array();
				
				foreach($_data as $_index => $detail)
				{
					$tmp = $detail;
					$tmp['type_id'] = $type_name;

					$tmp_data[] = $tmp;
				}

				$type_toplist_data[] = $tmp_data;
			}

		}

		$ret['type_toplist_data'] = $type_toplist_data;

		return $ret;
	}

	//全服充值排行榜
	public function GlobalVoucherToplist()
	{
		$this->check_user_type_flag = false;
		$this->check_date_flag = false;
		return $this->comm();
	}

	public function format_GlobalVoucherToplist($arr_data)
	{
		$ret = array();

		$ret['gen_date'] = isset($arr_data['gen_date']) ? $arr_data['gen_date'] : '';

		$type_toplist_data = array();

		if (!empty($arr_data['toplist']))
		{
			$type_toplist_data = $this->format_server_aid($arr_data['toplist']);
		}

		$ret['toplist'] = $type_toplist_data;

		if($_POST['d'] == 1 && $type_toplist_data)
		{
			return $this->format_global_toplist_download($type_toplist_data);
		}

		return $ret;
	}

	//全服消费排行榜
	public function GlobalConsumeToplist()
	{
		$this->check_user_type_flag = false;
		$this->check_date_flag = false;
		return $this->comm();
	}

	public function format_GlobalConsumeToplist($arr_data)
	{
		return $this->format_GlobalVoucherToplist($arr_data);
	}

	public function format_global_toplist_download($arr_data)
	{
		if (empty($arr_data))
		{
			return $arr_data;
		}

		$ret = array();
		$fields = array('rank', 'cid','player_id','ch_nick', 'unique_key','level', 'fc', 'score', 'area_id');

		foreach ($arr_data as $data)
		{
			$tmp = array();

			foreach($fields as $field)
			{
				$tmp[$field] = isset($data[$field]) ? $data[$field] : '';
			}
			
			$ret[] = $tmp;
		}

		return $ret;
	}

	public function format_server_aid($arr_data, $field='area_id')
	{
		if (empty($arr_data))
		{
			return $arr_data;
		}

		$common_config_file = '/data/moyu/www/common/config.php';

		if (file_exists($common_config_file))
		{
			require $common_config_file;
		}
		
		if (!empty($common_voucher_id))
		{
			$ret = array();

			foreach ($arr_data as $data)
			{
				$tmp = $data;
				
				$area_id = isset($data[$field]) ? $data[$field] : '';

				if ($area_id)
				{
					$server_id = $common_voucher_id + intval($area_id);
					$serverName = common\Functions::getServerUrl($server_id, 'serverName');
					$tmp['area_id'] = $area_id.'('.$serverName.')';
				}

				$ret[] = $tmp;
			}
		}
		else
		{
			$ret = $arr_data;
		}

		return $ret;
	}

	//豆蔓日志
	public function StatBabel()
	{
		//$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_StatBabel($arr_data)
	{
		$ret = array();
		$prof_map = $this->_LANG['prof_map'];
		$StatBabel_state_map = $this->_LANG['StatBabel_state_map'];

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			
			$prof = intval($tmp['prof']);
			isset($prof_map[$prof]) && $tmp['prof'] = $prof_map[$prof];

			$state = intval($tmp['state']);
			isset($StatBabel_state_map[$state]) && $tmp['state'] = $StatBabel_state_map[$state];

			$ret[] = $tmp;
		}

		return $ret;
	}

	//竞技场查询
	public function ArenaPk()
	{
		$this->check_user_type_flag = false;
		return $this->comm();
	}

	public function format_ArenaPk($arr_data)
	{
		$ret = array();

		foreach ($arr_data as $data)
		{
			$tmp = $data;
			$ret[] = $tmp;
		}

		return $ret;
	}

}
