<?php	  
namespace framework\data\memcached;

use \Memcached;
/**
 * Memcached管理工具，用于管理Memcached对象的工具，需要memcached扩展。
 * 
 * @author zivn
 * @package framework\data\memcached
 */
class MemcachedManager
{
	/**
	 * Memcached配置
	 * 
	 * @var <MemcachedConfiguration>array
	 */
	private static $configs;
	/**
	 * Memcached实例
	 * 
	 * @var \Memcached
	 */
	private static $instance;
	
	/**
	 * 添加Memcached配置
	 * 
	 * @param MemcachedConfiguration $config
	 */
	public static function addConfigration(MemcachedConfiguration $config)
	{
		self::$configs[] = $config;
	}
	
	/**
	 * 获取Memcached实例
	 * 
	 * @return \Memcached
	 */
	public static function getInstance()
	{
		if (empty(self::$instance))
		{			
			if (empty(self::$configs))
			{
				return null;
			}
			
			$memcached = new \Memcached();
			
			foreach (self::$configs as $config)
			{
				$memcached->addServer($config->host, $config->port);
			}
		
			self::$instance = $memcached;
		}
		
		return self::$instance;
	}
}