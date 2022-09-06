<?php
/**
 * @file   CacheCtrl.php
 * @author xiaoyang <xiaoyang.qi@kunlun-inc.com>
 * @date   Mon Dec 14 14:57:16 2010
 * 
 * @brief  Ctrl 的基础类
 *
 * @package       CacheCtrl
 * @subpackage    CtrlBase
 */
namespace ctrl;
use view;

use framework\util;
use framework\mvc\view\smarty;
use \view\RedirectView;
use	common;

class CacheCtrl extends CtrlBase{
	private $CacheService;
	/** 
	 * 构造函数，继承父方法
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct(){
		parent::__construct();
		$this->CacheServers = util\Singleton::get("service\\CacheService");
	}
	/**
	 * 更新缓存
	 */
	public function ReflushCache(){
		$this->CacheServers->main();
		throw new \Exception($this->_LANG['UpCacheSucceed']);
	}
	
	function getName()
	{
		
	}
		
}