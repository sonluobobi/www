<?php

namespace ctrl;

use framework\util;
use framework\mvc\view;
use framework\mvc\view\smarty;
use \view\RedirectView;
use framework\core\Context;
use service;
use common;

class ToplistCtrl extends CtrlBase 
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
		$this->service = util\Singleton::get("service\\ToplistService");
	}

	//全服战力
	public function GlobalFC()
	{
		$dataList = array();
		$stat_date = isset($_POST['stat_date']) ? trim($_POST['stat_date']) : '';

		if($_POST && $stat_date)
		{
			$dataList = $this->service->GlobalFC($stat_date);

			if(!$dataList)
			{
				$retmsg = $this->_LANG['no_data'];
				throw new \Exception($retmsg);
			}
		}

		return new smarty\SmartyView('Toplist.global.fc.html', array('dataList' => $dataList));
	}
}