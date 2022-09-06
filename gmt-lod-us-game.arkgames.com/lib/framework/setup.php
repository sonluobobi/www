<?php // -*-coding:utf-8; mode:php-mode;-*-
use framework\core;
initFrameworkPath();

use framework\core\Context;

require_once FRAMEWORK_PATH . DIRECTORY_SEPARATOR . "framework/core/Context.php";

if(isset($_SESSION['gup'])){
	if(file_exists("../data/cache/cache_serverlist".$_SESSION['gup'].'_'.$_SESSION['productId'].".php")){
		require_once '../data/cache/cache_serverlist'.$_SESSION['gup'].'_'.$_SESSION['productId'].".php";
	}
}

if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'Login.login')
{
	Context::setExceptionHandler("exception_handler_union");
}
else {
	Context::setExceptionHandler("framework_exception_handler");
}

function initFrameworkPath()
{
	if(!defined('FRAMEWORK_PATH'))
	{
		$setupPath = __FILE__;
		$strrpos = strrpos($setupPath, DIRECTORY_SEPARATOR);
		$frameworkPath = substr($setupPath, 0, $strrpos);
		
		define('FRAMEWORK_PATH', $frameworkPath);
	}
}

function __autoload($class) {
	$baseClasspath = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
	$classpath = Context::getClassesRoot(). DIRECTORY_SEPARATOR . $baseClasspath;
	
	if(!file_exists($classpath))
	{
		$classpath = FRAMEWORK_PATH . DIRECTORY_SEPARATOR . $baseClasspath;
	}
	//file_put_contents("/tmp/liao_path.log", $classpath."\r\n",FILE_APPEND);
	
	if(file_exists($classpath))
	{
		require_once($classpath);
	}
}

function framework_exception_handler($exception) {
	$exceptionXml = "<"."?xml version=\"1.0\" encoding=\"utf-8\" ?".">\n";
	$exceptionXml .= "<exception>\n";
	$exceptionXml .= "<code>".$exception->getCode()."</code>\n";
	$exceptionXml .= "<message>".$exception->getMessage()."</message>\n";
	if (defined("DEBUG_MODE") && DEBUG_MODE)
	{
		$exceptionXml .= "<file>".$exception->getFile()."</file>\n";
		$exceptionXml .= "<line>".$exception->getLine()."</line>\n";
		$exceptionXml .= "<trace>\n";

		$trace = $exception->getTrace();
		//file_put_contents('/tmp/gmt_cyz.log', json_encode($trace) . "\r\n", FILE_APPEND);
		foreach ($trace as $traceItem) {
			$exceptionXml .= "<traceItem>";
			$exceptionXml .= "<file>".$traceItem['file']."</file>\n";
			$exceptionXml .= "<line>".$traceItem['line']."</line>\n";
			$exceptionXml .= "<function>".$traceItem['function']."</function>\n";
			$exceptionXml .= "<class>".$traceItem['class']."</class>\n";
			$exceptionXml .= "<type>".$traceItem['type']."</type>\n";
			$exceptionXml .= "<args>\n";
			
			if (false && !empty($traceItem['args'])) {
				foreach ($traceItem['args'] as $argsItem) {
					$exceptionXml .= "<argsItem>".$argsItem."</argsItem>\n";
				}
			}
			$exceptionXml .= "</args>\n";
			$exceptionXml .= "</traceItem>";
		}
		$exceptionXml .= "</trace>\n";
	}
	$exceptionXml .= "</exception>\n";
	
	header("Content-Type:text/xml; charset=utf-8");	
	echo $exceptionXml;
}

function exception_handler_union($exception)
{
	$log_file = GMT_PATH_ROOT . '/data/exception_union.log';
	file_put_contents($log_file, $exception->getCode()."|".$exception->getMessage()."\r\n",FILE_APPEND);
	echo $exception->getCode();
}

