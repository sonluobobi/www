<?php

define('CUR_ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)));
define('BASE_ROOT_PATH', dirname(CUR_ROOT_PATH));

if (!empty($_SERVER['argv']) && !empty($_SERVER['argv'][1]) && $_SERVER['argv'][1] != 'do')
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

$cur_time = time();
$tomorrow = strtotime('+1 day');
$limit_time = 1*24*60*60;
$common_url = '/webproxy.php?act=' . OP_GMT_SET_OPEN_DATE;
$cache_file = CUR_ROOT_PATH . '/log_sync_server_date.php';
$msg = '';

foreach ($server_list as $tmp_server_id=>$server)
{
	if ($server['server_status'] > 1) continue;
	if (empty($server['server_date']) || $server['server_date'] == '0000-00-00 00:00:00') continue;

	$server_date = $server['server_date'];
	$server_date_int = strtotime($server_date);

	if ($server_date_int > $tomorrow || ($server_date_int + $limit_time < $cur_time)) continue;

	$server_url = $server['server_url'].$common_url;
	$params = array('opdate' => $server_date);

	$curl_data = json_encode($params);
	$response = my_sendStreamFile($server_url, $curl_data);
	$retmsg = $response;
	$ret = json_decode($response, true);

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
	
	$log_msg = '['.date('Y-m-d H:i:s').'] -- ' . $tmp_server_id . ' -- ' . $server_url . ' -- '.  $server_date . ' -- ' . $retmsg ."\r\n";
	$msg .= $log_msg;
	@file_put_contents($cache_file, $log_msg, FILE_APPEND);
	@chmod($cache_file , 0777);
}

function my_sendStreamFile($url, $content='', $file='')
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

	$url = "http://".$url;
	$data = @gzcompress($content);
	$post_arr = array('data' => $data);
	$post_string = @http_build_query($post_arr);

	$opts = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'content-type:application/x-www-form-urlencoded',
            'content' => $post_string
        )
    );

    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);

    return $response;
}


echo $msg;