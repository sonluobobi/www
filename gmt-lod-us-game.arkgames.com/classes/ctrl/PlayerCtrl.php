<?php
/**
 * @filesource PlayerCtrl.php
 * @desc 游戏用户查询接口，controll层
 * @author Juezhong Long
 * date 2010-07-06
 */

namespace ctrl;

use framework\util;
use framework\mvc\view;
use framework\mvc\view\smarty;
use \view\RedirectView;
use framework\core\Context;
use service;
use common;

class PlayerCtrl extends CtrlBase 
{

	private $PlayerService;
	
	/** 
	 * 构造函数，继承父方法
	 * @return void
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();
		$this->PlayerService = util\Singleton::get("service\\PlayerService");
	}

	/**
	 * 添加道具
	 * @return \framework\mvc\view\smarty\SmartyView
	 */
	public function addEquip()
	{
	    if (isset($_POST['equip_id']) && $_POST['equip_id'] > 0)
	    {
	        $result = $this->PlayerService->addEquip();
	        
	        if(is_array($result)){
	            throw new \Exception($result['retmsg']);
	            //exit('1|'.$result['retmsg']) ;
	        }else{
	            throw new \Exception($result);
	        }
	    }
	    else
	    {
	        return new smarty\SmartyView("Player.addEquip.html");
	    }
	}
	
	/**
	 * @method DataQuery
	 * @desc 提供游戏玩家信息查询
	 * @return smarty对象或提供下载
	 */
	public function dataQuery()
	{
		$result = $this->PlayerService->serviceDataQuery();
		
		/**
		 * $_POST['d'] 值为1时表示用户点击下载按钮
		 */
		if($_POST['d'] == 1)
		{
			$filename = Context::getCurrentTime().'_palyer';
			common\PhpExcel::downloadExcel($filename,'GameUserList',$result['list'],'xls');
		}else{
			return new smarty\SmartyView("Player.DataQuery.html",array('list' => $result['list'],'pages' => $result['pages']));	
		}
	}


	//问卷设置
	public function setQuestion()
	{
		if($_POST)
		{

		}
		else{

			$newfile = "/data/sanxiao/www/common/data/question.php";

			if (file_exists($newfile)) {
				//$return  = file_put_contents($newfile, '');
				$return  = file_get_contents($newfile);

				//common\Functions::alertFunc($return);
				$return  = json_decode($return,true);
			}
			else {
				$return = [];
			}


			return new smarty\SmartyView("Player.SetQuestion.html", $return);
		}
	}


	/**
	 * 游戏加载数查询
	 * @return \framework\mvc\view\smarty\SmartyView
	 */
	public function getGameLoadData()
	{
		$result = $this->PlayerService->getGameLoadData();
	
		/**
		 * $_POST['d'] 值为1时表示用户点击下载按钮
		*/
		if($_POST['d'] == 1)
		{
			$filename = Context::getCurrentTime().'_GameLoadData';
			common\PhpExcel::downloadExcel($filename,'getGameLoadData',$result['list'],'xls');
		}else{
			return new smarty\SmartyView("Player.getGameLoadData.html",array('list' => $result['list'],'pages' => $result['pages']));
		}
	}
	
	
	/**
	 * @method getGangPlayerInfo
	 * @desc 帮会用户信息查询
	 * @return smarty对象或提供下载
	 */
	public function getGangPlayerInfo()
	{
		$result = $this->PlayerService->getGangPlayerInfo();
	
		/**
		 * $_POST['d'] 值为1时表示用户点击下载按钮
		*/
		if($_POST['d'] == 1)
		{
			$filename = Context::getCurrentTime().'_gang_palyer';
			common\PhpExcel::downloadExcel($filename,'GameUserList',$result['list'],'xls');
		}else{
			return new smarty\SmartyView("Player.getGangPlayerInfo.html",array('list' => $result['list'],'pages' => $result['pages']));
		}
	}
	
	/**
	 * 封禁用户,禁言用户；
	 * 根据$_GET['type']参数判断; 1:封禁，2:禁言
	 * @return 输出Json对象
	 */
	public function userBlockGag()
	{
		if($_POST)
		{
			//print_r($_POST);exit;

			$result = $this->PlayerService->serviceUserBlockGag();
			echo $result['retmsg'];

			//common\Functions::debug($result['retmsg']);
				
		}
		else
		{
			//return new smarty\SmartyView("Player.BlockGag.html");
			
			$smarty = new smarty\SmartyView("Player.BlockGag.html");
			
			$title = $_GET['type'] == 1 ? $this->_LANG['userBlock'] : $this->_LANG['userGag'] ;
			$remind = array('remind' => $this->_LANG['blockGagNotice']);
			
			$json = view\JSONView::showJson($title,$smarty->fetch(),$remind); 
			
		}
	}
	
	/**
	 * 解禁用户,解禁言用户；
	 * 根据$_GET['type']参数判断; 1:解禁，2:解禁言
	 * @return 输出Json对象
	 */
	public function undoUserBlockGag()
	{
		if($_POST)
		{
			$result = $this->PlayerService->serviceUndoUserBlockGag();
			echo $result['retmsg'];

		}else{
			//return new smarty\SmartyView("Player.BlockGag.html");
			
			$smarty = new smarty\SmartyView("Player.BlockGag.html",array('undo' => 1));
			$title = $_GET['type'] == 1 ? $this->_LANG['undoBlock'] : $this->_LANG['undoGag'] ;
			$remind = array('remind' => $this->_LANG['reasonNotice'],'op' => 'undo');
			$json = view\JSONView::showJson($title,$smarty->fetch(),$remind);
		}
	}	
	
	/**
	 * 封禁列表
	 */
	public function listBlock()
	{
		$result = $this->PlayerService->serviceListBlock();
		/**
		 * $_POST['d'] 值为1时表示用户点击下载按钮
		 */
		if($_POST['d'] == 1)
		{
			$filename = Context::getCurrentTime().'_blockPalyer';
			common\PhpExcel::downloadExcel($filename,'blockPayer',$result['list'],'xls');
		}else{
			return new smarty\SmartyView("Player.BlockGagList.html",array('list' => $result['list'],'pages' => $result['pages'],'type' => 'block'));	
		}		
	}
	
	/**
	 * 禁言列表
	 */
	public function listGag()
	{
		$result = $this->PlayerService->serviceListGag();
		//echo "<pre>";print_r($result);
		/**
		 * $_POST['d'] 值为1时表示用户点击下载按钮
		 */
		if($_POST['d'] == 1)
		{
			$filename = Context::getCurrentTime().'_gagPalyer';
			common\PhpExcel::downloadExcel($filename,'gagPalyer',$result['list'],'xls');
		}else{
			return new smarty\SmartyView("Player.BlockGagList.html",array('list' => $result['list'],'pages' => $result['pages'],'type' => 'gag'));	
		}
	}

	/**
	 * 踢人
	 * @return unknown_type
	 */
	public function setOffLine()
	{
		if($_POST)
		{
			$result = $this->PlayerService->setOffLine();
			if(is_array($result)){
				exit('1|'.$result['retmsg']);
			}else{
				exit($result);
			}			
		}else{
			$smarty = new smarty\SmartyView("Player.setOffLine.html");
			$title = $this->_LANG['setOffLine'];
			view\JSONView::showJson($title,$smarty->fetch());
		}
	}

	/**
	 * 设置取消GM账号
	 * @return unknown_type
	 */
	public function setGm()
	{
		file_put_contents('/tmp/gmt_cyz.log', "setGm running\r\n", FILE_APPEND);
		if($_POST)
		{
			file_put_contents('/tmp/gmt_cyz.log', "setGm running11111111111111\r\n", FILE_APPEND);
			$result = $this->PlayerService->setGm();
			if(is_array($result)){
				// $single == true ? exit('1|'.$result['retmsg']) : common\Functions::alertFunc($result['retmsg'],'RQ("./?act=Notice.sendMail",pt.writeBody)');
				exit('1|'.$result['retmsg']);
			}else{
				// $single == true ? exit($result) : common\Functions::debug($result);
				exit($result);
			}			
		}else{
			// if($single == true)
			// {
				file_put_contents('/tmp/gmt_cyz.log', "setGm running\r\n", FILE_APPEND);
				$smarty = new smarty\SmartyView("Player.setGm.html");
				$title = $this->_LANG['setGmTitle'];
				file_put_contents('/tmp/gmt_cyz.log', $smarty->fetch . "\r\n", FILE_APPEND);
				view\JSONView::showJson($title,$smarty->fetch());
			// }else{
				// return new smarty\SmartyView("Notice.SendMail.html");
			// }
		}
	}

	/**
	 * 查询角色详细信息
	 * @return unknown_type
	 */
	public function getChDetail()
	{
		$result = $this->PlayerService->getChDetail();
		if($result['retcode'] > 0)
		{
			throw new \Exception($result['retmsg']);
			common\Functions::debug($result['retmsg']);
		}
		else
		{
		  $smarty = new smarty\SmartyView("Player.detail.html", array('data' => $result['data']));
		  $title = $this->_LANG['getDetail'];
		 
		  view\JSONView::showJson($title,$smarty->fetch());
		}
	}	

	/**
	 * 玩家等级分布查询
	 * @return unknown_type
	 */
	public function getLevelDistributionList()
	{
		$result = $this->PlayerService->getLevelDistributionList();
		return new smarty\SmartyView("Player.levelDistributionList.html", array("dataList" => $result['data']['data'], 'pages' => $result['pages']));
	}

	/**
	 * 玩家道具流向查询
	 * @return unknown_type
	 */
	public function getEquipFlowList()
	{
		$result = $this->PlayerService->getEquipFlowList();
		if($_POST['d'] == 1)
		{
			$filename = 'equip_flow_list_'.Context::getCurrentTime();
			common\PhpExcel::downloadExcel($filename,'equip_flow_list',$result['data']['data'],'xls');
		}
		else
		{
			return new smarty\SmartyView("Player.equipFlowList.html", array("dataList" => $result['data']['data'], 'pages' => $result['pages']));
		}
	}

	//道具流向统计
	public function getEquipFlowStats()
	{
		$result = $this->PlayerService->getEquipFlowStats();
		if($_POST['d'] == 1)
		{
			$filename = 'equip_flow_stats_'.Context::getCurrentTime();
			common\PhpExcel::downloadExcel($filename,'equip_flow_list',$result['data']['data'],'xls');
		}
		else
		{
			return new smarty\SmartyView("Player.equipFlowStats.html", array("dataList" => $result['data']['data'], 'pages' => $result['pages']));
		}
	}

	//获取道具流向对应日期范围明细
	public function getEquipFlowDetail()
	{
		$result = $this->PlayerService->getEquipFlowDetail();
		if($result['retcode'] > 0)
		{
			throw new \Exception($result['retmsg']);
		}
		else
		{
		  $smarty = new smarty\SmartyView("Player.getEquipFlowDetail.html", array('dataList' => $result['data']['data']));
		  $title = $this->_LANG['equipFlowDetail'];
		 
		  view\JSONView::showJson($title,$smarty->fetch());
		}
	}

	/**
	 * 宝物碎片流向日志
	 * @return unknown_type
	 */
	public function getBaoWuChipList()
	{
		$result = $this->PlayerService->getBaoWuChipList();
		if($_POST['d'] == 1)
		{
			$filename = 'baowu_chip_list_'.Context::getCurrentTime();
			common\PhpExcel::downloadExcel($filename,'baowu_chip_list',$result['data']['data'],'xls');
		}
		else
		{
			return new smarty\SmartyView("Player.baoWuChipList.html", array("dataList" => $result['data']['data'], 'pages' => $result['pages']));
		}
	}

	/**
	 * 检查名字
	 * @return unknown_type
	 */
	public function checkNicks()
	{
		$this->PlayerService->checkNicks();
	}
	
	
	/**
	 * @method petQuery
	 * @desc   断交侠客查询
	 * @return smarty对象或提供下载
	 */
	public function getPetInfo()
	{
		$result = $this->PlayerService->getPetInfo();
	
		/**
		 * $_POST['d'] 值为1时表示用户点击下载按钮
		*/
		if($_POST['d'] == 1)
		{
			$filename = Context::getCurrentTime().'_palyer';
			common\PhpExcel::downloadExcel($filename,'getPetInfo',$result['list'],'xls');
		}
		else
		{
			return new smarty\SmartyView("Player.getPetInfo.html",array('list' => $result['list'],'pages' => $result['pages']));
		}
	}
	
	/**
	 * @method disbandGang
	 * @desc   解散帮会
	 * @return smarty对象
	 */
	public function disbandGang()
	{
		if($_POST['gang_title'])
		{
			$result = $this->PlayerService->disbandGang();
			echo $result['retmsg'];
		}
		else
		{
			$smarty = new smarty\SmartyView("Player.disbandGang.html");
				
			$title = "解散帮会" ;
			$remind = array('remind' => '请输入帮会名称');
				
			$json = view\JSONView::showJson($title,$smarty->fetch(),$remind);
		}
	}
	
	
	/**
	 * @method removePassword
	 * @desc   清除二级密码
	 * @return smarty对象
	 */
	public function removePassword()
	{
		if($_POST)
		{
			$result = $this->PlayerService->removePassword();
			throw new \Exception($result['retmsg']);
			//exit($result['retmsg']);
		}
		else
		{
			return new smarty\SmartyView("Player.removePassword.html");
		}
	}

	/**
	 * 移出排行榜
	 * @return unknown_type
	 */
	public function setOffRank()
	{
		if($_POST)
		{
			$result = $this->PlayerService->setOffRank();
			if(is_array($result)){
				exit('1|'.$result['retmsg']);
			}else{
				exit($result);
			}			
		}else{
			$smarty = new smarty\SmartyView("Player.setOffRank.html");
			$title = $this->_LANG['setOffRank'];
			view\JSONView::showJson($title,$smarty->fetch());
		}
	}

	//角色简要信息查询
	public function getBaseInfo()
	{
		$result = $this->PlayerService->getBaseInfo();
		
		if($_POST['d'] == 1)
		{
			$filename = Context::getCurrentTime().'_palyer_base_info';
			common\PhpExcel::downloadExcel($filename,'GameUserBaseList',$result['list'],'xls');
		}else{
			return new smarty\SmartyView("Player.getBaseInfo.html",array('list' => $result['list'],'pages' => $result['pages']));	
		}
	}

	//角色id，帐号id,昵称，创建时间
	public function getChBase()
	{
		$op_type = isset($_REQUEST['op_type']) ? intval($_REQUEST['op_type']) : 0;
		
		if ($op_type > 0)
		{
			$roleId = isset($_REQUEST['roleId']) ? intval($_REQUEST['roleId']) : 0;

			if(empty($roleId))
			{
				throw new \Exception($this->_LANG['argvError']);
			}

			$server_url = common\Functions::getServerUrl($_REQUEST['server_id'],'server');
			if($server_url == false) throw new \Exception($this->_LANG['SelectServers']);

			$result = array('retcode' => 1, 'retmsg' => 'fail');
			$title = '';
			$tpl_name = 'Player.ch_base.html';

			switch ($op_type) {
				case '1':
					//宝石
					$title = $this->_LANG['ch_base_baoshi'];
					$tpl_name = 'Player.ch_base_baoshi.html';
					break;
				case '2':
					//装备精炼
					$title = $this->_LANG['ch_base_zhuangbei'];
					$tpl_name = 'Player.ch_base_zhuangbei.html';
					break;
				case '3':
					//宝物精炼
					$title = $this->_LANG['ch_base_baowu'];
					$tpl_name = 'Player.ch_base_baowu.html';
					break;
				case '4':
					//幻兽双星
					$title = $this->_LANG['ch_base_huanshou'];
					$tpl_name = 'Player.ch_base_huanshou.html';
					break;
				case '5':
					//符文精炼
					$title = $this->_LANG['ch_base_fuwen'];
					$tpl_name = 'Player.ch_base_fuwen.html';
					break;	
				case '6':
					//幻兽神格
					$title = $this->_LANG['ch_base_shenge'];
					$tpl_name = 'Player.ch_base_shenge.html';
					break;	
				case '7':
					//计数器
					$title = $this->_LANG['ch_base_counter'];
					$tpl_name = 'Player.ch_base_counter.html';
					break;	
				case '8':
					//仓库列表
					$title = $this->_LANG['ch_base_storages'];
					$tpl_name = 'Player.ch_base_storages.html';
					break;	
				default:
					$err_msg = $this->_LANG['ch_base_stat'].' -- '.$this->_LANG['argvError'] . ' -- ' .$op_type;
					throw new \Exception($err_msg);
					break;
			}

			$RestParm = array(
				'roleId'    =>  $roleId,
				'op_type' => $op_type
			);		
		
			$RestHost = $server_url.RESTSUFFIX;
			$result = common\Rest::CallCommRestInterFace('GameTools.getChBaseStat',$RestHost,$RestParm);

			if($result['retcode'] > 0)
			{
				throw new \Exception($result['retmsg']);
				common\Functions::debug($result['retmsg']);
			}
			else
			{
				$data = $result['data'];

				if ($op_type == 7)
				{
					//排序
					usort($data, function($a, $b){
								return $a['base_id'] > $b['base_id'];
							});
				}

				$smarty = new smarty\SmartyView($tpl_name, array('data' => $data));
				view\JSONView::showJson($title,$smarty->fetch());
			}
		}
		else
		{
			$result = $this->PlayerService->getChBase();

			if($_POST['d'] == 1)
			{
				$filename = Context::getCurrentTime().'_ch_base';
				common\PhpExcel::downloadExcel($filename,'GameChBaseList',$result['list'],'xls');
			}
			else
			{
				return new smarty\SmartyView("Player.getChBase.html",array('list' => $result['list'],'pages' => $result['pages']));	
			}
		}
	}
}

?>
