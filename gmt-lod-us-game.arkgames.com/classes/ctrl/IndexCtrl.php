<?php // -*-coding:utf-8; mode:php-mode;-*-
/**
 * @file   IndexCtrl.php
 * @author koocyton <koocyton@gmail.com>
 * @date   Mon Dec 14 14:57:16 2009
 * 
 * @brief  Ctrl 的基础类
 *
 * @package       IndexCtrl
 * @subpackage    CtrlBase
 */

namespace ctrl;

use framework\util;
use framework\mvc\view\smarty;
use \view\RedirectView;
use common;
/** 
 * 用户访问的首页
 *
 * @package       IndexCtrl
 * @subpackage    CtrlBase
 */
class IndexCtrl extends CtrlBase {

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
	 * 用户登录成功后，进入的首页
	 * 
	 * @return view\SmartView Object
	 * @access public
	 */
	public function main()
	{
		// 加载菜单缓存
		$menuTree = $setupTree = "";
  	  	require_once('../data/cache/cache_menu.php');
		$userService = util\Singleton::get("service\\UserService");
		$cacheService = util\Singleton::get("service\\CacheService");
		//$cacheService->menu_recache();
		
        //file_put_contents('/tmp/tmp_trace.log', __FILE__.__FUNCTION__,FILE_APPEND);
		return new smarty\SmartyView("Index.main.html", array('userInfo'=>$userService->getUserInfo($_SESSION['infoUser']['loginId']),'menuTree'=>$menuTree,'setupTree'=>$setupTree));
	}
}
