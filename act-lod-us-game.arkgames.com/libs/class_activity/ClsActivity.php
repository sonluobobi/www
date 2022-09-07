<?php
/**
 * 运营活动管理
 *
 * @author Andy Cai(huayi.cai@kunlun-inc.com)
 * @since 2009-10-29
 * @filesource ClsActivity.php
 * @version $Id: ClsActivity.php,v 1.5 2010/02/01 04:17:08 huayi Exp $
 *
 */

class ClsActivity
{
	var $DB = null; 							//数据库句柄
	var $tbl_activity = 'tbl_activity'; 		//活动表表名
	public $tbl_name_prefix = '';

	//表字段
	var $tbl_activity_fields = array ( 'id', 'activity_sort_id', 'title', 'order_by', 'start_time', 'end_time','server_ids', 'intro', 'res_id','published', 'created', 'updated' );

	const MEMCACHE_KEY_PREFIX = 'Activity_For_All';

	/**
	 * 构造函数
	 *
	 * @param db_MySQL $db
	 */
	function ClsActivity($db) {
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
		$sql = "SELECT COUNT(`id`) AS total " . " FROM " . $this->tbl_activity . " WHERE published=1 " . $condition;

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
	function getActList($condition = '', $order_by = '', $limit = '', $offset = '') {
		$str_fields = $this->formatFields ( $this->tbl_activity_fields );

		$order_byStr = $order_by == '' ? " ORDER BY id DESC " : " ORDER BY " . $order_by ;
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;

		$sql = "SELECT * FROM " . $this->tbl_activity . " WHERE published=1 " .
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

	//获取活动数据
	function getAllAct($select='*', $where='', $order_by='')
	{
		$sql = 'select ' . $select . ' from '.$this->tbl_activity;
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
	function addAct($arrData) {
		$sql = "INSERT INTO " . $this->tbl_activity . "(" . $arrData ['fields'] . ") VALUES(" . $arrData ['values'] . ")";
		if (function_exists('act_do_log'))
		{
			act_do_log('add activity sql | ' . $sql, 'activity');
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
	function getActById($id) {
		//$str_fields = $this->formatFields ( $this->tbl_activity_fields );

		$sql = "SELECT * FROM " . $this->tbl_activity . " WHERE published=1 AND `id` = " . $id . " LIMIT 1";

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
	function updateAct($id, $strData) {
		$sql = "UPDATE " . $this->tbl_activity . " SET " . $strData . " WHERE id = " . $id . " LIMIT 1";
		if (function_exists('act_do_log'))
		{
			act_do_log('update activity sql | ' . $sql, 'activity');
		}
		if ($this->DB->query ( $sql ))
			return true;
		else
			return false;

//		$this->update2memcache();
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

