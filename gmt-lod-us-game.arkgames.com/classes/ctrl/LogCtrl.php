<?php
/**
 * @file   LogCtrl.php
 * @author xiaoyang <xiaoyang.qi@kunlun-inc.com>
 * @date   Mon Dec 14 14:57:16 2010
 * 
 * @brief  Ctrl 的基础类
 *
 * @package       LogCtrl
 * @subpackage    CtrlBase
 */
namespace ctrl;

//use view;
use framework\mvc\view;
use framework\util;
use framework\mvc\view\smarty;
use framework\core\Context;
use \view\RedirectView;
use	common;

class LogCtrl extends CtrlBase{
	private $LogService;
	/** 
	 * 构造函数，继承父方法
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct(){
		parent::__construct();
		$this->LogService = util\Singleton::get("service\\LogService");
	}
	/**
	 * 公用操作日志接口
         * @var $content 操作信息
	 */
	public static function CallLogsInsert($content){
		$log = new LogCtrl();
		$log->LogCommonInsert($content);
	}
	/**
	 * 合作方操作日志接口
	 * @var $serverId  服务器ID
         * @var $content 操作信息
	 */
	public static function CallOperationLogs($serverId,$content,$operationObject='',$actkey = null,$acttitle = null,$affectObj = null){
		$log = new LogCtrl();
		$log->logOperationInsert($serverId,$content,$operationObject='',$actkey,$acttitle,$affectObj);
	}
	
	/**
	 * 公用操作日志入库
	 * @var $content 操作信息
	 */
	private function LogCommonInsert($content){
		$this->LogService->setLogCommonInsert($content);
	}
	/**
	 * 合作方操作日志入库
	 * @var $serverId  服务器ID
	 * @var $content 操作信息
	 */
	private function logOperationInsert($serverId,$content,$operationObject='',$actkey,$acttitle,$affectObj){
		$this->LogService->setLogOperationInsert($serverId,$content,$operationObject='',$actkey,$acttitle,$affectObj);
	}
	/**
	 * 获取公用操作日志
	 * @return Array();
	 */
	public function LogCommonList(){
		$Result = $this->LogService->GetLogConmon();
		
	
		return new smarty\SmartyView("Log.CommonList.html", array("dataList" => $Result['list'],'pages'=>$Result['pages']));
	}
	/**
	 * 获取合作方操作日志
	 */
	public function LogOperationList(){
		$Result = $this->LogService->GetLogOperation();
		$ActionService = util\Singleton::get("service\\ActionService");
		$actionList = $ActionService->getLogActionFromCache();
		//file_put_contents('/tmp/gmt_cyz.log', 'actionList:' . json_encode($actionList) . "\r\n", FILE_APPEND);
		//file_put_contents('/tmp/gmt_cyz.log', 'Result:' . json_encode($Result) . "\r\n", FILE_APPEND);
		return new smarty\SmartyView("Log.OperationList.html", array("actionList" => $actionList,"dataList" => $Result['list'],'pages'=>$Result['pages'], 'server_all'=>true));
	}
	
	/**
	 * 获取在线实时数据查询
	 */
	public function EveryDayOnline(){
		$server_id = intval($_POST['server_id']);
		$Result = $this->LogService->GetEveryDayOnlie($server_id);
		/**
		 * $_POST['d'] 值为1时表示用户点击下载按钮
		 */
		if($_POST['d'] == 1)
		{
			// $filename = Context::getCurrentTime().'_onlineData';
			$filename = $_POST['OnlineDate'].'_onlineData';
			common\PhpExcel::downloadExcel($filename,'EveryDayOnlineData',$Result,'xls');
		}
		else
		{
			return new smarty\SmartyView("Log.Online.html", array("dataList" => $Result));
		}
	}
	/**
	 * 获取某玩家某时间段的大区冲值日志
	 */
	public function LogVoucherList(){
		$server_id = intval($_POST['server_id']);
		$Result = $this->LogService->getLogVoucher($server_id);
		return new smarty\SmartyView("Log.Voucher.html", array("dataList" => $Result['list'],'fullGoldValue'=>$Result['total'],'goldCoin'=>$Result['goldCoin'],"pages"=>$Result['pages']));
	}
	/**
	 * 获取某玩家某时间段的大区消费日志
	 */
	public function LogConsumerList(){
		$server_id = intval($_POST['server_id']);
		$Result = $this->LogService->getLogCousumer($server_id);
		empty($Result['all_use_gold']) && $Result['all_use_gold'] = 0;
		if($_POST['d'] == 1)
		{
			$title_list[] = array(
				$this->_LANG['consumer_id'],
				'状态',
				$this->_LANG['consumer_service_id'],
				$this->_LANG['consumer_player_id'],
				$this->_LANG['consumer_character_id'],
				$this->_LANG['consumer_gold_type'],
				$this->_LANG['consumer_use_gold'],
				$this->_LANG['consumer_old_gold'],
				$this->_LANG['consumer_new_gold'],
				$this->_LANG['consumer_ip'],
				$this->_LANG['consumer_equip_id'],
				$this->_LANG['consumer_equip_num'],
				$this->_LANG['consumer_memo'],
				'参数',
				$this->_LANG['consumer_created'],
				'更新时间',
			);
			$Result['list'] = $title_list + $Result['list'];
			$filename = Context::getCurrentTime().'_LogConsumer';
			common\PhpExcel::downloadExcel($filename,$this->_LANG['consumerLogQuery'],$Result['list'],'xls');
		}

		return new smarty\SmartyView("Log.Consumer.html", array("all_use_gold" => $Result['all_use_gold'], "dataList" => $Result['list'],'sum'=>$Result['sum'],'pages'=>$Result['pages']));
	}
	/**
	 * 获取某玩家某时间段的升级日志
	 */
	public function LogChUpgradeList(){
		$server_id = intval($_POST['server_id']);
		$Result = $this->LogService->getLogChUpgrade($server_id);
		return new smarty\SmartyView("Log.ChUpgrade.html", array("dataList" => $Result['list'],'sum'=>$Result['sum'],'pages'=>$Result['pages']));
	}
	/**
	 * 获取某玩家某时间段的异常监控日志
	 */
	public function LogExceptionList(){
		$server_id = intval($_POST['server_id']);
		$Result = $this->LogService->getLogException($server_id);
		return new smarty\SmartyView("Log.Exception.html", array("dataList" => $Result['list'],'sum'=>$Result['sum'],'pages'=>$Result['pages']));
	}
	
	/**
	 * 获取某玩家某时间段的奖励日志
	 */
	public function getRewardList()
	{
		$Result = array();

		$type = isset($_REQUEST['type']) ? intval($_REQUEST['type']) : 0;
		if ($type > 0)
		{
			$this->LogService->rewardExtendExpire($type);
		}
		
		$server_id = intval($_POST['server_id']);
		$Result = $this->LogService->getRewardList($server_id);
		//echo "<pre>";print_r($Result);
		return new smarty\SmartyView("Log.Reward.html", array("dataList" => $Result['list'],'fullGoldValue'=>$Result['total'],'goldCoin'=>$Result['goldCoin'],"pages"=>$Result['pages']));
	}
	
	/**
	 * 获取某玩家某时间段的商城赠送日志
	 */
	public function getMallGiftList()
	{
		$Result = array();
		$server_id = intval($_POST['server_id']);
		$Result = $this->LogService->getMallGiftList($server_id);
		
		return new smarty\SmartyView("Log.MallGift.html", array("dataList" => $Result['list'],'fullGoldValue'=>$Result['total'],'goldCoin'=>$Result['goldCoin'],"pages"=>$Result['pages']));
	}
	
	/**
	 * 获取某个服的剩余元宝数量
	 */
	public function getRemainGold()
	{
		$Result = array();
		if ($_POST['server_id'])
		{
			$server_id = intval($_POST['server_id']);
			$Result = $this->LogService->getRemainGold($server_id);
		}
				
		return new smarty\SmartyView("Log.RemainGold.html", array("dataList" => $Result['list'],'server_all'=>true));
	}
	
	
}
?>
