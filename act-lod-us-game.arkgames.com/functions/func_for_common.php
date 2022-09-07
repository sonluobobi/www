<?php
/******************************************************************************
Filename              : func_for_common.inc.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2006-07-31
Purpose               : 公用函数集
Description           : 
Revisions             :

******************************************************************************/

if (!defined('WX_KUNLUN_COM'))
{
	header('http/1.0 404 not found');
	die();
}



//调试函数以html注释输出
function DebugHtml($arrStr)
{
	echo "\n\n";
	echo '<!--';
	print_r($arrStr);
	echo '-->';
}

//检查字符串是否都为英文
/*
params : 
	$str : 要检查的字符串
return ：true/false
*/
function IfAllEnglish($str)
{
	for ($i = 0, $strLength = strlen($str); $i < $strLength; $i++)
	{
		if (122 < ord($str{$i}))
			return false;
	}
	return true;
}
/**
 * 检查 $value 已 assign 且不为空
 * 
 * @access public 
 * @param mixd $value 
 * @return bool 
 */
function IssetStr($value) 
{
	if (isset($value) AND $value != "") 
		return true;
	else
		return false;
} 
//截取字符串
/*
params : 
	$string : 要裁减的字符串
	$strLen ：裁减长度
	$extra	: 补充字符串
	
return ：string
*/
function CutString($string, $strLen = 20, $extra = "...") 
{
	for ($i = 0; $i < $strLen; $i++) 
	{
		if (ord($string{$i}) > 127) 
			$j++;
	}
	if ($j % 2 != 0) 
		$strLen++;

	$rstr = substr($string, 0, $strLen);
	if ($extra != "" AND strlen($string) > $strLen)
		$rstr .= $extra;
	
	return $rstr;
}
/**
 * 去除 字符串 两边的空格并 html 编码
 *
 * @access public
 * @param string $text 待处理的字符串
 * @return string 处理完成后的字符串
 */
function HtmlTrim($text) 
{
/*
'&' (ampersand) becomes '&amp;'
'"' (double quote) becomes '&quot;' when ENT_NOQUOTES is not set.
''' (single quote) becomes '&#039;' only when ENT_QUOTES is set.
'<' (less than) becomes '&lt;'
'>' (greater than) becomes '&gt;'
*/
        /*

	$text = trim($text);
	$text = str_replace('&','&amp',$text);
	$text = str_replace('"','&quot',$text);
	$text = str_replace('\'','&#039',$text);
	$text = str_replace('<','&lt;',$text);
	$text = str_replace('>','&gt;',$text);

	return $text;
*/
	return htmlspecialchars(trim($text), ENT_COMPAT, 936);
} 
/**
 * function : 创建目录(递归生成目录)
 * params : 
 * 	$strPath : 路径
 *  $mode : 模式
 * return : bool
 */
function MkDirs($strPath = '', $mode = 777) 
{
	if (is_dir($strPath)) 
		return true;

	$pStrPath = dirname($strPath);
	if (!MkDirs($pStrPath, $mode)) 
		return false;
	
	return mkdir($strPath);
}

/**
 * 获取客户端 ip 地址
 * 
 * @access public 
 * @return string 
 */
function GetIP() 
{
	if (isset($_SERVER)) 
	{
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) 
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		elseif (isset($_SERVER["HTTP_CLIENT_IP"]))
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		else
			$realip = $_SERVER["REMOTE_ADDR"];
	}
	else 
	{
		if (getenv('HTTP_X_FORWARDED_FOR')) 
			$realip = getenv('HTTP_X_FORWARDED_FOR');
		elseif (getenv('HTTP_CLIENT_IP')) 
			$realip = getenv('HTTP_CLIENT_IP');
		else
			$realip = getenv('REMOTE_ADDR');
	}
	return $realip;
}

/**
 * function : 取当前时间
  * return : string
 */
function GetMicrotime()
{
	list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
}

/**
 * function : 将配置转化成队列
 * params : setting : array
 * 			default : array 被选中的
 * return : array
 */
function Setting2Array($arr_setting, $arr_selectd = array())
{
	if (!is_array($arr_setting))
		return array();
	
	foreach($arr_setting AS $key => $value)
	{
		$data['value'] = $key;
		$value = Utf82GB($value);
		$data['text']  = $value;
		
		if (in_array($key, $arr_selectd))
			$data['status']  = 'selected';
		else
			$data['status']  = '';
		
		$arr_data[] = $data;
	}
	
	return $arr_data;
}

/**
 * function : 将UTF-8转化成gb2312
 * params : string
 * return : string
 */
function Utf82GB($str)
{
	$str = iconv('utf-8', 'gbk//IGNORE', $str);
	
	return $str;
}

/**
 * function : 将gb2312转化成UTF-8
 * params : string
 * return : string
 */
function GB2Utf8($str)
{
	$str = iconv('gbk', 'utf-8//IGNORE', $str);
	
	return $str;
}
?>