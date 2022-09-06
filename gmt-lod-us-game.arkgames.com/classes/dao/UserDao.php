<?php // -*-coding:utf-8; mode:php-mode;-*-
namespace dao;

use framework\data\pdo;
use common;

class UserDao {
	/**
	 * 
	 * @var framework\data\pdo\PDOHelper
	 */
	private $pdoHelper;
	private $pdo;
	private $time;

	/** 
	 * 构造函数
	 * 
	 * @return 
	 */
	public function __construct()
	{
		$this->pdo = pdo\PDOManager::getInstance("default");

		$this->pdoHelper = new pdo\PDOHelper("entity\\User");
        	$this->pdoHelper->setPdo($this->pdo);
	}

	/** 
	 * 获取用户信息，从匹配的用户名中
	 * 
	 * @param String $userName 
	 * 
	 * @return entity\User
	 */
	public function fetchUserByLoginName($loginName)
	{
		return $this->pdoHelper->fetchEntityByUserName($loginName);
	}
	
	/**
	 * 去UM取用户信息
	 * @var $userName 用户名
	 * @var $password  密码
	 */
	public function fetchUmUserInfo($userName,$password){
		$soapParm = array($userName,md5($password),common\Functions::getClientIP(),'GMT',UMGMGAMEOPERATSIGN.$_SESSION['gupFlag'],UMGMGAMESIGN);
		return common\Soap::CallSaopInterface(UMURL,"logincheckFromGmt",$soapParm);
	}
	
	 /**
         * 去UM取用户信息
         * @var $userName 用户名
         * @var $password  密码
         */

        public function fetchUmUserInfoNew($userName,$password){
                //$soapParm = array($userName,md5($password),common\Functions::getClientIP(),'GMT',UMGMGAMEOPERATSIGN.$_SESSION['gupFlag'],UMGMGAMESIGN);
                //return common\Soap::CallSaopInterface(UMURL,"logincheckFromGmt",$soapParm);
                $sendData = array(
                        'account' =>$userName, // ‘登录帐号’,
                        'password' =>$password, //‘登录密码’,
                        'loginIp' =>common\Functions::getClientIP(), //‘登录用户的客户端IP地址’
                );
                $userPurviewArr = common\Functions::getUMReturn('iServer.autoLogin',$sendData);
                return $userPurviewArr;

        }
	/**
	 * UM验证产品权限
	 */
	public function fetchCheckProduct(){
		
	}
	
	/**
	 *	更新最后一次管理员登陆时间
	 */
	public function fetchUserBylastlogin($id,$time=''){
		$this->time = !empty($time) ? $time : time();
		return $this->pdoHelper->update(array('lastlogin'),array('lastlogin'=>$this->time),"id={$id} ");
	}
	
	/**
	 * 根据ID获取用户
	 * @param entity\User $id
	 */
	public function load($id)
	{
		return $this->pdoHelper->load($id);
	}
}
