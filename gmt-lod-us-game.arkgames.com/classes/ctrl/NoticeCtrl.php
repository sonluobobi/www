<?php
/**
 * @filesource NoticeCtrl.php
 * @desc 游戏用户查询接口，controll层
 * @author Juezhong Long
 * date 2010-07-13
 */

namespace ctrl;

use framework\util;
use framework\mvc\view;
use framework\mvc\view\smarty;
use \view\RedirectView;
use framework\core\Context;
use service;
use common;

class NoticeCtrl extends CtrlBase 
{
	private $NoticeService;
	
	/** 
	 * 构造函数，继承父方法
	 * @return void
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();
		$this->NoticeService = util\Singleton::get("service\\NoticeService");
	}
	
	/**
	 * 添加、编辑公告
	 * @return unknown_type
	 */
	public function add()
	{
		if($_GET['id'])
		{
		    //编辑公告
			/*$info = $this->NoticeService->serviceGetOne();
			$info['server_id'] = $_GET['server_id'];
			$serverInfo = common\Functions::getServerUrl($_GET['server_id']);
			$info['server_text'] = $serverInfo['server_text'];*/
			$info = $this->NoticeService->serviceNoticeOne($_GET['id']);
			if (!empty($info['begTime']) && is_numeric($info['begTime'])) $info['begTime'] = date('Y-m-d H:i:s', $info['begTime']);
			if (!empty($info['endTime']) && is_numeric($info['endTime'])) $info['endTime'] = date('Y-m-d H:i:s', $info['endTime']);

			return new smarty\SmartyView("Notice.Add.html",$info);

		}
		elseif($_GET['confirm'])
		{
			global $init;
			/*foreach($init['serverList'] as $k => $v)
                	{
				$servername[$v['Server_id']]=$v['Server_name'];
			}*/
			
		
			$smarty = new smarty\SmartyView("Notice.Confirm.html");
                        $title =  $this->_LANG['noticeAddConfirm'];
                        $mask_title = '11222233';
                        
                        $remind = array('remind' => $this->_LANG['blockGagNotice'],'servername'=>$servername);
                        
                     
                        $json = view\JSONView::showJson($title,$smarty->fetch(),$remind);
		}
		elseif($_POST)
		{
		    //添加公告
			$result = $this->NoticeService->ServiceAdd();
			
		
			echo '添加成功';
		}else{
			return new smarty\SmartyView("Notice.Add.html",array('begTime'=>date('Y-m-d 00:00:00'),'endTime'=>date('Y-m-d 23:59:59')));
		}
	}

	/**
	 * 添加推送公告
	 * @return unknown_type
	 */
	public function addPush()
	{
		if($_POST)
		{
			return new smarty\SmartyView("Notice.AddPush.html",array('begTime'=>date('Y-m-d 00:00:00'),'endTime'=>date('Y-m-d 23:59:59')));
		}else{
			return new smarty\SmartyView("Notice.AddPush.html",array('begTime'=>date('Y-m-d 00:00:00'),'endTime'=>date('Y-m-d 23:59:59')));
		}

	}


	/**
	 * 显示公告列表
	 * @return unknown_type
	 */
	public function lists()
	{
	
		/**
		 * $_POST['d'] 值为1时表示用户点击下载按钮
		 */
		if($_POST['d'] == 1)
		{
		    
		   	$result = $this->NoticeService->serviceLists();
			$filename = Context::getCurrentTime().'_palyer';
			common\PhpExcel::downloadExcel($filename,'GameUserList',$result['list'],'xls');
		}else{
		   
		    $result = $this->NoticeService->getNowNoticeList();
		    
			return new smarty\SmartyView("Notice.Lists.html",array('list' => $result['list'],'pages' => $result['pages'],'begTime'=>date('Y-m-d 00:00:00'),'endTime'=>date('Y-m-d 23:59:59'),'nowdate'=>date('Y-m-d H:i:s')));	
		}
	}
	
	
	/**
	 * 公告列表管理
	 * @return unknown_type
	 */
	public function manage()
	{
		$result = $this->NoticeService->getHistroyNoticeList();  
		
		/**
		 * $_POST['d'] 值为1时表示用户点击下载按钮   
		*/
		if ($_GET['id'])
		{
		    
			$info = array();
			if (isset($_GET['type']) && $_GET['type'] == 'local' )
			{
				$info = $result['list'][0];
				
			}
							
			return new smarty\SmartyView("Notice.addLocal.html",$info);
		}
				
		elseif($_POST['d'] == 1)
		{
		    echo 1;
			$filename = Context::getCurrentTime().'_manage';
			common\PhpExcel::downloadExcel($filename,'NoticeList',$result['list'],'xls');
		}
		else
		{
		    
		   
			return new smarty\SmartyView("Notice.manage.html",array('list' => $result['list'],'content' => '','pages' => $result['pages'],'begTime'=>date('Y-m-d 00:00:00'),'endTime'=>date('Y-m-d 23:59:59')));
		}
	}
	
	
	/**
	 * 显示全服邮件列表
	 * @return unknown_type
	 */
	public function sysMailList()
	{
		$result = $this->NoticeService->getSysMailList();
		
		return new smarty\SmartyView("Notice.sysMailList.html",array('list' => $result['list'],'pages' => $result['pages'],'begTime'=>date('Y-m-d 00:00:00'),'endTime'=>date('Y-m-d 23:59:59')));
	}
	
	/**
	 * 删除公告
	 * @return unknown_type
	 */
	public function del()
	{
		if(!empty($_GET['id']))
		{
			$result = $this->NoticeService->ServiceDel();
			echo '删除成功';
		
		}else{
			throw new \Exception($this->_LANG['delErrorPop']);
		}
	}
	
	public function deleteNotice()
	{
		if(!empty($_GET['id']) )
		{
			$arr_id = explode(',', $_GET['id']);
			if (is_array($arr_id) && count($arr_id) > 0)
			{
			  
				$result = $this->NoticeService->deleteNotice($_GET['id']);
				echo '删除成功';
			}
			else {
				throw new \Exception($this->_LANG['delErrorPop']);
			}
			
		}
		else{
			throw new \Exception($this->_LANG['delErrorPop']);
		}
	}
	
	//置顶公告
	public function topNotice()
	{
		if(!empty($_GET['id']) )
		{
		
		    $result = $this->NoticeService->topNotice($_GET['id']);
			echo '置顶成功';
		}
		else{
			throw new \Exception('置顶发生错误');
		}
	}
	
	
	
	/*
	 * 开始或者暂停公告
	* $_GET['server_id'] 服务器 id
	* $_GET['id'] 公告id列表，逗号相隔
	* $_GET['status'] 状态类型  1:开始  2:暂停
	*/
	public function startAndPause()
	{
		if (empty($_GET['status']) || !in_array($_GET['status'], array(1,2)))
		{
			echo $this->_LANG['argvError'];//参数错误
		}
		elseif (empty($_GET['server_id']))
		{
			echo $this->_LANG['SelectServers'];//请选择服务器
		}
		elseif(empty($_GET['id']))
		{
			echo $this->_LANG['delErrorPop'];//请选择要操作的公告
		}
		else
		{
			try {
				$result = $this->NoticeService->startAndPause();
				echo $result;
			}catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}
	
	/**
	 * 邮件发送
	 * @return unknown_type
	 */
	public function sendMail()
	{
		$single = $_REQUEST['single'] == 1 ? true : false;  //判断是否是单服发送
		if($_POST)
		{
			$result = $this->NoticeService->ServiceSendMail();
			
			if(is_array($result)){
				$single == true ? exit('1|'.$result['retmsg']) : common\Functions::alertFunc($result['retmsg'],'RQ("./?act=Notice.sendMail",pt.writeBody)');
			}else{
				$single == true ? exit($result) : common\Functions::debug($result);
			}			
		}
		else
		{
					
			if($single == true)
			{
				$smarty = new smarty\SmartyView("Notice.singleSendMail.html");
				$title = $this->_LANG['sendMailTitle'];
				view\JSONView::showJson($title,$smarty->fetch());
			}else{
				return new smarty\SmartyView("Notice.SendMail.html");
			}
		}
	}	
	
	
	/**
	 * 发送全服邮件
	 * @return unknown_type
	 */
	public function sendSysMail()
	{
		//编辑
		if($_GET['id'])
		{
			$mail_id = intval($_GET['id']);
			$item = $this->NoticeService->getSysMailById($mail_id);
			$item['server_id'] = $_GET['server_id'];
			$serverInfo = common\Functions::getServerUrl($_GET['server_id']);
			$item['server_text'] = $serverInfo['server_text'];
			return new smarty\SmartyView("Notice.SendSysMail.html",$item);
		}
		elseif($_POST)
		{
			$result = $this->NoticeService->sendSysMail();
				
			if(is_array($result))
			{
				//common\Functions::alertFunc($result['retmsg'],'RQ("./?act=Notice.sendSysMail",pt.writeBody)');
				common\Functions::alertFunc($result['retmsg']);
			}
			else
			{
				common\Functions::debug($result);
			}
		}
		else
		{
			return new smarty\SmartyView("Notice.SendSysMail.html");
		}
	}
	
	/**
	 * 道具发送(excel)
	 * @return unknown_type
	 */
	public function sendProps()
	{
		if($_POST)
		{
			$result = $this->NoticeService->ServiceSendProps();
			if($result){
				common\Functions::alertFunc($result['retmsg'],'RQ("./?act=Notice.sendPropsList",pt.writeBody)');
			}else{
				common\Functions::debug($this->_LANG['QueueFail']);
			}			
		}else{
			return new smarty\SmartyView("Notice.SendProps.html");
		}
	}		

	//道具发送
	public function sendPropsEquip()
	{
		if($_POST)
		{
			if(isset($_POST['push_title']))
			{
				try {
					//$result = $this->NoticeService->ServiceAddPush();
					$result = $this->NoticeService->ServiceAddPush();
					common\Functions::alertFunc('发送成功');
				}
				catch (\Exception  $e) {
					common\Functions::alertFunc($e);
				}
			}
			if(isset($_POST['chargecancel_wenjuan_id']))
			{
				$newfile = "/data/sanxiao/www/common/data/question.php";

				if (file_exists($newfile)) {
					//$return  = file_put_contents($newfile, '');
					$return  = file_put_contents($newfile, json_encode($_POST));
					common\Functions::alertFunc('设置成功' );
				}
				else {
					common\Functions::alertFunc('文件生成失败' );
				}
			}
			else
			{
				$result = $this->NoticeService->ServiceSendPropsEquip();
				if($result){
					common\Functions::alertFunc($result['retmsg'],'RQ("./?act=Notice.sendPropsList",pt.writeBody)');
				}else{
					common\Functions::debug($this->_LANG['QueueFail']);
				}
			}
		}else{
			$endTime = date('Y-m-d H:i:s', strtotime('+1 month'));
			return new smarty\SmartyView("Notice.SendPropsEquip.html", array('server_all'=>true, 'endTime' => $endTime));
		}
	}		

	 /**
         * 显示发道具列表
         * @return unknown_type
         */
        public function sendPropsList()
        {
                $result = $this->NoticeService->sendPropsList();
                return new smarty\SmartyView("Notice.SendPropsList.html",array('list' => $result['list'],'pages' => $result['pages']));
        }

        /**
         * 显示发道具列表
         * @return unknown_type
         */
        public function sendPropsConfirm()
        {
                $result = $this->NoticeService->sendPropsConfirm();
                return $this->sendPropsList();
        }

	 /**
         * 显示发道具列表
         * @return unknown_type
         */
        public function sendPropsDel()
        {
                $result = $this->NoticeService->sendPropsDel();
                
                return $this->sendPropsList();
        }

        public function sendPropsRecal()
        {
        		//$_POST['type'] = 4;
                $result = $this->NoticeService->sendPropsRecal();
                
                return $this->sendPropsList();
        }

	/**
	 * 查询道具详细信息
	 * @return unknown_type
	 */
	public function getEquipDetail()
	{
		
		if(!empty($_REQUEST['equipTitle']) || !empty($_REQUEST['equipId']))
		{
			$result = $this->NoticeService->getEquipDetail();
			
			if($result['retcode'] > 0)
				common\Functions::debug($result['retmsg']);
			else
			{
				if($_POST)
					return new smarty\SmartyView("Notice.getEquipDetail.html", array('data' => $result['data']));
				else
				{
					$smarty = new smarty\SmartyView("Notice.equipDetail.html", array('data' => $result['data']));
					$title = $this->_LANG['equipDetail'];
					view\JSONView::showJson($title, $smarty->fetch());
				}
			}
		}
		else
		{
			return $smarty = new smarty\SmartyView("Notice.getEquipDetail.html");
		}
	}	

	/**
	 * 查询误丢弃道具
	 * @return unknown_type
	 */
	public function getDiscardEquipList()
	{
		if($_POST)
		{
			$result = $this->NoticeService->getDiscardEquipList();
			//file_put_contents('/tmp/gmt_cyz.log', "result===>".var_export($result,true). "\r\n", FILE_APPEND);
			return new smarty\SmartyView("Notice.getDiscardEquipList.html", array('dataList' => $result['list'], 'pages' => $result['pages']));
		}
		else
		{
			return $smarty = new smarty\SmartyView("Notice.getDiscardEquipList.html");
		}
	}

	/**
	 * 恢复误丢弃道具
	 * @return unknown_type
	 */
	public function retrieveEquip()
	{
		if($_POST)
		{
			$result = $this->NoticeService->retrieveEquip();
			if(is_array($result)){
				exit('1|'.$result['retmsg']);
			}else{
				exit($result);
			}			
		}
		else
		{
			
			$smarty = new smarty\SmartyView("Notice.retrieveEquipConfirm.html");
			$title = $this->_LANG['retrieveEquip'];
			
			view\JSONView::showJson($title,$smarty->fetch());
		}
	}	
}

?>
