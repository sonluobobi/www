<?php
namespace framework\data\memcached;

use \Memcached;

/**
 * Memcached数据处理类
 * 
 * @author zivn
 * @package framework\data\memcached
 */
class MemcachedHelper
{
	/**
     * Memcached对象
     *
     * @var \Memcached
     */
    private $memcached;
    
	/** 
	 * 构造函数
	 * 
	 * @param bool $enable
	 */
	public function __construct($enable)
	{
		if ($enable)
		{
			$this->memcached = MemcachedManager::getInstance();
		}
	}
    
    /**
     * 启用缓存
     * 
     */
    function enable()
    {
    	if (empty($this->memcached))
    	{
    		$this->memcached = MemcachedManager::getInstance();
    	}
    }
    
    /**
     * 禁用缓存
     * 
     */
    function disable()
    {
    	if (!empty($this->memcached))
    	{
    		$this->memcached = null;
    	}
    }

    /**
     * 取得Memcached对象
     * 
	 * @return \Memcached
	 */
	function getMemcached() 
	{
		return $this->memcached;
	}
    
	/**
	 * 添加新数据（如存在则失败）
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @return bool
	 */
    public function add($key, $value, $expiration=0)
    {        
    	return $this->memcached ? $this->memcached->add($key, $value, $expiration) : false;
    }
    
	/**
	 * 替换指定键名的数据（如不存在则失败）
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @return bool
	 */
    public function replace($key, $value, $expiration=0)
    {        
        return $this->memcached ? $this->memcached->replace($key, $value, $expiration) : false;
    }
    
	/**
	 * 存储指定键名的数据（如存在则覆盖）
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @return bool
	 */
    public function set($key, $value, $expiration=0)
    {        
        return $this->memcached ? $this->memcached->set($key, $value, $expiration) : false;
    }
    
	/**
	 * 存储指定数据序列（如存在则覆盖）
	 * 
	 * @param array $items
	 * @param int $expiration
	 * @return bool
	 */
    public function setMulti($items, $expiration=0)
    {        
        return $this->memcached ? $this->memcached->setMulti($items, $expiration) : false;
    }
    
	/**
	 * 获取指定键名的数据
	 * 
	 * @param string $key
	 * @return mixed
	 */
    public function get($key)
    {        
        return $this->memcached ? $this->memcached->get($key) : null;
    }
    
	/**
	 * 获取指定键名序列的数据
	 * 
	 * @param array $keys
	 * @return array
	 */
    public function getMulti($keys)
    {        
        return $this->memcached ? $this->memcached->getMulti($keys) : null;
    }
    
	/**
	 * 增加整数数据的值
	 * 
	 * @param string $key
	 * @param int $offset
	 * @return bool
	 */
    public function increment($key, $offset=1)
    {        
        return $this->memcached ? $this->memcached->increment($key, $offset) : false;
    }
    
	/**
	 * 减少整数数据的值
	 * 
	 * @param string $key
	 * @param int $offset
	 * @return bool
	 */
    public function decrement($key, $offset=1)
    {        
        return $this->memcached ? $this->memcached->decrement($key, $offset) : false;
    }
    
	/**
	 * 删除指定数据
	 * 
	 * @param string $key
	 * @return bool
	 */
    public function delete($key)
    {        
        return $this->memcached ? $this->memcached->delete($key) : false;
    }
    
	/**
	 * 删除指定键名序列的数据
	 * 
	 * @param array $keys
	 * @return bool
	 */
    public function deleteMulti($keys)
    {        
    	if (!$this->memcached || empty($keys))
    	{
    		return false;
    	}
    	
    	foreach ($keys as $key)
    	{
    		$this->memcached->delete($key);
    	}
    	
    	return true;
    }
    
	/**
	 * 无效化所有缓存数据（清空缓存，慎用）
	 * 
	 * @return bool
	 */
    public function flush()
    {        
        return $this->memcached ? $this->memcached->flush() : false;
    }
    
	/**
	 * 获取服务器统计信息
	 * 
	 * @return array
	 */
    public function stat()
    {        
        return $this->memcached ? $this->memcached->getStats() : null;
    }
}
?>
