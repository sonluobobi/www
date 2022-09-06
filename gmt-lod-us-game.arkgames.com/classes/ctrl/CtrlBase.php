<?php  // -*-coding:utf-8; mode:php-mode;-*-
/**
 * @file   CtrlBase.php
 * @author koocyton <koocyton@gmail.com>
 * @date   Mon Dec 14 14:57:16 2009
 * 
 * @brief  Ctrl 的基础类
 *
 * @package       ctrl
 * @subpackage    framework.core.IController 
 */

namespace ctrl;

use framework\util;
use framework\view;
use framework\mvc\IController;
use framework\mvc\IRequestDispatcher;
use \view\RedirectView;
use \util\Functions;

/** 
 * CtrlBase Ctrl 的基础类
 *
 * @package       CtrlBase
 * @subpackage    framework.core.IController 
 */
class CtrlBase implements IController{

	/**
	 * dispatcher 对象
	 *
	 * @var object
	 * @access protected
	 */
	protected $dispatcher;
	/**
	 * 执行动作权限时，饶过权限验证
	 */
	private $actionHandler = array('Index.main');
	/**
	 * 语言对象
	 */
	protected $_LANG;

	/** 
	 * 设置 dispatcher
	 * 
	 * @param dispatcher 
	 * 
	 * @return void
	 * @access public
	 */
	public function setDispatcher(IRequestDispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}
	
	/**
	 * 获取 dispatcher
	 *
	 * @return framework\core\IRequestDispatcher
	 * @access public
	 */
	public function getDispatcher()
	{
		return $this->dispatcher;
	}

	/** 
	 * 在执行具体动作前，要执行的动作
	 * 
	 * @return ture/false
	 * @access public
	 */
	function beforeFilter()
	{
		
		if ((empty($_SESSION['infoUser']['loginId']) || empty($_SESSION['infoUser']['loginName'])) && empty($_SERVER['argv'][1]))
		{
			header("Location: ?act=Login.form");
			return false;
		}
		if(!empty($_SESSION['infoUser']['loginId']) && !empty($_GET['act']) && !array_search($_GET['act'],$this->actionHandler)  && empty($_SERVER['argv'][1]) ){
				$ActionService = util\Singleton::get("service\\ActionService");
				$actkey = $ActionService->getActionKeyByActionCode("./?act=".$_GET['act']);
			
		//	if(!in_array($actkey,$_SESSION['userRank'])){
		//		if(empty($_FILES)) throw new \Exception($this->_LANG['notPermission']);
		//		\common\Functions::alertFunc($this->_LANG['notPermission']);
		//		return false;
		//	}
			//$this->createGmtOptLog();
			return true;
                }
		if(!empty($_SERVER['argv'][1]) && preg_match("/queue|statis|sync$/",$_SERVER['argv'][1]))
		{
			switch ($_SERVER['argv'][1])
			{
				case 'queue':
                        require_once \framework\core\Context::getRootPath()."/webroot/queue.php";
                        break;
                case 'sync':
                		if (isset($_SERVER['argv'][2])) {
                			$_SESSION['locale'] = $_SERVER['argv'][2];
                		}
                        require_once \framework\core\Context::getRootPath()."/webroot/sync.php";
                        break;
			}
			exit;
		}

		return true;
	}

	/** 
	 * 在完成功能后，所执行的动作
	 * 
	 * @return ture/false
	 * @access public
	 */
	function afterFilter()
	{
		return true;
	}


	/**
	 * 对GMT管理员日常操作生成日志
	 */
	 public function createGmtOptLog()
	{
		$logDirPath = "/data/syslog/gmt/"; //日志路径
		$pid = $_SESSION['productId']; //获取当前产品ID
		$actionOthers = array('Login.checkpicone',"Login.checkpicone","Login.checkpicone");
        //和用户相关登录、退出操作不用生成日志
		if(!empty($_REQUEST['act']) && substr($_REQUEST['act'],0,6) != 'Login.')
		{
			$day = date('Ymd');
			$logFileName = $logDirPath.'gmtOpt_'.$pid.'_'.$day.'.log';
			$ActionService = util\Singleton::get("service\\ActionService");
			$actcode = './?act='.$_REQUEST['act'];
			$act_desc = $ActionService->getActionTitleByActionCode($actcode);
			$data = array(
				'pid' => $pid,
				'act' => $_REQUEST['act'],
				'act_desc' => $act_desc,
				'param' => base64_encode(json_encode($_REQUEST)),
				'username' => $_SESSION['infoUser']['fullname'],
				'opt_time' => date("Y-m-d H:i:s"),
				'ip' => $_SERVER['REMOTE_ADDR']
			);
			//日志文件,追加数据
			$line = implode("\t",$data)."\r\n";
			if(!is_dir($logDirPath))
			{
				//mkdir($logDirPath);
			}
			//file_put_contents($logFileName, $line, FILE_APPEND);
		}
	}

    public static function mkdir($strPath)
    {
        if (is_dir($strPath)) return true;

        $pStrPath = dirname($strPath);
        if (self::mkdir($pStrPath)) return false;

        @mkdir($strPath, 0777);
        @chmod($strPath, 0777);

        return true;
    }


     public static function do_log($str='', $name='golbal')
    {
        //global $ip;

        //empty($ip) && $ip = $_SERVER["REMOTE_ADDR"];

        $date_str = date('Ymd');
        $path = '/data/sanxiao/www/gmt-kf-sanxiao-zh.game.kunlun.com/classes/ctrl/log/';

        if (file_exists($path) && !empty($str))
        {
            $msg = ' -- ['. date('Y-m-d H:i:s') .'] -- ' .  $name . ' -- ' . $str . "\r\n";
            $reset = file_put_contents($path.$name.'_'.$date_str.'.log', $msg, FILE_APPEND);
        }
    }






	/** 
	 * 构造函数
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct()
	{
		global $_LANG;
		$this->_LANG = $_LANG;
	}

	//判断是否有对应的权限
	public function check_action_auth($actionCode='')
	{
		if (empty($actionCode))
		{
			return false;
		}

		$ActionService = util\Singleton::get("service\\ActionService");
		$actkey = $ActionService->getActionKeyByActionCode($actionCode);
			
		if(empty($actkey) || !in_array($actkey,$_SESSION['userRank']))
		{
			return false;
		}

		return true;
	}
}
