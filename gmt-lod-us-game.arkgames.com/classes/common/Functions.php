<?php
namespace common;

class Functions
{
	public static function debug($value,$jump='')
	{
		echo '<script type="text/javascript">parent.debug("'.$value.'");</script>';
		if($jump == '') exit;
	}
	
	public static function RedirectUrl($url){
		echo '<script type="text/javascript">parent.RedirectUrl("'.$url.'");</script>';
		exit;
	}
	
	/**
	 * 执行JS弹出，再执行执行方法
	 */
	public static function alertFunc($message,$func='')
	{
		echo "<script type=\"text/javascript\">parent.alertFunc('".$message."','".$func."');</script>";
		exit;
	}

	/**
	 *  将一个字串中含有全角的数字字符、字母、空格或'%+-()'字符转换为相应半角字符
	 *
	 * @access  public
	 * @param   string       $str         待转换字串
	 *
	 * @return  string       $str         处理后字串
	 */
	public static function make_semiangle($str)
	{
	    $arr = array('０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4',
	                 '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9',
	                 'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E',
	                 'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J',
	                 'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O',
	                 'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T',
	                 'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y',
	                 'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd',
	                 'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i',
	                 'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n',
	                 'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's',
	                 'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x',
	                 'ｙ' => 'y', 'ｚ' => 'z',
	                 '（' => '(', '）' => ')', '［' => '[', '］' => ']', '【' => '[',
	                 '】' => ']', '〖' => '[', '〗' => ']', '「' => '[', '」' => ']',
	                 '『' => '[', '』' => ']', '｛' => '{', '｝' => '}', '《' => '<',
	                 '》' => '>',
	                 '％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-',
	                 '：' => ':', '。' => '.', '、' => ',', '，' => ',', '、' => '.',
	                 '；' => ',', '？' => '?', '！' => '!', '…' => '-', '‖' => '|',
	                 '＂' => '"', '＇' => '`', '｀' => '`', '｜' => '|', '〃' => '"',
	                 '　' => ' ');
	
	    return strtr($str, $arr);
	}
	/** 
	 * 获取客户端的IP
	 *
	 * @return 
	 */
	/*public static function getClientIP()
	{
		if (isset($_SERVER))
		{
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			{
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			elseif (isset($_SERVER["HTTP_CLIENT_IP"]))
			{
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			}
			else
			{
				if(isset($_SERVER["REMOTE_ADDR"]))
                {
                    $realip = $_SERVER["REMOTE_ADDR"];
                }else
                {
                    $realip = "127.0.0.1";
                }
			}
		}
		else
		{
			if (getenv("HTTP_X_FORWARDED_FOR"))
			{
				$realip = getenv("HTTP_X_FORWARDED_FOR");
			}
			elseif (getenv("HTTP_CLIENT_IP"))
			{
				$realip = getenv("HTTP_CLIENT_IP");
			}
			else
			{
                $realip = getenv("REMOTE_ADDR");
			}
		}
		return addslashes($realip);
	}*/
	
	public static function getClientIP()
	{

		if (isset($_SERVER) && isset($_SERVER["REMOTE_ADDR"]))
		{
			$realip = $_SERVER["REMOTE_ADDR"];
		}else{
			$realip = getenv("REMOTE_ADDR");
		}
		return addslashes($realip);

	}
	
	/**
	 * 获取服务器的请求URL地址
	 * @param $sid 请求的服务器ID
	 * @param $type 为空时返回服务器信息，region返回大区URL，server返回游戏URL
	 * @return 如果服务器存在返回Server_url，反之返回false
	 */
	public static function getServerUrl($sid,$type='')
	{
		global $init;
		if ($sid == 9999)
        {
            return '全服';
        }
		foreach($init['serverList'] as $k => $v)
		{
			if($v['Server_id'] == $sid) 
			{
				switch($type)
				{
					case 'region':
						return 	$v['Region_url'];
						break;
					case 'server':
						return 	$v['Server_url'];
						break;
					case 'serverName':
						return $v['Server_name'];
						break;
					default :
						return $v;
							
				}
			}
		}		
		return false;
	}
	/**
	 * 上传Excel文件
	 * @var $Fobject  $_FILES['excleFile']
	 * @var $size   文件大小
	 * @var $type 文件类型
	 * @var $path 文件路径
	 * @var $file_name 新的文件名
	 */
	public static  function UploadFile($Fobject,$size,$type,$path,$file_name=''){
		/*if(!in_array(str_replace("'",'',$Fobject['type']),$type)){
			return array(0,'文件类型错误');	
		}else*/if ($Fobject['size'] > $size){
			return array(0,'文件大定超过限制');
		}
		if(!is_dir($path)) @mkdir($path,0777,true);
		$pre = explode('.',$Fobject['name']);
		$newName = !empty($file_name) ? $file_name : time().rand(100,99);
		$newName.= ".".$pre[count($pre)-1];
		if(file_exists($path.$newName)){
			unlink($path.$newName);
		}
		clearstatcache();
		if(move_uploaded_file($Fobject['tmp_name'],$path.$newName)){
			return array(1,$path.$newName);
		}else{
			return array(0,'上传失败');
		}
	}
	/**
	 *获取当前URL分析合作方
	 * @param $url  url地址
   	 */
	public static function identifyUrl($url=''){
		$nowUrl = !empty($url) ? $url : $_SERVER['SERVER_NAME'] ;
		if(preg_match('/\w+\.(\w+)?gm\.([\w+\.]+?)(com|net|cn|tw|jp)/',$nowUrl,$urlArr)){
			$urlParam = explode('.',$urlArr[0]);
			$operation = $urlParam[0] ; //获取到运营方标识
			$OEMDATA=\oemark::$oeMark;
                        foreach ($OEMDATA as $OEM){
                                if(in_array("$operation",$OEM)) {
                                        $groupData = $OEM;
                                        break;
                                }
                        }
			//$groupObject = \framework\util\Singleton::get("service\\GroupService");
			//$groupData = $groupObject->getOperactionGroup($operation);
			//$_SESSION['OPERACTIONSIGN'] = $groupData[0]['groupId'].'|'.$groupData[0]['languages'].'|'.$groupData[0]['flag'];
			$_SESSION['OPERACTIONSIGN'] = $groupData['gupId'].'|'.$groupData['Langage'].'|'.$groupData['gupFlag'].'|'.$groupData['productId'];

		}else{
			$_SESSION['OPERACTIONSIGN'] = '';
		}	
		return true;	
	}
	/**
         *解析海外合作方大区地址
         * @param $gid   合作方ID
         * @param $pid 产品ID
         */
        public static function regionOperationUrl($gid='',$pid='')
        {
                $gupId = !empty($gid) ? $gid : $_SESSION['gup'];
                $productId = !empty($pid) ? $pid : $_SESSION['productId'];
                $OEMDATA=\oemark::$oeMark[$gupId."_".$productId];
                if (NATION == 'external'){
                        $url = sprintf(RESTREGIONS,$OEMDATA['regionOemark']);
                        return $url;
                }
                return RESTREGIONS;
        }
        /**
         *解析海外合作方Passport地址
         * @param $gid   合作方ID
         * @param $pid 产品ID
         */
        public static function passportOperationUrl($gid='',$pid='')
        {
                $gupId = !empty($gid) ? $gid : $_SESSION['gup'];
                $productId = !empty($pid) ? $pid : $_SESSION['productId'];
                $OEMDATA=\oemark::$oeMark[$gupId."_".$productId];
                if (NATION == 'external'){
                        $url = sprintf(PASSPORTURL,$OEMDATA['regionOemark']);
                        return $url;
                }
                return PASSPORTURL;
        }

	 /**
         * UM加密函数
         * @param $string
         * @param $operation
         * @param $key
         * @param $expiry
         * @return 
         */
        public static function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
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

                if($operation == 'DECODE') {
                        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                                return substr($result, 26);
                        } else {
                                return '';
}
                } else {
                        return $keyc.str_replace('=', '', base64_encode($result));
                }
        }

        /**
         * UM接口请求函数
         * @param $act 
         * @param $info
         * @return ARRAY
         */
        public static function getUMReturn($act,$sendData,$umUserId="")
        {
                if(empty($umUserId))
                {
                        $umUserId = UMGMGAMESIGN;
                }
                $info = base64_encode(urlencode(self::_authcode(serialize($sendData),'ENCODE',UMTOKENKEY)));
               // error_log(var_export(UMURL."?act={$act}&info=".$info.'&system='.$umUserId.'&sign='.md5(UMTOKENKEY.'&info='.$info.'&system='.$umUserId),1),3,"/tmp/cmgmt.txt");
                $return = file_get_contents(UMURL."?act={$act}&info=".$info.'&system='.$umUserId.'&sign='.md5(UMTOKENKEY.'&info='.$info.'&system='.$umUserId));
                return json_decode($return,TRUE);
        }

        /**
         * 解析UM返回玩家权限函数，返回数据存入SESSION
         * @param $menu 
         * @param $retData
         */
        public static function recurGetUserPermission($menu,&$retData,$getKey='menuKey')
        {
                if(!is_array($menu)) return $retData;

                foreach ($menu as $k=> $v)
                {
                        if($v[$getKey])
                        {
                                $retData[] = str_replace('mhklw','gmt',$v[$getKey]);
                        }
                        if(!empty($v['subNode']))
                        {
                                self::recurGetUserPermission($v['subNode'],$retData,$getKey);
                        }
                }
        }

	 /**
         * 查找某一资源权限节点信息
         * @param $type 查询的类型 : platform, operations
         * @param $info Resources信息
         * @param $index 检索字段 默认按资源key值查找
         * @return Array
         */
        public static function findUmOneResources($type, $info, $index='menu', &$out=array())
        {
            if($info)
            {
                foreach($info as $k => $v)
                {
		    if($v[$index.'Key'] == $type)
                    {
                        $out = array('id' => $v[$index.'Id'],'key' => $v[$index.'Key'],'name' => $v[$index.'Name'],'type' => $v[$index.'Type'],'parent' => $v[$index.'Parent']);
                        break;
                    }
                    else
                    {
                        if($v['subNode'])
                        {
                            self::findUmOneResources($type, $v['subNode'], $index, $out);
                        }
                    }
                }
            }
            return $out;
        }


	 /**
         * 解析UM返回玩家权限函数，返回数据存入SESSION
         * @param $menu 
         * @param $retData */
        public static function recurGetUserResources($resources,&$retData,$getKey='resourcesKey')
        {
                if(!is_array($resources)) return $retData;

                foreach ($resources as $k=> $v)
                {
                        if($v[$getKey])
                        {
                                $v_array = explode('_',$v[$getKey]);
                                $num = count($v_array);
                                if(isset($v_array[$num-2]) && is_numeric($v_array[$num-2])&&isset($v_array[$num-1]) && is_numeric($v_array[$num-1]))
                                {
                                        if(!in_array($v_array[$num-2].'_'.$v_array[$num-1],$retData))
                                        {
                                                $retData[] = $v_array[$num-1].'_'.$v_array[$num-2];
                                        }
                               }
                        }
                        if(!empty($v['subNode']))
                        {
                                self::recurGetUserResources($v['subNode'],$retData,$getKey);
                        }
                }
        }
        /**
        * 二维数组排序
        * @param array $ArrayData 
        * @param string $KeyName1   order by name
        * @param string $SortOrder1 ("SORT_ASC"|"SORT_DESC")
        * @param string $SortType1  ("SORT_REGULAR"|"SORT_NUMERIC"|"SORT_STRING")
        * @return array 
        */
        public function sysSortArray($ArrayData,$KeyName1,$SortOrder1 = "SORT_ASC",$SortType1 = "SORT_REGULAR")
        {
                if(!is_array($ArrayData))
                {
                        return $ArrayData;
                }
                $ArgCount = func_num_args();
                for($I = 1;$I < $ArgCount;$I ++)
                { 
			$Arg = func_get_arg($I);
                        if(strpos($Arg,"SORT")===false)
                        {
                                $KeyNameList[] = $Arg;
                                $SortRule[] = '$'.$Arg;
                        }
                        else
                        {
                                $SortRule[] = $Arg;
                        }
                }
                foreach($ArrayData AS $Key => $Info)
                {
                        foreach($KeyNameList AS $KeyName)
                        {
                                ${$KeyName}[$Key] = $Info[$KeyName];
                        }
                }
                $EvalString = 'array_multisort('.join(",",$SortRule).',$ArrayData);';
                eval ($EvalString);
                return $ArrayData;
        }

        //获取字符串长度，主要用于中文
        public static function get_str_len($str)
        {
            preg_match_all("/./us", $str, $match);
            return count($match[0]);
        }
}
