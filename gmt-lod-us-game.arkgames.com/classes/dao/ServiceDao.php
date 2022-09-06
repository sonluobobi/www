<?php
namespace dao;

use common;
use framework\data\pdo;

class ServiceDao {
	/**
	 * 
	 * @var framework\data\pdo\PDOHelper
	 */
	private $pdoHelper;
	private $pdo;
	/** 
	 * 构造函数
	 * 
	 * @return 
	 */
	public function __construct()
	{
		$this->pdo = pdo\PDOManager::getInstance("default");

		$this->pdoHelper = new pdo\PDOHelper("entity\\Service");
        $this->pdoHelper->setPdo($this->pdo);
	}
	/**
	 * 获取服务器列表
	 */
	public function GetServicesList($sid = '', $gup = ''){
		//支持批量查询，$sid格式 1,2,3,..N
		$gup = $gup != '' ? $gup : $_SESSION['gup'];
		if(strstr($gup,"_")){
			$tmpGup = explode("_",$gup);
			$gup=$tmpGup[0];
			$productId = $tmpGup[1];
		}else{
                	$productId = $_SESSION['productId'];
		}
               // $where = " serverGroup = '".$gup."' AND productId='".$productId."' AND status=0 ";
                $where = " serverGroup = '".$gup."' AND productId='".$productId."' ";
                if(!empty($sid)){
                        $where .= " AND serverId in ($sid) ";
                }
		return $this->pdoHelper->fetchAll($where,null,"*"," serverId desc");
	}
	/**
	 * 获取游戏服务器基本信息
	 */
	public function GetServiceInfo($RestHost,$RestParams){
		return  common\Rest::CallRestInterFace("Rest_getServerInfo",$RestHost,$RestParams);
		//$SoapReturn =  common\Soap::CallSaopInterface($soapHost,$soapMethod,array($soapParams));
	}
	/**
	 * 获取游戏服务器配制
	 */
	public function GetServerConf($RestHost,$RestParams){
		return common\Rest::CallRestInterFace("Rest_getServerConfig",$RestHost,$RestParams);
	}
	/**
	 * 设置游戏服务器配制
	 */
	public function SetGameServerConfig($RestHost,$RestParams){
		return common\Rest::CallRestInterFace("Rest_setServerConfig",$RestHost,$RestParams);
	}
	/**
	 *
	 * 删除GMT服务器列表
	 * @var $server_id 服务器ID
	 * @return id
         */
	public function SetGmtServerDel($serverId){
		$filed = array('status');
		$updata = array('status'=>'1');
		return $this->pdoHelper->update($filed,$updata," serverId='{$serverId}' ");
	}

}
