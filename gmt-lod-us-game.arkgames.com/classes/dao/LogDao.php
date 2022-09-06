<?php
namespace dao;

use common;
use framework\data\pdo;

class LogDao {
	/**
	 * 
	 * @var framework\data\pdo\PDOHelper
	 */
	private $pdoHelper;
	private $pdo;
	private $operationHelper;
	private $operationPdo;
	
	
	/**
	 * 构造函数
	 * @return
	 */
	public function __construct(){
		//GMT主库log表对象
		$this->pdo = pdo\PDOManager::getInstance('default');
		$this->pdoHelper = new pdo\PDOHelper("entity\\Log");
		$this->pdoHelper->setPdo($this->pdo);
		//GMt从库合作方log表对象
		$this->operationPdo = pdo\PDOLogManager::getInstance("default");
		$this->operationHelper = new pdo\PDONewHelper();
		$this->operationHelper->setPdo($this->operationPdo);
		$this->operationHelper->setTableName("actionlog");
	}
	/**
	 * 公用操作日志入库
	 * @var $object 数组对象
	 */
	public function fetchCommonLogSave($object){
		foreach ($object as $key=>$value){
			$filed[] = $key;
		}
		return  $this->pdoHelper->add($object,$filed);
	}
	/**
	 * 合作方操作日志入库
	 * @var $object 数组对象
	 */
	public function fetchOperationLogSave($object){
		foreach ($object as $key=>$value){
			$filed[] = $key;
		}
		return  $this->operationHelper->add($object,$filed);
	}
	/**
	 * 获取公用操作日志
	 * @var $where  sql条件
	 * @var $limit  显示条数
	 */
	public function fetchCommonList($where,$limit){
		return $this->pdoHelper->fetchAll($where,null,"*",' LogDate desc ',$limit);
	}
	/**
	 * 获取合作方操作日志
	 * @var $where  sql条件
	 * @var $limit  显示条数
	 */
	public function fetchOperationList($where,$limit){
		return $this->operationHelper->fetchAll($where,null,"*",' LogDate desc ',$limit);
	}
	/**
	 * 获取公用操作日志总记录
	 * @var $where  sql条件
	 */
	public function fetchConmonCout($where){
		$data =  $this->pdoHelper->fetchEntity($where,null," COUNT(*) as num ");
		return $data->num;	
	}
	/**
	 * 获取合作方操作日志总记录
	 * @var $where  sql条件
	 */
	public function fetchOperationCout($where){
		$data = $this->operationHelper->fetchEntity($where,null," COUNT(*) as num ");
		return $data['num'];
	}
	/**
	 * 获取游戏在线数据
	 * $RestHost  游戏地址
	 * $RestParams 参数数组
	 */
	public function fetchEveryDayOnline($RestHost,$RestParams){
		return common\Rest::CallRestInterFace("Rest_getOnlineData",$RestHost,$RestParams);
	}
	/**
	 * 获取冲值日志
	 * @var $RestHost 大区地址
	 * @var $RestParams  参数数组
	 */
	public function fetchVoucherLog($RestHost,$RestParams){
		return common\Rest::CallRestInterFace("Rest_getVouchList",$RestHost,$RestParams);
	}
	/**
	 * 获取角色升级日志
	 * @var $RestHost 大区地址
	 * @var $RestParams  参数数组
	 */
	public function fetchChUpgradeLog($RestHost,$RestParams){
		return common\Rest::CallRestInterFace("Rest_getChUpgradeList",$RestHost,$RestParams);
	}
	/**
	 * 获取异常监控日志日志
	 * @var $RestHost 大区地址
	 * @var $RestParams  参数数组
	 */
	public function fetchExceptionLog($RestHost,$RestParams){
		return common\Rest::CallRestInterFace("Rest_getExceptionList",$RestHost,$RestParams);
	}
	/**
	 * 获取消费日志
	 * @var $RestHost 大区地址
	 * @var $RestParams  参数数组
	 */
	public function fetchConsumerLog($RestHost,$RestParams){
		return common\Rest::CallRestInterFace("Rest_getConsumList",$RestHost,$RestParams);
	}
	/**
	*获取Passport平台用户数据
	*@var $RestParms 参数数组
	*@var $RestHost  Passport地址
	*/
	public function getUserInfo($RestHost,$RestParams){
		return common\Rest::CallRestInterFace("Rest_getInfoByUname",$RestHost,$RestParams);
	}
	/**
        *获取游戏用户余额
        *@var $RestParms 参数数组
        *@var $RestHost  Passport地址
        *@return Array
        */
        public function fetchBlanceCoin($RestHost,$RestParams){
                return common\Rest::CallRestInterFace("Rest_balance",$RestHost,$RestParams);
        }

     /**
      * 获取联运平台9377 排行榜
      * @param unknown_type $RestHost
      * @param unknown_type $RestParams
      */
     public function f9377GetToplist($RestHost,$RestParams)
     {
     	return common\Rest::CallRestInterFace("Rest_f9377GetToplist",$RestHost,$RestParams);
     }
     
     
     /**
      * 获取发奖日志
      * @var $RestHost 大区地址
      * @var $RestParams  参数数组
      */
     public function getRewardList($RestHost,$RestParams)
     {
     	return common\Rest::CallRestInterFace("Rest_getRewardList",$RestHost,$RestParams);
     }
     
     /**
      * 获取某玩家某时间段的商城赠送日志
      * @var $RestHost 大区地址
      * @var $RestParams  参数数组
      */
     public function getMallGiftList($RestHost,$RestParams)
     {
     	return common\Rest::CallRestInterFace("Rest_getMallGiftList",$RestHost,$RestParams);
     }
	 
	/**
	 * 获取游戏服剩余元宝
	 * @var $RestHost 大区地址
	 * @var $RestParams  参数数组
	 */
	public function getRemainGold($RestHost,$RestParams)
	{
     	return common\Rest::CallRestInterFace("Rest_getRemainGold",$RestHost,$RestParams);
	}
}
?>