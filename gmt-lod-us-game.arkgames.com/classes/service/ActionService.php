<?php
namespace service;

use entity;
use dao;
use framework\util;
use common;//dongchen--20111216

/**
 * 权限的Service
 */
class ActionService extends ServersAbs {
	/**
	 * @var dao\ActionDao 
	 * 
	 */
	private $ActionDao;
	public function __construct(){
		parent::__construct();
		$this->ActionDao = util\Singleton::get("dao\\ActionDao");
	}
	/**
	 * 获取操作权限
	 * @return CacheData
	 */
	public function getActionList(){
		$ActionList = $this->ActionDao->fetchActionList('',TRUE);
		return $ActionList;
	}
	/**
	 * 获取本级操作权限
	 * @param Int $pid
	 * @return Arary
	 */
	public function getActionOne($id){
		
		return $this->ActionDao->fetchActionOne($id);
	}
	/**
	 * 获取子级操作权限
	 * @param Int $pid
	 * @return Arary
	 */
	public function getActionSonOne($id){
		
		return $this->ActionDao->fetchActionSonOne($id);
	}
	
	/**
	 * 添加,修改操作权限
	 */
	public function setActionSaveEdit($acticoDb){
		$isadd  = intval($_POST['isadd']);
		$Arr->orderid = intval($_POST['orderid']);
		$Arr->acttype	 = $_POST['acttype'];
		if(!in_array($Arr->acttype,array(-1,0,1))){
			throw new \Exception($this->_LANG['handlerTypeErr']);
		}
		$Arr->actico	 = htmlspecialchars($_POST['actico']);
		if(!empty($Arr->actico)){
			if(!in_array($Arr->actico,$acticoDb)){
				throw new \Exception($this->_LANG['icoNotexist']);
			}
		}
		$Arr->actcode  	 = htmlspecialchars(trim($_POST['actcode']));
    	if (!empty($Arr->actcode) && substr($Arr->actcode,0,1) != '.') 
    	{
    		throw new \Exception($this->_LANG['urlBegerror']);
    	}
		$Arr->acttitle  	 = htmlspecialchars(trim($_POST['acttitle']));
    	if (strlen($Arr->acttitle) < 2 || strlen($Arr->acttitle) > 50) 
    	{
    		throw new \Exception($this->_LANG['nameRestrict']);
    	}
    	$Arr->actdisplay  = htmlspecialchars($_POST['actdisplay']);
		if (!in_array($Arr->actdisplay,array('block','none'))) 
    	{
    		throw new \Exception($this->_LANG['plaseDisplay']);
    	}
    	if($isadd){
    		$id = 0;
    		$Arr->pid = intval($_POST['pid']);
    		/*
			//dongchen--20111216-start
			$userDao = util\Singleton::get("dao\\UserDao");
            $user =  $userDao->fetchUmUserInfoNew($_SESSION['infoUser']['userName'],$_SESSION['infoUser']['passWord']);
            $umInfo=common\Functions::findUmOneResources('gmt_action_'.$Arr->pid, $user['menu']);
			//dongchen--20111216-end
    		//*/
    		$log = $this->_LANG['add'].$this->_LANG['handler'].$this->_LANG['sign'].$Arr->acttitle;
    	}else{
    		$id = intval($_POST['id']);
    		if (!$id) 
    		{
    			throw new \Exception($this->_LANG['fetIdParameter']);
    		}
    		/*
			//dongchen--20111216-start
			$userDao = util\Singleton::get("dao\\UserDao");
            $user =  $userDao->fetchUmUserInfoNew($_SESSION['infoUser']['userName'],$_SESSION['infoUser']['passWord']);
            $umInfo=common\Functions::findUmOneResources('gmt_action_'.$id, $user['menu']);
			//dongchen--20111216-end
			//*/
    		$log = $this->_LANG['modify'].$this->_LANG['handler'].$this->_LANG['ID'].$this->_LANG['sign'].$id;
    	}
		//$Arr->actkey = $Arr->actcode?md5($Arr->actcode):md5(time());//dongchen--20111216
    	return  $this->ActionDao->fetchActionSaveHandle($id,$Arr,$umInfo);//dongchen--20111216
	}
	/**
	 * 删除权限
	 */
	public function setActionSaveDel($id){
		if(!$id){
			throw new \Exception($this->_LANG['fetIdParameter']);
		}
		$action  = $this->getActionOne($id);
		if(empty($action)){
			throw new \Exception($this->_LANG['dataExist']);
		}
		//dongchen--20111216-start
		$userDao = util\Singleton::get("dao\\UserDao");
        $user =  $userDao->fetchUmUserInfoNew($_SESSION['infoUser']['userName'],$_SESSION['infoUser']['passWord']);
        $umInfo=common\Functions::findUmOneResources('gmt_action_'.$id, $user['menu']);
		//dongchen--20111216-end
		return $this->ActionDao->fetchActionSaveDel($id,$umInfo);//dongchen--20111216
	}

	/**
	 * 从cache中根据actionCode获取action
	 */
	public function getActionByActionCodeFromCache($actionCode){
		return $this->ActionDao->getActionByActionCodeFromCache($actionCode);
	}
	/**
	 * 从cache中获取会记录操作日志的action
	 */
	public function getLogActionFromCache(){
		return $this->ActionDao->getLogActionFromCache();
	}
	public function getActionKeyByActionCode($actionCode)
        {
                $actKey = $this->ActionDao->getActionKeyByActionCode($actionCode);

                return $actKey[0]['actkey'];
        }
		public function getActionTitleByActionCode($actionCode)
        {
                $acttitle = $this->ActionDao->getActionTitleByActionCode($actionCode);

                return $acttitle[0]['acttitle'];
        }
}
