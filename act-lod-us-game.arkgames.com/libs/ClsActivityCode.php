<?php
/**
 * 运营活动激活码
 * 
 * @author Andy Cai(huayi.cai@kunlun-inc.com)
 * @since 2009-10-29
 * @filesource ClsActivityCode.php
 * @version $Id: ClsActivityCode.php,v 1.1 2010/09/29 08:58:11 mjl-xx Exp $
 *
 */

class ClsActivityCode
{
	var $DB = null; //数据库句柄

	var $tbl_activation_code = 'tbl_activation_code';
	var $tbl_activation_code_batch = 'tbl_activation_code_batch';

	var $tbl_activation_code_fields = array(
								'id',
								'batch_id',
								'code',
								'is_used',
								'start_time',
								'end_time',
								
								'created',
								'updated'
								);

	/**
	* 构造函数
	* 
	* @param  object $db
	*/
	function ClsActivityCode($db)
	{
		$this->DB = $db;
	}

	function microtime_float()
	{
	    list($usec, $sec) = explode(" ", microtime());
	    $tm = $sec .  intval($usec * 10000);
		return substr($tm,4);
	}
	
	function gencode()
	{
	    $tt = $this->microtime_float();
	    while($tt == $this->microtime_float())
	    {
	    	//
	    }
	    $tt = rand(10,99) . ($tt*100) + rand(10,99) . '';
	    echo $tt . ' ';
	    return base_convert($tt, 10, 36);
	}
	/**
	 * 生成激活码
	 *
	 * @param int $batch_id
	 * @param String $prefix
	 * @param int $num
	 * @param int $start_time
	 * @param int $end_time
	 * @return Boolean
	 */
	function createInvitationCode($batch_id, $prefix, $num, $start_time, $end_time)
	{
		$year   = substr($start_time, 0, 4); //年
		$month  = substr($start_time, 4, 2); //月
		$day    = substr($start_time, 6, 2); //日
		$hour   = substr($start_time, 8, 2); //时
		$minute = substr($start_time, 10, 2); //分
		$second = substr($start_time, 12, 2); //秒
		//$start_time = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minute . ':' . $second;
		
		$year   = substr($end_time, 0, 4); //年
		$month  = substr($end_time, 4, 2); //月
		$day    = substr($end_time, 6, 2); //日
		$hour   = substr($end_time, 8, 2); //时
		$minute = substr($end_time, 10, 2); //分
		$second = substr($end_time, 12, 2); //秒
		//$end_time = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minute . ':' . $second;

		$now = date('YmdHis');

		$insert_data = '';

		for ($i = 0; $i < $num; $i++)
		{
			$now_code = $this->gencode();//$prefix . md5($now . $end_time . $i);//
			$insert_data .= "(" . $batch_id . ", '" . $now_code . "', '" . $start_time . "', '" . $end_time . "', NOW()),";
			
		}

		if (4 < strlen($insert_data))
		{
			$insert_data = substr($insert_data, 0, -1);
			$sqlForCreateInvitationCode = "INSERT INTO " . $this->tbl_activation_code . "(batch_id, code, start_time, end_time, created) VALUES" . $insert_data;

			if ($this->DB->query($sqlForCreateInvitationCode))
				return true;
			else
				return false;
		}

		return false;
	}
	
	/**
	 * 创建新的激活码
	 * @param unknown_type $batch_id
	 * @param unknown_type $prefix
	 * @param unknown_type $num
	 * @param unknown_type $start_time
	 * @param unknown_type $end_time
	 * @param unknown_type $exist_code_arr
	 */
	function createNewInvitationCode($batch_id, $prefix, $num, $start_time, $end_time,$exist_code_arr,$length = 12)
	{
		$insert_data = '';;
		$token = '&@!gss*s#$@6$#sd^sd@fh#$d#h#f&s*@@#f&*#$#@4!f@d@s!#$#s#@!@@#fhgsdfg';
		$pp = 1;
		$length   = $length-strlen($prefix);
		$tmp_code ='';
		
		for ($i=0;$i<$num;$i++)
		{
			$cur_time = time();
			$md5  = md5($cur_time.$token.$token);
			
			$now_code = $prefix.substr($md5,0,$length);
			while (in_array($now_code,$exist_code_arr))
			{
				$cur_time = time();
				$md5  = md5($cur_time.$token.$pp.$token);
				$now_code = $prefix.substr($md5,0,$length);
				
				$pp++;
			}
			array_push($exist_code_arr,$now_code);
			$insert_data .= "(" . $batch_id . ", '" . $now_code . "', '" . $start_time . "', '" . $end_time . "', NOW()),";
			
			
			file_put_contents("/tmp/liao_activation.log",$now_code."\n",FILE_APPEND);
			
		}
				
		if (4 < strlen($insert_data))
		{
			$insert_data = substr($insert_data, 0, -1);
			$sqlForCreateInvitationCode = "INSERT INTO " . $this->tbl_activation_code . "(batch_id, code, start_time, end_time, created) VALUES" . $insert_data;

			if ($this->DB->query($sqlForCreateInvitationCode))
				return true;
			else
				return false;
		}
		return false;
	}

	/**
	 * 获取记录总数
	 *
	 * @param String $condition 查询条件
	 * @return int
	 */
	function getInvitationCodeCount($condition = '')
	{
		$sqlForGetInvitationCodeCount = "SELECT COUNT(`id`) AS total " . 
										 " FROM " . $this->tbl_activation_code . 
										" WHERE 1=1 " . $condition;

		$db_data = $this->DB->query_first($sqlForGetInvitationCodeCount);

		return $db_data['total'];
	}

	/**
	 * 获取激活码列表
	 *
	 * @param String $condition 查询条件
	 * @param String $order_by 显示顺序
	 * @param int $limit 显示数量
	 * @param int $offset 偏移量
	 * @return Array
	 */
	function getInvitationCodeList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$str_fields = $this->formatFields($this->tbl_activation_code_fields);
		
		$conStr = '';
		if ($condition) $conStr .= $condition;
		if ($order_by) $conStr .= " ORDER BY " . $order_by . " DESC";
		if ($limit) $conStr .= " LIMIT " . $limit;
		if ($offset) $conStr .= " OFFSET " . $offset;

		$sqlForGetInvitationCodeList = "SELECT * FROM " . $this->tbl_activation_code . 
									   " WHERE 1=1 " . $conStr;

		$db_data = $this->DB->query($sqlForGetInvitationCodeList);

		$arr_data = array();
		while ($data = $this->DB->fetch_array($db_data))
		{
			if ('0' == $data['is_used'])
				$data['is_used_text'] = '<font color="red">未使用</font>';
			else
				$data['is_used_text'] = '已经使用';

			$arr_data[] = $data;
		}

		$this->DB->free_result($db_data);

		return $arr_data;
	}
	
	/**
	 * 更新激活码信息
	 * 
	 * @param	int $id 要更新的活动 id号
	 * @param	String $strData 要更新的字段串
	 * @return	Boolean
	 * 
	 */
	function updateCodeItem($id, $strData) 
	{
		$sql = "UPDATE " . $this->tbl_activation_code . " SET " . $strData . " WHERE id = " . $id . " LIMIT 1";
		
		if ($this->DB->query ( $sql ))
			return true;
		else
			return false;
		
//		$this->update2memcache();
	}

	/**
	 * 格式化字段
	 * 
	 * @access private
	 * @param  array
	 * @return string
	 * //$str_fields = $this->formatFields($this->tbl_chatroom_base_fields);
	 */
	private function formatFields($arr_fileds)
	{
		foreach ($arr_fileds AS $field)
		{
			$str_fields .= '`' . $field . '`,';
		}
		//去掉最后的逗号
		$str_fields = substr($str_fields, 0, -1);
		
		return $str_fields;
	}
}
?>