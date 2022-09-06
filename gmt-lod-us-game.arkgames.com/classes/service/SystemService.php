<?php
/**
 * @file   SystemService.php
 * @author xiaoyang <xiaoyang.qi@kunlun-inc.com>
 * @date   Mon Dec 14 17:49:51 2010
 * 
 * @brief  游戏服务器的Service
 * @package       UserService
 * 
 */
namespace service;

use dao;
use common;
use framework\util;

class SystemService extends ServersAbs{
	private $ServiceDao;
	public function __construct()
	{
		parent::__construct();
		$this->ServiceDao = util\Singleton::get("dao\\ServiceDao");
		$this->pagecount = !empty($_POST['pagecount']) ? intval($_POST['pagecount']) : 30;
		$this->pageCurrent = !empty($_POST['p']) ? intval($_POST['p']) : 1;
	}
	/**
	 * 获取游戏服务器数据
	 */
	public function GetServerList($RefreshId){
		$ServerArr = $tempArr = $RestParm = $DataArr = array();
		if($RefreshId == 'all'){
			$sid = "";
		}else{
			$sid = implode(",",$RefreshId);
		}
		$ServerList = $this->ServiceDao->GetServicesList($sid);
		
		$totalNums = count($ServerList);
		$pagecount = $this->pagecount;
		$pageCurrent = $this->pageCurrent;
		$pageNums = ceil($totalNums/$pagecount);

		if ($pageCurrent < 1 || $pageCurrent > $pageNums)
		{
			$pageCurrent = 1;
		}

		//分页获取服务器列表
		$cur_page_before = ($pageCurrent -1 ) * $pagecount; 
		$offset = $cur_page_before >= $totalNums ? 0 : $cur_page_before;

		$ServerArr = array_slice($ServerList, $offset, $pagecount);
		
		$RestParm = array();

		foreach($ServerArr as $detail)
		{
			$tmp = array();
			$tempArr = $this->ServiceDao->GetServiceInfo($detail['serverUrl'].RESTSUFFIX,$RestParm);
			
			$tmp['recode'] = $tempArr['retcode'];
			$tmp['server_id'] = $detail['serverId'];
			$tmp['Server_name'] = $detail['serverName'];
			$tmp['Text'] = $detail['regionName']."-".$detail['serverName'];

			if (is_array($tempArr['data']))
			{
				foreach ($tempArr['data'] as $key=>$value){
					$tmp[$key] = $value;
				}
			}
			
			$DataArr[] = $tmp;
			unset($tempArr);
		}

		$result = array();
		$result['list'] = $DataArr;
		$subPages = new common\SubPages($pagecount,$totalNums,$pageCurrent);
		$result['pages'] = $subPages->show_SubPages();
		
		//echo '<pre>';print_r($DataArr);exit;
		return $result;
	}
	/**
	 * 获取游戏服务器配制
	 * @access Public
	 */
	public function getServerConfig(){
		$server_id = intval($_GET['server_id']);
		if(empty($server_id)){
			throw new \Exception($this->_LANG['argvError']);
		}
		$serverInfo = common\Functions::getServerUrl($server_id);
		$RestParm = array();
		$data = $this->ServiceDao->GetServerConf($serverInfo['Server_url'].RESTSUFFIX,$RestParm);
		if($data['retcode'] == "0"){
			$data['data']['serverName'] = $serverInfo['Server_name'];
			return $data['data'];
		}else{
			throw new \Exception($data['retmsg']);
		}
	}
	/**
	 * 设置游戏服务器配制
	 */
	public function setGameConfig(){
		$RestParm=array();
		$server_id = intval($_POST['server_id']);
		if(empty($server_id)){
			throw new \Exception($this->_LANG['argvError']);
		}
		$serverUrl = common\Functions::getServerUrl($server_id,'server');
		$RestParm['configInfo']= base64_encode(json_encode($_POST['configInfo']));
		$result = $this->ServiceDao->SetGameServerConfig($serverUrl.RESTSUFFIX,$RestParm);
		if($result['retcode'] == "0"){
			return true;
		}else{
			throw new \Exception($result['retmsg']);
		}
	}
	 /**
         * 删除服务器
	 * @return id
         */
	public function	setDelServer(){
		$server_id = intval($_GET['server_id']);
		if(empty($server_id)){
                        throw new \Exception($this->_LANG['argvError']);
                }
		$result = $this->ServiceDao->SetGmtServerDel($server_id);
		if($result > 0){
			return true;
		}else{
			throw new \Exception($this->_LANG['sqlQueryError']);
		}
	}
}
