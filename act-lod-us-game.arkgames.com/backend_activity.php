<?php 
$template_name = 'backend_activity_list.html';
$tpl = null;
require('common.php');
require_once('libs/mysql.medoo.php');
require_once 'functions/Utils.php';

//新后台活动
//backend_activity.php

$sort_id_tpl_file_map = array();
$sort_id_tpl_file_map[1] = 'backend_activity_other_data_hero_pool'; //召唤池活动
$sort_id_tpl_file_map[2] = 'backend_activity_other_data_sign'; //签到定制
$sort_id_tpl_file_map[3] = 'backend_activity_other_data_sign'; //签到定制
$sort_id_tpl_file_map[4] = 'backend_activity_other_data_questionnaire'; //问卷调查

class TargetObjBase
{
	public $tpl;
	public $DB;
	public $table='backend_activity';
	public $perpage = 15;
	public $backend_activity_sort_id_map = array();
	public $backend_act_no_need_other_data = array();

	public $sort_id_hero_pool_limit_num = 5;
	
	public function __construct()
	{
		global $medoo_db;
		global $tpl;
		global $backend_activity_sort_id_map;
		global $backend_act_no_need_other_data;
		global $sort_id_tpl_file_map;
		$this->tpl = &$tpl;
		$this->DB = $medoo_db;
		$this->backend_activity_sort_id_map = $backend_activity_sort_id_map;
		$this->backend_act_no_need_other_data = $backend_act_no_need_other_data;
		$this->sort_id_tpl_file_map = $sort_id_tpl_file_map;
	}

	public function listItem()
	{		
		$this->tpl->tpl_file = 'backend_activity_list.html';


		$total = $this->DB->count($this->table);
		/*********** 翻页 start ***********/
		$arr_params = array('total' => $total,'perpage' => $this->perpage);		
		$pager = new pager($arr_params);
		$this->tpl->assign($pager->result);		
		$limit  = $pager->perpage;
		$offset = $pager->offset;
		/*********** 翻页 end *************/	

		$item_list = array();
		$where_arr = array('ORDER' => 'updated desc');
		$item_list = $this->DB->select($this->table, '*', $where_arr);
		$ret = array();

		$show_add = 1;

		if (!empty($item_list))
		{
			$backend_activity_sort_id_map = $this->backend_activity_sort_id_map;
			$backend_act_no_need_other_data = $this->backend_act_no_need_other_data;
			$sort_id_arr = array();

			foreach($item_list as $detail)
			{
				$tmp = $detail;

				$sort_id = $detail['sort_id'];
				//格式化,活动类型
				$sort_id_title = '未定义--'.$sort_id;

				if (isset($backend_activity_sort_id_map[$sort_id]))
				{
				 	$sort_id_title = $backend_activity_sort_id_map[$sort_id];
					$sort_id_arr[$sort_id] = 1;
				}

				$tmp['sort_id_title'] = $sort_id_title;

				$need_other_data = 1;
				$show_publish = 1;

				if (isset($backend_act_no_need_other_data[$sort_id]) && $backend_act_no_need_other_data[$sort_id] == 1)
				{
					$need_other_data = 0;
				}
				elseif (empty($detail['other_data']))
				{
					$show_publish = 0;
				}

				$tmp['show_publish'] = $show_publish;
				$tmp['need_other_data'] = $need_other_data;

				$ret[] = $tmp;

			}

			if (count($sort_id_arr) == count($backend_activity_sort_id_map))
			{
				$show_add = 0;
			}
		}

		$this->tpl->assign('arr_act_list',$ret);
		$this->tpl->assign('show_add',$show_add);
	}

	//获取已经配置了的宝箱道具列表
	public function getSortIdUsedList()
	{
		$ret = array();
		$item_list = $this->DB->select($this->table, 'sort_id');

		if (!empty($item_list))
		{
			foreach($item_list as $detail)
			{
				$sort_id = $detail['sort_id'];
				$ret[$sort_id] = 1;
			}
		}

		return $ret;
	}

	public function getSortIdOtherDataTplFile($sort_id)
	{
		$tpl_file = 'backend_activity_other_data.html';
		$sort_id_tpl_file_map = $this->sort_id_tpl_file_map;
		!empty($sort_id_tpl_file_map[$sort_id]) && $tpl_file = $sort_id_tpl_file_map[$sort_id].'.html';
		return $tpl_file;
	}

	//获取2个日期间隔天数，从每天0点开始，24点结束计算
	public function getDistanceDay($begin_date, $end_date)
	{
		$begin_date_time = strtotime($begin_date);
		$end_date_time = strtotime($end_date);

		$begin_date_day_begin = strtotime(date('Y-m-d 00:00:00', $begin_date_time));
		$end_date_day_end = strtotime(date('Y-m-d 23:59:59', $end_date_time));

		$distance_day = ceil(($end_date_day_end - $begin_date_day_begin) / (24 * 60 * 60));
		return $distance_day;
	}

	public function edit()
	{
		$this->tpl->assign('module_header',setNewHeaderModule());

		$this->tpl->tpl_file = 'backend_activity_edit.html';	
		$id = intval(httpGetVal('id'));
		$item = array();		
		$http_server_ids_arr = array();

		if($id > 0)
		{
			$where_arr = array('id' => $id);
			$select_fields = '*';
			$item = $this->DB->get($this->table, $select_fields, $where_arr);

			if ($item)
			{
				$server_ids_str = $item['server_ids'];
				$http_server_ids_arr = explode(',', $server_ids_str);
				
				$this->tpl->assign($item);
			}
		}

		$backend_activity_sort_id_map = $this->backend_activity_sort_id_map;
		$act_sort_id_map = array();

		if (!empty($item))
		{
			$sort_id = $item['sort_id'];
			$sort_id_title = $sort_id;

			if (isset($backend_activity_sort_id_map[$sort_id]))
			{
				$sort_id_title = $backend_activity_sort_id_map[$sort_id];
			}

			$act_sort_id_map = array($sort_id => $sort_id_title);
			$this->tpl->assign('id',$id);
		}
		else
		{
			$act_sort_id_used_list = $this->getSortIdUsedList();

			if (empty($act_sort_id_used_list))
			{
				$act_sort_id_map = $backend_activity_sort_id_map;
			}
			else
			{
				foreach ($backend_activity_sort_id_map as $_sort_id => $_sort_id_title)
				{
					if (!isset($act_sort_id_used_list[$_sort_id]))
					{
						$act_sort_id_map[$_sort_id] = $_sort_id_title;
					}
				}
			}
		}
		
		if (empty($act_sort_id_map))
		{
			$err_msg = '已经无可添加的活动类型';
			Redirect('', $err_msg, 1);
		}

		$this->tpl->assign('act_sort_id_map',format_map($act_sort_id_map));

		$special_server_arr = array('all_server' => '所有正式服');
		$selected_server_arr = !empty($http_server_ids_arr) ? array_fill_keys($http_server_ids_arr, 1) : array();
		isset($selected_server_arr['all_server']) && $http_server_ids_arr = array('all_server');
		$arr_serv_list = getActServerList($selected_server_arr, $special_server_arr);
		$this->tpl->assign('serv_list',$arr_serv_list);
	}

	public function save()
	{
		$id = intval(httpGetVal('id'));
		$begin_date = httpGetVal('begin_date');
		$end_date = httpGetVal('end_date');

		$sort_id = httpGetVal('sort_id');
		$caption = httpGetVal('caption');
		$brief = httpGetVal('brief');
		$character_level_max = httpGetVal('character_level_max');
		$character_level_min = httpGetVal('character_level_min');

		$server_ids_arr = !empty($_POST['server_ids']) ? $_POST['server_ids'] : array();

		if (empty($begin_date) || empty($end_date) || empty($server_ids_arr) || empty($sort_id))
		{
			Redirect('', '参数错误!', 1);
		}

		$character_level_max = intval($character_level_max);
		$character_level_min = intval($character_level_min);
		$character_level_max < 1 && $character_level_max = 0;
		$character_level_min < 1 && $character_level_min = 0;

		if (($character_level_min >0  || $character_level_max > 0) && $character_level_min > $character_level_max)
		{
			Redirect('', '请正确配置,角色等级上下限!', 1);
		}

		$sort_id = intval($sort_id);

		if ($sort_id < 1)
		{
			Redirect('', '请正确配置,活动类型!', 1);
		}

		$begin_date_time = strtotime($begin_date);
		$end_date_time = strtotime($end_date);

		if (empty($begin_date_time) || empty($end_date_time))
		{
			Redirect('', '请正确配置时间信息!', 1);
		}

		if ($begin_date_time >= $end_date_time)
		{
			Redirect('', '请正确配置活动时间范围!', 1);
		}
		
		$where_arr = array();
		$update_arr = array();
		$server_ids_str = implode(',', $server_ids_arr);
		in_array('all_server', $server_ids_arr) && $server_ids_str = 'all_server';

		$update_arr['begin_date'] = date('Y-m-d H:i:s', $begin_date_time);
		$update_arr['end_date'] = date('Y-m-d H:i:s', $end_date_time);
		$update_arr['character_level_max'] = $character_level_max;
		$update_arr['character_level_min'] = $character_level_min;
		$update_arr['caption'] = $caption;
		$update_arr['brief'] = $brief;

		$update_arr['server_ids'] = $server_ids_str;
		$update_arr['updated'] = date('Y-m-d H:i:s');
		$update_arr['publish_date'] = null;

		if ($id > 0)
		{
			$where_arr = array('id' => $id);
			$this->DB->update($this->table, $update_arr, $where_arr);
		}
		else
		{
			$update_arr['sort_id'] = $sort_id;
			$update_arr['created'] = date('Y-m-d H:i:s');
			$this->DB->insert($this->table, $update_arr, $where_arr);
		}

		Redirect('', '保存成功！', 1);
	}

	public function remove()
	{
		$id = intval(httpGetVal('id'));

		if ($id > 0)
		{
			$where_arr = array('id' => $id);
			//$this->DB->delete($this->table, $where_arr);
		}

		return $this->listItem();
	}

	function formatPublishData($activity,$sync_type ='all')
	{
		global $ALL_CONFIG_SERVER;
		
		$activity_data = array();
		//echo '<pre>';print_r($activity);exit;
		$server_ids  = $activity['server_ids'];
		$activity_id = $activity['id'];
		
		unset($activity['server_ids']);

		$publish_data = array();
		$publish_data['id'] = intval($activity['id']);
		$publish_data['sort_id'] = intval($activity['sort_id']);
		$publish_data['begin_date'] = $activity['begin_date'];
		$publish_data['end_date'] = $activity['end_date'];
		$publish_data['character_level_max'] = intval($activity['character_level_max']);
		$publish_data['character_level_min'] = intval($activity['character_level_min']);
		$publish_data['caption'] = $activity['caption'];
		$publish_data['brief'] = $activity['brief'];

		$other_data = json_decode($activity['other_data'], true);
		$publish_data['other_data'] = $other_data;

		$method = 'publish_other_data_'.$activity['sort_id'];
		if (method_exists($this, $method))
		{
			$publish_data['other_data'] = $this->$method($activity);
		}
			
		if ($server_ids == 'all_server')
		{
			foreach ($ALL_CONFIG_SERVER as $server_id=>$item)
			{
				$activity_data[$server_id] = $publish_data;
			}
		}
		else
		{
			$server_id_arr = explode(",",$server_ids);
			foreach ($server_id_arr as $server_id)
			{
				if (!isset($ALL_CONFIG_SERVER[$server_id])) continue;
		
				$activity_data[$server_id] = $publish_data;
			}
		}
			
		$arr_node = array();
		//测试服、正式服检查
		foreach ($activity_data as $server_id=>$item)
		{
			if (!isset($ALL_CONFIG_SERVER[$server_id]))
			{
				unset($activity_data[$server_id]);
				continue;
			}
		
			if ($sync_type == 'test') //测试服
			{
				if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 1) {
					unset($activity_data[$server_id]);
					continue;
				}
			}
			elseif ($sync_type == 'offical') //官服
			{
				if ($ALL_CONFIG_SERVER[$server_id]['is_offical'] == 0) 
				{
					unset($activity_data[$server_id]);
					continue;
				}
				
				if ($ALL_CONFIG_SERVER[$server_id]['type'] != 'jd')
				{
					unset($activity_data[$server_id]);
					continue;
				}
			}
			
			$act = array(
					'op' => OP_GMT_BACKEND_ACTIVITY,
					'data' => $item,
			);
			
			$server_domain = $ALL_CONFIG_SERVER[$server_id]['server_name'];
			if (!isset($arr_node[$server_id])) {
				$arr_node[$server_id] = array();
			}
			$arr_node[$server_id] = array('server_id'=>$server_id,'server_domain'=>$server_domain,'act'=>$act);
		}
		$arr_node = array_values($arr_node);
		
		return $arr_node;
		
	}

	//发布操作处理
	public function publish()
	{
		//扭蛋活动
		$cur_date = date('Y-m-d H:i:s');
		//die('not open yet --' . $cur_date);
		
		$id = intval(httpGetVal('id'));

		if (empty($id) || !is_numeric($id))
		{
			$msg = '参数错误 -- id';
			die($msg);
		}

		$sync_type = httpGetVal('sync_type');
		$where_arr = array('id' => $id);
		$select_fields = '*';
		$data_arr = $this->DB->get($this->table, $select_fields, $where_arr);
			
		//echo '<pre>';print_r($data_arr);exit;
		$activity_data = $this->formatPublishData($data_arr,$sync_type);
		//print_r($activity_data);exit;
		
		if (httpGetVal('do') == 'do')
		{
			echo '<pre>';print_r($activity_data);exit;
		}	
		
		if (!empty($activity_data) && is_array($activity_data))
		{
			$arr_node = $activity_data;
			$ret_msg = "发布失败的游戏服：";
			$all_ok  = true;
			$results = func_multiple_request_handle($arr_node, 'backend_activity');
			
			foreach ($results as $server_id=>$item)
			{
				if ($item['retcode'] != 0)
				{
					$all_ok = false;
					$ret_msg .= $item['retmsg'].';';
				}
			}
			
			if (!$all_ok) {
				die($ret_msg);
			}else {
				$update_arr = array();
				$update_arr['publish_date'] = date('Y-m-d H:i:s');
				$this->DB->update($this->table, $update_arr, $where_arr);
				die('数据发布完毕！');
			}
			
		}
		else 
		{
			die("目前没有数据可发布！\n");
		}	
	}

	public function editOtherData()
	{
		$tpl_file = 'backend_activity_edit.html';	
		$id = intval(httpGetVal('id'));
		$item = array();		
		$http_server_ids_arr = array();

		if($id > 0)
		{
			$where_arr = array('id' => $id);
			$select_fields = '*';
			$item = $this->DB->get($this->table, $select_fields, $where_arr);

			if ($item)
			{
				$backend_activity_sort_id_map = $this->backend_activity_sort_id_map;
				$sort_id = $item['sort_id'];
				//格式化,活动类型
				$sort_id_title = '未定义--'.$sort_id;

				if (isset($backend_activity_sort_id_map[$sort_id]))
				{
				 	$sort_id_title = $backend_activity_sort_id_map[$sort_id];
				}

				$tpl_file = $this->getSortIdOtherDataTplFile($sort_id);

				$method = 'assign_other_data_'.$sort_id;
				
				if (method_exists($this, $method))
				{
					$other_data_arr = array();

					if (!empty($item['other_data']))
					{
						$other_data_arr = json_decode($item['other_data'],true);
					}

					$this->$method($other_data_arr, $item);
				}

				$this->tpl->assign('sort_id_title', $sort_id_title);
				$this->tpl->assign($item);
			}
		}

		if (empty($item))
		{
			Redirect('', '参数错误!', 1);
		}

		$this->tpl->tpl_file = $tpl_file;
	}

	public function saveOtherData()
	{
		$id = intval(httpGetVal('id'));

		if ($id < 1)
		{
			Redirect('', '参数错误！', 1);
		}
		
		$where_arr = array('id' => $id);
		$sort_id = $this->DB->get($this->table, 'sort_id', $where_arr);
		$backend_activity_sort_id_map = $this->backend_activity_sort_id_map;

		if (empty($sort_id) || !isset($backend_activity_sort_id_map[$sort_id]))
		{
			Redirect('', '记录id不存在,或者活动类型不正确--'.$id, 1);
		}

		$update_arr = array();
		$method = 'save_other_data_'.$sort_id;

		if (method_exists($this, $method))
		{
			$ret = $this->$method();

			if (empty($ret))
			{
				Redirect('', '保存失败，请联系开发', 1);
			}

			if (!empty($ret['err_msg']))
			{
				Redirect('', $ret['err_msg'], 1);
			}

			$ret['err_msg'] = '';
			unset($ret['err_msg']);

			if (!empty($ret['other_data']))
			{
				$update_arr['other_data'] = json_encode($ret['other_data']);

				unset($ret['other_data']);
			}

			if (!empty($ret))
			{
				foreach($ret as $_k => $_v)
				{
					$update_arr[$_k] = $_v;
				}
			}
		}

		$update_arr['updated'] = date('Y-m-d H:i:s');
		$update_arr['publish_date'] = null;

		$this->DB->update($this->table, $update_arr, $where_arr);

		Redirect('', '保存成功！', 1);
	}

	
}

$method = httpGetVal('method');
empty($method) && $method = 'list';
$retmsg = '';

try{
	$action = new TargetObj();

	switch($method)
	{
		case 'list':
			$action->listItem();
			break;
		case 'edit':
			$action->edit();
			break;
		case 'save':
			$action->save();
			break;
		case 'editOtherData':
			$action->editOtherData();
			break;
		case 'saveOtherData':
			$action->saveOtherData();
			break;
		case 'publish':
			$action->publish();
			break;
		default:			
			$action->listItem();
	}
}catch (Exception $e) {
	$retmsg = $e->getMessage();
}

$tpl->assign('title','活动列表');
$tpl->assign('retmsg',$retmsg);
$tpl->output();


class TargetObj extends TargetObjBase
{
	///////////////////召唤池活动 begin 
	public function assign_other_data_1($other_data, $item)
	{
		$this->tpl->assign('module_header',setNewHeaderModule());
		$data = isset($other_data['data']) ? $other_data['data'] : array();
		//$data = $other_data;
		$data_list = array();

		if (!empty($data))
		{
			foreach($data as $_info)
			{
				$tmp = array();
				$tmp['data1'] = $_info['start_date'];
				$tmp['data2'] = $_info['end_date'];
				$tmp['data3'] = $_info['pool_id'];
				$data_list[] = $tmp;
			}
		}

		$cnt = count($data_list);
		$limit_cnt = $this->sort_id_hero_pool_limit_num;
		$diss_num = $limit_cnt - $cnt;
		if ($diss_num > 0)
		{
			for ($i=0;$i<$diss_num;$i++)
			{
				$tmp = array();
				$tmp['data1'] = '';
				$tmp['data2'] = '';
				$tmp['data3'] = '';
				$data_list[] = $tmp;
			}
		}

		$this->tpl->assign('data_list',$data_list);
	}

	public function save_other_data_1()
	{
		$ret = array();
		$ret['err_msg'] = '';
		$ret['other_data'] = array();
		
		//格式化道具配置信息
		$http_data1 = isset($_POST['data1']) ? $_POST['data1'] : array();
		$http_data2 = isset($_POST['data2']) ? $_POST['data2'] : array();
		$http_data3 = isset($_POST['data3']) ? $_POST['data3'] : array();
		
		$cnt = count($http_data1);
		$limit_cnt = $this->sort_id_hero_pool_limit_num;

		if ($cnt > $limit_cnt)
		{
			Redirect('', '活动对应奖池列表超过上限('.$limit_cnt.')!', 1);
		}


		$data_list = array();
		$cur_date = date('Y-m-d H:i:s');
		$pool_id_map = array();
		$begin_date_min = '';
		$end_date_max = '';

		for($i=0; $i<$cnt; $i++)
		{
			$line_num = $i + 1;
			$start_date = isset($http_data1[$i]) ? trim($http_data1[$i]) : '';
			$end_date = isset($http_data2[$i]) ? trim($http_data2[$i]) : '';
			$pool_id = isset($http_data3[$i]) ? trim($http_data3[$i]) : 0;
			$pool_id = intval($pool_id);

			if (empty($start_date) || empty($end_date) || $pool_id == 0)
			{
				continue;
			}

			if ($pool_id < 1)
			{
				$err_msg = '第'.$line_num.'行记录中,抽将池子id,必须为正整数';
				Redirect('', $err_msg, 1);
			}

			if (strtotime($start_date) === false)
			{
				$err_msg = '第'.$line_num.'行记录中,开始时间格式不正确';
				Redirect('', $err_msg, 1);
			}

			if (strtotime($end_date) === false)
			{
				$err_msg = '第'.$line_num.'行记录中,结束时间格式不正确';
				Redirect('', $err_msg, 1);
			}

			if ($end_date <= $start_date)
			{
				$err_msg = '第'.$line_num.'行记录中,结束时间必须大于开始时间';
				Redirect('', $err_msg, 1);
			}

			if ($end_date <= $cur_date)
			{
				$err_msg = '第'.$line_num.'行记录中,结束时间必须大于当前时间';
				Redirect('', $err_msg, 1);
			}

			if (isset($pool_id_map[$pool_id]))
			{
				$err_msg = '第'.$line_num.'行记录中,抽将池子id与第行'.$pool_id_map[$pool_id].'重复了';
				Redirect('', $err_msg, 1);
			}

			$pool_id_map[$pool_id] = $line_num;

			$tmp = array();
			$tmp['start_date'] = $start_date;
			$tmp['end_date'] = $end_date;
			$tmp['pool_id'] = $pool_id;

			if (empty($begin_date_min) || $start_date < $begin_date_min)
			{
				$begin_date_min = $start_date;
			}

			if (empty($end_date_max) || $end_date_max < $end_date)
			{
				$end_date_max = $end_date;
			}

			$data_list[] = $tmp;
		}

		if (empty($data_list))
		{
			Redirect('', '请正确配置奖池列表数据!', 1);
		}

		$ret = array();

		$other_data = array();
		$other_data['data'] = $data_list;

		$ret['other_data'] = $other_data;

		!empty($begin_date_min) && $ret['begin_date'] = $begin_date_min;
		!empty($end_date_max) && $ret['end_date'] = $end_date_max;

		return $ret;
	}

	public function publish_other_data_1($activity_data)
	{
		$other_data = json_decode($activity_data['other_data'], true);
		$begin_date = $activity_data['begin_date'];
		$end_date = $activity_data['end_date'];

		$ret = array();

		if (!empty($other_data['data']))
		{
			foreach($other_data['data'] as $info)
			{
				$tmp = array();

				$tmp['start_time'] = strtotime($info['start_date']);
				$tmp['end_time'] = strtotime($info['end_date']);
				$tmp['pool_id'] = $info['pool_id'];

				$ret[] = $tmp;
			}
		}

		return $ret;
	}

	///////////////////召唤池活动 end 
	

	///////////////////签到定制 begin 
	///参数传递
	public function assign_other_data_sign($other_data, $item)
	{
		global $sign_style_id_map, $sign_award_type_map;

		$distance_day = $this->getDistanceDay($item['begin_date'], $item['end_date']);

		$db_award_equips = isset($other_data['day_equips']) ? $other_data['day_equips'] : array();

		$day_map = array();
		$award_equips = array();
		$equipBase = require_once ACTIVITY_DIR.'/EquipBase.inc';

		for ($i=1; $i<=$distance_day; $i++)
		{
			$day_map[] = array('day_num' => $i);

			$tmp_award_equips = array();
			$tmp_award_equips['day_num'] = $i;

			$day_equips = array();
			if (!empty($db_award_equips) && $db_award_equips[$i])
			{
				foreach($db_award_equips[$i] as $info)
				{
					$equip_id = $info['equip_id'];
					$equip_num = $info['equip_num'];
					$tmp = array();
					$tmp['equip_num'] = $equip_num;
					$tmp['day_num'] = $i;

					$equip_title = '';

					if ($equip_id && isset($equipBase[$equip_id]))
					{
						!empty($equipBase[$equip_id]['title']) && $equip_title = $equipBase[$equip_id]['title'];
					}

					$tmp['equip_id'] = $equip_title.','.$equip_id;

					$day_equips[] = $tmp;
				}
			}
			else
			{
				$tmp = array();
				$tmp['equip_id'] = '';
				$tmp['equip_num'] = 1;
				$tmp['day_num'] = $i;

				$day_equips[] = $tmp;
			}

			$tmp_award_equips['day_equips'] = $day_equips;
			$award_equips[] = $tmp_award_equips;
		}

		$this->tpl->assign('day_map',$day_map);
		$this->tpl->assign('award_equips',$award_equips);
		$this->tpl->assign('distance_day',$distance_day);

		$style_id = 1;
		!empty($other_data['style_id']) && $style_id = $other_data['style_id'];
		$style_id < 1 && $style_id = 1;

		$award_type = 1;
		!empty($other_data['award_type']) && $award_type = $other_data['award_type'];
		$award_type < 1 && $award_type = 1;

		$this->tpl->assign('style_id',$style_id);	
		$select_arr = array();
		$select_arr[$style_id] = 1;			
		$this->tpl->assign('sign_style_id_map',format_map($sign_style_id_map, $select_arr));

		$this->tpl->assign('award_type',$award_type);	
		$select_arr = array();
		$select_arr[$award_type] = 1;			
		$this->tpl->assign('sign_award_type_map',format_map($sign_award_type_map, $select_arr));
	}

	//保存
	public function save_other_data_sign()
	{
		global $sign_style_id_map, $sign_award_type_map;

		$style_id = httpGetVal('style_id');
		$style_id = intval($style_id);
		$style_id < 1 && $style_id = 1;

		$award_type = httpGetVal('award_type');
		$award_type = intval($award_type);
		$award_type < 1 && $award_type = 1;

		$id = intval(httpGetVal('id'));
		$where_arr = array('id' => $id);
		$select_fields = array('begin_date', 'end_date');
		$item = $this->DB->get($this->table, $select_fields, $where_arr);

		$begin_date = $item['begin_date'];
		$end_date = $item['end_date'];
		$distance_day = $this->getDistanceDay($begin_date, $end_date);

		$ret = array();
		$ret['err_msg'] = '';
		$ret['other_data'] = array();

		if (empty($sign_style_id_map) || empty($sign_style_id_map[$style_id]))
		{
			$err_msg = '客户端样式'.$style_id.'不存在!';
			$ret['err_msg'] = $err_msg;
			return $ret;
		}

		if (empty($sign_award_type_map) || empty($sign_award_type_map[$award_type]))
		{
			$err_msg = '领奖类型'.$award_type.'不存在!';
			$ret['err_msg'] = $err_msg;
			return $ret;
		}
		
		$equipBase = require_once ACTIVITY_DIR.'/EquipBase.inc';

		$award_equips = array();
		//道具验证部分
		for ($i=1; $i<=$distance_day; $i++)
		{
			$field_equip_id = 'reward_equip_ids_'.$i;
			$field_equip_num = 'reward_equip_nums_'.$i;

			if (empty($_POST[$field_equip_id]))
			{
				$err_msg = '请正确配置第'.$i.'天奖励!';
				$ret['err_msg'] = $err_msg;
				return $ret;
			}

			$http_reward_equip_ids = $_POST[$field_equip_id];
			$http_reward_equip_nums = $_POST[$field_equip_num];
			$cnt = count($http_reward_equip_ids);

			if ($cnt == 0 || empty($http_reward_equip_ids[0]))
			{
				$err_msg = '请正确配置第'.$i.'天奖励!';
				$ret['err_msg'] = $err_msg;
				return $ret;
			}

			comm_check_equips($http_reward_equip_ids);
			//echo '<pre>';print_r($http_reward_equip_ids);exit;

			$tmp_award_equips = array();

			for($j =0; $j<$cnt; $j++)
			{
				$equip_ids = $http_reward_equip_ids[$j];
				list($equip_title, $equip_id) = explode(',', $equip_ids);
				if (empty($equip_id) || !isset($equipBase[$equip_id]))
				{
					$err_msg = '第'.$i.'天配置的奖励道具不存在!,' . $equip_ids;
					$ret['err_msg'] = $err_msg;
					return $ret;
				}

				$equip_id = intval($equip_id);
				$equip_num = !empty($http_reward_equip_nums[$j]) ? intval($http_reward_equip_nums[$j]) : 1;
				$equip_num < 1 && $equip_num = 1;

				$tmp = array();
				$tmp['equip_id'] = $equip_id;
				$tmp['equip_num'] = $equip_num;

				$tmp_award_equips[] = $tmp;
			}

			$award_equips[$i] = $tmp_award_equips;
		}

		$ret = array();
		$other_data = array();
		$other_data['style_id'] = $style_id;
		$other_data['award_type'] = $award_type;
		$other_data['open_day'] = $distance_day;

		$other_data['day_equips'] = $award_equips;
		$ret['other_data'] = $other_data;
		return $ret;
	}

	//发布前检查
	public function publish_check_sign($activity_data)
	{
		global $sign_style_id_map, $sign_award_type_map;

		if (empty($activity_data) || empty($activity_data['other_data']))
		{
			return '记录或者其他数据为空';
		}

		$other_data = json_decode($activity_data['other_data'], true);
		if (empty($other_data))
		{
			return '请配置其他数据';
		}

		$begin_date = $activity_data['begin_date'];
		$end_date = $activity_data['end_date'];

		$equips = $other_data['day_equips'];

		if (empty($equips))
		{
			return '请先配置每天奖励数据';
		}

		$distance_day = $this->getDistanceDay($begin_date, $end_date);
		$cnt = count($equips);
		//return "distance_day=$distance_day, cnt=$cnt";

		if ($cnt < $distance_day)
		{
			$limit_day = $distance_day - $cnt;
			return '还缺少'.$limit_day.'天的其他数据配置中的奖励数据';
		}

		$style_id = $other_data['style_id'];

		if (empty($sign_style_id_map) || empty($sign_style_id_map[$style_id]))
		{
			return '客户端样式'.$style_id.'不存在!';
		}

		$award_type = $other_data['award_type'];
		
		if (empty($sign_award_type_map) || empty($sign_award_type_map[$award_type]))
		{
			return '领奖类型'.$award_type.'不存在!';
		}

		return '';
	}

	//发布格式化
	public function publish_other_data_sign($activity_data)
	{
		global $sign_style_id_title;
		$other_data = json_decode($activity_data['other_data'], true);
		$begin_date = $activity_data['begin_date'];
		$end_date = $activity_data['end_date'];

		$ret = array();
		$ret['begin_date'] = $begin_date;
		$ret['end_date'] = $end_date;

		$ret['begin_time'] = strtotime($begin_date);
		$ret['end_time'] = strtotime($end_date);

		$distance_day = $this->getDistanceDay($begin_date, $end_date);

		$ret['open_day'] = $distance_day;

		$equips = $other_data['day_equips'];
		$style_id = $other_data['style_id'];
		$style_title = '';
		!empty($sign_style_id_title[$style_id]) && $style_title = $sign_style_id_title[$style_id];

		$tmp_equips = array();
		for($i=1;$i<=$distance_day;$i++)
		{
			$tmp_equips[$i] = $equips[$i];
		}

		$ret['unique_id'] = intval($activity_data['sort_id']);
		$ret['day_equips'] = $tmp_equips;
		$ret['style_id'] = intval($style_id);
		$ret['style_title'] = $style_title;
		$ret['award_type'] = intval($other_data['award_type']);

		return $ret;
	}
	
	////////////////签到定制1 -------begin
	public function assign_other_data_2($other_data, $item)
	{
		$this->assign_other_data_sign($other_data, $item);
	}

	public function save_other_data_2()
	{
		return $this->save_other_data_sign();
	}

	public function publish_check_2($activity_data)
	{
		return $this->publish_check_sign($activity_data);
	}

	public function publish_other_data_2($activity_data)
	{
		return $this->publish_other_data_sign($activity_data);
	}
	////////////////签到定制1 -------end

	////////////////签到定制2 -------begin
	public function assign_other_data_3($other_data, $item)
	{
		$this->assign_other_data_sign($other_data, $item);
	}

	public function save_other_data_3()
	{
		return $this->save_other_data_sign();
	}

	public function publish_check_3($activity_data)
	{
		return $this->publish_check_sign($activity_data);
	}

	public function publish_other_data_3($activity_data)
	{
		return $this->publish_other_data_sign($activity_data);
	}
	////////////////签到定制2 -------end

	///////////////////签到定制 end
	
	///////////////////调查问卷 begin 
	public function assign_other_data_4($other_data)
	{
		$survey = isset($other_data['survey']) ? $other_data['survey'] : '';
		
		$this->tpl->assign('survey',$survey);
	}

	public function save_other_data_4()
	{
		$ret = array();
		$ret['err_msg'] = '';
		$ret['other_data'] = array();
		
		$survey = httpGetVal('survey');
		$survey = trim($survey);
		if (empty($survey))
		{
			$err_msg = '问卷编码,不能为空';
			$ret['err_msg'] = $err_msg;
			return $ret;
		}

		$other_data = array();
		$other_data['survey'] = $survey;

		$ret['other_data'] = $other_data;
		return $ret;
	}

	public function publish_other_data_4($activity_data)
	{
		$other_data = json_decode($activity_data['other_data'], true);
		$begin_date = $activity_data['begin_date'];
		$end_date = $activity_data['end_date'];

		$ret = array();
		$ret['begin_date'] = $begin_date;
		$ret['end_date'] = $end_date;

		$ret['begin_time'] = strtotime($begin_date);
		$ret['end_time'] = strtotime($end_date);

		$ret['character_level_max'] = intval($activity_data['character_level_max']);
		$ret['character_level_min'] = intval($activity_data['character_level_min']);

		$ret['survey'] = trim($other_data['survey']);

		return $ret;
	}

	///////////////////调查问卷 end


}