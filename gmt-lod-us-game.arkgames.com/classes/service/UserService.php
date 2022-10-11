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
	
	
	/**
	 * 添加用户
	 * @param Int $id
	 */
	public function addUsers()
	{
	    if(empty($_POST['name']))
	    {
	        common\Functions::alertFunc('请输入用户名');
	    	exit();
	    }
	    
	    if(empty($_POST['password']) or empty($_POST['password2']))
	    {
	        common\Functions::alertFunc('请输入用户密码');
	    	exit();
	    }
	    
	     if($_POST['password'] != $_POST['password2'])
	    {
	        common\Functions::alertFunc('用户密码不一致');
	    	exit();
	    }
	    
	    //保存进文档
	    
	    include  ACCOUNT_PATH.'account.add.php';
	    
	    if(isset($common_account_add[$_POST['name']]))
	    {
	        common\Functions::alertFunc('此用户名已存在');
	    	exit();
	    }
	    
	    
	    $common_account_add[$_POST['name']] = md5($_POST['password']);
	    
	    
	  
	    
					$content = "<?php \r\n ";
					$content .= '$common_account_add = ' . var_export($common_account_add,true)."\r\n";
					$content .= "?> ";
					
	    $ret = file_put_contents(ACCOUNT_PATH.'account.add.php', $content);
	    
	   //$ret = file_get_contents('/data/zlcs/www/common/account.add.php');
	    
		return  1;
	}
	
	/**
	 * 添加用户
	 * @param Int $id
	 */
	public function updatePassword()
	{
	    
	    if( $_SESSION['infoUser']['loginId'] != $_POST['name'])
	    {
	        common\Functions::alertFunc('只可以修改自己账号密码');
	    	exit();
	    }
	    
	    
	    if(empty($_POST['name']))
	    {
	        common\Functions::alertFunc('请输入用户名');
	    	exit();
	    }
	    
	    if(empty($_POST['password']) or empty($_POST['password2']))
	    {
	        common\Functions::alertFunc('请输入用户密码');
	    	exit();
	    }
	    
	     if($_POST['password'] != $_POST['password2'])
	    {
	        common\Functions::alertFunc('用户密码不一致');
	    	exit();
	    }
	    
	     
	    
	    //保存进文档
	    
	    include  ACCOUNT_PATH.'account.add.php';
	    
	    if(!isset($common_account_add[$_POST['name']]))
	    {
	        common\Functions::alertFunc('没有此用户名');
	    	exit();
	    }
	    

	    $common_account_add[$_POST['name']] = md5($_POST['password']);
	    
	    
	  
	    
					$content = "<?php \r\n ";
					$content .= '$common_account_add = ' . var_export($common_account_add,true)."\r\n";
					$content .= "?> ";
					
	    $ret = file_put_contents(ACCOUNT_PATH.'account.add.php', $content);
	    
	   //$ret = file_get_contents('/data/zlcs/www/common/account.add.php');
	    
		return  1;
	}
	
	
	/**
	删除用户
	 */ 
	public function deleteuser($user_name)
	{
	    
	    include  ACCOUNT_PATH.'account.add.php';
	    
	  
	    unset($common_account_add[$user_name]);
	    
					$content = "<?php \r\n ";
					$content .= '$common_account_add = ' . var_export($common_account_add,true)."\r\n";
					$content .= "?> ";
					
	    $ret = file_put_contents(ACCOUNT_PATH.'account.add.php', $content);
	  
	}
	
	
	
}
