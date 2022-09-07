<?php

class Utils 
{
	
	public static function str_is_int($str)
	{
		if(strlen($str) == 0)
		{
			return false;
		}		
		return strcmp($str,intval($str))==0;
	}
	
	public static function echo_msg($msg)
	{		
		$html = "<html encoding='utf-8'><font color='RED'>$msg</font></html>";		
		die($html); 
	}

	public static function array_2_str(array $arr,$depth)
	{
		$sp = '';
		for($i=0;$i<$depth;$i++)
		{
			$sp .= '	';
		}
		$enter = "\r\n";
		
		$str  = 'array' .$enter;
		$str .= $sp . '('. $enter;
		$sp  .= '	';
		foreach($arr as $key => &$value)
		{	
			if(!is_numeric($key))
			{
				$key = str_replace('"','\\"',$key);
				$key = '"' . $key . '"';
			}
			
			if(is_array($value))
			{
				$str_value = self::array_2_str($value,$depth+1);
				$str .= $sp . "$key => $str_value," . $enter;	
			}else 
			{
				if(is_object($value))
				{
					$str_value = "'" . serialize($value) . "'" ;
				}else
				{
					$str_value = '"' . $value .'"';
				}			
				$str .= $sp . "$key => $str_value," . $enter;		
			}
		}		
		$str .= substr($sp,1) .')';		
		return $str;		
	}
	
	public static function mkDirs($strPath = '', $mode = 777) 
	{
		if (is_dir($strPath)) 
			return true;

		$pStrPath = dirname($strPath);
		if (!self::MkDirs($pStrPath, $mode)) 
			return false;
		
		return mkdir($strPath);
	}
	
	public static function getConfigCode($server,$order_by)
	{
		
/*		if($server == 'kxw')
		{
			if($order_by == 1)
				return 92701;
			if($order_by == 2)
        	                return 92702;
			if($order_by == 3)
                                return 92749;
			if($order_by == 6)
                                return 92748;

		}	
*/
		if(!$_SESSION['xxfy_code_cache'])
		{
			$_SESSION['xxfy_code_cache'] = array();
		}
		$code_cache = &$_SESSION['xxfy_code_cache'];
		
		$server_id = $server . '-' . $order_by;
		if(isset($code_cache[$server_id]) and $code_cache[$server_id])
		{
			$code = $code_cache[$server_id];
			return $code;
		}
		
		if($server == 'all')
		{
			return 0;	
		}
		elseif($server == 't')
		{
			$url = GAME_SERVER_URL_FOR_CONFIG_CODE;
		}else
		{
			$prefix = 'http://game-serv-s' . $order_by;//?-xiaonei.xxfy.kunlun.com
			if($server != 'xx')
			{
				$prefix .= '-' . $server;
			}
			$url = $prefix . '.xxfy.kunlun.com';
		}		
		//md5(date('Y-m-d') . '10.22.86.51');
		$key = date('Y-m-d') . '10.22.86.51';
		$url .= '/config_code.php?simple_check=' . md5($key);
		$code = @file_get_contents($url);
		if($code)
		{
			$code_cache[$server_id] = $code;
		}
		$log_msg = date('Y-m-d H:i:s ') . $url . ' => ' . $code . "\r\n";
                file_put_contents('/tmp/get_config_code.log',$log_msg,FILE_APPEND);
		return $code;
	}
	
	public  static function args_addslashes()
	{
		if (!get_magic_quotes_gpc())
		{
			self::str_addslashes($_GET);
			self::str_addslashes($_POST);
			self::str_addslashes($_COOKIE);
		}
	}
	
	public  static function str_addslashes(&$_value)
	{
		if (!empty($_value))
		{
			if (is_array($_value))
			{
				foreach($_value as $_key => $_val)
				{
					self::str_addslashes($_value[$_key]);
				}
			} else {
				$_value = htmlspecialchars($_value, ENT_QUOTES);
				$_value = trim(addslashes($_value));
			}
		}
	}

}

?>
