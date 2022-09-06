<?php

namespace dao;

use common;
use framework\data\pdo;

class ChatDao 
{
	private $pdoHelper;
	private $pdo;
	
	function __construct() 
	{
		$this->pdo = pdo\PDOManager::getInstance("default");
		//$this->pdoHelper = new pdo\PDOHelper("entity\\Chat");
        //$this->pdoHelper->setPdo($this->pdo);
	}

	/**
	 * 检查角色名
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function checkNicks($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_checkNicks",$RestHost,$RestParams);
	}

	/**
	 * 发送私信
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function send($RestHost,$RestParams)
	{
		return common\Rest::CallCommRestInterFace('GameTools.sendChat',$RestHost,$RestParams);
	}
}