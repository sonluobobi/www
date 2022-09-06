<?php
namespace service;

use framework\core;
use framework\util;

class ServersAbs {

	/**
	 * 语言对象
	 */
	protected $_LANG;
	/**
	 * 构造函数
	 */
	public function __construct(){
		global $_LANG;
		$this->_LANG=$_LANG;
	}
	
	//判断是否有对应的权限
	public function check_action_auth($actionCode='')
	{
		if (empty($actionCode))
		{
			return false;
		}

		$ActionService = util\Singleton::get("service\\ActionService");
		$actkey = $ActionService->getActionKeyByActionCode($actionCode);
			
		if(empty($actkey) || !in_array($actkey,$_SESSION['userRank']))
		{
			return false;
		}

		return true;
	}
}
