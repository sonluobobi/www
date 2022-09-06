<?php

namespace service;

use framework\core;
use entity;
use dao;
use framework\util;
use common;
use ctrl\LogCtrl;

class ChatService extends ServersAbs
{
	private $dao;
	private $pagecount; //每页显示的条数
	private $pageCurrent; //当前页数
	private $result = array();
	private $list = array();

	/**
	 * @desc 初始化父类构造函数，实例化NoticeDao对象
	 */
	public function __construct()
	{
		parent::__construct();
		$this->dao = util\Singleton::get("dao\\ChatDao");
		$this->pagecount = !empty($_POST['pagecount']) ? $_POST['pagecount'] : 10;
		$this->pageCurrent = !empty($_POST['p']) ? $_POST['p'] : 1;
	}

	/**
	 * 将角色ID字符化
	 * @param $roleArr
	 * @return String
	 */
	private function getRoleids($roleArr=array())
	{
		$rids = array();
		foreach($roleArr as $tmp)
		{
			$rids[]= $tmp[1];
		}
		return implode(',',$rids);
	}

	//私聊
	public function send()
	{
		$RestArr = array();
		$content = isset($_POST['content']) ? trim($_POST['content']) : '';

		if(empty($_POST['server_id']))
		{
			common\Functions::debug($this->_LANG['SelectServers']);
		}

		if(empty($_POST['rids']) && empty($_FILES['excleFile']['name']))
		{
			common\Functions::debug($this->_LANG['emptyReiver']);
		}

		$serverList = $_POST['server_id'];


		if(!empty($_FILES['excleFile']['name'])) //处理文件上传，接收角色ID
		{
			$fileName = common\Functions::UploadFile($_FILES['excleFile'],2097152,array('application/vnd.ms-excel'),"../data/upload/props/");
			if(!$fileName[0])
			{
				common\Functions::debug($fileName[1]);
			}
			$ExcleData = common\PhpExcel::readExcel($fileName[1]);
			if(is_array($ExcleData[0]['cells']) && count($ExcleData[0]['cells'])>1)
			{
				for ($i=2;$i<=count($ExcleData[0]['cells']);$i++)
				{
	 				$RestArr['cid'][$j] = $ExcleData[0]['cells'][$i];
	 				$j++;
	 			}
			}
		}

		/**
		 * 如果使用输入的文本提交，格式化角色ID或角色名进入数组
		 */
		if(!empty($_POST['rids']))
		{
			$RestArr['cid'] = $_POST['rids'];
		}else{
			$RestArr['cid'] = $this->getRoleids($RestArr['cid']);
		}

		if (empty($RestArr['cid']))
		{
			common\Functions::debug($this->_LANG['emptyReiver']);
		}

		$affectObj = $RestArr['cid'];

		//按角色名发送
		if($_POST['receiverType'] == 2)
		{
			$RestArr['cname'] = $RestArr['cid'];
			unset($RestArr['cid']);
		}

		$server_url = common\Functions::getServerUrl($_POST['server_id'],'server');

		if (empty($server_url))
		{
			common\Functions::debug($this->_LANG['SelectServers']);
		}

		//检查角色名
		if($_POST['is_check_role_name'] && $_POST['receiverType'] == 2)
		{
			$serverReturn = $this->dao->checkNicks($server_url.RESTSUFFIX,array('nicks' => $RestArr['cname']));
				
			if($serverReturn['retcode'] > 0)
			{
				common\Functions::debug($serverReturn['retmsg']);
				return;
			}
			$exist_nicks = $serverReturn['data']['exist_nicks'];
			$nexist_nicks = $serverReturn['data']['nexist_nicks'];
			
			if (!empty($exist_nicks))
			{
				$retmsg = '存在的角色名有['.$exist_nicks.']';
			}
			
			if (!empty($nexist_nicks))
			{
				if ($retmsg) {
					$retmsg .= '；不存在的角色名有['.$nexist_nicks.']';
				}else {
					$retmsg = '不存在的角色名有['.$nexist_nicks.']';
				}
			}
			$retmsg = htmlspecialchars($retmsg);
					
			common\Functions::debug($retmsg);
			
			return;
		}

		if(empty($content))
		{
			common\Functions::debug($this->_LANG['emptyContent']);
		}

		/*
		if(mb_strlen($content)>1000)
		{
           common\Functions::debug($this->_LANG['contentError']);
         }
         //*/

		if (get_magic_quotes_gpc())
		{
			$content = htmlspecialchars_decode(stripslashes($content), ENT_QUOTES);
		}else{
			$content = htmlspecialchars_decode($content, ENT_QUOTES) ;
		}			

		$content = str_replace('&nbsp;', ' ', $content);
		$content = strip_tags($content, '<link><color></color>');
		$RestArr['content'] = $content;

		//$RestArr['author'] = $_SESSION['infoUser']['fullname'];

		//return array('retmsg' => json_encode($RestArr));
		$serverReturn = array('retmsg' => '操作失败');
		
		$ActionService = util\Singleton::get("service\\ActionService");
		$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
		LogCtrl::CallOperationLogs($serverList,$content,'',$action['actkey'],$this->_LANG['chat_title'],$affectObj);
		$serverReturn = $this->dao->send($server_url.RESTSUFFIX,$RestArr);

		return $serverReturn;
	}
}
