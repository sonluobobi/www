<?php
/**
 * @file   ServiceCtrl.php
 * @author xiaoyang <xiaoyang.qi@kunlun-inc.com>
 * @date   Mon Dec 1 14:57:16 2010
 * 
 * @brief  Ctrl 的基础类
 *
 * @package       ServiceCtrl
 * @subpackage    CtrlBase
 */
namespace ctrl;
use view;

use framework\util;
use framework\mvc\view\smarty;
use \view\RedirectView;
use common;

class ServiceCtrl extends CtrlBase{
	/**
	 * 服务器Service
	 * @var Object
	 */
	private $SystemService;
	/** 
	 * 构造函数，继承父方法
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct(){
		parent::__construct();
		$this->SystemService = util\Singleton::get("service\\SystemService");
	}
	/**
	 * 获取服务器列表
	 */
	public function GetServerList(){
		$RefreshId = (isset($_GET['sid']) && is_array($_GET['sid'])) ? $_GET['sid'] : 'all';
		$result = $this->SystemService->GetServerList($RefreshId);
		return new smarty\SmartyView("Server.List.html", array("dataList" => $result['list'], 'pages' => $result['pages']));
	}
	/**
	 * 获取服务器配制
	 * @return view\SmartView Array
	 * @access public
	 */
	public function GetServerConfig(){
		$ServerConfig = $this->SystemService->getServerConfig();
		$servername = $ServerConfig['serverName'];
		unset($ServerConfig['serverName']);
		return new smarty\SmartyView("Server.Config.html", array("dataList" => $ServerConfig,'serverName'=>$servername));
	}
	/**
	 * 设置服务器配制
	 * @return Clew
	 * @access public
	 */
	public function SetServerConfig(){
		$result = $this->SystemService->setGameConfig();
		return $this->GetServerList();
	}
	/**
	* 删除服务器
	* @return id
	* @access public
	*/
	public function delServer(){
		$result = $this->SystemService->setDelServer();
                return $this->GetServerList();
	}
	
}
