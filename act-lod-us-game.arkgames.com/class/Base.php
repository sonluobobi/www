<?php

if (!defined('KUNLUN_COM'))
{
        header('http/1.0 404 not found');
        die();
}

class Base
{
	public $_db = null;

	public function __construct()
	{
	}

	public function getDb()
	{
		global $config_server,$config_database,$config_user,$config_password;
		
		$db = $this->_db;

		if (!empty($db))
		{
			return $db;
		}

		require ROOT_PATH . '/libs/mysql.medoo.php';
		$this->_db = $medoo_db;
		
		return $medoo_db;
	}

	public function getDomainByPlatform($platform_sign)
	{
		global $platform_domain_map;

		if (!empty($platform_sign) && !empty($platform_domain_map) && isset($platform_domain_map[$platform_sign]))
		{
			return $platform_domain_map[$platform_sign];
		}

		return false;
	}

	public function ShowAjaxMsg($retmsg)
	{
		die($retmsg);
	}

	//输出信息
	public function ShowErrorMsg($retmsg='fail')
	{
		show_error(2, $retmsg);
	}

	public function ShowSuccMsg($retmsg= 'succ', $data=array())
	{
		show_error(0, $retmsg, $data);
	}

	public function ShowSuccMsgGz($retmsg= 'succ', $data=array())
	{
		$ret = array();
		$ret['retcode'] = 0;
		$ret['retmsg'] = $retmsg;
		!empty($data) && $ret['data'] = $data;

		$ret_str = json_encode($ret);
		echo @gzcompress($ret_str);
		exit;
	}

	public function Log($msg, $name='base', $folder='base')
	{
		do_log($msg, $name, $folder);
	}

	public function getTokenParams()
	{
		$params = array();
		$t = time();
		$params['t'] = $t;
		$params['s'] = md5(INTERFACE_TOKEN.$t.INTERFACE_TOKEN);

		return http_build_query($params);
	}

	public function sendStreamFile($server_url, $content='', $file='')
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

		$token_params_str = $this->getTokenParams();
		$url = "http://".$server_url.'&'.$token_params_str;
		$this->Log($url, 'sendStreamFile', 'base');

		$content = @gzcompress($content);
		
		$opts = array(
	        'http' => array(
	            'method' => 'POST',
	            'header' => 'content-type:application/x-www-form-urlencoded',
	            'content' => $content
	        )
	    );

	    $context = @stream_context_create($opts);
	    //$response = @file_get_contents($url, false, $context);

	    $cnt = 0;

	    while($cnt <= 3 && ($response = @file_get_contents($url, false, $context)) === false)
	    {
	    	$cnt++;
	    }

	    return $response;
	}

	public function getPostStreamData()
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
	public function receiveStreamFile($receive_file)
	{
		$stream_data = $this->getPostStreamData();

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

	public function requestUrl($server_url, $ungz=false)
	{
		$date_str = date('Y-m-d H:i:s');
		$msg = '['.$date_str.']begin -- '. $server_url . ' -- ';
		$ret = array('retcode' => 0, 'msg' => '');
		$token_params_str = $this->getTokenParams();
		$url = "http://".$server_url.'&'.$token_params_str;
		$this->Log($url, 'requestUrl', 'base');
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
}