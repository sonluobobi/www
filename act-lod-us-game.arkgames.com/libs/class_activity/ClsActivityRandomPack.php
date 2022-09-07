<?php
/**
 * 随机包管理
 * 
 * @author Andy Cai(huayi.cai@kunlun-inc.com)
 * @since 2009-10-29
 * @filesource ClsActivityRandomPack.php
 * @version $Id: ClsActivityRandomPack.php,v 1.10 2010/05/18 03:32:06 huaxingqian Exp $
 *
 */

class ClsActivityRandomPack {
	var $DB = null; 									// 数据库句柄
	var $tbl_activity_random_pack = 'tbl_activity_random_pack'; 		// 随机包表名

	//表字段
	var $tbl_activity_random_pack_fields = array ( 'id', 'activity_id', 'activity_sort_id', 'activity_item_sort_id', 'inter_npc_id', 'inter_npc_dialog', 
										'faction_ids', 'character_level_min', 'character_level_max', 'exchange_cond_sort_id', 'exchange_reward_sort_id',
										'exchange_special_cond_sort_id', 'special_limit_min', 'special_limit_max', 'consume_num', 'charge_num',
										'equip_score', 'need_equip_ids', 'need_equip_nums', 'is_rand_need_equip', 'need_equip_rand_num',
										'jewel_level_min', 'jewel_level_max', 'jewel_num', 'reward_exp', 'reward_silver', 'reward_equip_ids', 'reward_equip_nums', 
										'rate_of_getting_equip', 'reward_jewel_level', 'reward_jewel_num', 'reward_prompt', 'get_ch_num', 
										'eday_exh_times', 'all_act_exh_times', 'act_exh_times', 'is_input_num', 'scene_group_ids', 
										'answer_proba', 'ai_type', 'kill_proba', 'max_kill_num', 'activity_monster_id', 'period_type', 'voucher_score', 
										'period_dots', 'start_times', 'end_times', 'start_datetime', 'end_datetime', 
										'error_prompt', 'title', 'intro', 'created', 'updated'
										);
	
		
	/**
	 * 构造函数
	 *
	 * @param db_MySQL $db
	 */
	function __construct($db)
	{
		$this->DB = $db;
	}
	
	/**
	 * 获取活动总数
	 * 
	 * @param	$condition  查询条件
	 * @return	活动总数
	 * 
	 */
	function getRandomPackCount($condition = '') 
	{
		$sql = "SELECT COUNT(`id`) AS total " . " FROM " . $this->tbl_activity_random_pack . " WHERE 1=1 " . $condition;
		
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
	function getRandomPackList($condition = '', $order_by = '', $limit = '', $offset = '') 
	{
		$str_fields = $this->formatFields ( $this->tbl_activity_random_pack_fields );
		
		$order_byStr = $order_by == '' ? '' : " ORDER BY " . $order_by . " DESC ";
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;
		
		$sql = "SELECT * FROM " . $this->tbl_activity_random_pack . " WHERE 1=1 " . $condition . $order_byStr . $limitStr . $offsetStr;
		
		$db_data = $this->DB->query ( $sql );
		
		$arr_data = array ();
		while ( $data = $this->DB->fetch_array ( $db_data ) ) {
			$arr_data [] = $data;
		}
		
		$this->DB->free_result ( $db_data );
		
		return $arr_data;
	}
	
/**
	 * 添加新的活动
	 * 
	 * @param	Array $arrData
	 * @return	插入数据库的最新记录ID
	 * 
	 */
	function addRandomPack($arrData) 
	{
		$sql = "INSERT INTO " . $this->tbl_activity_random_pack . "(" . $arrData ['fields'] . ") VALUES(" . $arrData ['values'] . ")";
		
		if ($this->DB->query ( $sql ))
			return $this->DB->insert_id ();
		else
			return 0;
		
	}
	
	/**
	 * 根据ID获取一个活动信息
	 * 
	 * @param	Int $id 活动ID
	 * @return	活动的数据（关联数组）
	 * 
	 */
	function getRandomPackByPackId($pack_id) 
	{
		$str_fields = $this->formatFields ( $this->tbl_activity_random_pack_fields );
		
		$sql = "SELECT * FROM " . $this->tbl_activity_random_pack . " WHERE `pack_id` = " . $pack_id  ;
		
		$db_data = $this->DB->query ( $sql );
		$arr_data = array ();
		while ( $data = $this->DB->fetch_array ( $db_data ) ) {
			$arr_data [] = $data;
		}
		
		$this->DB->free_result ( $db_data );
		
		return $arr_data;
		
	}
	
	/**
	 * 更新随机包
	 * 
	 * @param	int $id 要更新的活动 id号
	 * @param	String $strData 要更新的字段串
	 * @return	Boolean
	 * 
	 */
	function updateRandomPack($ids, $strData) 
	{
		$sql = "UPDATE " . $this->tbl_activity_random_pack . " SET " . $strData . " WHERE id IN( " . $ids . " )";
		
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
	function removeRandomPack($id) 
	{
		$sql = "DELETE FROM " . $this->tbl_activity_random_pack . " WHERE id = " . $id . " LIMIT 1";
		
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
	    $str_fields = $this->formatFields ( $this->tbl_activity_random_pack_fields );
		
		$sql = "SELECT min(start_datetime) as min_stime, max(end_datetime) as max_etime FROM " . $this->tbl_activity_random_pack . " WHERE `activity_id` = " . $activity_id . " ";
		
		$arr_data = $this->DB->query_first ( $sql );
		
		return $arr_data;
	}
	
	private function update2memcache() {
		$mem_key = self::MEMCACHE_KEY_PREFIX;
		$objMyMemcache = new MyMemcache(); //连接memcache服务器
        @$objMyMemcache->memcache->delete($mem_key);
	}
}

