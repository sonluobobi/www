<?php

namespace framework\mvc\view\smarty;
/**
 * Smarty配置信息
 * @author xodger@gmail.com
 * @package framework\mvc\view\smarty
 */
class SmartyConfiguration 
{
	/**
	 * Smarty框架的路径
	 * 
	 * @var String
	 */
	public $smartyPath;
	/**
	 * Smarty缓存目录
	 * 
	 * @var String
	 */
	public $cacheDir;
	/**
	 * Smarty编译目录
	 * 
	 * @var String
	 */
	public $compileDir;
	/**
	 * Smarty模板目录
	 * 
	 * @var String
	 */
	public $templateDir;
	/**
	 * Smarty配置目录
	 * 
	 * @var String
	 */
	public $configDir;
	/**
	 * Smarty 引入语言包
	 */
	public $Langage;
	/**
	 * Smarty 引入服务器缓存列表
	 */
	public $ServerList;
	
	/**
	 * 构造函数
	 * 
	 * @param string $smartyPath
	 * @param string $cacheDir
	 * @param string $compileDir
	 * @param string $templateDir
	 * @param string $configDir
	 */
	public function __construct($smartyPath = null, $cacheDir = null, $compileDir = null, $templateDir = null, $configDir = null, $LANGAGE=null, $ServerList=null)
	{
		$this->smartyPath = $smartyPath;
		$this->cacheDir = $cacheDir;
		$this->compileDir = $compileDir;
		$this->templateDir = $templateDir;
		$this->configDir = $configDir;
		$this->Langage = $LANGAGE;
		$this->ServerList = $ServerList;
	}
}
?>