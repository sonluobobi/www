<?php
namespace framework\data\pdo;

use \PDO;

/**
 * PDO管理工具，用于管理PDO对象的工具，需要PDO扩展。
 * 
 * @author xiaoyang
 * @package framework\data\pdo
 */
class PDOLogManager{
	
		/**
	 * PDO实例
	 * 
	 * @var array<\PDO>
	 */
	private static $instances;
	
	/**
	 * 获取PDO实例
	 * 
	 * @param string $name
	 * @return \PDO
	 */
	public static function getInstance($name,$group='')
	{
		if (empty(self::$instances[$name]))
		{
			$group = !empty($group) ?  $group : $_SESSION['gup']."_".$_SESSION['productId'];
			$operation = \operation::$operationDataServer[$group];
			//file_put_contents("/tmp/liao_gmt_opt.log", var_export($operation,true),FILE_APPEND);
			
			$dsn = $operation['DB_PROTOCOL'].":host=".$operation['DB_HOST'].";port=".$operation['DB_PORT'].";dbname=".$operation['DB_LIBR'];
			$pdo = new \PDO($dsn, $operation['DB_USER'], $operation['DB_PASS'], array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$operation['ENCODING']}';",
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			));
			self::$instances[$name] = $pdo;
		}
		
		return self::$instances[$name];
	}
}
