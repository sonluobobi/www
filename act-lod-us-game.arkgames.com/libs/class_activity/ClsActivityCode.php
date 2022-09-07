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
require_once('libs/PdoHelper.php');

class ClsActivityCode extends PdoHelper
{
	public $DB = null; //数据库句柄

	static $act_code_file_prefix = '/tmp/moyu_code_';
	static $import_code_sql_file_prefix = '/tmp/import_code_sql_';
	static $import_code_batch_list = '/tmp/import_batch_code_list';
	
	public $tbl_activation_code = 'tbl_activation_code';
	public $tbl_activation_code_batch = 'tbl_activation_code_batch';
	public $tbl_name = '';
	
	
	public function __construct($tbl_name = null)
	{
		$this->tbl_activation_code = CUR_TBL_CODE_LIB;
		
		$className = __CLASS__;
	
		global $config_server,$config_database,$config_user,$config_password;
		$arr_server = explode(':', $config_server);
		$db_host = $arr_server[0];
		$db_port = $arr_server[1];
	
		parent::__construct($db_host,$db_port,$config_database,$config_user,$config_password,$className);
		
		if ($tbl_name) 
		{
			$this->tbl_activation_code = $tbl_name;
		}
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
	 * @author fuqian.liao
	 */
	public function makeActivationCode($prefix,$batch_id,$num,$length,$start_date,$end_date)
	{
		set_time_limit(0);
			
		file_put_contents(IMPORT_CODE_SQL_FILE, '');
		
		$length = $length - 2;
	
		$code_file = self::$act_code_file_prefix.$batch_id.'.log';

        ///tmp/moyu_code_';
	
		$active_codes = array();
		$code_list    = array();
	
		$pp=1;
	
		$tmp_code ='';
	
		for ($i=0;$i<$num;$i++)
		{
			$rand_data = mt_rand(1000, 99999999999);
			$md5  = md5($rand_data.ACT_CODE_TOKEN.$token);
		
			$code = $prefix.substr($md5,0,$length);
			while (isset($active_codes[$code]))
			{
				$rand_data = mt_rand(1000, 99999999999);
				$md5  = md5($rand_data.ACT_CODE_TOKEN.$pp.$token);
				$code = $prefix.substr($md5,0,$length);
			
				$pp++;
			}
			$active_codes[$code] = true;
				
			$code_list[] = array('code'=>$code);
				
			file_put_contents($code_file,$code."\n",FILE_APPEND);
		}
		
		$tbl_code_lib = CUR_TBL_CODE_LIB;
		$sql_str = '';
		$sql_file = self::$import_code_sql_file_prefix.$batch_id.'.sql';
		
		$sql_prefix = " INSERT INTO `$tbl_code_lib` (activation_code_sort_id,batch_id,code,start_time,end_time) VALUES " ;
		file_put_contents($sql_file, $sql_prefix,FILE_APPEND);
		
		$size = count($code_list);
		foreach ($code_list as $key=>$item)
		{
			$act_code = $item['code'];
			
			if (($key+1) < $size) {
				$sql_str = "(1,$batch_id,'$act_code','$start_date', '$end_date'),\r\n";
			}else {
				$sql_str = "(1,$batch_id,'$act_code','$start_date', '$end_date');\r\n";
			}
						
			file_put_contents($sql_file, $sql_str,FILE_APPEND);
		}

		$insert_sql = file_get_contents($sql_file);
        $this->executeSql($insert_sql);
				
		//将激活码导入数据库操作放到后台执行
		if (!file_exists($sql_file) )
		{
			return false;
		}
		
		/*$cmd = '/bin/sh /data/syslog/serverlist/import_code.sh '.$sql_file.' >> /tmp/import_code.log 2>&1 &';
		$handle = popen($cmd, 'r');*/
		if (true)
		{
			//将激活码写入日志文件,方便以后提取使用。
			$act_code_dir = ACT_CODE_DIR.'/'.$batch_id;
			if (!is_dir($act_code_dir))
			{
				mkdir($act_code_dir);
			}
			$act_code_file = $act_code_dir.'/act_code.php';
			$code_content  = "<?php \r\n return ";
			$code_content .= var_export($code_list,true);
			$code_content .= ";\r\n ?>";
			
			file_put_contents($act_code_file, $code_content);

			//pclose($handle);
			return true;
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
	function createNewInvitationCode($batch_id, $prefix, $num, $start_time, $end_time,$exist_code_arr = array(),$length = 12)
	{
		$code_list = array();
		$insert_data = '';
		$length   = $length-strlen($prefix);
		$tmp_code ='';
		$pp=1;
				
		for ($i=0;$i<$num;$i++)
		{
			$rand_data = mt_rand(1000, 99999999999);
			$md5  = md5($rand_data.ACT_CODE_TOKEN.ACT_CODE_TOKEN);
			
			$now_code = $prefix.substr($md5,0,$length);
			while (isset($active_codes[$now_code]))
			{
				$rand_data = mt_rand(1000, 99999999999);
				$md5  = md5($rand_data.ACT_CODE_TOKEN.$pp.ACT_CODE_TOKEN);
				$now_code = $prefix.substr($md5,0,$length);
				
				$pp++;
			}
			
			$active_codes[$now_code] = 1;
			$code_list[] = array('code'=>$now_code);
			
			$insert_data .= "(" . $batch_id . ", '" . $now_code . "', '" . $start_time . "', '" . $end_time . "', NOW()),";
			
		}
								
		if (4 < strlen($insert_data))
		{
			$insert_data = substr($insert_data, 0, -1);
			$sql = "INSERT INTO " . CUR_TBL_CODE_LIB . "(batch_id, code, start_time, end_time, created) VALUES" . $insert_data;

			if (!$this->addRecord($sql))
			{
				return false;
			}
			
			//将激活码写入日志文件,方便以后提取使用。
			$act_code_dir = ACT_CODE_DIR.'/'.$batch_id;
			if (!is_dir($act_code_dir))
			{
				mkdir($act_code_dir);
			}
			$act_code_file = $act_code_dir.'/act_code.php';
			$code_content  = "<?php \r\n return ";
			$code_content .= var_export($code_list,true);
			$code_content .= ";\r\n ?>";
			
			file_put_contents($act_code_file, $code_content);
			
			return true;
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
		$sql = "SELECT COUNT(`id`) AS total " . 
										 " FROM " . $this->tbl_activation_code . 
										" WHERE 1=1 " . $condition;

		$result = $this->fetchOneRecord($sql);

		return $result['total'];
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
		$conStr = '';
		if ($condition) $conStr .= $condition;
		if ($order_by) $conStr .= " ORDER BY " . $order_by . " DESC";
		if ($limit) $conStr .= " LIMIT " . $limit;
		if ($offset) $conStr .= " OFFSET " . $offset;

		$sql = "SELECT * FROM " . $this->tbl_activation_code . 
									   " WHERE 1=1 " . $conStr;

		$arr_data = $this->fetchAllRecord($sql);
		
		return $arr_data;
	}
	
	function getInvitationCodeInfo($condition = '', $order_by = '', $limit = '', $offset = '',$sort_id=1)
	{
		$str_fields = $this->formatFields($this->tbl_activation_code_fields);
	
		$conStr = '';
		if ($condition) $conStr .= $condition;
		if ($order_by) $conStr .= " ORDER BY " . $order_by . " DESC";
		if ($limit) $conStr .= " LIMIT " . $limit;
		if ($offset) $conStr .= " OFFSET " . $offset;
	
		if ($sort_id == 2)
		{
			$sqlForGetInvitationCodeList = "SELECT SUBSTRING(`code`,3) as code FROM " . $this->tbl_activation_code .
			" WHERE 1=1 " . $conStr;
		}
		else
		{
			$sqlForGetInvitationCodeList = "SELECT code FROM " . $this->tbl_activation_code .
			" WHERE 1=1 " . $conStr;
		}		
	
		$arr_data = $this->fetchAllRecord($sqlForGetInvitationCodeList);
	
		return $arr_data;
	}
	
	public function getActivationCode($condition)
	{
		$sql = "SELECT * FROM " . $this->tbl_activation_code . 
									   " WHERE 1=1 AND " . $condition." limit 1";

		$arr_data = $this->fetchOneRecord($sql);
		
	}
	
	public function getCodeUseCountByPid($batch_id, $player_id)
	{
		$sql = "SELECT COUNT(`id`) as use_num FROM " . $this->tbl_activation_code . 
									   " WHERE 1=1 AND batch_id=".$batch_id." AND user_player_id=".$player_id." limit 1";

		$result = $this->fetchOneRecord($sql);
		
		return $result['use_num'];
	}
	
	
	public function getCodeUseCountByCid($batch_id, $server_id,$character_id)
	{
		$sql = "SELECT COUNT(`id`) as use_num FROM " . $this->tbl_activation_code . 
									   " WHERE 1=1 AND batch_id=".$batch_id."
									    AND user_character_id=".$character_id."
									    AND user_serv_id= ".$server_id." limit 1";
		
		$result = $this->fetchOneRecord($sql);
		return $result['use_num'];
	}
	
	public function getUsedCodeList($table = null,&$used_code_list)
	{
		if (!$table) {
			$table = $this->tbl_activation_code;
		}
		
		$sql = "SELECT COUNT(`id`) as used_num,batch_id FROM " . $table .
				" GROUP BY  `batch_id`";
		
		$result = $this->fetchAllRecord($sql);
		foreach ($result as $item)
		{
			$used_code_list[$item['batch_id']] = $item;
		}
		
		return $used_code_list;
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
		
		return $this->executeSql($sql);
	}
	
	/**
	 * 更新激活码信息
	 * 
	 * @param	int $id 要更新的活动 id号
	 * @param	String $strData 要更新的字段串
	 * @return	Boolean
	 * 
	 */
	function updateCodeItemByIds($id_str, $strData) 
	{
		$sql = "UPDATE " . $this->tbl_activation_code . " SET " . $strData . " WHERE id IN(" . $id_str . ") ";
		
		return $this->executeSql($sql);
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