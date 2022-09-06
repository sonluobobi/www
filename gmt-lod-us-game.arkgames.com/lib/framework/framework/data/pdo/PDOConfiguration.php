<?php
namespace framework\data\pdo;

/**
 * 数据库配置信息
 * 
 * @author xodger@gmail.com
 * @package framework\data\pdo
 */
class PDOConfiguration
{
	/**
	 * 协议，数据库类型
	 * 
	 * @var String
	 */
	public $protocol = "mysql";
	/**
	 * 服务器地址
	 * 
	 * @var string
	 */
	public $host;
	/**
	 * 服务器端口
	 * 
	 * @var int
	 */
	public $port;
	/**
	 * 数据库用户名
	 * 
	 * @var String
	 */
	public $user;
	/**
	 * 数据库密码
	 * 
	 * @var String
	 */
	public $pass;
	
	/**
	 * 数据库名称
	 * @var String
	 */
	public $dbname;
	/**
	 * 默认编码
	 * 
	 * @var String
	 */
	public $charset = "UTF8";
	
	/**
	 * 构造函数
	 * 
	 * @param string $protocol
	 * @param string $host
	 * @param int $port
	 * @param string $user
	 * @param string $pass
	 */
	public function __construct()
	{
	}
	
	public function getDSN()
	{
		$dsn = $this->protocol.':host='.$this->host.';port='.$this->port;
		if(!empty($this->dbname))
		{
			$dsn .= ";dbname=".$this->dbname;
		}
		return $dsn;
	}
}