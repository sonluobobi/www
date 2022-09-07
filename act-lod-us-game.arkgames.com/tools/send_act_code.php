<?php

define('CUR_ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)));
define('BASE_ROOT_PATH', dirname(CUR_ROOT_PATH));

if (!empty($_SERVER['argv']) && !empty($_SERVER['argv'][1]) && $_SERVER['argv'][1] != 'do')
{
	die('you are not allowed');
}

require_once BASE_ROOT_PATH . '/config/config.php'; 
require_once BASE_ROOT_PATH . '/libs/mysql.config.inc.php';
require_once BASE_ROOT_PATH . '/libs/PdoHelper.php';

$base_url = 'pl'.$common_second_domain;
//$base_url = 's0'.$common_second_domain;
$url = "http://".$base_url.'/act_gift/receive_act_code.php';

function sendStreamFile($url, $content='', $file='')
{
	if (empty($content) && !empty($file))
	{
		if (file_exists($file))
		{
			$content = file_get_contents($file);
		}
	}

	if (empty($url) || empty($content))
	{
		return false;
	}

	$opts = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'content-type:application/x-www-form-urlencoded',
            'content' => $content
        )
    );

    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);

    return $response;
}

class ClsActivityCodeBatch extends PdoHelper
{
	public  $DB = null; //数据库句柄

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
}

$msg = '';
//获取数据
$obj_activity_code_batch = new ClsActivityCodeBatch();
$cur_date_int = date('Ymd');
$sql = 'select id,activation_prefix,tbl_code_lib from tbl_activation_code_batch where DATE_FORMAT(`end_time`,"%Y%m%d") >=' . $cur_date_int;
$msg .= $sql . "\r\n";
$code_batch_arr = $obj_activity_code_batch->fetchAllRecord($sql);

if (empty($code_batch_arr))
{
	die('no code batch');
}

$arr_tbl_code_lib = array();

foreach ($code_batch_arr as $code_batch_detail)
{
	$batch_id = $code_batch_detail['id'];
	$tbl_code_lib = $code_batch_detail['tbl_code_lib'];

	!isset($arr_tbl_code_lib[$tbl_code_lib]) && $arr_tbl_code_lib[$tbl_code_lib] = array();
	$arr_tbl_code_lib[$tbl_code_lib][] = $batch_id;
}

$code_result = array();

foreach ($arr_tbl_code_lib as $_tbl_code_lib => $batch_id_arr) 
{
	$sql = 'select code from '.$_tbl_code_lib.' where batch_id in ('.implode(',', $batch_id_arr).')';
	$msg .= $sql . "\r\n";
	$code_arr = $obj_activity_code_batch->fetchAllRecord($sql);

	foreach($code_arr as $code_detail)
	{
		$code = $code_detail['code'];
		$code_result[$code] = 1;
	}
}

$content = "<?php \r\n ";
$content .= '//@' . date('Y-m-d H:i:s') . "\r\n";
$content .= "\r". '$act_code_map = ' . var_export($code_result,true) . ";\r\n";
$content .= '?>';

$cache_file = CUR_ROOT_PATH . '/log_act_code_map.php';
@file_put_contents($cache_file, $content);
//echo $msg;

$response = sendStreamFile($url, $content);
print_r($response);



