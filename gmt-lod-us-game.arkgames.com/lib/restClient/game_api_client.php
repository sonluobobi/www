<?php
require_once('kunlunapi_php5_restlib.php');

/**
 * LOGIN SERVER 服务调用 API 
 * 
 * @author hangjun.mao@kunlun-inc.com
 * @version 1.0
 * @example 
 * 
 * <pre>
 * define('api_token', '432c3fe51c404ec3');
 * require_once ('region_api_client.php');
 * $api = new RegionAPIClient(api_token);
 * $ret = $api->CRegion_balance(........);
 * var_dump($ret);
 * </pre>
 */
class GameAPIClient
{
    private $api_client;

    public function __construct($api_token,$server_addr)
    {
        $this->api_client = new KunlunRestClient($api_token, $server_addr);
    }

    public function __destruct()
    {
        $this->api_client = null;
    }
    
    public function Platform_getCharInfo($uid,$ext)
    {
        return $this->api_client->call_method('Platform.getCharInfo',
               array(
                    'uid'=>$uid,
                    'ext'=>$ext,
                    )
		);
    }
    public function Platform_createChar($uid,$uname,$cname,$ext)
    {
        return $this->api_client->call_method('Platform.createChar',
               array(
                    'uid'=>$uid,
                    'uname'=>$uname,
                    'cname'=>$cname,
                    'ext'=>$ext,
                    )
		);
    }
    public function Platform_Awards($uid,$cid,$gift)
    {
        return $this->api_client->call_method('Platform.Awards',
               array(
                    'uid'=>$uid,
                    'cid'=>$cid,
                    'gift'=>$gift,
                    )
		);
    }
    public function Platform_sendMessage($uid,$cid,$title,$message,$ext)
    {
        return $this->api_client->call_method('Platform.sendMessage',
               array(
                    'uid'=>$uid,
                    'cid'=>$cid,
                    'title'=>$title,
                    'message'=>$message,
                    'ext'=>$ext,
                    )
		);
    }
    public function Platform_sendVouchMsg($uid,$uname,$golds,$amount,$blanace,$vtime,$orderid,$ext)
    {
        return $this->api_client->call_method('Platform.notifyVouchMsg',
               array(
                    'uid'=>$uid,
                    'uname'=>$uname,
                    'golds'=>$golds,
                    'amount'=>$amount,
                    'blanace'=>$blanace,
                    'vtime'=>$vtime,
                    'orderid'=>$orderid,
                    'ext'=>$ext,
                    )
		);
    }
}