<?php

namespace ctrl;

use framework\util;
use framework\mvc\view;
use framework\mvc\view\smarty;
use \view\RedirectView;
use framework\core\Context;
use service;
use common;

class ToolsCtrl extends CtrlBase 
{
	private $service;

	/** 
	 * 构造函数，继承父方法
	 * @return void
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();
		$this->service = util\Singleton::get("service\\ToolsService");
	}

	//还原数据操作
	public function restore()
	{
		$data = array();
		$cid = isset($_REQUEST['cid']) ? trim($_REQUEST['cid']) : 0;

		if($_POST || $cid >0)
		{
			$type = isset($_GET['type']) ? intval($_GET['type']) : 0;

			$result = $this->service->restore();
			$retmsg = $this->_LANG['op_fail'];

			if($result)
			{
				!empty($result['retmsg']) && $retmsg = trim($result['retmsg']);

				if ($type == 0)
				{
					$data = !empty($result['data']) ? $result['data'] : array();
					//echo '<pre>';print_r($data);exit;
					return new smarty\SmartyView('Tools.restore.html', array('data' => $data));
				}
			}

			throw new \Exception($retmsg);
		}else{
			return new smarty\SmartyView('Tools.restore.html', array('data' => $data));
		}
	}

	//迁移角色
	public function shiftRole()
	{
		$data = array();
		$cid = isset($_REQUEST['cid']) ? trim($_REQUEST['cid']) : 0;

		if($_POST || $cid >0)
		{
			$type = isset($_GET['type']) ? intval($_GET['type']) : 0;

			$result = $this->service->shiftRole();
			$retmsg = $this->_LANG['op_fail'];

			if($result)
			{
				!empty($result['retmsg']) && $retmsg = trim($result['retmsg']);

				if ($type == 0)
				{
					$data = !empty($result['data']) ? $result['data'] : array();

					if ($result['retcode'] != 0)
					{
						return new smarty\SmartyView('Tools.shiftRole.html', array('data' => $data, 'retmsg' => $retmsg));
					}

					//echo '<pre>';print_r($data);exit;
					return new smarty\SmartyView('Tools.shiftRole.html', array('data' => $data));
				}
			}

			throw new \Exception($retmsg);
		}else{
			return new smarty\SmartyView('Tools.shiftRole.html', array('data' => $data));
		}
	}

	//删除翅膀
	public function delWing()
	{
		$data = array();
		$cid = isset($_REQUEST['cid']) ? trim($_REQUEST['cid']) : 0;

		if($_POST || $cid >0)
		{
			$type = isset($_GET['type']) ? intval($_GET['type']) : 0;

			$result = $this->service->delWing();
			$retmsg = $this->_LANG['op_fail'];

			if($result)
			{
				!empty($result['retmsg']) && $retmsg = trim($result['retmsg']);

				if ($type == 0)
				{
					$data = !empty($result['data']) ? $result['data'] : array();

					if ($result['retcode'] != 0)
					{
						return new smarty\SmartyView('Tools.delWing.html', array('data' => $data, 'retmsg' => $retmsg));
					}

					//echo '<pre>';print_r($data);exit;
					return new smarty\SmartyView('Tools.delWing.html', array('data' => $data));
				}
			}

			throw new \Exception($retmsg);
		}else{
			return new smarty\SmartyView('Tools.delWing.html', array('data' => $data));
		}
	}
}