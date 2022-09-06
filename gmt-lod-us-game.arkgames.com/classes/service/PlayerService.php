<?php
/**
 * @filesource PlayerService.php
 * @desc 游戏用户查询接口，Service层
 * @author Juezhong Long
 * date 2010-07-06
 */

namespace service;

use framework\core;
use entity;
use dao;
use framework\util;
use common;
use ctrl\LogCtrl;

class PlayerService extends ServersAbs 
{
	private $PlayerDao;
	private $server_url; //服务器的请求URL
	private $pagecount; //每页显示的条数
	private $pageCurrent; //当前页数
	private $result = array();
	private $list = array();

	/**
	 * @desc 初始化父类构造函数，实例化PlayerDao对象
	 */
	public function __construct() 
	{
		parent::__construct();
		$this->PlayerDao = util\Singleton::get("dao\\PlayerDao");
		if($_POST)
		{
			$this->server_url = common\Functions::getServerUrl($_POST['server_id'],'server');
			if($this->server_url == false) throw new \Exception($this->_LANG['SelectServers']); //不存在返回false
		}	
		
		$this->pagecount = !empty($_REQUEST['pagecount']) ? $_REQUEST['pagecount'] : 30;
		$this->pageCurrent = !empty($_REQUEST['p']) ? $_REQUEST['p'] : 1;

		if(!empty($_POST['d']) && $_POST['d'] == 1)
		{
			$this->pagecount = $_REQUEST['pagecount'] = 5000;
			$this->page = $_REQUEST['p'] = 1;
		}
	}
	
	public function addEquip()
	{
	    $params = array();
	    $result = $this->PlayerDao->addEquip($this->server_url.RESTSUFFIX,$_POST);
	    return $result;
	}
	
	/**
	 * @desc 请求逻辑处理，访问DAO层获取信息
	 * @return Array
	 */
	public function serviceDataQuery()
	{
		if($_POST)
		{

			if($_POST['lastLoginIp']&&!preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/',$_POST['lastLoginIp'])){
				throw new \Exception($this->_LANG['ipError']);
			}
			$RestParm = array(
								'opType'      =>  $_POST['user_type'],
								'opValue'     =>  $_POST['user_value'],
								'isPay'       =>  $_POST['isPay'],
								'status'      =>  $_POST['status'],
								'begTime'      =>  $_POST['begTime'],
								'endTime'     =>  $_POST['endTime'],
								'lastLoginIp' =>  $_POST['lastLoginIp'],
								'unique_key' => $_POST['unique_key'],
								'page'        =>  $this->pageCurrent,
								'pagecount'    =>  $this->pagecount
								
							);

			if (empty($_POST['user_type']) || empty($_POST['user_value']))
			{
				//throw new \Exception($this->_LANG['userTypeError']);
			}

			if (!empty($_POST['level_begin']) || !empty($_POST['level_end']))
			{
				if (empty($_POST['level_begin']) || empty($_POST['level_end']))
				{
					throw new \Exception($this->_LANG['error_level_range']);
				}

				if (!is_numeric($_POST['level_begin']) || !is_numeric($_POST['level_end']))
				{
					throw new \Exception($this->_LANG['error_level_range']);
				}

				if ($_POST['level_begin'] > $_POST['level_end'])
				{
					throw new \Exception($this->_LANG['error_level_range']);
				}

				$RestParm['level_begin'] = $_POST['level_begin'];
				$RestParm['level_end'] = $_POST['level_end'];
			}

			try {
				$serverReturn = $this->PlayerDao->getPlayerInfo($this->server_url.RESTSUFFIX,$RestParm);
			}catch (Exception $e) {
	    		throw new \Exception($e->getMessage(), "\n");
			}
			$pageNums = !empty($serverReturn['totalRows']) ? $serverReturn['totalRows'] : 0;
			//die(var_dump($serverReturn));
			//
			if($serverReturn['retcode'] == 0)
			{
				/**
				 * 为下载列表转换特殊标识
				 */
				if($_POST['d'] == 1)
				{
					$this->list[] = array(
									$this->_LANG['passportId'],
									$this->_LANG['passportName'],
									$this->_LANG['roleId'],
									$this->_LANG['roleName'],
									$this->_LANG['createTime'],
									$this->_LANG['lastLoginTime'],
									$this->_LANG['lastLoginIp'],
									$this->_LANG['logout_time'],
									$this->_LANG['isGm'],
									$this->_LANG['voucher_order_amount'],
								); 
					foreach($serverReturn['data'] as $tmp)
					{
						$tmp_info = array();
						$tmp['isPay'] = $tmp['isPay'] == 1 ? $this->_LANG['yes'] : $this->_LANG['no'];
						if($tmp['status'] == 0)
						{
							$tmp['status'] = $this->_LANG['normal'];
						}elseif($tmp['status'] == 1){
							$tmp['status'] = $this->_LANG['block'];
						}elseif ($tmp['status'] == 2){
							$tmp['status'] = $this->_LANG['gag'];
						}
						$tmp_info['player_id'] = $tmp['player_id'];
						$tmp_info['account'] = $tmp['account'];
						$tmp_info['character_id'] = $tmp['character_id'];
						$tmp_info['nick'] = $tmp['nick'];
						$tmp_info['created'] = $tmp['created'];
						$tmp_info['now_login_time'] = $tmp['now_login_time'];
						$tmp_info['now_login_ip'] = $tmp['now_login_ip'];
						$tmp_info['logout_time'] = $tmp['logout_time'];
						$tmp_info['is_gm'] = $tmp['is_gm'];
						$tmp_info['total_pay'] = $tmp['total_pay'];
						$this->list[] = $tmp_info;
					}
				}else{
					$this->list = $serverReturn['data'];
				}
			}else{

				die(var_dump($serverReturn));
				throw new \Exception($serverReturn['retmsg']);
			}
				unset($serverReturn);

		}
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();


		return $this->result;
	}



	
	
	/**
	 * 游戏加载数查询
	 * @throws \Exception
	 * @return multitype:
	 */
	public function getGameLoadData()
	{
		if($_POST)
		{
			if (!$_POST['begTime'] || !$_POST['endTime'])
			{
				throw new \Exception("请输入有效的查询日期");
			}
			
			$begTime = date('Y-m-d',strtotime($_POST['begTime']));
			$endTime = date('Y-m-d',strtotime($_POST['endTime']));
						
			$RestParm = array(
					'begTime'     =>  $begTime,
					'endTime'     =>  $endTime,
					'page'        =>  $this->pageCurrent,
					'pagecount'   =>  $this->pagecount
	
			);
			
			try {
				$serverReturn = $this->PlayerDao->getGameLoadData($this->server_url.RESTSUFFIX,$RestParm);
			}catch (Exception $e) {
				throw new \Exception($e->getMessage(), "\n");
			}
			
			$pageNums = !empty($serverReturn['totalRows']) ? $serverReturn['totalRows'] : count($serverReturn['data']);
				
			if($serverReturn['retcode'] == 0)
			{
				$this->list = $serverReturn['data'];
			}
			else
			{
				throw new \Exception($serverReturn['retmsg']);
			}
			unset($serverReturn);
		}
		
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();
		return $this->result;
	}
	
	
	/**
	 * 帮会用户信息查询
	 * @throws \Exception
	 * @return multitype:
	 */
	public function getGangPlayerInfo()
	{
		if($_POST)
		{
			$RestParm = array(
					'opType'      =>  $_POST['user_type'],
					'opValue'     =>  $_POST['user_value'],
					'begTime'     =>  $_POST['begTime'],
					'endTime'     =>  $_POST['endTime'],
					'page'        =>  $this->pageCurrent,
					'pagecount'   =>  $this->pagecount
		
			);
			try {
				$serverReturn = $this->PlayerDao->getGangPlayerInfo($this->server_url.RESTSUFFIX,$RestParm);
			}catch (Exception $e) {
				throw new \Exception($e->getMessage(), "\n");
			}
			$pageNums = !empty($serverReturn['totalRows']) ? $serverReturn['totalRows'] : count($serverReturn['data']);
			
			if($serverReturn['retcode'] == 0)
			{
				$this->list = $serverReturn['data'];
			}
			else
			{
				throw new \Exception($serverReturn['retmsg']);
			}
			unset($serverReturn);
		}
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();
		return $this->result;
	}
	
	/**
	 * 解散帮会
	 * @return unknown
	 */
	public function disbandGang()
	{
		$RestParm = array(
				'gang_title'   =>  $_REQUEST['gang_title'],
		);
		$result = $this->PlayerDao->disbandGang($this->server_url.RESTSUFFIX,$RestParm);
		return $result;
	}
	
	/**
	 * 清除二级密码
	 * @return unknown
	 */
	public function removePassword()
	{
		$RestParm = array(
				'user_type'   =>  $_REQUEST['user_type'],
				'user_value'  =>  $_REQUEST['user_value'],
		);
		$result = $this->PlayerDao->removePassword($this->server_url.RESTSUFFIX,$RestParm);
		return $result;
	}
	
	
	/**
	 * @desc 获取断交侠客信息
	 * @return Array
	 */
	public function getPetInfo()
	{
		if($_POST)
		{
			if($_POST['lastLoginIp']&&!preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/',$_POST['lastLoginIp'])){
				throw new \Exception($this->_LANG['ipError']);
			}
			$RestParm = array(
					'opType'      =>  $_POST['user_type'],
					'opValue'     =>  $_POST['user_value'],
					'isPay'       =>  $_POST['isPay'],
					'status'      =>  $_POST['status'],
					'begTime'      =>  $_POST['begTime'],
					'endTime'     =>  $_POST['endTime'],
					'page'        =>  $this->pageCurrent,
					'pagecount'    =>  $this->pagecount
	
			);
			try {
				$serverReturn = $this->PlayerDao->getPetInfo($this->server_url.RESTSUFFIX,$RestParm);
			}catch (Exception $e) {
				throw new \Exception($e->getMessage(), "\n");
			}
			$pageNums = !empty($serverReturn['totalRows']) ? $serverReturn['totalRows'] : 0;
			//die(var_dump($serverReturn));
			if($serverReturn['retcode'] == 0)
			{
				/**
				 * 为下载列表转换特殊标识
				 */
				if($_POST['d'] == 1)
				{
					$this->list[] = array(
							$this->_LANG['passportId'],
							$this->_LANG['passportName'],
							$this->_LANG['roleId'],
							$this->_LANG['roleName'],
							$this->_LANG['payUser'],
							$this->_LANG['userStat'],
							$this->_LANG['lastLoginTime'],
							$this->_LANG['lastLoginIp'],
							$this->_LANG['createTime']
					);
					foreach($serverReturn['data'] as $tmp)
					{
						$this->list[] = $tmp;
					}
				}else{
					$this->list = $serverReturn['data'];
				}
			}else{
				throw new \Exception($serverReturn['retmsg']);
			}
			unset($serverReturn);
		}
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();
		return $this->result;
	}
		
	
	
	public function serviceListBlock()
	{
		if($_POST)
		{
			if($_POST['endTime'] && $_POST['begTime'] && $_POST['endTime'] < $_POST['begTime']){
				//throw new \Exception($this->_LANG['ipError']);	
				throw new \Exception($this->_LANG['dateError']);	
			}
			$RestParm = array(
								'begTime'   =>  $_POST['begTime'],
								'endTime'  =>  $_POST['endTime'],
								'opType'   =>  $_POST['user_type'],
								'opValue'  =>  $_POST['user_value'],
								'page'     =>  $this->pageCurrent,
								'pagecount' =>  $this->pagecount
							);
			try {
				$serverReturn = $this->PlayerDao->getBanLoginlist($this->server_url.RESTSUFFIX,$RestParm);
			}catch (Exception $e) {
	    		throw new \Exception($e->getMessage(), "\n");
			}
			$pageNums = !empty($serverReturn['data']['totalRows']) ? $serverReturn['data']['totalRows'] : 0;
			if($serverReturn['retcode'] == 0)
			{
				/**
				 * 为下载列表转换特殊标识
				 */
				if($_POST['d'] == 1)
				{
					$this->list[] = array(
									$this->_LANG['passportId'],
									$this->_LANG['passportName'],
									$this->_LANG['roleId'],
									$this->_LANG['roleName'],
									$this->_LANG['payUser'],							
									$this->_LANG['blockTime'],
									$this->_LANG['blockReason']
								);
					foreach($serverReturn['data'] as $tmp)
					{
						$tmp['isPay'] = $tmp['isPay'] == 1 ? $this->_LANG['yes'] : $this->_LANG['no'];
						$this->list[] = $tmp;
					}
				}else{
					$this->list = $serverReturn['data'];
				}
			}else{
				throw new \Exception($serverReturn['retmsg'] . 'asdfasf' . json_encode($serverReturn));
			}
				unset($serverReturn);
		}
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();
		return $this->result;
	}
	
	public function serviceListGag()
	{
		if($_POST)
		{
			 if($_POST['endTime'] && $_POST['begTime'] && $_POST['begTime'] >= $_POST['endTime']){
                                //throw new \Exception($this->_LANG['ipError']);
                                throw new \Exception($this->_LANG['dateError']);
                        }			
			$RestParm = array(
								'begTime'   =>  $_POST['begTime'],
								'endTime'  =>  $_POST['endTime'],
								'opType'   =>  $_POST['user_type'],
								'opValue'  =>  $_POST['user_value'],
								'page'     =>  $this->pageCurrent,
								'pagecount' =>  $this->pagecount
							);
			try {
				$serverReturn = $this->PlayerDao->getBanTalkList($this->server_url.RESTSUFFIX,$RestParm);
			}catch (Exception $e) {
	    		throw new \Exception($e->getMessage(), "\n");
			}
			
			$pageNums = !empty($serverReturn['data']['totalRows']) ? $serverReturn['data']['totalRows'] : 0;
			
			if($serverReturn['retcode'] == 0)
			{
				/**
				 * 为下载列表转换特殊标识
				 */
				if($_POST['d'] == 1)
				{
					$this->list[] = array(
									$this->_LANG['passportId'],
									$this->_LANG['passportName'],
									$this->_LANG['roleId'],
									$this->_LANG['roleName'],
									$this->_LANG['payUser'],							
									$this->_LANG['gagTime'],
									$this->_LANG['gagReason']
								);
					foreach($serverReturn['data'] as $tmp)
					{
						$tmp['isPay'] = $tmp['isPay'] == 1 ? $this->_LANG['pay'] : $this->_LANG['free'];
						$this->list[] = $tmp;
					}
				}else{
					$this->list = $serverReturn['data'];
				}
			}else{
				throw new \Exception($serverReturn['retmsg']);
			}
				unset($serverReturn);
		}
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();
		return $this->result;
	}
	
	/**
	 * 设置封禁及禁言用户
	 * @return unknown_type
	 */
	public function serviceUserBlockGag()
	{

		if(empty($_POST['endTime']) || empty($_POST['reason']) || empty($_POST['roleId']))
		{
			throw new \Exception($this->_LANG['blockGagNotice']);
		}
		$RestParm = array(
				'endTime'   =>  $_POST['endTime'],
				'roleId'    =>  $_POST['roleId'],
				'reason'    =>  $_POST['reason'],
				'author'    =>  $_SESSION['infoUser']['fullname'],
			);


		$ActionService = util\Singleton::get("service\\ActionService");
		$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);

		$action['actkey'] = 4;


		if($_POST['type'] == 2)
		{
			$RestParm['ext'] = '';
			LogCtrl::CallOperationLogs($_POST['server_id'],$this->_LANG['gagReason'].':'.$_POST['reason'],$_POST['roleId'],$action['actkey'],$this->_LANG['gag'],'角色id:'.$_POST['roleId']);
		}else{
			$this->_LANG['gag'].'roleId:'.$_POST['roleId'];
			LogCtrl::CallOperationLogs($_POST['server_id'],$this->_LANG['blockReason'].':'.$_POST['reason'],$_POST['roleId'],$action['actkey'],$this->_LANG['block'],'角色id:'.$_POST['roleId']);
		}
		$serverReturn = $this->PlayerDao->setBlockGag($this->server_url.RESTSUFFIX,$RestParm);
		return $serverReturn;
	}
	
	/**
	 * 解封禁及禁言用户
	 * @return Array
	 */
	public function serviceUndoUserBlockGag()
	{
		//throw new \Exception(2222222);
		if(empty($_POST['reason']) || empty($_POST['roleId']))
		{
			//throw new \Exception($this->_LANG['reasonNotice']);
			throw new \Exception(2222222);
		}
		$RestParm = array(
				'roleId'    =>  $_POST['roleId'],
				'reason'    =>  $_POST['reason'],
				'author'    =>  $_SESSION['infoUser']['fullname'],
			);		
		$ActionService = util\Singleton::get("service\\ActionService");
		/*$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
		if($_POST['type'] == 2)
		{
			$RestParm['ext'] = '';
			LogCtrl::CallOperationLogs($_POST['server_id'],$this->_LANG['undoGagReason'].':'.$_POST['reason'],$_POST['roleId'],$action['actkey'],$this->_LANG['undoGag'],'角色id:'.$_POST['roleId']);
		}else{
			LogCtrl::CallOperationLogs($_POST['server_id'],$this->_LANG['undoBlockReason'].':'.$_POST['reason'],$_POST['roleId'],$action['actkey'],$this->_LANG['undoBlock'],'角色id:'.$_POST['roleId']);
		}*/
		$serverReturn = $this->PlayerDao->setUndoBlockGag($this->server_url.RESTSUFFIX,$RestParm);
		return $serverReturn;
	}	
	
	/**
	 * 踢人
	 * @return Array
	 */
	public function setOffLine()
	{
		if(empty($_POST['roleId']))
		{
			throw new \Exception($this->_LANG['roleNotice']);
		}
		$RestParm = array(
				'roleId'    =>  $_POST['roleId'],
				'author'    =>  $_SESSION['infoUser']['fullname'],
			);		
		$ActionService = util\Singleton::get("service\\ActionService");
		$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
		LogCtrl::CallOperationLogs($_POST['server_id'], $this->_LANG['setOffLine'],$action['actkey'],$this->_LANG['setOffLine'],'角色id:'.$_POST['roleId']);
		$serverReturn = $this->PlayerDao->setOffLine($this->server_url.RESTSUFFIX,$RestParm);
		return $serverReturn;
	}

	/**
	 * 设置取消GM账号
	 * @return Array
	 */
	public function setGm()
	{
		if(empty($_POST['roleId']))
		{
			throw new \Exception($this->_LANG['reasonNotice']);
		}
		$RestParm = array(
				'roleId'    =>  $_POST['roleId'],
				'isGm'		=>	$_POST['isGm'],
				'author'    =>  $_SESSION['infoUser']['fullname'],
			);		
		$ActionService = util\Singleton::get("service\\ActionService");
		$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
		LogCtrl::CallOperationLogs($_POST['server_id'], $_POST['isGm'] ? $this->_LANG['setGm'] : $this->_LANG['unsetGm'],$action['actkey'],$this->_LANG['setGmTitle'],'角色id:'.$_POST['roleId']);
		$serverReturn = $this->PlayerDao->setGm($this->server_url.RESTSUFFIX,$RestParm);
		return $serverReturn;
	}
	
	/**
	 * 获取玩家详细信息
	 * @return Array
	 */
	public function getChDetail()
	{
		if(empty($_GET['roleId']))
		{
			throw new \Exception($this->_LANG['reasonNotice']);
		}
		$RestParm = array(
				'roleId'    =>  $_GET['roleId'],
			);		
		
		$server_url = common\Functions::getServerUrl($_GET['server_id'],'server');
		$serverReturn = $this->PlayerDao->getChDetail($server_url.RESTSUFFIX,$RestParm);
		return $serverReturn;
	}	
	
	/**
	 * 查询玩家等级分布
	 * @return Array
	 */
	public function getLevelDistributionList()
	{
		$RestParm = array(
				'page'    =>  $this->pageCurrent,
				'pagecount'    =>  $this->pagecount,
			);		
		$server_url = common\Functions::getServerUrl($_POST['server_id'],'server');
		$serverReturn = $this->PlayerDao->getLevelDistributionList($server_url.RESTSUFFIX,$RestParm);
		
		if($serverReturn['retcode'] > 0)
		{
			common\Functions::debug($serverReturn['retmsg']);
		}
		$subPages = new common\SubPages($this->pagecount, $serverReturn['data']['totalRows'],$this->pageCurrent);
		$serverReturn['pages'] = $subPages->show_SubPages();
		return $serverReturn;
	}
	
	/**
	 * 玩家道具流向查询
	 * @return Array
	 */
	public function getEquipFlowList()
	{
		if($_POST)
		{
			if($_POST['user_type'] < 1 || empty($_POST['user_value']))
			{
				//throw new \Exception($this->_LANG['roleNotice']);
			}
			
			$RestParm = array(
					'op_id'   => $_POST['op_id'],
					'user_type'  => $_POST['user_type'],
					'user_value' => $_POST['user_value'],
					'equipId'    => $_POST['equipId'],
					'equipTitle' => $_POST['equipTitle'],
					'begTime'    => $_POST['beginDate'],
					'endTime'    => $_POST['endDate'],
					'source_direct' => intval($_POST['source_direct']),
					'page'       =>  $this->pageCurrent,
					'pagecount'  =>  $this->pagecount,
				);		
			$server_url = common\Functions::getServerUrl($_POST['server_id'],'server');
			$serverReturn = $this->PlayerDao->getEquipFlowList($server_url.RESTSUFFIX,$RestParm);
			
			if($serverReturn['retcode'] > 0)
			{
				throw new \Exception($serverReturn['retmsg']);
				common\Functions::debug($serverReturn['retmsg']);
			}

			if($_POST['d'] == 1)
			{
				$data_download = array();
				$data_download[] = array(
						$this->_LANG['equip_title'],
						$this->_LANG['equip_id'],
						$this->_LANG['equipNum'],
						$this->_LANG['roleName'],
						$this->_LANG['roleId'],
						$this->_LANG['accountId'],
						$this->_LANG['sourceDirect'],
						$this->_LANG['op_id'],
						$this->_LANG['awardSource'],
						$this->_LANG['targetNick'],
						$this->_LANG['targetCid'],
						$this->_LANG['scene_id'],
						$this->_LANG['created'],
				);

				if (!empty($serverReturn['data']['data']))
				{
					foreach($serverReturn['data']['data'] as $_detail)
					{
						$tmp = array();
						$tmp[] = $_detail['equip_title'];
						$tmp[] = $_detail['equip_id'];
						$tmp[] = $_detail['equip_num'];
						$tmp[] = $_detail['master_nick'];
						$tmp[] = $_detail['master_cid'];
						$tmp[] = $_detail['master_pid'];

						if ($_detail['is_get'] == 1)
						{
							$tmp[] = $this->_LANG['sourceGet'];
						}
						else
						{
							$tmp[] = $this->_LANG['sourceLose'];
						}
						
						$tmp[] = $_detail['op_title'];
						$tmp[] = $_detail['reward_module_title'];
						$tmp[] = $_detail['slave_nick'];
						$tmp[] = $_detail['slave_cid'];
						$tmp[] = $_detail['scene_id'];
						$tmp[] = $_detail['created'];

						$data_download[] = $tmp;	
					}

					$serverReturn['data']['data'] = $data_download;
				}
			}
		}
		$subPages = new common\SubPages($this->pagecount, $serverReturn['data']['totalRows'], $this->pageCurrent);
		$serverReturn['pages'] = $subPages->show_SubPages();
		return $serverReturn;
	}	
	
	//道具流向统计
	public function getEquipFlowStats()
	{
		if($_POST)
		{
			if($_POST['user_type'] < 1 || empty($_POST['user_value']))
			{
				throw new \Exception($this->_LANG['roleNotice']);
			}
			
			//时间判断
			if(empty($_POST['beginDate']) || empty($_POST['endDate'])){
				throw new \Exception($this->_LANG['begOrEndDateEmpty']);
			}

			$beginDateTime  =  strtotime($_POST['beginDate']);
			$endDateTime = strtotime($_POST['endDate']);

			if($beginDateTime>$endDateTime)
			{
				throw new \Exception($this->_LANG['dateError']);
			}

			//throw new \Exception($_POST['beginDate']. ' -> ' . $_POST['endDate']);
			$limit_time = 15 * 24 * 3600;
			$limit_str = $beginDateTime + $limit_time;

			if($limit_str<$endDateTime)
			{
				throw new \Exception($this->_LANG['equipFlowStatsDesc']);
			}

			if (empty($_POST['equipId']) && empty($_POST['equipTitle']))
			{
				throw new \Exception($this->_LANG['error_equip_info']);
			}

			$RestParm = array(
					'op_id'   => $_POST['op_id'],
					'user_type'  => $_POST['user_type'],
					'user_value' => $_POST['user_value'],
					'equipId'    => $_POST['equipId'],
					'equipTitle' => $_POST['equipTitle'],
					'begTime'    => $_POST['beginDate'],
					'endTime'    => $_POST['endDate'],
					'source_direct' => intval($_POST['source_direct']),
					'page'       =>  $this->pageCurrent,
					'pagecount'  =>  $this->pagecount,
				);		
			$server_url = common\Functions::getServerUrl($_POST['server_id'],'server');

			$RestHost = $server_url.RESTSUFFIX;
			$serverReturn = common\Rest::CallCommRestInterFace('GameTools.getEquipFlowStats',$RestHost,$RestParm);
			//echo '<pre>';print_r($serverReturn);exit;

			if($serverReturn['retcode'] > 0)
			{
				$retmsg = !empty($serverReturn['retmsg']) ? $serverReturn['retmsg'] : $this->_LANG['op_fail'];
				throw new \Exception($retmsg);
			}

			if($_POST['d'] == 1)
			{
				$data_download = array();
				$data_download[] = array(
						$this->_LANG['DateTime'],
						$this->_LANG['pid'],
						$this->_LANG['roleId'],
						$this->_LANG['roleName'],
						$this->_LANG['equip_id'],
						$this->_LANG['equip_title'],
						$this->_LANG['equipNum'],
				);

				if (!empty($serverReturn['data']['data']))
				{
					foreach($serverReturn['data']['data'] as $_detail)
					{
						$tmp = array();
						$tmp[] = $_detail['date_time'];
						$tmp[] = $_detail['master_pid'];
						$tmp[] = $_detail['master_cid'];
						$tmp[] = $_detail['master_nick'];
						$tmp[] = $_detail['equip_id'];
						$tmp[] = $_detail['equip_title'];
						$tmp[] = $_detail['equip_num'];


						$data_download[] = $tmp;	
					}

					$serverReturn['data']['data'] = $data_download;
				}
			}
		}
		$subPages = new common\SubPages($this->pagecount, $serverReturn['data']['totalRows'], $this->pageCurrent);
		$serverReturn['pages'] = $subPages->show_SubPages();
		return $serverReturn;
	}	

	//获取道具流向对应日期范围明细
	public function getEquipFlowDetail()
	{
		if(empty($_GET) || empty($_GET['roleId']))
		{
			throw new \Exception($this->_LANG['reasonNotice']);
		}
		
		$date_time = $_GET['date_time'];
		$beginDate = $date_time . ' 00:00:00';
		$endDate = $date_time . ' 23:59:59';

		$RestParm = array(
				'op_id'   => $_GET['op_id'],
				'user_type'  => 3,
				'user_value' => $_GET['roleId'],
				'equipId'    => $_GET['equip_id'],
				'equipTitle' => '',
				'begTime'    => $beginDate,
				'endTime'    => $endDate,
				'source_direct' => intval($_GET['source_direct']),
				'page'       =>  1,
				'pagecount'  =>  10000,
			);	

		$server_url = common\Functions::getServerUrl($_GET['server_id'],'server');
		$serverReturn = $this->PlayerDao->getEquipFlowList($server_url.RESTSUFFIX,$RestParm);
		
		if($serverReturn['retcode'] > 0)
		{
			throw new \Exception($serverReturn['retmsg']);
		}

		return $serverReturn;
	}	

	/**
	 * 宝物碎片流向日志
	 * @return Array
	 */
	public function getBaoWuChipList()
	{
		if($_POST)
		{
			if($_POST['user_type'] < 1 || empty($_POST['user_value']))
			{
				throw new \Exception($this->_LANG['roleNotice']);
			}
			
			$RestParm = array(
					'op_id'   => $_POST['op_id'],
					'user_type'  => $_POST['user_type'],
					'user_value' => $_POST['user_value'],
					'equipId'    => $_POST['equipId'],
					'equipTitle' => $_POST['equipTitle'],
					'begTime'    => $_POST['beginDate'],
					'endTime'    => $_POST['endDate'],
					'page'       =>  $this->pageCurrent,
					'pagecount'  =>  $this->pagecount,
				);		
			$server_url = common\Functions::getServerUrl($_POST['server_id'],'server');
			$RestHost = $server_url.RESTSUFFIX;
			$serverReturn = common\Rest::CallCommRestInterFace('GameTools.getBaoWuChipList',$RestHost,$RestParm);
			
			if($serverReturn['retcode'] > 0)
			{
				throw new \Exception($serverReturn['retmsg']);
			}

			if($_POST['d'] == 1)
			{
				$data_download = array();
				$data_download[] = array(
						$this->_LANG['get_cid'],
						$this->_LANG['get_pid'],
						$this->_LANG['get_nick'],
						$this->_LANG['op_id'],
						$this->_LANG['lost_cid'],
						$this->_LANG['lost_pid'],
						$this->_LANG['lost_nick'],
						$this->_LANG['chip_equip_id'],
						$this->_LANG['chip_equip_title'],
						$this->_LANG['chip_equip_num'],
						$this->_LANG['created'],
				);

				if (!empty($serverReturn['data']['data']))
				{
					foreach($serverReturn['data']['data'] as $_detail)
					{
						$tmp = array();
						$tmp[] = $_detail['get_cid'];
						$tmp[] = $_detail['get_pid'];
						$tmp[] = $_detail['get_nick'];
						$tmp[] = $_detail['op_title'];
						$tmp[] = $_detail['lost_cid'];
						$tmp[] = $_detail['lost_pid'];
						$tmp[] = $_detail['lost_nick'];
						$tmp[] = $_detail['chip_equip_id'];
						$tmp[] = $_detail['chip_equip_title'];
						$tmp[] = $_detail['chip_equip_num'];
						$tmp[] = $_detail['created'];

						$data_download[] = $tmp;	
					}

					$serverReturn['data']['data'] = $data_download;
				}
			}
		}
		$subPages = new common\SubPages($this->pagecount, $serverReturn['data']['totalRows'], $this->pageCurrent);
		$serverReturn['pages'] = $subPages->show_SubPages();
		return $serverReturn;
	}
	
	/**
	 * 检查名字
	 * @return Array
	 */
	public function checkNicks()
	{
		//检查角色名
		if($_POST['is_check_role_name'] && $_POST['receiverType'] == 2)
		{
			//TODO 从excel中读取角色名
			if(empty($_POST['rids']))
			{
				common\Functions::debug($_LANG['']);
				return;
			}
			$server_url = common\Functions::getServerUrl($_REQUEST['server_id'],'server');
			
			$serverReturn = $this->PlayerDao->checkNicks($server_url.RESTSUFFIX,array('nicks' => $_POST['rids']));
			
			if($serverReturn['retcode'] > 0)
			{
				common\Functions::debug($serverReturn['retmsg']);
				return;
			}
			
			$exist_nicks = $serverReturn['data']['exist_nicks'];
			$nexist_nicks = $serverReturn['data']['nexist_nicks'];
			if(empty($nexist_nicks) && !empty($exist_nicks))
			{
				common\Functions::debug("正确！存在的角色名有[$exist_nicks]。");
			}				
			else
				common\Functions::debug("错误！不存在的角色名有[$nexist_nicks]，存在的角色名有[$exist_nicks]。");
			return;
		}
	}	

	/**
	 * 移出排行榜
	 * @return Array
	 */
	public function setOffRank()
	{
		//$server_url = common\Functions::getServerUrl($_POST['server_id'],'server');

		//erverReturn = $this->PlayerDao->checkNicks($server_url.RESTSUFFIX,array('nicks' => $_POST['rids']));


		if(empty($_POST['roleId']))
		{
			throw new \Exception($this->_LANG['roleNotice']);
		}
		$RestParm = array(
				'roleId'    =>  $_POST['roleId'],
				'isOff'		=>	intval($_POST['isOff']),
				'author'    =>  $_SESSION['infoUser']['fullname'],
			);		
		$ActionService = util\Singleton::get("service\\ActionService");
		$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
		LogCtrl::CallOperationLogs($_POST['server_id'], $this->_LANG['setOffRank'],$action['actkey'],$this->_LANG['setOffRank'],'角色id:'.$_POST['roleId']);
		//$serverReturn = $this->PlayerDao->setOffRank($this->server_url.RESTSUFFIX,$RestParm);



		/*$RestHost = $this->server_url.RESTSUFFIX;
		$serverReturn = common\Rest::CallCommRestInterFace('GameTools.setOffRank',$RestHost,$RestParm);*/

		$server_url = $this->server_url; //获取游戏服的地址
		if($server_url == false) throw new \Exception($this->_LANG['SelectServers']); //不存在返回false

		$url_with_get = 'http://'.$server_url.'/webproxy.php?act=removeChToplist';
		$postfields = array('data' => json_encode($RestParm));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_with_get);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
		curl_setopt($ch, CURLOPT_TIMEOUT, 300);
		$serverReturn = curl_exec($ch);
		curl_close($ch);

		$serverReturn = json_decode($serverReturn,true);
		//throw new \Exception();
			
		if (!empty($serverReturn) && $serverReturn['retcode'] == 0)
		{
			$serverReturn['retmsg'] = '操作成功';
		}

		return $serverReturn;
	}

	//获取玩家简要信息
	public function getBaseInfo()
	{
		if($_POST)
		{
			$RestParm = array(
								'opType'      =>  $_POST['user_type'],
								'opValue'     =>  $_POST['user_value'],
								'isPay'       =>  $_POST['isPay'],
								'status'      =>  $_POST['status'],
								'begTime'      =>  $_POST['begTime'],
								'endTime'     =>  $_POST['endTime'],
								'lastLoginIp' =>  $_POST['lastLoginIp'],
								'page'        =>  $this->pageCurrent,
								'pagecount'    =>  $this->pagecount
								
							);
			try {
				//$serverReturn = $this->PlayerDao->getPlayerInfo($this->server_url.RESTSUFFIX,$RestParm);
				$RestHost = $this->server_url.RESTSUFFIX;
				//throw new \Exception($RestHost);
				$serverReturn = common\Rest::CallCommRestInterFace('GameTools.getBaseInfo',$RestHost,$RestParm);
				

			}catch (Exception $e) {
	    		throw new \Exception($e->getMessage(), "\n");
			}
			$pageNums = !empty($serverReturn['totalRows']) ? $serverReturn['totalRows'] : 0;
			//die(var_dump($serverReturn));	
			if($serverReturn['retcode'] == 0)
			{
				/**
				 * 为下载列表转换特殊标识
				 */
				if($_POST['d'] == 1)
				{
					$this->list[] = array(
									$this->_LANG['passportId'],
									$this->_LANG['passportName'],
									$this->_LANG['roleId'],
									$this->_LANG['roleName'],
									//$this->_LANG['createTime'],
									//$this->_LANG['lastLoginTime'],
									//$this->_LANG['lastLoginIp'],
									//$this->_LANG['logout_time'],
								); 
					foreach($serverReturn['data'] as $tmp)
					{
						$tmp_info = array();
						$tmp_info['player_id'] = $tmp['player_id'];
						$tmp_info['account'] = $tmp['account'];
						$tmp_info['character_id'] = $tmp['character_id'];
						$tmp_info['nick'] = $tmp['nick'];
						//$tmp_info['created'] = $tmp['created'];
						//$tmp_info['now_login_time'] = $tmp['now_login_time'];
						//$tmp_info['now_login_ip'] = $tmp['now_login_ip'];
						//$tmp_info['logout_time'] = $tmp['logout_time'];
						$this->list[] = $tmp_info;
					}
				}else{
					$this->list = $serverReturn['data'];
				}
			}else{
				throw new \Exception($serverReturn['retmsg']);
			}
				unset($serverReturn);
		}
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();
		return $this->result;
	}

	public function getChBase()
	{
		if($_POST)
		{
			$RestParm = array(
								'opType'      =>  $_POST['user_type'],
								'opValue'     =>  $_POST['user_value'],
								'page'        =>  $this->pageCurrent,
								'pagecount'    =>  $this->pagecount
								
							);
			try {
				$RestHost = $this->server_url.RESTSUFFIX;
				$serverReturn = common\Rest::CallCommRestInterFace('GameTools.getChBase',$RestHost,$RestParm);
			}catch (Exception $e) {
	    		throw new \Exception($e->getMessage(), "\n");
			}
			$pageNums = !empty($serverReturn['totalRows']) ? $serverReturn['totalRows'] : 0;
			//die(var_dump($serverReturn));	
			if($serverReturn['retcode'] == 0)
			{
				/**
				 * 为下载列表转换特殊标识
				 */
				if($_POST['d'] == 1)
				{
					$this->list[] = array(
									$this->_LANG['passportId'],
									$this->_LANG['roleId'],
									$this->_LANG['roleName'],
									$this->_LANG['createTime'],
								); 
					foreach($serverReturn['data'] as $tmp)
					{
						$tmp_info = array();
						$tmp_info['player_id'] = $tmp['player_id'];
						$tmp_info['id'] = $tmp['id'];
						$tmp_info['nick'] = $tmp['nick'];
						$tmp_info['created'] = $tmp['created'];
						$this->list[] = $tmp_info;
					}
				}else{
					$this->list = $serverReturn['data'];
				}
			}else{
				throw new \Exception($serverReturn['retmsg']);
			}
				unset($serverReturn);
		}
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();
		return $this->result;
	}
}

?>
