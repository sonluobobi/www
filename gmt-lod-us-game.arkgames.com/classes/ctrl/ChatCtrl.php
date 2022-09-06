<?php

namespace ctrl;

use framework\util;
use framework\mvc\view;
use framework\mvc\view\smarty;
use \view\RedirectView;
use framework\core\Context;
use service;
use common;

class ChatCtrl extends CtrlBase 
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
		$this->service = util\Singleton::get("service\\ChatService");
	}

	public function send()
	{
		if($_POST)
		{
			$result = $this->service->send();
			if($result){
				common\Functions::alertFunc($result['retmsg'],'RQ("./?act=Chat.send",pt.writeBody)');
			}else{
				common\Functions::debug($this->_LANG['op_fail']);
			}			
		}else{
			return new smarty\SmartyView("Chat.send.html");
		}
	}
}