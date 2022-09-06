<?php // -*-coding:utf-8; mode:php-mode;-*-

namespace framework\mvc\dispatcher;

use framework\core\Context;
use framework\mvc\IRequestDispatcher;
use framework\mvc\IController;
/**
 * IRequestDispatcher的抽象实现，它实现了dispatch方法，并且定义了getCtrlClassName和getCtrlMethodName两个抽象方法，其子类只需实现这两个方法即可。
 * @author xodger@gmail.com
 * @package framework\mvc\dispatcher
 */
abstract class RequestDispatcherBase implements IRequestDispatcher {

	protected $defaultAction;
		
	public function dispatch()
	{
		$ctrlClass = Context::getCtrlNamespace() . "\\" . $this->getCtrlClassName();
        $ctrlMethod = $this->getCtrlMethodName();
        //file_put_contents("/tmp/liao_param.log", $ctrlClass."|".$ctrlMethod,FILE_APPEND);
        $ctrl = new $ctrlClass();
        
		$filtered = false;
		if($ctrl instanceof IController)
		{
			$ctrl->setDispatcher($this);
			
			$filtered = !$ctrl->beforeFilter();
		}
		
		$exception = null;
		
		if(!$filtered)
		{
			try
			{
				$view = $ctrl->$ctrlMethod();
				if($view)
				{
					$view->display();
				}
			}
			catch(Exception $e)
			{
				$exception = $e;
			}
			
		}
		
		if($ctrl instanceof IController)
		{
			$ctrl->afterFilter();
		}
		
				
		if($exception != null)
		{
			throw $exception;
		}
	}
	
		
	/**
	 * 获取控制器类名
	 * @return String
	 */
	abstract public function getCtrlClassName();
	
	/**
	 * 获取控制器方法名
	 * @return String
	 */
	abstract public function getCtrlMethodName();
}
