<?php // -*-coding:utf-8; mode:php-mode;-*-
	  
namespace framework\mvc\dispatcher;

/**
 * 用于执行控制台脚本的请求转发器。
 * @author xodger@gmail.com
 * @package framework\mvc\dispatcher
 */
class ShellRequestDispatcher extends RequestDispatcherBase{
	private $ctrlClassName;
	private $ctrlMothodName;
	
	public function __construct()
	{
		// $this->defaultAction = 'Queue.main';
			
		if(array_key_exists("argv", $_SERVER) && array_key_exists("1", $_SERVER['argv']))
        {
        	$act = $_SERVER['argv'][1];
        }
        else
        {
        	$act = $this->defaultAction;
        }

        if (preg_match ( '/^([a-z_]+)\.([a-z_]+)$/i', $act, $arr ))
        {
        	$this->ctrlClassName = $arr[1].'Ctrl';
        	$this->ctrlMethodName = $arr[2];
        }
	}
	
	public function getCtrlClassName()
	{
		return $this->ctrlClassName;
		//return "TestCtrl";
	}
	
	public function getCtrlMethodName()
	{
		return $this->ctrlMothodName;
		//return "haha";
	}
}