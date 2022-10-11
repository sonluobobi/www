<?php
/**
 * 权限管理
 * @author jianzhu
 * @version  2015-08-11
 */
namespace ctrl;
use framework\util;
use framework\mvc\view;
use framework\mvc\view\smarty;

use \util\Functions;
use view\RedirectView;

use framework\core\Context;
use service;
use common;

class AuthCtrl extends CtrlBase {
	private $ActionServers;
	
	/**
	 * 构造函数，继承父方法
	 *
	 * @return void
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();
		$this->ActionServers = util\Singleton::get("service\\ActionService");
	}
	
	/**
	 * 用户在登录操作前，此方法先执行
	 *
	 * @return boolean Success
	 * @access public
	 */
	function beforeFilter()
	{
		if (empty($_SESSION['infoUser']['loginId']) || empty($_SESSION['infoUser']['loginName']))
		{
			header("Location: ?act=Login.form");
			return false;
		}
		
		/*	
		$name = trim($_SESSION['infoUser']['fullname']);
		$auths = array('liujianzhu');
		
		if (!in_array($name, $auths))
		{
			throw new \Exception($this->_LANG['notPermission']);
			\common\Functions::alertFunc($this->_LANG['notPermission']);
			return false;
		}
		//*/
			
		return true;
	}
	
	public function action(){
		global $_CONFIG_ACCOUNT;
		$internal_account = $_CONFIG_ACCOUNT;
		$auth = trim($_SESSION['infoUser']['fullname']);

		if (isset($internal_account[$auth]))
		{
			$internal_account[$auth] = '';
			unset($internal_account[$auth]);
		}
		
		unset($internal_account['jiancheng']);
	    unset($internal_account['liujianzhu']);

		//echo '<pre>';print_r($this->_LANG);exit;
		$type = isset($_REQUEST['type']) ? trim($_REQUEST['type']) : '';
		$do_auth_tools = false;

		if (class_exists('AuthTools'))
		{
			$do_auth_tools = true;
		}

		if (!empty($type) && 'load' == $type)
		{
			$account = isset($_REQUEST['account']) ? trim($_REQUEST['account']) : '';
			$actions = array();

			if (!empty($account) && !empty($internal_account[$account]))
			{
				$auth_file = INCLUDE_PATH . '/data/cache/cache_auth_'.$account.'.php';

				if (file_exists($auth_file))
				{
					$tmp_actions = require $auth_file;
				}

				if (!empty($tmp_actions))
				{
					foreach($tmp_actions as $_action)
					{
						$i = trim(strrchr($_action, '_'),'_');
						$has_no_auth = \AuthTools::has_no_auth($account, $i);

						if (!$do_auth_tools || !$has_no_auth)
						{
							$actions[] = $_action;
						}
					}
				}
			}

			view\JSONView::showJson('',$actions);
			exit;
		}

		if (!empty($_POST))
		{
			if (!empty($_POST['actions']) && !empty($_POST['account']) && is_array($_POST['actions']))
			{
				$account = isset($_POST['account']) ? trim($_POST['account']) : '';
				$actions = isset($_POST['actions']) ? $_POST['actions'] : array();
				
				if (empty($account) || empty($internal_account[$account]))
				{
					throw new \Exception($this->_LANG['ErrorAccount']);
				}

				if (!empty($actions))
				{
					$tmp_actions = array();

					foreach($actions as $action)
					{
						if (!empty($action))
						{
							$i = trim(strrchr($action, '_'),'_');
							//$has_no_auth = \AuthTools::has_no_auth($account, $i);
							$has_no_auth = false;

							if (!$do_auth_tools || !$has_no_auth)
							{
								$tmp_actions[] = $action;
							}
						}
					}

					$cur_date = date('Y-m-d H:i:s');

					//保存账号对应权限文件
					$auth_file = INCLUDE_PATH . '/data/cache/cache_auth_'.$account.'.php';
					$content = "<?php \r\n ";
					$content .= "//@$cur_date -- $auth \r\n";
					$content .= 'return ' . var_export($tmp_actions,true)."\r\n";
					$content .= "?> ";
					
					@file_put_contents($auth_file, $content);
			
					if (function_exists('gmt_do_log'))
					{
						$log_msg = 'auth.action -- ' . $account;
						gmt_do_log($log_msg, 'auth');
					}
				}
				
				throw new \Exception($this->_LANG['AuthSucc']);
			}
			else
			{
				throw new \Exception($this->_LANG['argvError']);
			}
		}
		
		$ActionInfo = $this->ActionServers->getActionList();
		//echo '<pre>';print_r($ActionInfo);exit;
		return new smarty\SmartyView("Auth.action.html", array("menuTree" => $ActionInfo, "internal_account" => array_keys($internal_account)));
	}
}
