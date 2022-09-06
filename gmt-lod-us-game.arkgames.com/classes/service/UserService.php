<?php // -*-coding:utf-8; mode:php-mode;-*-
/**
 * @file   UserService.php
 * @author koocyton <koocyton@gmail.com>
 * @date   Mon Dec 14 17:49:51 2009
 * 
 * @brief  用户的 Service
 * @package       UserService
 * 
 */

namespace service;

use entity;

use dao;

use framework\util;

use common;

/** 
 * 用户的的Service
 *
 * @package       UserService
 */
class UserService extends ServersAbs {
	
	/**
	 * @var dao\UserDao $userDao
	 */
	private $userDao;
	
	public function __construct()
	{
		parent::__construct();
		$this->userDao = util\Singleton::get("dao\\UserDao");
	}
	
	/**
	 * 验证登陆
	 * @param String $username
	 * @param String $password
	 */
	public function login($username,$password){
		
		$user =  $this->userDao->fetchUmUserInfoNew($username,$password);
		
		/*
		if(empty($user['staffId']))
		{
				throw new \Exception($user[1]);				
		}
		*/
		
		/**验证UM是否加了产品权限 */
		return $user;
	}
	
	
	//旧登陆
	/*public function login($username, $password)
	{
		$user = $this->userDao->fetchUserByLoginName($username);
		if (empty($user))
		{
			throw new \Exception($this->_LANG['UserNotExist']);
		}
		elseif ($user->password != entity\User::encryptPassword($password)) {
			throw new \Exception($this->_LANG['EnterPwdError']);
		}
		
		$this->userDao->fetchUserBylastlogin($user->id);
		return $user;
	}*/
	
	/**
	 * 获取用户信息
	 * @param Int $id
	 */
	public function getUserInfo($id)
	{
		return  $this->userDao->load($id);
	}
}
