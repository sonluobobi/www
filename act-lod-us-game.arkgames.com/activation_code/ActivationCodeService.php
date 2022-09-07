<?php
/**
 * 激活码使用逻辑
 * @author fuqian.liao
 */
require_once '../libs/PdoHelper.php';

class ActivationCodeService extends PdoHelper
{
	public $tbl_code_batch    = 'tbl_activation_code_batch'; //激活码批次表
	public $tbl_code_lib_base = 'tbl_activation_code_common'; //激活码库基础表
	public $tbl_code_use_base = 'tbl_activation_code_use';    //激活码基础表
	
	public $tbl_code_lib = '';  //存放激活码的表
	public $tbl_code_use = '';  //存放激活码使用的表
		
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
	
	/**
	 * 设置激活码库表（不用）
	 * @param unknown_type $batch_id
	 */
	private function setCodeLibTableNameBak($batch_id)
	{
		global $g_code_lib_tbl_conf;
		
		$this->tbl_code_lib = '';
		
		foreach ($g_code_lib_tbl_conf as $tbl_name=>$arr_batch_id)
		{
			foreach ($arr_batch_id as $tmp_batch_id)
			{
				if ($tmp_batch_id == $batch_id) 
				{
					//file_put_contents('/tmp/liao_tbl.log', 'batch_id2333 into==>'.$tmp_batch_id."\r\n",FILE_APPEND);
					
					$this->tbl_code_lib = $tbl_name;
					break;
				}
			}
			if ($this->tbl_code_lib)
				break;
		}
				
		if (!$this->tbl_code_lib) {
			$this->tbl_code_lib = $this->tbl_code_lib_base;
		}
		
		//file_put_contents('/tmp/liao_tbl.log', 'tbl_code_lib==>'.$this->tbl_code_lib."\r\n",FILE_APPEND);
		
	}
	
	/**
	 * 设置某个批次激活码相关表
	 * @param unknown_type $code_batch
	 */
	private function getTableName($act_code)
	{
		//初始化表名
		$this->tbl_code_lib = '';
		$this->tbl_code_use = '';
		
		$prefix = substr($act_code, 0,2);
		$sql = " select `id`,`tbl_code_lib`,`tbl_code_use` 
		         FROM `$this->tbl_code_batch` 
				 WHERE `activation_prefix`='".$prefix."' LIMIT 1";
		
		$code_batch = $this->fetchOneRecord($sql);
		
		if (is_array($code_batch) && count($code_batch) > 0)
		{
			//设置该批次激活码存放表
			if (!empty($code_batch['tbl_code_lib']))
			{
				$this->tbl_code_lib = $code_batch['tbl_code_lib'];
			}
			else
			{
				$this->tbl_code_lib = $this->tbl_code_lib_base;
			}
			
			//设置该批次激活码使用记录表
			if (!empty($code_batch['tbl_code_use']))
			{
				$this->tbl_code_use = $code_batch['tbl_code_use'];
			}
			else
			{
				$this->tbl_code_use = $this->tbl_code_use_base;
			}
		}
		
		//file_put_contents('/tmp/liao_code.log', var_export(array($this->tbl_code_lib,$this->tbl_code_use),true),FILE_APPEND);
		
		
		return array($this->tbl_code_lib,$this->tbl_code_use);
	}
	
	/**
	 * 设置表名(不用)
	 * @param unknown_type $batch_id
	 */
	private function setTableName($batch_id)
	{
		global $g_actcode_use_tbl_conf;
						
		if (isset($g_actcode_use_tbl_conf[$batch_id])) {
			$this->tbl_code_use =  $this->tbl_code_use_base.'_'.$g_actcode_use_tbl_conf[$batch_id];
		}else {
			$this->tbl_code_use = $this->tbl_code_use_base;
		}
	}
		
	public function getActCode($act_code)
	{
		$sql = " SELECT `id`,`batch_id`,`code` FROM `$this->tbl_code_lib` WHERE `code`='".$act_code."' LIMIT 1";
		$result = $this->fetchOneRecord($sql);
		return $result;
	}
	
	/**
	 * 获取激活码使用记录
	 * @param unknown_type $condition
	 * @return mixed
	 */
	public function getActCodeUseLog($code_item)
	{
		$sql = " SELECT COUNT(`id`) as use_num FROM `$this->tbl_code_use` ".
		        " WHERE `batch_id`=".$code_item['batch_id'].
		        " AND `act_code_id`=".$code_item['id'] ." LIMIT 1 ";
		$result = $this->fetchOneRecord($sql);
		return $result['use_num'];
	}
	
	/**
	 * 获取激活码批次信息
	 * @param unknown_type $batch_id
	 * @return mixed
	 */
	public function getActivationCodeBatchById($batch_id)
	{
		$sql = " SELECT `id`,`start_time`,`end_time`,`character_level_min`,`character_level_max`,`is_limit_character`,`is_global_use`,`use_num_pre`,`gift_pack`,`server_ids`   FROM `$this->tbl_code_batch` WHERE `id`=".$batch_id;
		$result = $this->fetchOneRecord($sql);
		return $result;
	}
	
	
	/**
	 * 验证激活码使用
	 * @throws Exception
	 */
	public function validActivationCode()
	{
		$character_id    = $_GET['cid'];
		$activation_code = $_GET['activation_code'];
		$player_id       = $_GET['pid'];
		$area_id         = $_GET['server_id'];
		$character_level = $_GET['ch_level'];
		
		//获取该批次激活码相关表
		list($tbl_code_lib,$tbl_code_use) = $this->getTableName($activation_code);
		if (!$tbl_code_lib || !$tbl_code_use)
		{
			throw new Exception('', ACTIVATION_CODE_UNKNOW_BATCH);
		}
		
		$code_item = $this->getActCode($activation_code);
		
		if (!is_array($code_item) || $code_item['id'] < 1)
		{
			throw new Exception('', ACTIVATION_CODE_UNKNOW_CODE);
		}
		
		$code_batch = $this->getActivationCodeBatchById($code_item['batch_id']);
		if (!is_array($code_batch))
		{
			throw new Exception('',ACTIVATION_CODE_UNKNOW_BATCH);
		}

        $is_server = $this->checkServerId($area_id,$code_batch['server_ids']);

        
        if(!$is_server)
        {
            throw new Exception('',ACTIVATION_CODE_USED_ERROR_AREA);
        }


		//是否全服使用
		$is_global_use = intval($code_batch['is_global_use']);
		$code_use_num = $this->getActCodeUseLog($code_item);

		if ($is_global_use >= 0)
		{
			$can_use_num = 1;
			$is_global_use > 1 && $can_use_num = $is_global_use;

			if ($code_use_num >= $can_use_num)
			{
				throw new Exception('',ACTIVATION_CODE_USED_OTHER);
			}
		}

		$current_time = time();
		if (strtotime($code_batch['start_time']) > $current_time)
		{
			throw new Exception('',ACTIVATION_CODE_NOT_INTIME);
		}
		
		if (strtotime($code_batch['end_time']) < $current_time) 
		{
			throw new Exception('',ACTIVATION_CODE_IS_OUTDATE);
		}
		
		//检查角色等级是否符合
		if ($code_batch['character_level_max'] > 0 && $character_level > $code_batch['character_level_max'])
		{
			throw new Exception('',ACTIVATION_CODE_LEVEL_MORE);
		}
		
		if ($character_level < $code_batch['character_level_min'])
		{
			throw new Exception('',ACTIVATION_CODE_LEVEL_LESS);
		}
		
		if ($code_batch['use_num_pre'])
		{
			if (!$code_batch['is_limit_character'])
			{
				$use_count = $this->getCodeUseCountByPid($code_batch['id'], $player_id);
				
				if ($use_count >= $code_batch['use_num_pre'])
				{
					throw new Exception('',ACTIVATION_CODE_USED_SAME_BATCH);
				}
			}
			else
			{
				$use_count = $this->getCodeUseCountByCid($code_batch['id'],$player_id, $area_id,$character_id);

				if ($use_count >= $code_batch['use_num_pre'])
				{
					throw new Exception('',ACTIVATION_CODE_USED_SAME_BATCH);
				}
			}
		}
		
		//添加使用记录
		$use_item = array();
		$use_item['player_id']    = $player_id;
		$use_item['character_id'] = $character_id;
		$use_item['batch_id']     = $code_item['batch_id'];
		$use_item['act_code_id']  = $code_item['id'];
		$use_item['act_code']     = $activation_code;
		$use_item['serv_id']      = $area_id;
		$use_item['created']      = date('Y-m-d H:i:s');

		if (!$this->addCodeUseLog($use_item))
		{
			throw new Exception('',ACTIVATION_CODE_USED_FAIL);
		}

		if ($is_global_use != 1)
		{
			$this->updateActCode($code_item['id'], $player_id, $area_id, $character_id);
		}

		$return =  [];
        $return['flag'] = true;
        $reward = explode("|",$code_batch['gift_pack']);
        $return['reward'] = implode(";",$reward);
		
		return $return;
	}
		
	public function getCodeUseCountByPid($batch_id, $player_id)
	{
		$sql = "SELECT COUNT(`id`) as use_num FROM `$this->tbl_code_use`" .
				" WHERE player_id=".$player_id." AND batch_id=".$batch_id." limit 1";
	
		$arr_data = $this->fetchOneRecord($sql);
		
		return $arr_data['use_num'];
	}
	
	
	public function getCodeUseCountByCid($batch_id, $player_id, $server_id,$character_id)
	{
		$sql = "SELECT COUNT(`id`) as use_num FROM `$this->tbl_code_use` " .
				" WHERE    player_id=".$player_id." AND character_id=".$character_id."
						   AND batch_id=".$batch_id."
						   AND serv_id= ".$server_id." limit 1";
		
		$arr_data = $this->fetchOneRecord($sql);
		
		return $arr_data['use_num'];
	}
	
	/**
	 * 添加激活码使用记录
	 * 
	 * @param unknown_type $use_item
	 * @return Ambigous <number, string>
	 */
	function addCodeUseLog($use_item)
	{
		$fields = array_keys($use_item);
		
		return $this->simpleAdd($this->tbl_code_use, $use_item, $fields);
	}
	
	/**
	 *  更新激活码使用信息
	 * @param number $id 激活码记录id
	 * @param number $player_id 玩家id
	 * @param number $server_id 玩家所在服务器id
	 * @param number $character_id 玩家角色id
	 */
	function updateActCode($id, $player_id,$server_id,$character_id)
	{
		$sql = 'UPDATE `' . $this->tbl_code_lib . '` set `is_used`=1,`user_character_id`=' . $character_id . ',`user_player_id`=' . $player_id . ',`user_serv_id` = ' . $server_id . ',`publish`=1, `updated` = \''. date('Y-m-d H:i:s') . '\' where id=' . $id;
		$this->executeSql($sql);
	}

    /**
     * 检查大区id
     * @param $server_id
     * @param $server_ids
     */
	function checkServerId($server_id,$server_ids)
    {
        $area_ids = explode(',',$server_ids);

        $server_list = [
            't1' => 4390901,
            'brt3' => 4391903,
            'ust3' => 4390903,
        ];

        $server_id_list = [];
      foreach ($area_ids as $key => $val)
      {
          if ($server_list[$val])
          {
              $server_id_list[] = $server_list[$val];
          }
      }

      if(in_array($server_id,$server_id_list))
      {
          return true;
      }
      else
      {
          return false;
      }
    }
}




?>