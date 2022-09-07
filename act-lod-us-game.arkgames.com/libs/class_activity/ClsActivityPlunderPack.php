<?php
/**
 * 运营活动掉落包管理
 * 
 * @author Andy Cai(huayi.cai@kunlun-inc.com)
 * @since 2009-10-29
 * @filesource ClsActivityPlunderPack.php
 * @version $Id: ClsActivityPlunderPack.php,v 1.10 2010/05/18 03:32:06 huaxingqian Exp $
 *
 */

class ClsActivityPlunderPack {
	var $DB = null; 									// 数据库句柄
	var $tbl_activity_plunder_pack = 'tbl_activity_plunder_pack '; 		// 活动表表名

	//表字段
	var $tbl_activity_plunder_pack_fields = array ( 'id', 'pack_sort_id', 'activity_id','max_get_times', 'probability', 'monster_level_min', 'monster_level_max', 
										'monster_ids', 'scene_ids', 'character_level_min', 'character_level_max', 'equip_ids', 'equip_probas', 'exp_radix',
										'period_type', 'period_dots', 'eday_exh_times', 'start_times', 'end_times', 'start_datetime', 'end_datetime',
										'collect_types', 'title', 'intro', 'created', 'updated'
										);
	
	const MEMCACHE_KEY_PREFIX = 'ActivityPlunderPack_For_All';
	
	/**
	 * 构造函数
	 *
	 * @param db_MySQL $db
	 */
	function ClsActivityPlunderPack($db) {
		$this->DB = $db;
	}
	
	/**
	 * 获取活动总数
	 * 
	 * @param	$condition  查询条件
	 * @return	活动总数
	 * 
	 */
	function getActPackCount($condition = '') {
		$sql = "SELECT COUNT(`id`) AS total " . " FROM " . $this->tbl_activity_plunder_pack . " WHERE 1=1 " . $condition;
		
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
	function getActPackList($condition = '', $order_by = '', $limit = '', $offset = '') {
		$str_fields = $this->formatFields ( $this->tbl_activity_plunder_pack_fields );
		
		$order_byStr = $order_by == '' ? '' : " ORDER BY " . $order_by . " DESC ";
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;
		
		$sql = "SELECT " . $str_fields . " FROM " . $this->tbl_activity_plunder_pack . " WHERE 1=1 " . $condition . $order_byStr . $limitStr . $offsetStr;
		
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
	function addActPack($arrData) {
		$sql = "INSERT INTO " . $this->tbl_activity_plunder_pack . "(" . $arrData ['fields'] . ") VALUES(" . $arrData ['values'] . ")";
		
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
	function getActPackById($id) {
		$str_fields = $this->formatFields ( $this->tbl_activity_plunder_pack_fields );
		
		$sql = "SELECT " . $str_fields . " FROM " . $this->tbl_activity_plunder_pack . " WHERE `id` = " . $id . " LIMIT 1";
		
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
	function updateActPack($id, $strData) {
		$sql = "UPDATE " . $this->tbl_activity_plunder_pack . " SET " . $strData . " WHERE id = " . $id . " LIMIT 1";
		
		if ($this->DB->query ( $sql ))
			return true;
		else
			return false;
		
//		$this->update2memcache();
	}
	
	/**
	 * 删除一个掉落包
	 *
	 * @param int $id 掉落包 id
	 */
	function removeActPack($id) {
		$sql = "DELETE FROM " . $this->tbl_activity_plunder_pack . " WHERE id = " . $id . " LIMIT 1";
		
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
	    $str_fields = $this->formatFields ( $this->tbl_activity_plunder_pack_fields );
		
		$sql = "SELECT min(start_datetime) as min_stime, max(end_datetime) as max_etime FROM " . $this->tbl_activity_plunder_pack . " WHERE `activity_id` = " . $activity_id . " ";
		
		$arr_data = $this->DB->query_first ( $sql );
		
		return $arr_data;
	}
	
	private function update2memcache() {
		$mem_key = self::MEMCACHE_KEY_PREFIX;
		$objMyMemcache = new MyMemcache(); //连接memcache服务器
        @$objMyMemcache->memcache->delete($mem_key);
	}
}

