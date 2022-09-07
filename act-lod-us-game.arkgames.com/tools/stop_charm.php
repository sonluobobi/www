<?php
//stop_charm.php
//提前结束魅力活动
define('CUR_ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)));
define('BASE_ROOT_PATH', dirname(CUR_ROOT_PATH));

$stop_interval = 10; //多少秒之后

if (empty($_SERVER['argv']) || empty($_SERVER['argv'][1]) || $_SERVER['argv'][1] != 'do')
{
	die('you are not allowed');
}

require_once BASE_ROOT_PATH . '/config/config.php'; 
require_once BASE_ROOT_PATH . '/config/static_config.php';
require_once BASE_ROOT_PATH . '/functions/func_for_common.inc.php';

$servlist = require_once SERVER_LIST_DATA_FILE;

$server_list = array();
//指定游戏服
if (!empty($argv[2]) && is_numeric($argv[2])) 
{
	$server_id = $argv[2];

	if (!empty($servlist[$server_id]))
	{
		$server_list[$server_id] = $servlist[$server_id];
	}
	else
	{
		die('params error server_id');
	}
}
else
{
	$server_list = $servlist;
}

$opcode = OP_GMT_PRE_STOP_CHARM;
$cache_file = CUR_ROOT_PATH . '/'.$opcode.'.log';

$params = array();
$params['interval'] = $stop_interval;

echo 'begin --' . date('Y-m-d H:i:s') . "\r\n";

foreach ($server_list as $tmp_server_id=>$server)
{
	if ($server['server_status'] > 1) continue;
	if (empty($server['server_date']) || $server['server_date'] == '0000-00-00 00:00:00') continue;

	$server_url = $server['server_url'];

	$ret = rpcRequest($opcode, $params, $server_url);

	if (!empty($ret))
	{
		$retmsg = !empty($ret['retmsg']) ? $ret['retmsg'] : '';

		if (isset($ret['retcode']) && 0 == $ret['retcode'])
		{
			$retmsg .= ' -- succ';
		}
		else
		{
			$retmsg .= ' -- fail';
		}
	}
	
	$log_msg = '['.date('Y-m-d H:i:s').'] -- ' . $server_url . ' -- ' . $retmsg ."\r\n";
	echo $log_msg. "\r\n";
}

echo 'end --' . date('Y-m-d H:i:s') . "\r\n";

function rpcRequest($opcode,$data,$server_url)
{
	global $cache_file;

	$ch = curl_init();
	$filename = $cache_file;

	file_put_contents($filename,"-------------------------------------  start  ------------------------------------------------\n",FILE_APPEND);
	file_put_contents($filename,date('Y-m-d H:i:s')."\n",FILE_APPEND);

	$curl_data = json_encode($data);
	$func= $opcode;
	$url = "http://" . $server_url . "/webproxy.php?act=$func";
	file_put_contents($filename, 'url='.$url."\n",FILE_APPEND);

	$options = array(CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			//CURLOPT_CONNECTTIMEOUT => 2,
			//CURLOPT_TIMEOUT  => 5,
			CURLOPT_POSTFIELDS => array(
					"data"     => gzcompress($curl_data),
			),
	);

	curl_setopt_array($ch, $options);
	$response = curl_exec($ch);
	curl_close($ch);
	$bak_response = $response;
	file_put_contents($filename,"response=>".$response."\n",FILE_APPEND);
	$response = json_decode($response,true);

	file_put_contents($filename,"result=>".var_export($response,true)."\n",FILE_APPEND);
	file_put_contents($filename,"----------------------------------------- end  -------------------------------------------------\n",FILE_APPEND);

	$result = array();

	if (!is_array($response))
	{
		$result['retcode'] = 1;
		$result['retmsg'] = '设置失败，游戏服没有返回数据。' . $bak_response;
	}
	elseif ($response['retcode'] != 0)
	{
		$result['retcode'] = 1;
		$result['retmsg']  = $response['retmsg'];
		$result['data']    = $response['data'];
	}
	else
	{
		$result['retcode'] = 0;
		$result['retmsg']  = 'success';
		$result['data']    = $response['data'];
	}

	return $result;
}
