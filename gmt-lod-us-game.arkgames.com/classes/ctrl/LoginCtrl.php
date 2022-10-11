<?php // -*-coding:utf-8; mode:php-mode;-*-
/**
 * @file   LoginCtrl.php
 * @author koocyton <koocyton@gmail.com>
 * @date   Mon Dec 14 14:57:16 2009
 * 
 * @brief  Ctrl 的基础类
 *
 * @package       LoginCtrl
 * @subpackage    CtrlBase
 */

namespace ctrl;

use framework\mvc\view\smarty;

use framework\util;
use \util\Functions;
use view\RedirectView;

/** 
 * 用户登录的 ctrl
 *
 * @package       LoginCtrl
 * @subpackage    CtrlBase
 */
class LoginCtrl extends CtrlBase {

	/** 
	 * 构造函数，继承父方法
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/** 
	 * 用户在登录操作前，此方法先执行
	 * 
	 * @return boolean Success
	 * @access public
	 */
	function beforeFilter()
	{
		if (!empty($_SESSION['loginId']) && !empty($_SESSION['loginName']) && $this->dispatcher->ctrlMethodName!="quit")
		{
			header("Location: ./");
			return false;
		}
		return true;
	}

	/** 
	 * 用户退出
	 * 
	 * @return void
	 * @access public
	 */
	function quit()
	{
		$_SESSION = null;
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		return new RedirectView("?act=Login.form");
		
	}
	
	/** 
	 * 输出用户登录的界面
	 * 
	 * @return view\SmartView Object
	 * @access public
	 */
	public function form()
	{
		//$GroupService = util\Singleton::get("service\\GroupService");
		//$groupList = $GroupService->getUserGroup();
		$groupList = \oemark::$oeMark;
		\common\Functions::identifyUrl();

		$language_list = array();

		if (defined('LANG_SIGN') && 'kr'== LANG_SIGN)
		{
			$language_list = array(array('k' => '한국어', 'v' => 'kr'), array('k' => '简体中文', 'v'=> 'zh'));
		}

		return new smarty\SmartyView("Login.form.html",array('GroupList'=>$groupList, 'languageList' => $language_list));
	}

	/** 
	 * 用户提交登录
	 * 
	 * @return void
	 * @access public
	 */
	public function post()
	{
		global $_CONFIG_ACCOUNT;
		if ($_SERVER['REQUEST_METHOD']=="POST" && !empty($_POST['username']) && !empty($_POST['password']))
		{
			//验证账号
			$internal_account = $_CONFIG_ACCOUNT;
			$username = trim($_POST['username']);
			
			if (isset($internal_account[$username]))
			{
				$password = $internal_account[$username];
				if ($password != md5(trim($_POST['password'])))
				{
					throw new \Exception('密码错误');
					//throw new \Exception($this->_LANG['noGroup']);
				}
				
				$_SESSION['infoUser']['loginId'] = $username;
				$_SESSION['infoUser']['fullname']  = $username;
				$_SESSION['infoUser']['loginName'] = $username;
				$_SESSION['infoUser']['userName']  = $username;
				$_SESSION['infoUser']['passWord']  = trim($_POST['password']);
				
				$_SESSION['userRank'][0] = 'GMT_JDSJ';
				
				if (function_exists('gmt_do_log'))
				{
					//记录登录日志
					gmt_do_log('login in gmt', 'login');
				}

				$auth_file = INCLUDE_PATH . '/data/cache/cache_auth_'.$username.'.php';

				$do_auth_tools = false;

				if (class_exists('AuthTools'))
				{
					$do_auth_tools = true;
				}
				
				
				if(!file_exists($auth_file))
				{
				    $auth_file = INCLUDE_PATH . '/data/cache/cache_auth_test1.php';
				}
				
				
				if (file_exists($auth_file))
				{
					$actions = require $auth_file;
						
					foreach ($actions as $a)
					{
						if (empty($a)) continue;

						$i = trim(strrchr($a, '_'),'_');

						if (empty($i) || !is_numeric($i)) continue;

						//过滤权限，普通用户没有管理员权限
						$has_no_auth = true;
						if ($do_auth_tools)
						{
							$has_no_auth = \AuthTools::has_no_auth($username, $i);
						}

						if($has_no_auth) continue;
						$_SESSION['userRank'][] = $a;
					}
				}
				else
				{
					for($i = 1;$i<= 300; $i++)
					{
						$has_no_auth = true;
						//过滤权限，普通用户没有管理员权限
						if ($do_auth_tools)
						{
							$has_no_auth = \AuthTools::has_no_auth($username, $i);
						}
											
						if($has_no_auth) continue;
						$_SESSION['userRank'][$i] = 'gmt_action_'.$i;
					}
				}
			}
			else
			{
				throw new \Exception($this->_LANG['noGroup']);
			}
		}
		else {
			throw new \Exception($this->_LANG['PlaseFormWfull']);
		}
	}
	
}
