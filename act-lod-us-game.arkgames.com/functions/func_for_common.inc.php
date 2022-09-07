<?php
/******************************************************************************
Filename              : func_for_common.inc.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2006-07-31
Purpose               : 公用函数集
Description           :
Revisions             :

******************************************************************************/

/**
 * UM加密函数
 * @param $string
 * @param $operation
 * @param $key
 * @param $expiry
 * @return
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
	$ckey_length = 4;
	$key = md5($key ? $key : $this->system['GLOBAL_KEY']);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string.$keyb), 0, 16) . $string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();

	for($i = 0; $i <= 255; $i++)
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);

		for($j = $i = 0; $i < 256; $i++) {
	$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
	$a = ($a + 1) % 256;
	$j = ($j + $box[$a]) % 256;
	$tmp = $box[$a];
	$box[$a] = $box[$j];
	$box[$j] = $tmp;
	$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') 
	{
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} 
	else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

/**
* UM接口请求函数
	* @param $act
	* @param $info
	* @return ARRAY
	*/
function getUMReturn($act,$info,$umUserId="")
{
	if(empty($umUserId))
	{
		$umUserId = 'GMT_JDSJ';
    }
    
    $info = base64_encode(urlencode(authcode(serialize($info),'ENCODE','UM@KunLun$SubSystem')));
    
    $http_url = "http://um2.kunlun.com/manage.php?act=iServer.simLogin&info=".$info.'&system='.$umUserId.'&sign='.md5('UM@KunLun$SubSystem&info='.$info);
    $return = file_get_contents($http_url);
    return json_decode($return,TRUE);
}

//调试函数
function debug($arrStr)
{
	echo "<div align=\"left\">";
	echo '<pre>';
	print_r($arrStr);
	echo '</pre>';
	echo "</div>";
}
//调试函数以html注释输出
function debugHtml($str)
{
	echo '<!--' . $str . '-->';
}
/**
 * 打印错误提示页面
 *
 * @access public
 * @param string $error 错误信息
 */
function displayError($error = "")
{
	$tpl_error = new smartTemplate("display_error.html");

	$tpl_error->assign("error", $error);
	$tpl_error->output();

	exit;
}

//检查字符串是否都为英文
/*
params :
	$str : 要检查的字符串
return ：true/false
*/
function ifAllEnglish($str)
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
function issetStr($value)
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
/**
* 截取UTF8字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $sourcestr    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @return string
*/
function cutString($source_str, $cut_length =10)
{
	$return_str = ''; //返回的字符串
	$i = 0;
	$n = 0;
	$str_length = strlen($source_str);//字符串的字节数 原来串的长度

	//echo $str_length . '<br><br>';

	while (($n < $cut_length) and ($i <= $str_length))
	{
		$temp_str = substr($source_str, $i, 1); //取出第一个字节

		$asc_num = Ord($temp_str);	//得到字符串中第$i位字符的ascii码
		if ($asc_num >= 224)		//如果ASCII位高于224，
		{
			//根据UTF-8编码规范，将3个连续的字符计为单个字符
			$return_str .= substr($source_str, $i, 3);
			$i += 3;		//实际Byte计为3
			$n++;			//字串长度计1
		}
		elseif ($asc_num >= 192) //如果ASCII位高于192，
		{
			//根据UTF-8编码规范，将2个连续的字符计为单个字符
			$return_str .= substr($source_str,$i,2);
			$i += 2;		//实际Byte计为2
			$n++;			//字串长度计1
		}
		elseif ($asc_num >= 65 && $asc_num <= 90) //如果是大写字母，
		{
			$return_str .= substr($source_str,$i,1);
			$i += 1;		//实际的Byte数仍计1个
			$n++;			//但考虑整体美观，大写字母计成一个高位字符
		}
		else				//其他情况下，包括小写字母和半角标点符号，
		{
			$return_str .= substr($source_str, $i, 1);
			$i += 1;		//实际的Byte数计1个
			$n = $n + 0.5;	//小写字母和半角标点等与半个高位字符宽...
		}
	}
	if ($str_length > $i)
	{
		$return_str = $return_str . '...';//超过长度时在尾处加上省略号
	}

    return $return_str;
}
/**
 * 去除 字符串 两边的空格并 html 编码
 *
 * @access public
 * @param string $text 待处理的字符串
 * @return string 处理完成后的字符串
 */
function htmlTrim($text)
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
function mkDirs($strPath = '', $mode = 777)
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
function getIP()
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
function getMicrotime()
{
	list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}

/**
 * 用GD生成高度不超过$height的缩略图
 *	支持jpeg gif png 图片生成宿略图
 *	输出jpeg格式
 * @param int width
 * @param int height
 * @param string src_path
 * @param string thumb_out_path
 * @return bool
 */
function generateThumb($src_path, $thumb_out_path, $width, $height)
{
	if (false === file_exists($src_path))
		return false;
	if (false === file_exists(dirname($thumb_out_path)) && !mkDirs(dirname($thumb_out_path)))
		return false;
	if ($thumb_out_path == '' || $width == '' || $height == '')
		return false;

	// Get new dimensions
	list($width_orig, $height_orig) = getimagesize($src_path);

	if ($width && ($width_orig < $height_orig)) {
	    $width = ($height / $height_orig) * $width_orig;
	} else {
	    $height = ($width / $width_orig) * $height_orig;
	}

	// Resample
	$extname = substr(basename($src_path), strrpos(basename($src_path), '.')+1);
	$image = null;
	if ($extname == "jpg")
		$extname = "jpeg";
	if ($extname == "jpeg")
		$image = imagecreatefromjpeg($src_path);
	else if ($extname == "png")
		$image = imagecreatefrompng($src_path);
	else if ($extname == "gif")
		$image = imagecreatefromgif($src_path);
	else {
		die("图片扩展名无效($src_path)");
		return false;
	}

	$image_p = imagecreatetruecolor($width, $height);
	if (!imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig)) {
		if (!imagecopyresized($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig)) {
			die("生成宿略图失败，请刷新页面重试一下");
			return false;
		}
	}

	// Output
	$fun = "image$extname";
	return $fun($image_p, $thumb_out_path);
}

function randCode($len=6, $format='ALL') {
	switch($format) {
		case 'ALL':
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
			break;
		case 'CHAR':
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~';
			break;
		case 'NUMBER':
			$chars='0123456789';
			break;
		default :
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
			break;
	}
    mt_srand((double)microtime()*1000000*getmypid()); // seed the random number generater (must be done)
    $password='';
    while(strlen($password)<$len)
        $password .= substr($chars, (mt_rand()%strlen($chars)), 1);
    return $password;
 }

 function formatTODate($date) {
	$year   = substr($date, 0, 4); //年
	$month  = substr($date, 4, 2); //月
	$day    = substr($date, 6, 2); //日
	$hour   = substr($date, 8, 2); //时
	$minute = substr($date, 10, 2); //分
	$second = substr($date, 12, 2); //秒
	$format_date = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minute . ':' . $second;

	return $format_date;
}
function formatDateToInt($date) {
	$arr = explode(' ', trim($date));
	$arr_date = explode('-', $arr[0]);
	$arr_time = explode(':', $arr[1]);

	return $arr_date[0].$arr_date[1].$arr_date[2].$arr_time[0].$arr_time[1].$arr_time[2];
}

/**
 * 记录数据到文件中
 */
function write2File($full_path, $str_log, $mode='wb')
{
//	if (is_writable($full_path)) {
		if ($full_path AND $str_log)
		{
			$file_handle = @fopen($full_path, $mode);
			if($file_handle)
			{
				@fwrite($file_handle, $str_log);
				@fclose($file_handle);
				return true;
			}

		}
//	}
//	return false;
}

function formatLog($module, $opt)
{
	return "[" . date('Y-m-d H:i:s') . "] [User:" . $_SESSION['username'] . "] " . $opt . "\"" .  $module . "\"" . "\n";
}

function operationLog($log)
{
	@write2File(OPERATION_LOG_DIR . DIRECTORY_SEPARATOR . "operation_log_" . date('Y-m-d') . '.log', $log, 'ab');
//	@write2File(ACTIVITY_DIR . DIRECTORY_SEPARATOR . "operation_log_" . date('Y-m-d') . '.log', $log, 'ab');
}

function log2File($module,$log=null)
{
	$log_file = $module."_".date('Y-m-d').'.log';
		
	$ip = getIP();
	
	if ($log) {
		$log = "[" . date('Y-m-d H:i:s') . "]account=".$_SESSION['username']."|name=".$_SESSION['accountname']."|ip=".$ip."|".$log."\r\n";
	}else {
		$log = "[" . date('Y-m-d H:i:s') . "]account=".$_SESSION['username']."|name=".$_SESSION['accountname']."|ip=".$ip."\r\n";
	}	
	
	$realpath = OPERATION_LOG_DIR . DIRECTORY_SEPARATOR . $log_file;
	@write2File($realpath, $log, 'ab');
}

/**
 * 远程调用
 * @param $act
 * @param $server_domain
 * @param $opcode
 */
function rpc_request($act, $server_domain)
{
	global $RPC_REQUEST_PORT;

	$ch = curl_init();

	$options = array(CURLOPT_URL => "http://" . $server_domain . "/webproxy.php",
									CURLOPT_RETURNTRANSFER => 1,
									CURLOPT_POST => 1,
									CURLOPT_CONNECTTIMEOUT => 2,
									CURLOPT_TIMEOUT  => 3,
									CURLOPT_POSTFIELDS => array(
									//	"baseHost" => $server_domain,//'10.22.173.11',
										"port"    => $RPC_REQUEST_PORT ,
										"act"     => json_encode($act),
										),
									);

	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);

	file_put_contents("/tmp/liao_act.log","----------------------------------------------------------------------------------------------\n",FILE_APPEND);
	file_put_contents("/tmp/liao_act.log",date('Y-m-d H:i:s')."\n",FILE_APPEND);
	//file_put_contents("/tmp/liao_act.log",var_export($options,true)."\n",FILE_APPEND);
	file_put_contents("/tmp/liao_act.log",$server_domain."\n",FILE_APPEND);
	file_put_contents("/tmp/liao_act.log","result=>".var_export($result,true)."\n",FILE_APPEND);

	if(curl_errno($ch) > 0)
	{
		$retmsg = curl_error($ch);
		file_put_contents("/tmp/liao_act.log",$retmsg,FILE_APPEND);
		curl_close($ch);
		$result = array("rsp_code_id"=>1,'retmsg'=>$retmsg);
		return $result;
	}
	file_put_contents("/tmp/liao_act.log","----------------------------------------------------------------------------------------------\n",FILE_APPEND);

	$result = json_decode(trim($result),true);
	curl_close($ch);
	if(!is_array($result) && !is_object($result))
	{
		$result = array("rsp_code_id"=>1,'retmsg'=>" 发布数据失败,数据包太大或者游戏服域名无效或者域名还未解析成功");
	}
	else
	{
		if ($result['rsp_code_id'] != 0)
		{
			if(is_integer(strpos($result['retmsg'],'connect to host')))
			{
				$result['retmsg'] = " 连接目标服务器 ".$server_domain." 失败，请找莫吉林或者李蔷薇支持。";
			}
			elseif (is_integer(strpos($result['retmsg'],'this ip is not allowed')))
			{
				$result['retmsg'] = $result['retmsg']." ，请找莫吉林支持。";
			}
			else
			{
				$result['retmsg'] = $result['msg'];
			}
		
			$result = array("rsp_code_id"=>1,'retmsg'=>$result['retmsg']);
		}
	}
	
	return $result;
}

function getNpcTitleById($npc_id)
{
	global $ACTIVITY_NPC_CONFIG;

	$npc_title = "";
	foreach ($ACTIVITY_NPC_CONFIG as $config)
	{
		if ($config['id'] == $npc_id) {
			$npc_title = $config['title'];
			break;
		}
	}
	return $npc_title;
}

/**
 * 获取服务器列表
 * @param unknown_type $selected_server_arr
 * @return multitype:multitype:unknown multitype:multitype:number unknown
 */
function getServerList($selected_server_arr = array())
{
	$arr_server_list = array();
	$all_server_arr  = parse_ini_file(SERVER_LIST_FILE,true);

	foreach ($all_server_arr as $type => $item_arr)
	{
		$server_item = array();
		$server_item['server_name'] = $type;
		$server_item['title']       = $item_arr['title'];

		$arr_server_ids = array();
		$arr_ids = array();
		$server_id_str  = "";

		foreach ($item_arr['server_for_act'] as $key=>$value)
		{
			$arr_ids[$key] = $value;
		}

		foreach($arr_ids as $id => $name)
		{
			$hit = isset($selected_server_arr[$id]) ? 1 : 0;
			list($sx , $tmp_server_name) = explode(' ',$name,2);
			$arr_server_ids[] = array('serv_id'=>$id,'hit'=>$hit, 'serv_name' => $sx);
		}
		$server_item['server_ids'] = $arr_server_ids;

		$arr_server_list[] = $server_item;
	}

	return $arr_server_list;
}


/**
 * 获取活动服务器列表
 * @param unknown_type $selected_server_arr
 * @return multitype:multitype:unknown multitype:multitype:number unknown
 */
function getActServerList($selected_server_arr = array(), $special_server_arr=array())
{
	$arr_server_list = array();
	$all_server_arr  = parse_ini_file(SERVER_LIST_FILE,true);

	foreach ($all_server_arr as $type => $item_arr)
	{
		$server_item = array();
		$server_item['server_name'] = $type;
		$server_item['title']       = $item_arr['title'];
		$server_item['select_state']   = '';

		$arr_server_ids = array();
		$arr_ids = array();
		$server_id_str  = "";

		foreach ($item_arr['server_for_act'] as $key=>$value)
		{
			$arr_ids[$key] = $value;
		}

		if (!empty($special_server_arr))
		{
			$arr_ids += $special_server_arr;
		}

		$checked = 1;
		foreach($arr_ids as $id => $name)
		{
			$hit = isset($selected_server_arr[$id]) ? 1 : 0;
			$arr_server_ids[] = array('serv_id'=>$id,'hit'=>$hit, 'serv_name' => $name);

			if ($hit == 0) $checked = 0;
		}

		if (count($arr_ids))
		{
			$server_item['select_state']   = $checked;
		}

		$server_item['server_ids'] = $arr_server_ids;

		$arr_server_list[] = $server_item;
	}

	return $arr_server_list;
}



function html2json($str)
{
	$result = array();

	if (preg_match_all('|<p>(.*)</p>|U',$str,$output))
	{
		if ($output[1])
		{
			foreach ($output[1] as $key=>$item)
			{
				$content = strip_tags($item, '<link>');
				//$content = urlencode($content);

				$result[$key] = array();
				if (is_integer(strpos($item,'href')))
				{
					$tmp_arr = explode('">',$item);
					if (is_array($tmp_arr) && count($tmp_arr) > 1)
					{
						foreach ($tmp_arr as $tmp_item)
						{
							if (is_integer(strpos($tmp_item,'style')))
							{
								$str_arr = explode('="',$tmp_item);
								$style = explode(":",$str_arr[1]);
								if (is_integer(strpos($style[0],'size')))
								{
									$size = trim(str_replace(array('px',';'),'',$style[1]));
									$result[$key]['size'] = substr($size,0,-1);
								}
								elseif (is_integer(strpos($style[0],'color')))
								{
									$color = $style[1];
									$color = substr($color,0,-1);
									if (is_integer(strpos($color,'rgb')))
									{
										$color = rgb2hex(str_replace('rgb','array',$color));
									}
									$color = str_replace(";","",$color);
									$result[$key]['color'] = $color;
								}
							}
							elseif (strpos($tmp_item,'href'))
							{
								$str_arr = explode('href="',$tmp_item);
								$href = $str_arr[1];
								$result[$key]['href'] = $href;
							}
						}
					}
					$result[$key]['content'] = $content;
				}
				elseif (is_integer(strpos($item,'style')))
				{
					$tmp_arr = explode('">',$item);

					if (is_array($tmp_arr) && count($tmp_arr) > 1)
					{
						foreach ($tmp_arr as $tmp_item)
						{
							if (strpos($tmp_item,'style'))
							{
								$str_arr = explode('="',$tmp_item);
								$style = explode(":",$str_arr[1]);

								if (is_integer(strpos($style[0],'size')))
								{
									$size = trim(str_replace(array('px',';'),'',$style[1]));
									$result[$key]['size'] = $size;
								}
								elseif (is_integer(strpos($style[0],'color')))
								{
									$color = trim($style[1]);

									if (is_integer(strpos($color,'rgb')))
									{
										$search = array('rgb(',')');
										$tmp = str_replace($search,'',$color);
										$tmp = explode(",",$tmp);

										$color = rgb2hex($tmp);
									}
									$color = str_replace(";","",$color);
									$result[$key]['color'] = $color;
								}
							}
						}
					}

					$result[$key]['content'] = $content;
				}
				else
				{
					$result[$key]['content'] = $content;
				}
			}
		}
	}

	return json_encode($result);
}


function rgb2hex($r, $g=-1, $b=-1)
{
	$prefix = '#';
	if (is_array($r) && sizeof($r) == 3)
		list($r, $g, $b) = $r;
	$r = intval($r); $g = intval($g);
	$b = intval($b);
	$r = dechex($r<0?0:($r>255?255:$r));
	$g = dechex($g<0?0:($g>255?255:$g));
	$b = dechex($b<0?0:($b>255?255:$b));
	$color = (strlen($r) < 2?'0':'').$r;
	$color .= (strlen($g) < 2?'0':'').$g;
	$color .= (strlen($b) < 2?'0':'').$b;

	return $prefix.$color;
}

function json2html($json_str)
{
	$str = '';
	$data_arr = json_decode($json_str,true);
	if (is_array($data_arr) && count($data_arr) > 0)
	{

		foreach ($data_arr as $data)
		{
			$html = '';
			$size    = $data['size'];
			$color   = $data['color'];
			//$content = urldecode($data['content']);
			$content = $data['content'];
			$href    = $data['href'];

			if ($content)
			{
				$html = $content;
			}

			if ($size)
			{
				$html = '<span style="font-size:'.$size.';">'.$html.'</span>';
			}

			if ($color)
			{
				$html = '<span style="color:'.$color.';">'.$html.'</span>';
			}

			if ($href)
			{
				$html = '<a href="'.$href.'">'.$html.'</a>';
			}
			$html = '<p>'.$html.'</p>';
			$str .= $html;
		}
	}
	return $str;

}

/**
 * 活动数据发布是否处于开放状态
 */
function isActDataPublishOpen()
{
	if (ACT_PUBLISH_OPEN == true)
	{
		return 1;
	}
	else
	{
		$week = date('w');
		$hour = date('H');
		if ($week >0 && $week < 6)
		{
			if ($hour >=10 && $hour < 19) {
				return 1;
			}else {
				return 0;
			}
		}
		return 0;
	}
}

//获取装备列表
function getEquipIdTitleMap()
{
	$target_file = ACTIVITY_DIR.'/EquipBase.inc';
	$equip_list = require $target_file;
	$ret = array();
	
	if ($equip_list)
	{
		foreach($equip_list as $equip_id => $detail)
		{
			$ret[$equip_id] = $detail['title'];
		}
	}	

	return $ret;
}

function checkEquips($reward_equip_arr)
{
	if (empty($reward_equip_arr))
	{
		return false;
	}

	foreach ($reward_equip_arr as $reward_equips)
	{
		$equip_arr = explode(",",$reward_equips);
		if (count($equip_arr) != 2) return false;

		if (!is_numeric($equip_arr[1])) return false;
	}

	return true;
}

function comm_check_equips($reward_equip_arr)
{
	if (!checkEquips($reward_equip_arr))
	{
		Redirect('', '道具格式配置有误！', 1);
	}
}

function curl_single($func,$server_url, $data=array(),$log_folder='act')
{
	if (empty($func) || empty($server_url))
	{
		return array('retcode' => 1, 'retmsg' => '参赛错误');
	}

	$ch = curl_init();

	if (defined('OPERATION_LOG_DIR'))
	{
		$data_path = OPERATION_LOG_DIR . '/';
	}
	else
	{
		$data_path = '/tmp/';
	}

	empty($log_folder) && $log_folder = 'act';
	$data_path .= $log_folder . '/';

	if (!file_exists($data_path))
	{
		@mkdir($data_path, 755, true);
	}
	
	$filename = $data_path . $log_folder . '_' . date('Ym').'.log';

	$curl_data = json_encode($data);
	$url = $server_url . "/webproxy.php?act=$func";
	file_put_contents($filename, date('Y-m-d H:i:s') . ' -- url='.$url."\n",FILE_APPEND);

	$options = array(CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_CONNECTTIMEOUT => 2,
			CURLOPT_TIMEOUT  => 5,
			CURLOPT_POSTFIELDS => array(
					"data"     => gzcompress($curl_data),
			),
	);

	curl_setopt_array($ch, $options);
	$response = curl_exec($ch);
	curl_close($ch);

	//file_put_contents($filename,"response=>".$response."\n",FILE_APPEND);
	$response = json_decode($response,true);

	file_put_contents($filename,"result=>".var_export($response,true)."\n",FILE_APPEND);

	$result = array();

	if (empty($response) || !is_array($response))
	{
		$result['retcode'] = 1;
		$result['retmsg'] = '设置失败，游戏服没有返回数据。';
	}
	elseif ($response['retcode'] != 0)
	{
		$result['retcode'] = 1;
		$result['retmsg']  = empty($response['retmsg']) ? 'no msg' : $response['retmsg'];
		$result['data']    = empty($response['data']) ? array() : $response['data'];
	}
	else
	{
		$result['retcode'] = 0;
		$result['retmsg']  = 'success';
		$result['data']    = empty($response['data']) ? array() : $response['data'];
	}

	return $result;
}

function get_server_list($key='')
{
	$ret = array();
	$server_list = require_once SERVER_LIST_DATA_FILE;

	foreach ($server_list as $tmp_server_id=>$item)
	{
		if ($item['server_status'] <= 1) 
		{
			if ($key && $item[$key])
			{
				$ret[$tmp_server_id] = $item[$key];
			}
			else
			{
				$ret[$tmp_server_id] = $item;
			}
		}
	}

	return $ret;
}

//格式化href to link 标签
function format_href_to_link($str)
{
	$bak_str = trim($str);
	if (empty($bak_str)) return $str;

	$pattern ="/<a href=\"(.*?)\".*?>(.*?)<\/a>/i";
	preg_match_all($pattern, $str, $matches);

	if (!empty($matches) && !empty($matches[0]))
	{
		$pattern_data = $matches[0];
		$cnt = count($pattern_data);

		for($i=0; $i<$cnt; $i++)
		{
			$str_find = $pattern_data[$i];
			$tmp_url = trim($matches[1][$i]);
			$tmp_text = $matches[2][$i];
			$str_replace = '<link id=href&url='.$tmp_url.' text='.$tmp_text.'>';
			$str = str_replace($str_find, $str_replace, $str);
		}
	}

	return $str;
}

//格式化link to href 标签
function format_link_to_href($str)
{
	$bak_str = trim($str);
	if (empty($bak_str)) return $str;

	$pattern = "/<link.*?url=(.*?)text=(.*?)>/i";
	preg_match_all($pattern, $str, $matches);

	if (!empty($matches) && !empty($matches[0]))
	{
		$pattern_data = $matches[0];
		$cnt = count($pattern_data);

		for($i=0; $i<$cnt; $i++)
		{
			$str_find = $pattern_data[$i];
			$tmp_url = trim($matches[1][$i]);
			$tmp_text = $matches[2][$i];
			$str_replace = '<a href="'.$tmp_url.'">'.$tmp_text.'</a>';
			$str = str_replace($str_find, $str_replace, $str);
		}
	}

	return $str;
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
	
	return $value;
}


function func_do_log($str='', $name='golbal', $folder='base')
{
	$date_str = date('Ymd'); 
	$path = LOGS_DIR . '/';
	$folder && $path .= $folder . '/';

	if (is_dir($path) && !empty($str))
	{
		$file = $path.$name.'_'.$date_str.'.log';
		$msg = '['. date('Y-m-d H:i:s') .'] -- ' .  $name . ' -- ' . $str . "\r\n";
		@file_put_contents($file, $msg, FILE_APPEND);
	}	
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
	func_do_log($url, 'func_sendStreamFile');

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


function func_requestUrl($server_url, $ungz=false)
{
	$date_str = date('Y-m-d H:i:s');
	$msg = '['.$date_str.']begin -- '. $server_url . ' -- ';
	$ret = array('retcode' => 0, 'msg' => '');
	$token_params_str = func_getTokenParams();
	$url = "http://".$server_url.'&'.$token_params_str;
	func_do_log($url, 'func_requestUrl');
	//$result = @file_get_contents($url);

	$cnt = 0;
    while($cnt <= 3 && ($result = @file_get_contents($url)) === false)
    {
    	$cnt++;
    }

	$ungz && $result = @gzuncompress($result);

	$arr = json_decode($result, true);
	$msg .= !empty($arr['retmsg']) ? $arr['retmsg'] : '';

	if (!empty($arr) && 0 == $arr['retcode'])
	{
		$ret['retcode']= 0;
		!empty($arr['data']) && $ret['data'] = $arr['data'];
		$msg .= ' -- succ';
	}
	else
	{
		$ret['retcode']= !empty($arr['retcode']) ? $arr['retcode'] : 400;
		$msg .= '--fail -- result=' . $result . ' -- end['.date('Y-m-d H:i:s').']';
	}

	$ret['msg'] = $msg;

	return $ret;
}

/**
 * 多进程处理活动发布
 * @param array $nodes = array(
 * 								array('server_id'=>,'server_domain'=>,'act'=>),
 * 								array('server_id'=>,'server_domain'=>,'act'=>),
 * )
 * @return array 
 */
function func_multiple_request_handle($node_list, $sign='multiple')
{
	global $ALL_CONFIG_SERVER;
	
	$mh = curl_multi_init();
	
	$dead_urls      = array();
	$results        = array();
		
	/***************** 处理返回结果 START *******************************************************/
	$retmsg = '';
	$file_log = OPERATION_LOG_DIR . '/multiple_' .$sign . '_'. date('Ymd') . '.log';
	
	@file_put_contents($file_log,"------------------------------------- START -----------------------------------------------\n",FILE_APPEND);
	
	$len = 30;
	$offset = 0;
	$size = count($node_list);
		
	while ($offset < $size)
	{
		$nodes = array_slice($node_list, $offset,$len);
		$offset += $len;
	
		$arr_ch = array();
		
		foreach($nodes as $i => $item)
		{
			$arr_ch[$i] = curl_init();
	
			$act = $item['act'];

			$server_domain = $item['server_domain'];
			$func = $act['op'];
			unset($act['op']);
	
			$data = json_encode($act);
			$url = "http://" . $server_domain . "/webproxy.php?act=$func";
			@file_put_contents($file_log,"url = $url \n",FILE_APPEND);
			//@file_put_contents($file_log,"data = $data \n",FILE_APPEND);
	
			$options = array(CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_POST => 1,
					//CURLOPT_CONNECTTIMEOUT => 3,
					//CURLOPT_TIMEOUT  => 4,
					CURLOPT_POSTFIELDS => array(
							"data"     => @gzcompress($data),
					),
			);
				
			curl_setopt_array($arr_ch[$i], $options);
			curl_multi_add_handle($mh, $arr_ch[$i]);
		}
		
		$running = NULL;
		
		do {
			usleep(10000);
			curl_multi_exec($mh,$running);
		} while($running > 0);
		
		
		foreach ($arr_ch as $handle)
		{
			$chinfo = curl_getinfo($handle);
				
			$cur_url   = $chinfo['url'];
			$http_code = $chinfo['http_code'];
				
			$arr_info = parse_url($cur_url);
			$server_domain = $arr_info['host'];
			$sx = strstr($server_domain, '.', true);
				
			$results[$server_domain] = array();
			$results[$server_domain]['retcode']   = 0;
			$results[$server_domain]['retmsg']    = 'OK';
				
			if ($http_code == 200)
			{
				//获取执行结果
				$ret_curl = curl_multi_getcontent($handle);
				
				@file_put_contents($file_log,"-------------------------------------------------------------\r\n",FILE_APPEND);
				@file_put_contents($file_log,$server_domain."\r\n",FILE_APPEND);
				@file_put_contents($file_log,date('Y-m-d H:i:s')."\r\n",FILE_APPEND);
				@file_put_contents($file_log,"result=>".var_export($ret_curl,true)."\r\n",FILE_APPEND);
			
				if (curl_errno($handle) > 0)
				{
					$msg = curl_error($mhinfo['handle']);
					$results[$server_domain]['retcode'] = -1;
					$results[$server_domain]['retmsg']  = $msg;
			
					@file_put_contents($file_log, $msg."\r\n",FILE_APPEND);
				}
				else
				{
					$ret_curl = json_decode(trim($ret_curl),true);
					@file_put_contents($file_log,"result_decode=>".var_export($ret_curl,true)."\r\n",FILE_APPEND);
					
					if(empty($ret_curl))
					{
						$results[$server_domain]['retcode'] = -1;
						$results[$server_domain]['retmsg']  = " 发布数据失败,数据包太大或者游戏服域名无效或者域名还未解析成功";
					}
			
					if ($ret_curl['retcode'] != 0)
					{
						$results[$server_domain]['retcode'] = -1;
						$results[$server_domain]['retmsg']  = $ret_curl['retmsg'];
					}
					elseif ($ret_curl['rsp_code_id'] != 0)
					{
						$results[$server_domain]['retcode'] = -1;
			
						if(is_integer(strpos($ret_curl['retmsg'],'connect to host')))
						{
							$results[$server_domain]['retmsg']  = " 连接目标服务器 ".$server_domain." 失败，请找莫吉林或者李蔷薇支持。";
						}
						else
						{
							$results[$server_domain]['retmsg'] = $ret_curl['msg'];
						}
					}
			
				}

				if ($results[$server_domain]['retcode'] != 0 && !empty($ALL_CONFIG_SERVER[$sx]))
				{
					!empty($ALL_CONFIG_SERVER[$sx]['sname']) && $results[$server_domain]['retmsg'] = $ALL_CONFIG_SERVER[$sx]['sname'] . ' -- ' . $results[$server_domain]['retmsg']; 
				}
			
				@file_put_contents($file_log,"retmsg==>".$results[$server_domain]['retmsg']."\r\n",FILE_APPEND);
				@file_put_contents($file_log,"-------------------------------------------------------------\r\n\r\n",FILE_APPEND);
			}
			else 
			{
				$dead_urls[]= $chinfo;
			}
			
			// 12. 移除句柄
			curl_multi_remove_handle($mh, $handle);

			curl_close($handle);
		}
		
	}
	
	if ($dead_urls)
	{
	    foreach ($dead_urls as $url)
	    {
	        $arr_parse = parse_url($url['url']);
	        $server_domain = $arr_parse['host'];
	        $sx = strstr($server_domain, '.', true);

	        $results[$server_domain]['retcode'] = -1;
	        $results[$server_domain]['retmsg'] = "连接游戏服失败";

	        if (!empty($ALL_CONFIG_SERVER[$sx]) && !empty($ALL_CONFIG_SERVER[$sx]['sname']))
			{
				$results[$server_domain]['retmsg'] = $ALL_CONFIG_SERVER[$sx]['sname'] . ' -- ' . $results[$server_domain]['retmsg']; 
			}
	    }
	    
		@file_put_contents($file_log, "invalid_urls==>".var_export($dead_urls,true)."\r\n",FILE_APPEND);
	}
		
	//关闭连接句柄
	curl_multi_close($mh);
		
	return $results;
}

function setNewHeaderModule()
{
	$str = <<<HEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="zhongsy">
<meta http-equiv="pragma" content="no-cache">
<link href="style/cp.css" rel="stylesheet" type="text/css">
<link href="style/pager.css" rel="stylesheet" type="text/css">
<link href="style/note.css" rel="stylesheet" type="text/css">
<link type="text/css" href="style/redmond/jquery-ui-1.7.2.custom.css" rel="Stylesheet" />	
<link rel="stylesheet" type="text/css" href="style/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="style/jquery-ui-timepicker-addon.min.css" />

<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src='js/jquery.autocomplete.pack.js'></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.min.js"></script>

<script>jQuery.noConflict();</script>
<title>魔域2活动管理平台</title>
</head>

<body>
<div class="main">
HEADER;

	return $str;
}

?>
