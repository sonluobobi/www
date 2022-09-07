<?php
/**
 * 运营活动管理
 * 
 * @author Andy Cai(huayi.cai@kunlun-inc.com)
 * @since 2009-10-29
 * @filesource ClsActivityItem.php
 * @version $Id: ClsActivityItem.php,v 1.10 2010/05/18 03:32:06 huaxingqian Exp $
 *
 */

class ClsActivityItem {
	var $DB = null; 									// 数据库句柄
	var $tbl_activity_item = 'tbl_activity_item'; 		// 活动表表名

	//表字段
	var $tbl_activity_item_fields = array ( 'id', 'activity_id', 'activity_sort_id', 'activity_item_sort_id', 
										'character_level_min', 'character_level_max', 'exchange_cond_sort_id', 'exchange_reward_sort_id',
										'exchange_special_cond_sort_id', 'special_limit_min', 'special_limit_max', 'consume_num', 'charge_num',
										'need_equip_ids', 'need_equip_nums','reward_equip_ids', 'reward_equip_nums', 
										'get_ch_num','eday_exh_times', 'act_exh_times', 'is_input_num', 'max_kill_num', 
										'start_datetime', 'end_datetime','title', 'intro', 'created', 'updated'
										);
	
	const MEMCACHE_KEY_PREFIX = 'ActivityItem_For_All';
	
	/**
	 * 构造函数
	 *
	 * @param db_MySQL $db
	 */
	function ClsActivityItem($db) {
		$this->DB = $db;
	}
	
	/**
	 * 获取活动总数
	 * 
	 * @param	$condition  查询条件
	 * @return	活动总数
	 * 
	 */
	function getActItemCount($condition = '') {
		$sql = "SELECT COUNT(`id`) AS total " . " FROM " . $this->tbl_activity_item . " WHERE 1=1 " . $condition;
		
		$db_data = $this->DB->query_first ( $sql );
		
		return $db_data ['total'];
	}
	
	/**
	 * 获取活动列表
	 * 
	 * @param	$condition	查询条件
	 * @param	$order_by	显示顺序
	 * @param	$limit		显示数量
	 * @param	$offset		偏移量
	 * @return	活动的数据（关联数组）
	 * 
	 */
	function getActItemList($condition = '', $order_by = '', $limit = '', $offset = '') {
		$str_fields = $this->formatFields ( $this->tbl_activity_item_fields );
		
		$order_byStr = $order_by == '' ? '' : " ORDER BY " . $order_by . " DESC ";
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;
		
		$sql = "SELECT * FROM " . $this->tbl_activity_item . " WHERE 1=1 " . $condition . $order_byStr . $limitStr . $offsetStr;
		
		$db_data = $this->DB->query ( $sql );
		
		$arr_data = array ();
		while ( $data = $this->DB->fetch_array ( $db_data ) ) {
			$arr_data [] = $data;
		}
		
		$this->DB->free_result ( $db_data );
		
		return $arr_data;
	}

	function getAllActItem($select='*', $where='', $order_by='')
	{
		$sql = 'select ' . $select . ' from '.$this->tbl_activity_item;
		!empty($where) && $sql .= ' where ' . $where;
		!empty($order_by) && $sql .= ' order by ' . $order_by;

		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while($data = $this->DB->fetch_array($db_data))
		{
			$arr_data[] = $data;
		}

		$this->DB->free_result($db_data);
		
		return $arr_data;
	}
	
/**
	 * 添加新的活动
	 * 
	 * @param	Array $arrData
	 * @return	插入数据库的最新记录ID
	 * 
	 */
	function addActItem($arrData) {
		$sql = "INSERT INTO " . $this->tbl_activity_item . "(" . $arrData ['fields'] . ") VALUES(" . $arrData ['values'] . ")";
		if (function_exists('act_do_log'))
		{
			act_do_log('add activity_item sql | ' . $sql, 'activity_item');
		}
		if ($this->DB->query ( $sql ))
			return $this->DB->insert_id ();
		else
			return 0;
		
//		$this->update2memcache();
	}
	
	/**
	 * 根据ID获取一个活动信息
	 * 
	 * @param	Int $id 活动ID
	 * @return	活动的数据（关联数组）
	 * 
	 */
	function getActItemById($id) {
		$str_fields = $this->formatFields ( $this->tbl_activity_item_fields );
		
		$sql = "SELECT * FROM " . $this->tbl_activity_item . " WHERE `id` = " . $id . " LIMIT 1";
		
		$arr_data = $this->DB->query_first ( $sql );
		
		return $arr_data;
	}
	
	/**
	 * 更新一个活动
	 * 
	 * @param	int $id 要更新的活动 id号
	 * @param	String $strData 要更新的字段串
	 * @return	Boolean
	 * 
	 */
	function updateActItem($id, $strData) {
		$sql = "UPDATE " . $this->tbl_activity_item . " SET " . $strData . " WHERE id = " . $id . " LIMIT 1";
		if (function_exists('act_do_log'))
		{
			act_do_log('update activity_item sql | ' . $sql, 'activity_item');
		}
		if ($this->DB->query ( $sql ))
			return true;
		else
			return false;
		
//		$this->update2memcache();
	}
	
	/**
	 * 删除一个活动
	 *
	 * @param int $id 活动的id
	 */
	function removeActItem($id) {
		$sql = "DELETE FROM " . $this->tbl_activity_item . " WHERE id = " . $id . " LIMIT 1";
		if (function_exists('act_do_log'))
		{
			act_do_log('remove activity_item sql | ' . $sql, 'activity_item');
		}
		if ($this->DB->query ( $sql ))
			return true;
		else
			return false;
	}
	
	/**
	 * 格式化字段
	 * $str_fields = $this->formatFields($this->tbl_chatroom_base_fields);
	 * 
	 * @access private
	 * @param  Array $arr_fileds
	 * @return String
	 * 
	 */
	function formatFields($arr_fileds) {
		foreach ( $arr_fileds as $field ) {
			$str_fields .= '`' . $field . '`,';
		}
		//去掉最后的逗号
		$str_fields = substr ( $str_fields, 0, - 1 );
		
		return $str_fields;
	}
	
	/**
	 * 获取指定活动的最小开始时间、 最大结束时间
	 */
	function getMinMaxTime($activity_id)
	{
	    $str_fields = $this->formatFields ( $this->tbl_activity_item_fields );
		
		$sql = "SELECT min(start_datetime) as min_stime, max(end_datetime) as max_etime FROM " . $this->tbl_activity_item . " WHERE `activity_id` = " . $activity_id . " ";
		
		$arr_data = $this->DB->query_first ( $sql );
		
		return $arr_data;
	}
	
	private function update2memcache() {
		$mem_key = self::MEMCACHE_KEY_PREFIX;
		$objMyMemcache = new MyMemcache(); //连接memcache服务器
        @$objMyMemcache->memcache->delete($mem_key);
	}
}

