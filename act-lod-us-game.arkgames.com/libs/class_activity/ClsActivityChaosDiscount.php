<?php
/**
 * 活动洗炼折扣管理
 * 
 * @author fuqian.liao
 * @since 2009-10-29
 * @filesource MallDiscount.php
 * @version $Id: MallDiscount.php,v 1.5 2010/02/01 04:17:08 huayi Exp $
 *
 */

class ClsActivityChaosDiscount {
	
	var $DB = null; 							//数据库句柄
	var $tbl_chaos_discount = 'tbl_chaos_discount';    //折扣表名

	//表字段
	var $tbl_chaos_discount_fields = array ( 'id', 'activity_sort_id', 'title', 'character_level', 'interfix_npc_id', 'interfix_npc', 'start_time', 'end_time', 'server_ids', 'intro', 'is_view_act', 'published', 'created', 'updated' );
	
	const MEMCACHE_KEY_PREFIX = 'Activity_For_All';
	
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
	function getActCount($condition = '') {
		$sql = "SELECT COUNT(`id`) AS total " . " FROM " . $this->tbl_chaos_discount . " WHERE 1 " . $condition;
		
		$db_data = $this->DB->query_first ( $sql );
		
		return $db_data ['total'];
	}
	
	/**
	 * 获取折扣列表
	 * 
	 * @param	$condition	查询条件
	 * @param	$order_by	显示顺序
	 * @param	$limit		显示数量
	 * @param	$offset		偏移量
	 * @return	活动的数据（关联数组）
	 * 
	 */
	function getChaosDiscountList($condition = '', $order_by = '', $limit = '', $offset = '') {
		$str_fields = $this->formatFields ( $this->tbl_chaos_discount_fields );
		
		$order_byStr = $order_by == '' ? " ORDER BY id DESC " : " ORDER BY " . $order_by . " DESC ";
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;
		
		$sql = "SELECT * FROM " . $this->tbl_chaos_discount .  " WHERE 1 " .
				$condition . $order_byStr . $limitStr . $offsetStr;
		
		$db_data = $this->DB->query ( $sql );
//		die($sql);
		$arr_data = array ();
		while ( $data = $this->DB->fetch_array ( $db_data ) ) {
			$arr_data [] = $data;
		}
		
		$this->DB->free_result ( $db_data );
		
		return $arr_data;
	}
	
	/**
	 * 添加新的折扣
	 * 
	 * @param	Array $arrData
	 * @return	插入数据库的最新记录ID
	 * 
	 */
	function addChaosDiscount($arrData) {
		$sql = "INSERT INTO " . $this->tbl_chaos_discount . "(" . $arrData ['fields'] . ") VALUES(" . $arrData ['values'] . ")";
		
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
	function getChaosDiscountById($id) {
		$str_fields = $this->formatFields ( $this->tbl_chaos_discount_fields );
		
		$sql = "SELECT * FROM " . $this->tbl_chaos_discount . " WHERE  `id` = " . $id . " LIMIT 1";
		
		$arr_data = $this->DB->query_first ( $sql );
		
		return $arr_data;
	}
	
	/**
	 * 更新一个活动
	 * 
	 * @param	Int $id 要更新的活动 id号
	 * @param	String $strData 要更新的字段串
	 * @return	Boolean
	 * 
	 */
	function updateChaosDiscount($id, $strData) {
		$sql = "UPDATE " . $this->tbl_chaos_discount . " SET " . $strData . " WHERE id = " . $id . " LIMIT 1";
		
		if ($this->DB->query ( $sql ))
			return true;
		else
			return false;
		
//		$this->update2memcache();
	}
	
	/**
	 * 删除一个折扣项
	 *
	 * @param int $id 活动的id
	 */
	function deleteDiscountItemById($id) {
		$sql = "DELETE FROM " . $this->tbl_chaos_discount . " WHERE id = " . $id . " LIMIT 1";
		
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
	
	private function update2memcache() {
		$mem_key = self::MEMCACHE_KEY_PREFIX;
		$objMyMemcache = new MyMemcache(); //连接memcache服务器
        @$objMyMemcache->memcache->delete($mem_key);
	}
}

