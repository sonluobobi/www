<?php
if (!defined('KUNLUN_COM'))
{
        header('http/1.0 404 not found');
        die();
}

class GashaponService extends Base
{
	public $sign = 'gashapon';
	public $tbl_gashapon_base = 'gashapon_base';
	public $tbl_gashapon_detail = 'gashapon_detail';

	public function Import()
	{
		$ret = array();
		$sign = $this->sign;
		$func_name = strtolower(__FUNCTION__);
		$log_folder = $sign;
		$log_file_name = $func_name;
		$cur_date_int = date('YmdH');
		$cur_date_str = date('Y-m-d H:i:s');
		$log_msg = '['.$func_name.']  ---------------------------- [begin]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		$ids = trim(httpGetVal('ids'), ',');

		if (empty($ids))
		{
			$this->ShowErrorMsg('params ids error');
		}

		$ids_arr = explode(',', $ids);

		if (empty($ids_arr) || !is_array($ids_arr))
		{
			$this->ShowErrorMsg('params ids is wrong -- '. $ids);
		}

		$ret = $this->getBaseAndDetail($ids_arr);
		$log_msg = 'act_ids=' . $ids . ' -- cnt='. count($ids_arr);
		!empty($ret) && $log_msg .= ' -- match cnt=' . count($ret);
		$this->Log($log_msg, $log_file_name, $log_folder);

		$log_msg = '['.$func_name.']  ---------------------------- [end]';
		$this->Log($log_msg, $log_file_name, $log_folder);

		$this->ShowSuccMsgGz('', $ret);
	}

	public function getBaseAndDetail($ids_arr)
	{
		$ret = array();
		$cur_date_str = date('Y-m-d H:i:s');
		$db = $this->getDb();

		$tbl_gashapon_base = $this->tbl_gashapon_base;
		$tbl_gashapon_detail = $this->tbl_gashapon_detail;

		$cond = array();
		$cond['AND'] = array(
			'id' => $ids_arr,
			//'end_time[>=]' => $cur_date_str,
		);

		$cond['ORDER'] = 'id asc';

		$cnt_source = count($ids_arr);
		$act_result = $db->select($tbl_gashapon_base, '*', $cond);

		if (!empty($act_result))
		{
			$act_data_arr = array();
			$activity_id_arr = array();

			foreach($act_result as $detail)
			{
				$act_id = $detail['id'];
				$act_data_arr[$act_id] = $detail;
				$activity_id_arr[] = $act_id;
			}

			$cond_item = array();
			$cond_item['item_id'] = $activity_id_arr;
			$cond_item['ORDER'] = 'item_id asc';

			$act_item_result = $db->select($tbl_gashapon_detail, '*', $cond_item);
			$act_item_data_arr = array();

			if (!empty($act_item_result))
			{
				foreach($act_item_result as $item_detail)
				{
					$activity_id = $item_detail['item_id'];
					!isset($act_item_data_arr[$activity_id]) && $act_item_data_arr[$activity_id] = array();
					$act_item_data_arr[$activity_id][] = $item_detail;
				}
			}

			foreach($act_data_arr as $_act_id => $_act_info)
			{
				$tmp = array();

				if (isset($act_item_data_arr[$_act_id]))
				{
					$tmp['base'] = $_act_info;
					$tmp['detail'] = $act_item_data_arr[$_act_id];
					$ret[$_act_id] = $tmp;
				}
			}
		}

		return $ret;
	}
}