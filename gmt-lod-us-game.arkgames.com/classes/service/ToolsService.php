<?php

namespace service;

use framework\core;
use entity;
use dao;
use framework\util;
use common;
use ctrl\LogCtrl;

class ToolsService extends ServersAbs
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

		if($_POST)
		{
			$this->server_url = common\Functions::getServerUrl($_REQUEST['server_id'],'server');
			if($this->server_url == false) throw new \Exception($this->_LANG['SelectServers']); //不存在返回false
		}	

		$this->pagecount = !empty($_POST['pagecount']) ? $_POST['pagecount'] : 10;
		$this->pageCurrent = !empty($_POST['p']) ? $_POST['p'] : 1;
	}

	public function restore()
	{
		$server_id = isset($_REQUEST['server_id']) ? trim($_REQUEST['server_id']) : '';
		$cid = isset($_REQUEST['cid']) ? trim($_REQUEST['cid']) : 0;
		$pid = isset($_REQUEST['pid']) ? trim($_REQUEST['pid']) : 0;
		$type = isset($_GET['type']) ? intval($_GET['type']) : 0;

		if(empty($server_id))
		{
			throw new \Exception($this->_LANG['SelectServers']);
		}

		if(empty($cid) || !is_numeric($cid))
		{
			throw new \Exception($this->_LANG['no_cid']);
		}

		if(empty($pid) || !is_numeric($pid))
		{
			throw new \Exception($this->_LANG['no_pid']);
		}

		$vip = isset($_GET['vip']) ? intval($_GET['vip']) : 0;
		$vip_old = isset($_GET['vip_old']) ? intval($_GET['vip_old']) : 0;
		$equip_id = isset($_GET['equip_id']) ? trim($_GET['equip_id']) : 0;
		$equip_num = isset($_GET['equip_num']) ? intval($_GET['equip_num']) : 0;
		$order_id = isset($_GET['order_id']) ? trim($_GET['order_id']) : 0;
		$shouhun_num = isset($_GET['shouhun_num']) ? trim($_GET['shouhun_num']) : 0;
		$game_gold_num = isset($_GET['game_gold']) ? trim($_GET['game_gold']) : 0;
		$jl_lev = isset($_GET['jl_lev']) ? intval($_GET['jl_lev']) : 0;

		$title = $this->_LANG['tools_restore_title'];
		$desc = $title;
		$affectObj = 'player_id='.$pid.'|cid='.$cid;
		$desc .= ':'.$affectObj;

		$op_title_map = array();
		$op_title_map[8] = $this->_LANG['tools_del_title_monthcard'];
		$op_title_map[9] = $this->_LANG['tools_del_title_lifelongcard'];
		$op_title_map[10] = $this->_LANG['tools_del_title_fund'];
		$op_title_map[12] = $this->_LANG['tools_del_title_magic_pea'];

		//type = 0:查看角色数据; 1:修改vip; 2:清理道具; 3:清理充值记录
		if ($type == 1)
		{
			if ($vip>12 || $vip < 0)
			{
				throw new \Exception($this->_LANG['error_vip']);
			}

			if ($vip_old < $vip)
			{
				throw new \Exception($this->_LANG['error_vip_change']);
			}

			$desc .= ':' . $this->_LANG['tools_restore_vip_title'] . ':vip='.$vip;

			$title .= '->' . $this->_LANG['tools_restore_vip_title'];
		}
		elseif (2 == $type)
		{
			if (empty($equip_id) || !is_numeric($equip_id))
			{
				throw new \Exception($this->_LANG['error_equip_id']);
			}

			if (empty($equip_num) || $equip_num < 0)
			{
				throw new \Exception($this->_LANG['error_equip_num']);
			}

			$desc .= ':' . $this->_LANG['tools_restore_equip_title'] . ':equip_id='.$equip_id.'|equip_num='.$equip_num;
			$title .= '->' . $this->_LANG['tools_restore_equip_title'];
		}
		elseif (3 == $type)
		{
			if (empty($order_id) || !is_numeric($order_id))
			{
				throw new \Exception($this->_LANG['error_order_id']);
			}

			$desc .= ':' . $this->_LANG['tools_restore_gold'] .':order_id='.$order_id;
			$title .= '->' . $this->_LANG['tools_restore_gold'];
		}
		elseif(4 == $type)
		{
			if (empty($shouhun_num) || !is_numeric($shouhun_num))
			{
				throw new \Exception($this->_LANG['error_shouhun_num']);
			}

			$desc .= ':' . $this->_LANG['tools_del_shouhun_title'] .':shouhun_num='.$shouhun_num;
			$title .= '->' . $this->_LANG['tools_del_shouhun_title'];
		}
		elseif(5 == $type)
		{
			//删除装备栏装备
			if (empty($equip_id) || !is_numeric($equip_id))
			{
				throw new \Exception($this->_LANG['error_itembar_equip_id']);
			}

			$desc .= ':' . $this->_LANG['tools_restore_itembar_equip_title'] .':itembar_equip_id='.$equip_id;
			$title .= '->' . $this->_LANG['tools_restore_itembar_equip_title'];
		}
		elseif(6 == $type)
		{
			//删除装备栏装备
			if (empty($equip_id) || !is_numeric($equip_id))
			{
				throw new \Exception($this->_LANG['error_itembar_equip_id']);
			}

			if ($jl_lev < 0)
			{
				throw new \Exception($this->_LANG['error_jl_lev']);
			}

			$desc .= ':' . $this->_LANG['tools_restore_itembar_equip_jl_lev_title'] . ':itembar_equip_id='.$equip_id.'|jl_lev='.$jl_lev;
			$title .= '->' . $this->_LANG['tools_restore_itembar_equip_jl_lev_title'];
		}
		elseif(7 == $type)
		{
			if (empty($game_gold_num) || !is_numeric($game_gold_num))
			{
				throw new \Exception($this->_LANG['error_game_gold_num']);
			}

			$desc .= ':' . $this->_LANG['tools_restore_del_game_gold_title'] .':game_gold_num='.$game_gold_num;
			$title .= '->' . $this->_LANG['tools_restore_del_game_gold_title'];
		}
		elseif(11 == $type)
		{
			if (empty($game_gold_num) || !is_numeric($game_gold_num))
			{
				throw new \Exception($this->_LANG['error_silver']);
			}

			$desc .= ':' . $this->_LANG['tools_restore_del_silver_title'] .':silver='.$game_gold_num;
			$title .= '->' . $this->_LANG['tools_restore_del_silver_title'];
		}
		elseif (!empty($op_title_map) && $type >0 && !empty($op_title_map[$type]))
		{
			$op_title = $op_title_map[$type];
			$desc .= ':' . $op_title;
			$title .= '->' . $op_title;
		}

		//检查权限
		//*
		$action_key = './?act=Tools.restore';
		$check_auth = $this->check_action_auth($action_key);

		if (empty($check_auth))
		{
			common\Functions::debug($this->_LANG['notPermission']);
		}
		//*/

		$server_url = common\Functions::getServerUrl($server_id,'server');;
		if(empty($server_url)) throw new \Exception($this->_LANG['SelectServers']); //不存在返回false

		$server_name = common\Functions::getServerUrl($server_id,'serverName');
		$author = !empty($_SESSION['infoUser']['fullname']) ? $_SESSION['infoUser']['fullname'] : '';
		
		$RestParm = array(
			'type' => $type,
			'cid' => $cid,
			'pid' => $pid,
			'vip' => $vip,
			'equip_id' => $equip_id,
			'equip_num' => $equip_num,
			'order_id' => $order_id,
			'shouhun_num' => $shouhun_num,
			'game_gold' => $game_gold_num,
			'jl_lev' => $jl_lev,
			'author' => $author,
		);

		$ActionService = util\Singleton::get("service\\ActionService");
		$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);

		$type>0 && LogCtrl::CallOperationLogs($server_id,$desc,$server_id,$action['actkey'],$title, $affectObj);
		$RestHost = $server_url.RESTSUFFIX;
		$serverReturn = common\Rest::CallCommRestInterFace('Platform.restore',$RestHost,$RestParm);
			
		if (!empty($serverReturn) && $serverReturn['retcode'] == 0)
		{
			//添加本地数据
			if (2 == $type && isset($serverReturn['retmsg']))
			{
				$nums = intval($serverReturn['retmsg']);
				$serverReturn['retmsg'] = $this->_LANG['op_succ'] . ' -- ' . sprintf($this->_LANG['page_CountResult'],$nums);
			}
			elseif( 6 == $type || 5 == $type || 12 == $type)
			{
				//采用游戏接口返回信息
			}
			else
			{
				$serverReturn['retmsg'] = $this->_LANG['op_succ'];
			}

		}

		return $serverReturn;
	}

	//迁移角色
	public function shiftRole()
	{
		$server_id = isset($_REQUEST['server_id']) ? trim($_REQUEST['server_id']) : '';
		$cid = isset($_REQUEST['cid']) ? trim($_REQUEST['cid']) : 0;
		$pid = isset($_REQUEST['pid']) ? trim($_REQUEST['pid']) : 0;
		$type = isset($_GET['type']) ? intval($_GET['type']) : 0; // 0:查询 1:迁移

		if(empty($server_id))
		{
			throw new \Exception($this->_LANG['SelectServers']);
		}

		if(empty($cid) || !is_numeric($cid))
		{
			throw new \Exception($this->_LANG['no_from_cid']);
		}

		if(empty($pid) || !is_numeric($pid))
		{
			throw new \Exception($this->_LANG['no_to_pid']);
		}

		$title = $this->_LANG['tools_shift_role_title'];
		$desc = $title;
		$affectObj = 'from_cid='.$cid .'|to_player_id='.$pid;
		$desc .= ':'.$affectObj;

		//检查权限
		//*
		$action_key = './?act=Tools.shiftRole';
		$check_auth = $this->check_action_auth($action_key);

		if (empty($check_auth))
		{
			common\Functions::debug($this->_LANG['notPermission']);
		}
		//*/

		$server_url = common\Functions::getServerUrl($server_id,'server');;
		if(empty($server_url)) throw new \Exception($this->_LANG['SelectServers']); //不存在返回false

		$server_name = common\Functions::getServerUrl($server_id,'serverName');
		$author = !empty($_SESSION['infoUser']['fullname']) ? $_SESSION['infoUser']['fullname'] : '';
		
		$RestParm = array(
			'type' => $type,
			'from_cid' => $cid,
			'to_pid' => $pid,
			'author' => $author,
		);

		$ActionService = util\Singleton::get("service\\ActionService");
		$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);

		$type>0 && LogCtrl::CallOperationLogs($server_id,$desc,$server_id,$action['actkey'],$title, $affectObj);
		$RestHost = $server_url.RESTSUFFIX;
		$serverReturn = common\Rest::CallCommRestInterFace('Platform.shiftRole',$RestHost,$RestParm);
			
		if (!empty($serverReturn) && $serverReturn['retcode'] == 0)
		{
			$serverReturn['retmsg'] = $this->_LANG['op_succ'];
		}

		return $serverReturn;
	}

	//删除翅膀
	public function delWing()
	{
		$server_id = isset($_REQUEST['server_id']) ? trim($_REQUEST['server_id']) : '';
		$cid = isset($_REQUEST['cid']) ? trim($_REQUEST['cid']) : 0;
		$equip_id = isset($_REQUEST['equip_id']) ? trim($_REQUEST['equip_id']) : 0;
		$type = isset($_GET['type']) ? intval($_GET['type']) : 0; // 0:查询 1:迁移

		if(empty($server_id))
		{
			throw new \Exception($this->_LANG['SelectServers']);
		}

		if(empty($cid) || !is_numeric($cid))
		{
			throw new \Exception($this->_LANG['no_cid']);
		}

		if(empty($equip_id) || !is_numeric($equip_id))
		{
			throw new \Exception($this->_LANG['no_wing_equip_id']);
		}

		$title = $this->_LANG['tools_del_wing_title'];
		$desc = $title;
		$affectObj = 'cid='.$cid .'|equip_id='.$equip_id;
		$desc .= ':'.$affectObj;

		//检查权限
		//*
		$action_key = './?act=Tools.delWing';
		$check_auth = $this->check_action_auth($action_key);

		if (empty($check_auth))
		{
			common\Functions::debug($this->_LANG['notPermission']);
		}
		//*/

		$server_url = common\Functions::getServerUrl($server_id,'server');;
		if(empty($server_url)) throw new \Exception($this->_LANG['SelectServers']); //不存在返回false

		$server_name = common\Functions::getServerUrl($server_id,'serverName');
		$author = !empty($_SESSION['infoUser']['fullname']) ? $_SESSION['infoUser']['fullname'] : '';
		
		$RestParm = array(
			'type' => $type,
			'cid' => $cid,
			'del_equip_id' => $equip_id,
			'author' => $author,
		);

		$ActionService = util\Singleton::get("service\\ActionService");
		$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);

		$type>0 && LogCtrl::CallOperationLogs($server_id,$desc,$server_id,$action['actkey'],$title, $affectObj);
		$RestHost = $server_url.RESTSUFFIX;
		$serverReturn = common\Rest::CallCommRestInterFace('Platform.delWing',$RestHost,$RestParm);
			
		if (!empty($serverReturn) && $serverReturn['retcode'] == 0)
		{
			$serverReturn['retmsg'] = $this->_LANG['op_succ'];
		}

		return $serverReturn;
	}
}
