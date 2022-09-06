<?php
/**
 * @file   LogService.php
 * @author xiaoyang <xiaoyang.qi@kunlun-inc.com>
 * @date   Mon Dec 14 17:49:51 2010
 * 
 * @brief  日志的 Service
 * @package       LogService
 * 
 */
namespace service;
use entity;
use dao;
use common;
use framework\util;
use ctrl\LogCtrl;

class LogService extends ServersAbs{
	private $LogDao;
	private $pagecount;
	private $page;
	private $server_all = false;
	private $server_name ;
	
	public function __construct()
	{
		parent::__construct();
		if($_POST)
		{
			
			if($_POST['server_id'] == 9999) {
				$this->server_all = true;
			}else {
				$this->server_url  = common\Functions::getServerUrl($_POST['server_id'],'server');
				$this->server_name = common\Functions::getServerUrl($_POST['server_id'],'serverName');
			}
		}
		
		$this->pagecount = !empty($_REQUEST['pagecount']) ? $_REQUEST['pagecount'] : 30;

		if(!empty($_POST['d']) && $_POST['d'] == 1)
		{
			$this->pagecount = 5000;
		}

		$this->page = !empty($_REQUEST['p']) ? $_REQUEST['p'] : 1;
		$this->LogDao = util\Singleton::get("dao\\LogDao");
	}
	/**
	 * 公用GMT操作日志入库
	 * @var $content 操作信息
	 */
	public function setLogCommonInsert($content){
		$Arr->fullname = $_SESSION['infoUser']['fullname'];
		$Arr->username = $_SESSION['infoUser']['loginName'];
		$Arr->content = $content;
		$Arr->ip = common\Functions::getClientIP();
		$Arr->logDate = date('Y-m-d H:i:s');
		return $this->LogDao->fetchCommonLogSave($Arr);
	}
	/**
	 * 合作方GMT操作日志入库
	 * @var $serverId 服务器ID
	 * @var $content  操作信息
	 */
	public function setLogOperationInsert($serverId,$content,$operationObject='',$actkey,$acttitle,$affectObj){
		
		$Arr->serverId = $serverId;
		$Arr->actkey = $actkey;
		$Arr->acttitle = $acttitle;
		$Arr->affectObj = $affectObj;
		$Arr->content = $content;
		$Arr->fullname = $_SESSION['infoUser']['fullname'];
		$Arr->username = $_SESSION['infoUser']['loginName'];
		$Arr->ip = common\Functions::getClientIP();
		$Arr->logDate = date('Y-m-d H:i:s');
		$Arr->operationObject=$operationObject;
		return $this->LogDao->fetchOperationLogSave($Arr);
	}
	/**
	 * 获取GMT操作日志
	 */
	public function GetLogConmon(){
		$where = " 1 ";
		$limit = ($this->page-1)*$this->pagecount.",".$this->pagecount;
		if(!empty($_POST['fullname'])){
			$where.=" AND fullname='{$_POST['fullname']}' ";
		}
		
		if(!empty($_POST['beginDate']) && !empty($_POST['endDate'])){
			if(strtotime($_POST['beginDate'])>strtotime($_POST['endDate'])){
				throw new \Exception($this->_LANG['dateError']);
			}
			$where.=" AND LogDate>='{$_POST['beginDate']}' AND LogDate<='{$_POST['endDate']}' ";
		}
		$pageNums= $this->LogDao->fetchConmonCout($where);
		$result['list'] = $this->LogDao->fetchCommonList($where,$limit);
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->page);
		$result['pages'] = $subPages->show_SubPages();
		return $result;
	}
	/**
	 * 获取合作方操作日志
	 */
	public function GetLogOperation(){
		$where = " 1 ";
		$limit = ($this->page-1)*$this->pagecount.",".$this->pagecount;
		$where.= !empty($_POST['server_id']) ? " AND serverId='{$_POST['server_id']}' " : "";
		if(!empty($_POST['fullname'])){
			$where.=" AND fullname='{$_POST['fullname']}' ";
		}
		if(!empty($_POST['logActkey'])){
			$where.=" AND actkey='{$_POST['logActkey']}' ";
		}
		if(!empty($_POST['beginDate']) && !empty($_POST['endDate'])){
			if(strtotime($_POST['beginDate'])>strtotime($_POST['endDate'])){
				throw new \Exception($this->_LANG['dateError']);
			}
			$where.=" AND LogDate>='{$_POST['beginDate']}' AND LogDate<='{$_POST['endDate']}' ";
		}
		$pageNums= $this->LogDao->fetchOperationCout($where);
		$result['list'] = $this->LogDao->fetchOperationList($where,$limit);
		foreach ($result['list'] as $key=>$value){
			$result['list'][$key]['serverName'] = common\Functions::getServerUrl($value['serverId'],'serverName');
		}
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->page);
		$result['pages'] = $subPages->show_SubPages();
		return $result;
	}
	/**
	 * 获取游戏在线数据
	 * @var $server_id 服务器ID
	 */
	public function GetEveryDayOnlie($server_id){
		if($server_id){
			$RestParm = array('date'=>$_POST['OnlineDate']);
			$RestHost = common\Functions::getServerUrl($server_id,'server');
			$Return =  $this->LogDao->fetchEveryDayOnline($RestHost.RESTSUFFIX,$RestParm);
			if($Return['retcode']=='0'){
				if(!empty($Return['data']) && is_array($Return['data'])){
                                        $nums = count($Return['data'])-1;
                                        for($i=$nums;$i>=0;$i--){
                                                $tmpdata = explode("\t",$Return['data'][$i]);
                                                foreach($tmpdata as $key=>$value)
                                                $data[$i][$key] = $value;
                                        }
                                        $Return['data'] = $data;
                                }
				return $Return['data'];
			}else{
				throw new \Exception($Return['retmsg']);
			}
		}else{
			return false;
		}
	}
	 /**
         * 获取角色升级日志--- 通行证名不能为空，开始结束时间也不能为空
         * @var $serverId 服务器ID
         */
        public function getLogChUpgrade($serverId){
                if($serverId){
                        // if(empty($_POST['userId'])){
                                // throw new \Exception($this->_LANG['userIdEmpty']);
                                // return false;
                        // }else
						if(empty($_POST['begTime']) || empty($_POST['endTime'])){
                                throw new \Exception($this->_LANG['dateEmpty']);
                                return false;
                        }elseif(strtotime($_POST['begTime'])>strtotime($_POST['endTime'])){
                                throw new \Exception($this->_LANG['dateError']);
                                return false;
                        }elseif($this->server_url == false){
							throw new \Exception($this->_LANG['SelectServers']);
						}
                        $serverInfo = common\Functions::getServerUrl($serverId);
                        $regionUrl = common\Functions::regionOperationUrl();
			/*$passportUrl = common\Functions::passportOperationUrl();
                        $userInfo = $this->LogDao->getUserInfo($passportUrl,array('user_name'=>$_POST['userName']));
                        if($userInfo['retcode'] != 0){
                                throw new \Exception($userInfo['retmsg']);
                                return false;
                        }*/
                        $restParm = array(
							'pid'		=> $serverInfo['productId'],
							'rid'		=> $serverInfo['regionId'],
							'opType'	=> $_POST['user_type'],
							'opValue'	=> $_POST['user_value'],
							'begtime'	=> $_POST['begTime'],
							'endtime'	=> $_POST['endTime'],
							'all'		=> '1',
							'page'		=> $this->page,
							'pagecount'	=> $this->pagecount
							);
                        // $Return = $this->LogDao->fetchVoucherLog(RESTBAKREGIONS,$restParm);
                        $Return = $this->LogDao->fetchChUpgradeLog($this->server_url.RESTSUFFIX,$restParm);
                        // $banlanceParm = array('pid'=>$serverInfo['productId'],'rid'=>$serverInfo['regionId'],'uid'=>$_POST['userId']);
                        if($Return['retcode'] != 0) throw new \Exception($Return['retmsg']);
						$tempArr['list'] = $Return['data'];
                        $subPages = new common\SubPages($this->pagecount,$tempArr['list']['count'],$this->page);
						unset($tempArr['list']['count']);
                        $tempArr['pages'] = $subPages->show_SubPages();
						$tempArr['sum'] = empty($tempArr['list']) ? 0 : count($tempArr['list']);
						return $tempArr;
                }else{
                        return false;
                }
        }
	 /**
         * 获取异常监控日志--- 通行证名不能为空，开始结束时间也不能为空
         * @var $serverId 服务器ID
         */
        public function getLogException($serverId){
                if($serverId){
						if(empty($_POST['begTime']) || empty($_POST['endTime'])){
                                throw new \Exception($this->_LANG['dateEmpty']);
                                return false;
                        }elseif(strtotime($_POST['begTime'])>strtotime($_POST['endTime'])){
                                throw new \Exception($this->_LANG['dateError']);
                                return false;
                        }elseif($this->server_url == false){
							throw new \Exception($this->_LANG['SelectServers']);
						}
                        $serverInfo = common\Functions::getServerUrl($serverId);
                        $regionUrl = common\Functions::regionOperationUrl();
                        $restParm = array(
							'pid'		=> $serverInfo['productId'],
							'rid'		=> $serverInfo['regionId'],
							'opType'	=> $_POST['user_type'],
							'opValue'	=> $_POST['user_value'],
							'begtime'	=> $_POST['begTime'],
							'endtime'	=> $_POST['endTime'],
							'all'		=> '1',
							'page'		=> $this->page,
							'pagecount'	=> $this->pagecount
							);
                        $Return = $this->LogDao->fetchExceptionLog($this->server_url.RESTSUFFIX,$restParm);
                        if($Return['retcode'] != 0) throw new \Exception($Return['retmsg']);
						$tempArr['list'] = $Return['data'];
                        $subPages = new common\SubPages($this->pagecount,$tempArr['list']['count'],$this->page);
						unset($tempArr['list']['count']);
                        $tempArr['pages'] = $subPages->show_SubPages();
						$tempArr['sum'] = empty($tempArr['list']) ? 0 : count($tempArr['list']);
						return $tempArr;
                }else{
                        return false;
                }
        }
	 /**
         * 获取用户冲值日志--- 通行证名不能为空，开始结束时间也不能为空
         * @var $serverId 服务器ID
         */
        public function getLogVoucher($serverId){
                if($serverId){
                        // if(empty($_POST['userId'])){
                                // throw new \Exception($this->_LANG['userIdEmpty']);
                                // return false;
                        // }else
						if(empty($_POST['begTime']) || empty($_POST['endTime'])){
                                throw new \Exception($this->_LANG['dateEmpty']);
                                return false;
                        }elseif(strtotime($_POST['begTime'])>strtotime($_POST['endTime'])){
                                throw new \Exception($this->_LANG['dateError']);
                                return false;
                        }elseif($this->server_url == false){
							throw new \Exception($this->_LANG['SelectServers']);
						}
                        $serverInfo = common\Functions::getServerUrl($serverId);
                        $regionUrl = common\Functions::regionOperationUrl();
			/*$passportUrl = common\Functions::passportOperationUrl();
                        $userInfo = $this->LogDao->getUserInfo($passportUrl,array('user_name'=>$_POST['userName']));
                        if($userInfo['retcode'] != 0){
                                throw new \Exception($userInfo['retmsg']);
                                return false;
                        }*/
                        $restParm = array(
							'pid'		=> $serverInfo['productId'],
							'rid'		=> $serverInfo['regionId'],
							'opType'	=> $_POST['user_type'],
							'opValue'	=> $_POST['user_value'],
							'begtime'	=> $_POST['begTime'],
							'endtime'	=> $_POST['endTime'],
							'all'		=> '1',
							'page'		=> $this->page,
							'pagecount'	=> $this->pagecount
							);
                        // $Return = $this->LogDao->fetchVoucherLog(RESTBAKREGIONS,$restParm);
                        $Return = $this->LogDao->fetchVoucherLog($this->server_url.RESTSUFFIX,$restParm);
                        // $banlanceParm = array('pid'=>$serverInfo['productId'],'rid'=>$serverInfo['regionId'],'uid'=>$_POST['userId']);
                        if($Return['retcode'] != 0) throw new \Exception($Return['retmsg']);
						$tempArr['list'] = $Return['data'];
                        $subPages = new common\SubPages($this->pagecount,$tempArr['list']['count'],$this->page);
						unset($tempArr['list']['count']);
                        $tempArr['pages'] = $subPages->show_SubPages();
						$tempArr['sum'] = empty($tempArr['list']) ? 0 : count($tempArr['list']);
						return $tempArr;
                        // $banlance = $this->LogDao->fetchBlanceCoin($regionUrl,$banlanceParm);
                        // if($banlance['retcode'] != 0) throw new \Exception($banlance['retmsg']);
                        // $dataArr = explode("\n",$Return['data']);
                        // unset($dataArr[count($dataArr)-1]);
                        // foreach ($dataArr as $v){
                                // $t = explode("\t",$v);
                                // $sum+=$t[3];
                                // unset($t);
                        // }
                        // $start = ($this->page - 1) * $this->pagecount;
                        // $outList= array_slice($dataArr, $start,$this->pagecount);
                        // foreach ($outList as $value){
                                // $tempArr['list'][] = explode("\t",$value);
                        // }
                        // $tempArr['total'] =$sum;
                        // $subPages = new common\SubPages($this->pagecount,count($dataArr),$this->page);
                        // $tempArr['pages'] = $subPages->show_SubPages();
                        // $tempArr['goldCoin'] = $banlance['balance'];
                        // return $tempArr;
                }else{
                        return false;
                }
        }
	/**
         * 获取用户消费日志 --- 通行证名不能为空，开始结束时间也不能为空
         * @var $serverId 服务器ID
         */
        public function getLogCousumer($serverId){
                if($serverId){
                        // if(empty($_POST['userId'])){
                                // throw new \Exception($this->_LANG['userIdEmpty']);
                                // return false;
                        // }else
						if(empty($_POST['begTime']) || empty($_POST['endTime'])){
                                throw new \Exception($this->_LANG['dateEmpty']);
                                return false;
                        }elseif(strtotime($_POST['begTime'])>strtotime($_POST['endTime'])){
                                throw new \Exception($this->_LANG['dateError']);
                                return false;
                        }elseif($this->server_url == false){
							throw new \Exception($this->_LANG['SelectServers']);
						}
                        $serverInfo = common\Functions::getServerUrl($serverId);
			/*$passportUrl = common\Functions::passportOperationUrl();
                        $userInfo = $this->LogDao->getUserInfo($passportUrl,array('user_name'=>$_POST['userName']));
                        if($userInfo['retcode'] != 0){
                                throw new \Exception($userInfo['retmsg']);
                                return false;
                        }*/
                        $restParm = array(
							'pid'		=> $serverInfo['productId'],
							'rid'		=> $serverInfo['regionId'],
							'opType'	=> $_POST['user_type'],
							'opValue'	=> $_POST['user_value'],
							'begtime'	=> $_POST['begTime'],
							'endtime'	=> $_POST['endTime'],
							'consumerServerId'	=> $_POST['consumerServerId'],
							'equip_id' => $_POST['equip_id'],
							'page'		=> $this->page,
							'pagecount'	=> $this->pagecount
							);
                        // $Return = $this->LogDao->fetchConsumerLog(RESTBAKREGIONS,$restParm);
                        $Return = $this->LogDao->fetchConsumerLog($this->server_url.RESTSUFFIX,$restParm);
                        if($Return['retcode'] != 0) throw new \Exception($Return['retmsg']);
						//file_put_contents("/home/xingzeng.jiang/www/t1.jd.kunlun.com/gmt/cyz.log", "retcode{$Return['retcode']}\r\n", FILE_APPEND);
						//file_put_contents("/home/xingzeng.jiang/www/t1.jd.kunlun.com/gmt/cyz.log", "retmsg{$Return['retmsg']}\r\n", FILE_APPEND);
						//file_put_contents("/home/xingzeng.jiang/www/t1.jd.kunlun.com/gmt/cyz.log", 'data' . json_encode($Return['data']) . "\r\n", FILE_APPEND);
						$tempArr['list'] = $Return['data'];
						$tempArr['all_use_gold'] = 0;

						//汇总消费元宝数
						
						if (!empty($tempArr['list']))
						{
							$all_use_gold = 0;
							foreach ($tempArr['list'] as $i => $info) {
								$use_gold = isset($info['use_gold']) ? intval($info['use_gold']) : 0;
								$all_use_gold += $use_gold;
							}
							$tempArr['all_use_gold'] = $all_use_gold;
						}

                        $subPages = new common\SubPages($this->pagecount,$tempArr['list']['count'],$this->page);
						unset($tempArr['list']['count']);
                        $tempArr['pages'] = $subPages->show_SubPages();
						$tempArr['sum'] = empty($tempArr['list']) ? 0 : count($tempArr['list']);
						return $tempArr;
                }else {
                        return false;
                }
        }
        
        
        /**
         * 获取用户冲值日志--- 通行证名不能为空，开始结束时间也不能为空
         * @var $serverId 服务器ID
         */
        public function getRewardList($serverId)
        {
        	if($_POST)
        	{
        		/*
        		if(empty($_POST['begTime']) || empty($_POST['endTime'])){
        			throw new \Exception($this->_LANG['dateEmpty']);
        			return false;
        		}elseif(strtotime($_POST['begTime'])>strtotime($_POST['endTime'])){
        			throw new \Exception($this->_LANG['dateError']);
        			return false;
        		}elseif($this->server_url == false){
        			throw new \Exception($this->_LANG['SelectServers']);
        		}
        		*/
        		
        		if($this->server_url == false)
        		{
        			throw new \Exception($this->_LANG['SelectServers']);
        		}
        		   
        		/*    
        		if($_POST['user_type'] < 1 || empty($_POST['user_value']))
				{
					throw new \Exception($this->_LANG['roleNotice']);
				} 
				//*/
						
        		$serverInfo = common\Functions::getServerUrl($serverId);
        		$regionUrl = common\Functions::regionOperationUrl();
        		
        		$restParm = array(
        				'pid'		=> $serverInfo['productId'],
        				'rid'		=> $serverInfo['regionId'],
        				'opType'	=> $_POST['user_type'],
        				'opValue'	=> $_POST['user_value'],
        				'begtime'	=> $_POST['begTime'],
        				'endtime'	=> $_POST['endTime'],
        				'module_id' => $_POST['module_id'],
        				'status' => intval($_POST['status']),
        				'all'		=> '1',
        				'page'		=> $this->page,
        				'pagecount'	=> $this->pagecount
        		);
        		
        		$Return = $this->LogDao->getRewardList($this->server_url.RESTSUFFIX,$restParm);
        		if($Return['retcode'] != 0) throw new \Exception($Return['retmsg']);
        		$tempArr['list'] = $Return['data'];
        		$subPages = new common\SubPages($this->pagecount,$tempArr['list']['count'],$this->page);
        		unset($tempArr['list']['count']);
        		$tempArr['pages'] = $subPages->show_SubPages();
        		$tempArr['sum'] = empty($tempArr['list']) ? 0 : count($tempArr['list']);
        		return $tempArr;
        		
        	}
        }
        
        //延长过期时间
        public function rewardExtendExpire($type=1)
        {
        	$server_id = isset($_REQUEST['server_id']) ? $_REQUEST['server_id'] : '';
        	$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        	$roleId = isset($_REQUEST['roleId']) ? $_REQUEST['roleId'] : '';
        	$roleName = isset($_REQUEST['roleName']) ? $_REQUEST['roleName'] : '';

        	if(empty($server_id))
			{
				throw new \Exception($this->_LANG['reasonNotice']);
			}

			$RestParm = array(
					'id'    =>  $id,
					'type' => $type,
					'author'    =>  $_SESSION['infoUser']['fullname'],
				);	

			$server_url = common\Functions::getServerUrl($server_id,'server');
			if(empty($server_url)) 
			{
				throw new \Exception($this->_LANG['SelectServers']); //不存在返回false
			}

			$RestHost = $server_url.RESTSUFFIX;
			$serverReturn = common\Rest::CallCommRestInterFace('CRegion.rewardExtendExpire',$RestHost,$RestParm);

			if (!empty($serverReturn) && $serverReturn['retcode'] == 0)
			{
				$ActionService = util\Singleton::get("service\\ActionService");
				$action = $ActionService->getActionByActionCodeFromCache('./?act=Log.getRewardList');
				$affectObj = 'roleId='.$roleId .'|roleName='.$roleName . '|type='.$type;
				$desc = $this->_LANG['extend_expire'] . ':'.$affectObj;
				LogCtrl::CallOperationLogs($server_id,$desc,$server_id,$action['actkey'],$this->_LANG['extend_expire'], $affectObj);
				throw new \Exception($this->_LANG['op_succ']);
			}

			$retmsg = !empty($serverReturn['retmsg']) ? $serverReturn['retmsg'] : $this->_LANG['op_fail'];

			throw new \Exception($retmsg);
        }
        
        /**
         * 获取某玩家某时间段的商城赠送日志
         * @var $serverId 服务器ID
         */
        public function getMallGiftList($serverId)
        {
        	if($serverId)
        	{
        		if($this->server_url == false)
        		{
        			throw new \Exception($this->_LANG['SelectServers']);
        		}
        
        		$serverInfo = common\Functions::getServerUrl($serverId);
        		$regionUrl = common\Functions::regionOperationUrl();
        
        		$restParm = array(
        				'pid'		=> $serverInfo['productId'],
        				'rid'		=> $serverInfo['regionId'],
        				'opType'	=> $_POST['user_type'],
        				'opValue'	=> $_POST['user_value'],
        				'begtime'	=> $_POST['begTime'],
        				'endtime'	=> $_POST['endTime'],
        				'page'		=> $this->page,
        				'pagecount'	=> $this->pagecount
        		);
        
        		$Return = $this->LogDao->getMallGiftList($this->server_url.RESTSUFFIX,$restParm);
        		if($Return['retcode'] != 0) throw new \Exception($Return['retmsg']);
        		$tempArr['list'] = $Return['data'];
        		$subPages = new common\SubPages($this->pagecount,$tempArr['list']['count'],$this->page);
        		unset($tempArr['list']['count']);
        		$tempArr['pages'] = $subPages->show_SubPages();
        		$tempArr['sum'] = empty($tempArr['list']) ? 0 : count($tempArr['list']);
        		return $tempArr;
        
        	}
        	else
        	{
        		return false;
        	}
        }
		
		
	/**
	 * 获取游戏服剩余元宝
	 * @var $serverId 服务器ID
	 */
	public function getRemainGold($serverId)
	{
		if($serverId)
		{
			$id = 1;
			//统计全服
			if($this->server_all == true)
			{
				global $init;
				$restParm   = array();
				$arr_result = array();
				$summary_data = array();
				
				$summary_data['server_name'] = '——汇总——';
				$summary_data['voucher_gold'] = 0;
				$summary_data['game_gold']    = 0;
				$summary_data['total_gold']   = 0;
				
				
				foreach($init['serverList'] as $k => $v)
				{
					$data = array();
					$this->server_url  = $v['Server_url'];
					$this->server_name = $v['Server_name'];
					
					$result = $this->LogDao->getRemainGold($this->server_url.RESTSUFFIX,$restParm);
					
					if($result)
					{
						if($result['data']) {
							$data = $result['data'][0];
							$data['server_name'] = $this->server_name;
							$data['id'] = $id;
							$id++;
							
							array_push($arr_result,$data);
							
							$summary_data['voucher_gold'] += $data['voucher_gold'];
							$summary_data['game_gold']    += $data['game_gold'];
							$summary_data['total_gold']   += $data['total_gold'];
						}
					}
									
				}
				$summary_data['id'] = $id;
				array_push($arr_result,$summary_data);
				
				$tempArr['list'] = $arr_result;
			}
			else
			{
				if($this->server_url == false)
				{
					throw new \Exception($this->_LANG['SelectServers']);
				}
				
				$serverInfo = common\Functions::getServerUrl($serverId);
				$regionUrl = common\Functions::regionOperationUrl();
				
				$restParm = array(
					'pid'		=> $serverInfo['productId'],
					'rid'		=> $serverInfo['regionId'],
					'page'		=> $this->page,
					'pagecount'	=> $this->pagecount
				);
				
				$result = $this->LogDao->getRemainGold($this->server_url.RESTSUFFIX,$restParm);
				
				if($result['retcode'] != 0) throw new \Exception($result['retmsg']);
				$result['data'][0]['server_name'] = $this->server_name;
				$result['data'][0]['id'] = $id;
				$tempArr['list'] = $result['data'];
			}
						
			return $tempArr;
			
		}
		else
		{
			return false;
		}
	}
                
}
?>
