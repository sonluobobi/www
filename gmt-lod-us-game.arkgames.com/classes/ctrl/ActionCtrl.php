<?php
/**
 * @file   ActionCtrl.php
 * @author xiaoyang <xiaoyang.qi@kunlun-inc.com>
 * @date   Mon Dec 14 14:57:16 2010
 * 
 * @brief  Ctrl 的基础类
 *
 * @package       ActionCtrl
 * @subpackage    CtrlBase
 */

namespace ctrl;
use view;

use framework\util;
use framework\mvc\view\smarty;
use \view\RedirectView;
use	common;

class ActionCtrl extends CtrlBase{
	private $ActionServers;
	private  $acticoDb = array('无'=>'','Dash'=>'menuDash', 'Eye'=>'menuEye', 'Goals'=>'menuGoals', 'Help'=>'menuHelp');
	/** 
	 * 构造函数，继承父方法
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct(){
		parent::__construct();
		$this->ActionServers = util\Singleton::get("service\\ActionService");
		
		$name = trim($_SESSION['infoUser']['fullname']);
		$auths = array('liujianzhu');
		
		if (!in_array($name, $auths))
		{
			throw new \Exception($this->_LANG['notPermission']);
			\common\Functions::alertFunc($this->_LANG['notPermission']);
			return false;
		}
	}
	/**
	 * 获取权限列表
	 */
	public function ActionList(){
		$ActionInfo = $this->ActionServers->getActionList();
		
		return new smarty\SmartyView("Action.List.html", array("menuTree" => $ActionInfo));
	}
	/**
	 * 添加权限
	 */
	public function ActionAdd(){
		$pid = intval($_GET['pid']);
		if($pid){
			$action = $this->ActionServers->getActionOne($pid);
			if(empty($action)){
				throw new \Exception($this->_LANG['superiorNotExist']);
			}
		}
		$upname = (empty($action)) ? $this->_LANG['Firsthandler'] : $action->acttitle;
		return new smarty\SmartyView("Action.Edit.html", array('isadd'=>1,'upname'=>$upname,'acticodb'=>$this->acticoDb,'pid'=>$pid));
	}
	/**
	 * 删除权限
	 */
	public function ActionDel(){
		$id = intval($_GET['id']);
		if(!$id){
			throw new \Exception($this->_LANG['fetIdParameter']);
		}
		$action = $this->ActionServers->getActionOne($id);
		if(empty($action)){
			throw new \Exception($this->_LANG['dataExist']);
		}
		return  new smarty\SmartyView("Action.Del.html",array("action" => $action,'isfather'=>$this->ActionServers->getActionSonOne($action->id)));
	}
	/**
	 * 修改权限
	 */
	public function ActionEdit(){
		$id = intval($_GET['id']);
		if($id){
			$action = $this->ActionServers->getActionOne($id);
			if(empty($action)){
				throw new \Exception($this->_LANG['dataExist']);
			}
			if($action->pid){
				$up = $this->ActionServers->getActionOne($action->pid);
			}
		}
		$upname = (empty($up)) ? $this->_LANG['Firsthandler'] : $up->acttitle;
		return new smarty\SmartyView("Action.Edit.html", array('isadd'=>0,'upname'=>$upname,'acticodb'=>$this->acticoDb,'action'=>$action));
	}
	/**
	 * 添加,修改权限处理
	 */
	public function ActionSaveEdit(){
		$result = $this->ActionServers->setActionSaveEdit($this->acticoDb);
		if($result[0]){
			$text = !empty($_POST['id']) ? $this->_LANG['EditAction'] : $this->_LANG['AddAction'];
			LogCtrl::CallLogsInsert($text.$_POST['acttitle']);
			$CacheServers = util\Singleton::get("service\\CacheService");
			$CacheServers->menu_recache(); 
			return $this->ActionList();
		}
		else
		{
			//throw new \Exception($this->_LANG['modifyFail']);
			throw new \Exception($result[1]);
		}
	}
	/**
	 * 删除权限处理
	 */
	public function ActionSaveDel(){
		$id = intval($_POST['id']);
		$action  = $this->ActionServers->setActionSaveDel($id);
		if($action){
			LogCtrl::CallLogsInsert($this->_LANG['delAction'].$id);
			$CacheServers = util\Singleton::get("service\\CacheService");
			$CacheServers->menu_recache(); 
			return $this->ActionList();
		}else{
			throw new \Exception($this->_LANG['MoveFail']);
		}
	}
}
