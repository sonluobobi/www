<?php

function format_inject($str)
{
	if (empty($str))
	{
		return $str;
	}

	$str = stripslashes($str);
	$str = htmlspecialchars($str);
	$str = str_replace('"', '', $str);
	$str = str_replace("'", '', $str);
	$str = str_replace('\\', '', $str);

	return $str;
}

//循环创建目录
function mkdir_recyle($strPath)
{
	if (is_dir($strPath)) return true;

	$pStrPath = dirname($strPath);
	if (!mkdir_recyle($pStrPath)) return false;
	
	@mkdir($strPath, 0777);
	@chmod($strPath, 0777);

	return true;
}

function do_log($str='', $name='golbal', $folder='')
{
	global $ip;

	empty($ip) && $ip = $_SERVER["REMOTE_ADDR"];
	
	$date_str = date('Ymd'); 
	$path = CURRENT_PATH . '/log/';
	mkdir_recyle($path);

	if (!empty($folder))
	{
		$path .= $folder . '/';
		mkdir_recyle($path);
	}
	
	if (file_exists($path) && !empty($str))
	{
		$msg = $ip . ' -- ['. date('Y-m-d H:i:s') .'] -- ' .  $name . ' -- ' . $str . "\r\n";
		@file_put_contents($path.$name.'_'.$date_str.'.log', $msg, FILE_APPEND);
	}	
}

function format_map($arr)
{
	$ret = array();

	if (empty($arr) or !is_array($arr)) return $ret;

	foreach ($arr as $key => $value) {
		$tmp = array();
		$tmp['val'] = $key;
		$tmp['txt'] = $value;
		$ret[] = $tmp;
	}

	return $ret;
}

function httpGetVal($key)
{
	$value = '';
	
	if (isset($_POST[$key])) 
	{
		$value = $_POST[$key];
	}
	
	if (!$value)
	{
		if (isset($_GET[$key]))
		{
			$value = $_GET[$key];
		}
	}
	
	$value = trim($value);
	
	return format_inject($value);
}

function show_error($msg='')
{
	die($msg);
}

function getServerFromCenterIni()
{
	$server_list = array();
	
	if (defined('SERVER_CENTER_INI') && file_exists(SERVER_CENTER_INI))
	{
		$server_ini = parse_ini_file(SERVER_CENTER_INI,true);

		if (is_array($server_ini) && count($server_ini) > 0)
		{
			foreach ($server_ini as $type=>$item_arr)
			{
				if (!empty($item_arr['server_for_name']))
				{
					foreach ($item_arr['server_for_name'] as $server_x => $server_name) 
					{
						$server_list[$server_x] = $server_name;
					}
				}
			}
		}
	}

	return $server_list;
}

function getServerList()
{
	$ret = array();
	$server_list = array();
	
	if (defined('SERVER_LIST') && file_exists(SERVER_LIST))
	{
		$server_list = require SERVER_LIST;

		if (!empty($server_list))
		{
			foreach ($server_list as $server_id =>$item_arr)
			{
				if ($item_arr['server_status'] > 2) continue;

				$tmp = array();
				$tmp['server_url'] = $item_arr['server_url'];
				$tmp['server_ip'] = $item_arr['server_ip'];
				$tmp['server_name'] = $item_arr['server_name'];
				$tmp['server_date'] = $item_arr['server_date'];
				$tmp['server_status'] = $item_arr['server_status'];

				$ret[$server_id] = $tmp;
			}
		}
	}

	return $ret;
}

function getServerListForSelect($hide_test = true)
{
	$ret = array();

	$server_list = getServerList();

	if (!empty($server_list))
	{
		foreach ($server_list as $server_id =>$item_arr)
		{
			if ($hide_test && ucfirst(substr($item_arr['server_name'], 0 ,1)) == 'T')
			{
				continue;
			}

			$sx = strstr($item_arr['server_url'], '.', true);
			$ret[$sx] = $item_arr['server_name'] . '--' . $item_arr['server_ip'] . '--'. $item_arr['server_url'];
		}
	}

	return $ret;
}

function getAllServerListForSelect()
{
	$ret = array();

	$server_list = getServerList();

	if (!empty($server_list))
	{
		foreach ($server_list as $server_id =>$item_arr)
		{
			$sx = strstr($item_arr['server_url'], '.', true);
			$ret[$sx] = $item_arr['server_name'] . '--' . $item_arr['server_ip'] . '--'. $item_arr['server_url'];
		}
	}

	return $ret;
}

function getAllServerListForSx()
{
	$ret = array();

	$server_list = getServerList();

	if (!empty($server_list))
	{
		foreach ($server_list as $server_id =>$item_arr)
		{
			$sx = strstr($item_arr['server_url'], '.', true);
			$ret[$sx] = $item_arr['server_url'];
		}
	}

	return $ret;
}

function getOpenServerList()
{
	$ret = array();
	$server_list = array();
	$cur_time = time();
	
	if (defined('SERVER_LIST') && file_exists(SERVER_LIST))
	{
		$server_list = require SERVER_LIST;

		if (!empty($server_list))
		{
			foreach ($server_list as $server_id =>$item_arr)
			{
				$server_date_time = strtotime($item_arr['server_date']);

				if ($server_date_time < $cur_time && $item_arr['server_status'] < 3)
				{
					$tmp = array();
					$tmp['server_url'] = $item_arr['server_url'];
					$tmp['server_ip'] = $item_arr['server_ip'];
					$tmp['server_name'] = $item_arr['server_name'];
					$tmp['server_date'] = $item_arr['server_date'];
					$tmp['server_status'] = $item_arr['server_status'];

					$ret[$server_id] = $tmp;
				}
			}
		}
	}

	return $ret;
}

//获取开服列表
function getOpenServerListForSelect()
{
	$ret = array();
	$server_list = getOpenServerList();

	if (!empty($server_list))
	{
		foreach ($server_list as $server_id =>$item_arr)
		{
			if (ucfirst(substr($item_arr['server_name'], 0 ,1)) != 'T')
			{
				$sx = strstr($item_arr['server_url'], '.', true);
				$ret[$sx] = $item_arr['server_name'] . '--' . $item_arr['server_ip'] . '--'. $item_arr['server_url'];
			}
		}
	}

	return $ret;
}

function getPkList($domain)
{
	$ret = array();
	$pk_config_file = '/data/moyu/www/pkadmin' . $domain . '/config/pk.vchat.center.php';

	if (file_exists($pk_config_file))
	{
		require $pk_config_file;

		if (!empty($CENTER_CONFIG) && !empty($CENTER_CONFIG['serverpk']) && !empty($CENTER_DOMAIN_CONFIG['serverpk']))
		{
			foreach ($CENTER_CONFIG['serverpk'] as $info)
			{
				$id = $info['id'];
				$domain = $CENTER_DOMAIN_CONFIG['serverpk'][$id];
				$sx = strstr($domain, '.', true);
				$ret[$sx] = $sx . '_'. $id . '--' . $info['ip'] . '--'. $domain;
			}
		}
	}

	return $ret;
}

function getGlobalPkList($domain)
{
	$ret = array();
	$pk_config_file = '/data/moyu/www/pkadmin' . $domain . '/config/pk.vchat.center.php';

	if (file_exists($pk_config_file))
	{
		require $pk_config_file;

		if (!empty($CENTER_CONFIG) && !empty($CENTER_CONFIG['globalpk']) && !empty($CENTER_DOMAIN_CONFIG['globalpk']))
		{
			foreach ($CENTER_CONFIG['globalpk'] as $info)
			{
				$id = $info['id'];
				$domain = $CENTER_DOMAIN_CONFIG['globalpk'][$id];
				$sx = strstr($domain, '.', true);
				$ret[$sx] = $sx . '_'. $id . '--' . $info['ip'] . '--'. $domain;
			}
		}
	}

	return $ret;
}

function rpcRequestWebProxy($server_url,$func,$data=array())
{
	global $auth_user;

	$ch = curl_init();

	$str = $server_url . '--' . $func . '---by '. $auth_user .' ---- begin -----';
	do_log($str, 'global_webproxy', 'webproxy');

	$curl_data = json_encode($data);
	$url = "http://" . $server_url . '/webproxy.php?act='.$func;

	$options = array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => array(
			"data"     => gzcompress($curl_data),
		),
	);

	curl_setopt_array($ch, $options);
	$response = curl_exec($ch);
	curl_close($ch);
	$bak_response = $response;
	$str = $func . '-- response => ' . $response; 
	do_log($str, 'global_webproxy', 'webproxy');
	$response = trim($response);
	$response = json_decode($response,true);

	$str = '';
	!empty($response) && $str = $func . '-- result => ' . var_export($response,true);
	$str .= ' ---- end';
	do_log($str, 'global_webproxy', 'webproxy');

	$result = array();

	if (!empty($response) && 0 == $response['retcode'])
	{
		$result['retcode'] = 0;
		$result['retmsg']  = 'success';
	}
	else
	{
		$result['retcode'] = 1;
		$default_retmsg = '设置失败，游戏服没有返回数据。' . $bak_response;
		$result['retmsg']  = !empty($response['retmsg']) ? $response['retmsg'] : $default_retmsg;
		//$result['retmsg']  = $response['retmsg'];
	}

	!empty($response['data']) && $result['data'] = $response['data'];

	return $result;
}

//按ip获取服务器列表
function getServerListForSelectPerIp($hide_test)
{
	$ret = array();
	$ip_list = array();
	$server_list = getServerList();

	if (!empty($server_list))
	{
		foreach ($server_list as $server_id =>$item_arr)
		{
			if (!$hide_test || ucfirst(substr($item_arr['server_name'], 0 ,1)) != 'T')
			{
				$sx = strstr($item_arr['server_url'], '.', true);
				$server_ip = $item_arr['server_ip'];
				!isset($ip_list[$server_ip]) && $ip_list[$server_ip] = array();
				$ip_list[$server_ip][] = $sx;
			}
		}

		foreach($ip_list as $_ip => $detail)
		{
			$_sx = $detail[0];
			$ret[$_sx] = $_ip;
		}
	}

	return $ret;
}

function func_getTokenParams()
{
	$params = array();
	$t = time();
	$params['t'] = $t;
	$params['s'] = md5(INTERFACE_TOKEN.$t.INTERFACE_TOKEN);

	return http_build_query($params);
}


function func_sendStreamFile($server_url, $content='', $file='')
{
	if (empty($content) && !empty($file))
	{
		if (file_exists($file))
		{
			$content = @file_get_contents($file);
		}
	}

	if (empty($server_url) || empty($content))
	{
		return false;
	}

	$token_params_str = func_getTokenParams();
	$url = "http://".$server_url.'&'.$token_params_str;
	do_log($url, 'func_sendStreamFile');

	$content = @gzcompress($content);
	
	$opts = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'content-type:application/x-www-form-urlencoded',
            'content' => $content
        )
    );

    $context = @stream_context_create($opts);

    $cnt = 0;

    while($cnt <= 3 && ($response = @file_get_contents($url, false, $context)) === false)
    {
    	$cnt++;
    }

    return $response;
}

function func_getPostStreamData()
{
	$stream_data = isset($GLOBALS['HTTP_RAW_POST_DATA'])? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

	if(empty($streamData)){
        $stream_data = @file_get_contents('php://input');
    }

    if ('' != $stream_data)
    {
    	$stream_data = @gzuncompress($stream_data);
    }

    return $stream_data;
}

//接收文件传输
function func_receiveStreamFile($receive_file)
{
	$stream_data = func_getPostStreamData();

    if ('' != $stream_data)
    {
    	$ret = @file_put_contents($receive_file, $stream_data);
    	@chmod($receive_file, 0777);
    }
    else
    {
    	$ret = false;
    }

	return $ret;
}


function func_requestUrl($server_url, $ungz=false, $try_num=3)
{
	$date_str = date('Y-m-d H:i:s');
	$ret = array('retcode' => 0, 'retmsg' => '');
	$token_params_str = func_getTokenParams();
	$url = "http://".$server_url.'&'.$token_params_str;
	do_log($url, 'func_requestUrl', 'func_requestUrl');
	$try_num < 1 && $try_num = 1;

	$cnt = 0;
    while($cnt < $try_num && ($result = @file_get_contents($url)) === false)
    {
    	$cnt++;
    }

    $bak_result = $result;
    $result = trim($result);
	$ungz && $result = @gzuncompress($result);

	$arr = json_decode($result, true);
	$msg = !empty($arr['retmsg']) ? $arr['retmsg'] : '';

	if (!empty($arr) && 0 == $arr['retcode'])
	{
		$ret['retcode']= 0;
		!empty($arr['data']) && $ret['data'] = $arr['data'];
		$msg .= ' -- succ';
	}
	else
	{
		$ret['retcode']= !empty($arr['retcode']) ? $arr['retcode'] : 400;
		$arr = json_decode($bak_result, true);
		$msg = !empty($arr['retmsg']) ? $arr['retmsg'] : '';
		//$msg .= ' -- fail';
		$log_msg = '['.$date_str.']'. $server_url . ' -- result=' . $bak_result . ' -- fail';
		do_log($log_msg, 'func_requestUrl', 'func_requestUrl');
	}

	$ret['retmsg'] = $msg;

	return $ret;
}

function func_requestUrlPost($server_url, $ungz=false, $try_num=3, $params=array())
{
	$date_str = date('Y-m-d H:i:s');
	$ret = array('retcode' => 0, 'retmsg' => '');
	$token_params_str = func_getTokenParams();
	$url = "http://".$server_url.'&'.$token_params_str;
	do_log($url, 'func_requestUrl', 'func_requestUrl');
	$try_num < 1 && $try_num = 1;

	$content = @gzcompress($params);
		
	$opts = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'content-type:application/x-www-form-urlencoded',
            'content' => $content
        )
    );

    $context = stream_context_create($opts);

	$cnt = 0;
    while($cnt < $try_num && ($result = @file_get_contents($url,false, $context)) === false)
    {
    	$cnt++;
    }

    $bak_result = $result;
	$ungz && $result = @gzuncompress($result);

	$arr = json_decode($result, true);
	$msg = !empty($arr['retmsg']) ? $arr['retmsg'] : '';

	if (!empty($arr) && 0 == $arr['retcode'])
	{
		$ret['retcode']= 0;
		!empty($arr['data']) && $ret['data'] = $arr['data'];
		$msg .= ' -- succ';
	}
	else
	{
		$ret['retcode']= !empty($arr['retcode']) ? $arr['retcode'] : 400;
		$arr = json_decode($bak_result, true);
		$msg = !empty($arr['retmsg']) ? $arr['retmsg'] : '';
		$msg .= ' -- fail';
		$log_msg = '['.$date_str.']'. $server_url . ' -- result=' . $bak_result . ' -- fail';
		do_log($log_msg, 'func_requestUrl', 'func_requestUrl');
	}

	$ret['retmsg'] = $msg;

	return $ret;
}

//包含被合服过的游戏服列表信息
function getAllServerIncludeHefu()
{
	global $common_product_id;

	$platform_tableinfo_file = '/data/syslog/serverlist/platform_tableinfo_'.$common_product_id.'.php';
	$ret = array();

	if (file_exists($platform_tableinfo_file))
	{
		$tableInfo = array();
		require $platform_tableinfo_file;

		if (!empty($tableInfo))
		{
			foreach($tableInfo as $sid => $info)
			{
				if ($info['product_id'] != $common_product_id) continue;
				
				$server_status = $info['server_status'];
				//if ($server_status >= 2) continue;

				$url_arr = parse_url($info['login_url']);
				$server_url   = $url_arr['host'];

				$server_name = trim($info['server_name']);

				$to_region_id=0;
				$server_name = trim($info['server_name']);
				list($server_name,$to_region_id) = explode('_',$server_name);
				$server_name = trim($server_name);
				!empty($to_region_id) && $to_region_id = trim($to_region_id);

				$tmp = array();
				//$tmp['product_id'] = $info['product_id'];
				//$tmp['region_id'] = $info['region_id'];
				$tmp['server_id'] = $info['server_id'];
				$tmp['server_name'] = $server_name;
				$tmp['to_region_id'] = $to_region_id;
				$tmp['server_ip'] = $info['server_ip'];
				$tmp['server_date'] = $info['server_date'];
				$tmp['server_status'] = $server_status;
				$tmp['server_url'] = $server_url;
				$ret[$sid] = $tmp;
			}
		}
	}

	return $ret;
}

//循环活动合服目标服
function get_hefu_parent($sid, $all_servers=array())
{
	$ret = array();

	if (empty($all_servers) || empty($sid) || !isset($all_servers[$sid]))
	{
		return $ret;
	}

	$tmp_servers = $all_servers[$sid];
	
	if (!empty($tmp_servers['to_region_id']))
	{
		$to_region_id = $tmp_servers['to_region_id'];
		
		if (!empty($all_servers[$to_region_id]))
		{
			$ret = $all_servers[$to_region_id];
		}
	}	

	return $ret;
}

//缓存数据
function cache_data($data, $filename, $folder='')
{
	if (empty($filename) || empty($data))
	{
		return false;
	}

	empty($folder) && $folder = $filename;
	$path = CURRENT_PATH . '/data/cache/'. $folder . '/';
	mkdir_recyle($path);
	$cache_file = $path . $filename . '.php';
	$cur_date = date('Y-m-d H:i:s');

	//缓存数据
	$str_log = "<?php \r\n ";
	$str_log .= '//@' . $cur_date. "\r\n";
	$str_log .= "\r". ' return ' . var_export($data,true) . ";\r\n";
	$str_log .= '?>';
	@file_put_contents($cache_file, $str_log);

	@chmod($cache_file, 0777);
}

//获取缓存数据
function getCacheData($filename, $folder='')
{
	$ret = array();

	if (empty($filename))
	{
		return $ret;
	}

	empty($folder) && $folder = $filename;
	$path = CURRENT_PATH . '/data/cache/'. $folder . '/';
	$cache_file = $path . $filename . '.php';

	if (file_exists($cache_file))
	{
		$ret = require $cache_file;
	}

	return $ret;
}
