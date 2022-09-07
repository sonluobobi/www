<?php
if (!defined('KUNLUN_COM'))
{
        header('http/1.0 404 not found');
        die();
}

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

function do_log($str='', $name='golbal', $folder='')
{
	$date_str = date('Ymd'); 
	$path = PATH_LOGS;
	$folder && $path .= $folder . '/';

	mkdir_recyle($path);
	
	if (!empty($str))
	{
		$msg = '['. date('Y-m-d H:i:s') .'] -- ' .  $name . ' -- ' . $str . "\r\n";
		@file_put_contents($path.$name.'_'.$date_str.'.log', $msg, FILE_APPEND);
	}	
}

if (!function_exists('httpGetVal'))
{
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
}

function show_error($retcode=0,$retmsg='', $data=array())
{
	$ret = array();
	$ret['retcode'] = $retcode;
	$ret['retmsg'] = $retmsg;
	!empty($data) && $ret['data'] = $data;
	echo json_encode($ret);
	exit;
}

//获取字符串长度，支持中文
function get_str_len($str)
{
    preg_match_all("/./us", $str, $match);
    return count($match[0]);
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

