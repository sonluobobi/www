<?php // -*-coding:utf-8; mode:php-mode;-*-
/**
 * @file   UserCtrl.php
 * @author koocyton <koocyton@gmail.com>
 * @date   Mon Dec 14 14:57:16 2009
 * 
 * @brief  Ctrl 的基础类
 *
 * @package       UserCtrl
 * @subpackage    CtrlBase
 */

namespace ctrl;

use framework\util;
use framework\view;

/** 
 * 用户的 ctrl
 *
 * @package       UserCtrl
 * @subpackage    CtrlBase
 */
class UserCtrl extends CtrlBase {
	
	/** 
	 * 构造函数，继承父方法
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/** 
	 * 输出用户列表
	 * 
	 * @return view\SmartView Object
	 * @access public
	 */
	public function showInfo()
	{
		$userService = util\Singleton::get("service\\UserService");
		$usersInfo   = $userService->getUsersInfo();
		return new view\SmartyView("User.showInfo.html", array("userList" => $usersInfo));
	}
	
	
}