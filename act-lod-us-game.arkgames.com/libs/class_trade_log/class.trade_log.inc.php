<?php
/******************************************************************************
Filename             :  class.trade_log.inc.php
Author               :  lei.zhang@globalnet-inc.com
Date/time            :  2009-01-20
Purpose              : 
Description          :  
Revisions            :

******************************************************************************/

class ClsTradeLog
{
	private $DB = null;
	private $tbl_trade_log = 'tbl_trade_log_';
	
	/**
	  * 
	  *  
	  * @param  object $db
	  */
	public function __construct($db, $date)
	{
		$this->DB = $db;
		$this->tbl_trade_log .= $date;
	}
	
	/**
	* 获取记录总数
	* params : $condition : 查询条件
	*/
	function count($condition = '')
	{
		$sql = "SELECT count(`id`) as total FROM `".$this->tbl_trade_log."` WHERE 1=1 ".$condition ;
		//echo $sql;
		//die();
		$db_data = $this->DB->query_first($sql);
		return $db_data['total'];
	}
	
	public function get($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$sql = "SELECT * FROM `".$this->tbl_trade_log."` WHERE 1=1 ".$condition." ORDER BY id ". " LIMIT " . $limit . " OFFSET " . $offset; ;
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);
		return $arr_data;
	}
	
	public function get_all_type()
	{
		global $_CONFIG_GLOBAL_TRADE_LOG_TYPE;
		return $_CONFIG_GLOBAL_TRADE_LOG_TYPE;
	}
}
?>

