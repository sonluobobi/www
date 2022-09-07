<?php
/**
 * 激活码生成逻辑
 * @author fuqian.liao
 */

require_once 'PdoHelper.php';

class ActivationCodeService extends PdoHelper
{
	static $act_code_file_prefix = '/tmp/liao_';
	//static $act_batch_file = '/tmp/liao_bacth_list.php';
	
	/**
	 * 初始化数据库连接
	 */
	public function __construct()
	{
		$className = __CLASS__;
		
		global $config_server,$config_database,$config_user,$config_password;
		$arr_server = explode(':', $config_server);
		$db_host = $arr_server[0];
		$db_port = $arr_server[1];
		
		parent::__construct($db_host,$db_port,$config_database,$config_user,$config_password,$className);
	}
	
	private function getCodeBatchPrefix()
	{
		$prefix = '';
		
		//获取所有批次激活码前缀
		$batch_id_exist = array();
		$sql = " SELECT `activation_prefix` FROM `tbl_activation_code_batch` ";
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
				);
		foreach ($code as $item) 
		{
			$code_list[] = $item;
			$code_list[] = strtoupper($item);
		}
		
		/*
		for($i=1;$i<10;$i++) {
			$code_list[] = $i;
		}*/
		
		shuffle($code_list);
		
		while (true)
		{
			$key_list = array_rand($code_list,2);
			$prefix   = $code_list[$key_list[0]].$code_list[$key_list[1]];
			$prefix   = strtolower($prefix);
			
			if (!isset($batch_id_exist[$prefix])) break;
		}
		
		return $prefix;
		
	}
	
	private function getBacthInfoById($batch_id)
	{
		$sql = " SELECT `activation_prefix` FROM 
				`tbl_activation_code_batch` where id=".$batch_id;
		
		$batch = $this->fetchOneRecord($sql);
		return $batch;
	}
	
	/**
	 * 添加激活码批次数据
	 * @throws Exception
	 */
	public function addBatch()
	{
		set_time_limit(0);
		
		$num    = $_GET['num'];         //激活码数量
		$length = $_GET['length'];   //激活码长度
		$gift   = $_GET['gift'];       //激活码长度
		
		$start_date  = $_GET['start_date'];   //激活码使用开始时间
		$end_date    = $_GET['end_date'];     //激活码使用结束时间
		
		$tbl_code_lib = $_GET['tbl_code_lib'];  //该批次激活码存放的表
		$tbl_code_use = $_GET['tbl_code_use'];  //该批次激活码使用记录表
		
		$title = $_GET['title'];
		$server_ids = $_GET['server_ids'];
		
		//file_put_contents('/tmp/param.log', var_export($_GET,true),FILE_APPEND);
		$prefix = $this->getCodeBatchPrefix();
		
		if (!$prefix || !$tbl_code_lib || !$tbl_code_use || !$gift ||  !$num || !$length || !$server_ids || !$title)
		{
			throw new Exception(" Error: lost param or param invalid.");
		}
		
		$sql = "INSERT INTO `tbl_activation_code_batch` ( `activation_code_sort_id`, `title`, `activation_prefix`, `tbl_code_lib`,`tbl_code_use`, `length`, `activation_code_total`, `server_ids`, `gift_pack`, `character_level_max`, `character_level_min`, `use_num_pre`, `is_limit_character`, `res_id`, `start_time`, `end_time`, `intro`, `created`, `updated`) VALUES
		
		( 1, '$title', 
			'$prefix', 
			'$tbl_code_lib',
			'$tbl_code_use',
			$length, 
			$num,
			'$server_ids', 
		  	'$gift',
			 300, 
			1, 
			1, 
			1, 
			'Y0004',
		 	'$start_date',
		 	'$end_date', NULL, '2013-05-25 16:21:58', NULL)";
		
		$last_insert_id = $this->executeSql($sql);
		file_put_contents('/tmp/batch_id.log', $last_insert_id."\r\n",FILE_APPEND);
		
		throw new Exception(" OK: add code batch success .\r\n");
	}
	
	/**
	 * 生成激活码
	 */
	public function makeActivationCode()
	{
		set_time_limit(0);
		
		$token    = $_GET['token'];       //验证码
		$batch_id = $_GET['batch_id'];    //激活码前缀
		$num      = $_GET['num'];         //激活码数量
		$length   = $_GET['length'];   //激活码长度
		
		$title = $_GET['title'];
		
		if (!$token || !$batch_id || !$num || !$length)
		{
			throw new Exception(" Error: lost param or param invalid.");
		}
		
		$batch = $this->getBacthInfoById($batch_id);
		if (!$batch) {
			throw new Exception(" Error: batch not exist .");
		}
		
		$prefix = $batch['activation_prefix'];
		
		
		$length = $length - 2;
		
		$code_file = self::$act_code_file_prefix.$title.'.log';
		
		$active_codes = array();
		$code_list = array();
				
		$pp=1;
		
		$tmp_code ='';
		
		for ($i=0;$i<$num;$i++)
		{
			$rand_data = mt_rand(1000, 99999999999);
			$md5  = md5($rand_data.$token.$token);
		
			$code = $prefix.substr($md5,0,$length);
			while (isset($active_codes[$code]))
			{
				$rand_data = mt_rand(1000, 99999999999);
				$md5  = md5($rand_data.$token.$pp.$token);
				$code = $prefix.substr($md5,0,$length);
		
				$pp++;
			}
			$active_codes[$code] = true;
			
			$code_list[] = array('code'=>$code);
			
			file_put_contents($code_file,$code."\n",FILE_APPEND);
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
		
		throw new Exception(" OK: makeActivationCode finish.\r\n");
	}
}


