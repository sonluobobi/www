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
use framework\mvc\view;
use framework\mvc\view\smarty;
use \util\Functions;
use common;

/** 
 * 用户的 ctrl
 *
 * @package       UserCtrl
 * @subpackage    CtrlBase
 */
class UserCtrl extends CtrlBase {
    
    
    private $userService;
	
	/** 
	 * 构造函数，继承父方法
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();
		$this->NoticeService = util\Singleton::get("service\\UserService");
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
	
	/** 
	 * 添加用户列表
	 * 
	 * @return view\SmartView Object
	 * @access public
	 */
	public function addUser()
	{
	    
	    if($_POST)
	    {
	        						//$result = $this->NoticeService->ServiceAddPush();
				$msg   = $this->NoticeService->addUsers();
				common\Functions::alertFunc('创建成功');
			
	    }
	    else
	    {
	        	return new smarty\SmartyView("User.addUser.html",[]);
	    }
	
	}
	
	/** 
	 * 修改密码
	 * 
	 * @return view\SmartView Object
	 * @access public
	 */
	public function updatePassword()
	{
	    
	    if($_POST)
	    {
	        						//$result = $this->NoticeService->ServiceAddPush();
				$msg   = $this->NoticeService->updatePassword();
				common\Functions::alertFunc('修改成功');
			
	    }
	    else
	    {
	        	return new smarty\SmartyView("User.updatePassword.html",[]);
	    }
	
	}
	
	/** 
	 * 用户列表
	 * 
	 * @return view\SmartView Object
	 * @access public
	 */
	public function userlist()
	{
	    
	    if($_POST)
	    {
	        						//$result = $this->NoticeService->ServiceAddPush();
				$msg   = $this->NoticeService->updatePassword();
				common\Functions::alertFunc('修改成功');
			
	    }
	    else
	    {
	        
	        include  ACCOUNT_PATH.'account.add.php';
	        
	        $result = $common_account_add;
	        
	        return new smarty\SmartyView("User.userlist.html",array('list' => $result,'pages' => $result['pages'],'begTime'=>date('Y-m-d 00:00:00'),'endTime'=>date('Y-m-d 23:59:59')));
	        
	    }
	
	}
	
	
	/** 
	 * 用户列表
	 * 
	 * @return view\SmartView Object
	 * @access public
	 */
	public function deleteuser()
	{

	    $this->NoticeService->deleteuser($_GET['id']);
	    echo '删除成功';
	    //common\Functions::alertFunc('1111成功');
			
	}
	
	
	
	
	
	
	
	
}