<?php
/**
 * 运营活动激活码批次
 * 
 * @author Andy Cai(huayi.cai@kunlun-inc.com)
 * @since 2009-10-29
 * @filesource ClsActivityCodeBatch.php
 * @version $Id: ClsActivityCodeBatch.php,v 1.1 2010/09/29 08:58:11 mjl-xx Exp $
 *
 */
require_once('libs/PdoHelper.php');

class ClsActivityCodeBatch extends PdoHelper
{
	public  $DB = null; //数据库句柄

	public $tbl_activation_code_batch = 'tbl_activation_code_batch';

	public $tbl_activation_code_batch_fields = array(
								'id',
								'title',
								'activation_prefix',
								'length',
								'activation_code_total',
								'server_ids',
								'gift_pack',
								'character_level_max',
								'character_level_min',
								'use_num_pre',
								'is_limit_character',
								'is_global_use',
								'start_time',
								'end_time',
								'created',
								'updated'
								);
	
	
	public function __construct($tbl_name = null)
	{
		$className = __CLASS__;
	
		global $config_server,$config_database,$config_user,$config_password;
		$arr_server = explode(':', $config_server);
		$db_host = $arr_server[0];
		$db_port = $arr_server[1];
	
		parent::__construct($db_host,$db_port,$config_database,$config_user,$config_password,$className);
	
		if ($tbl_name) 
		{
			$this->tbl_name = $tbl_name;
		}
	}
	
	public  function getCodeBatchPrefix($batch_type=0)
	{
		global $sync_platform_map, $common_area_sign;
		$prefix = '';
	
		//获取所有批次激活码前缀
		$batch_id_exist = array();
		$sql = " SELECT `activation_prefix` FROM `$this->tbl_activation_code_batch` ";
		$batch_list = $this->fetchAllRecord($sql);
		foreach ($batch_list as $batch)
		{
			$tmp_prefix = strtolower($batch['activation_prefix']);
			$batch_id_exist[$tmp_prefix] = true;
		}
	
		$code_list = array();
	
		$code = array('a','b','c','d','e','f','g','h',
				'i','j','k','l','m','n','o','p','q',
				'r','s','t','u','v','w','x','y','z',
				1,2,3,4,5,6,7,8,9,
		);
		
		foreach ($code as $item)
		{
			$code_list[] = $item;
			$code_list[] = strtoupper($item);
		}
	   	$code_list = array_unique($code_list); 	
		shuffle($code_list);

		//$batch_id_exist['tt'] = true;
		//echo '<pre>';print_r($batch_id_exist);

		//*
		if ($batch_type == 2 && !empty($sync_platform_map) && !empty($common_area_sign) && !empty($sync_platform_map[$common_area_sign]))
		{
			//检验其他共享大区激活码批次，避免重复
			foreach($sync_platform_map[$common_area_sign] as $platform_sign)
			{
				$file = INCLUDE_PATH. '/data/platform_batch_prefix/batch_' . $platform_sign . '.php';
				if (file_exists($file))
				{
					$platform_batch_prefix = array();
					require $file;
					//echo $file."<br>";
					//echo '<pre>';print_r($platform_batch_prefix);

					!empty($platform_batch_prefix) && $batch_id_exist = $batch_id_exist + $platform_batch_prefix;
				}
			}
		}
		//*/
		//echo '<pre>';print_r($batch_id_exist);

		while (true)
		{
			$key_list = array_rand($code_list,2);
			$code_one = strtolower($code_list[$key_list[0]]);
			$code_two = strtolower($code_list[$key_list[1]]);
			$prefix   = $code_one.$code_two;
			//$batch_type == 2 && $prefix = $code_one.$code_one;

			if (!isset($batch_id_exist[$prefix]))
			{
				//if ($batch_type == 2) break;
				//if ($code_one != $code_two) break;
				break;
			}							
		}
		
		return $prefix;
	
	}
		
	
	function getBatchList($condition = '', $order_by = '', $limit = '', $offset = '') 
	{
		$str_fields = $this->formatFields ( $this->tbl_activation_code_batch_fields );
		
		$order_byStr = $order_by == '' ? '' : " ORDER BY " . $order_by . " DESC ";
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;
		
		$sql = "SELECT * FROM " . $this->tbl_activation_code_batch . " WHERE 1=1 " . $condition . $order_byStr . $limitStr . $offsetStr;
		
		$arr_data = $this->fetchAllRecord($sql);
				
		return $arr_data;
	}
	
	public function getActivationCodeBatch($condition)
	{
		$sql = "SELECT * FROM " . $this->tbl_activation_code_batch . 
									   " WHERE 1=1 AND " . $condition."' limit 1";

		return $this->fetchOneRecord($sql);
		
	}
	
	public function getActivationCodeBatchById($id)
	{
		$sql = "SELECT * FROM " . $this->tbl_activation_code_batch . 
									   " WHERE id=$id limit 1";

		return $this->fetchOneRecord($sql);
		
	}
	
	/**
	 * 添加激活码批次
	 * 
	 * @param	Array $arrData
	 * @return	插入数据库的最新记录ID
	 * 
	 */
	function addActivityBatch($arrData) 
	{
		$sql = "INSERT INTO " . $this->tbl_activation_code_batch . "(" . $arrData ['fields'] . ") VALUES(" . $arrData ['values'] . ")";
		if (function_exists('act_do_log'))
		{
			act_do_log('add activity batch sql | ' . $sql, 'code_batch');
		}

		return $this->addRecord($sql);
	}
	
	public function update($id,$params)
	{
		if(!$params or !is_array($params))
		{
			return 0;
		}
		
		$str_set_fields = '';
		
		foreach($params as $field => $value)
		{
			if(!is_int($value) and !is_float($value))
			{
				$value = "'$value'";
			}
			$str_set_fields .= " `$field` = $value,";
		}		
		$str_set_fields = substr($str_set_fields,0,-1);		
		$sql = "UPDATE " . $this->tbl_activation_code_batch . " SET $str_set_fields WHERE `id`=$id limit 1 ";

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