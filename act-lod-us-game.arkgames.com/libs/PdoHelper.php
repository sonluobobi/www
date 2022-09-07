<?php
/**
 * Dao辅助类，用于一些常用的数据库操作
 * @package dao
 *
 */
class PdoHelper
{
    private static $defaultPDO;
    /**
     * pdo对象
     *
     * @var PDO
     */
    public $pdo;
    /**
     * 数据表名
     *
     * @var string
     */
    public $tableName;
    /**
     * 类名
     *
     * @var string
     */
    public $className;
    
    public $query;

    /**
     * 取得默认的PDO对象
     *
     * @return PDO
     */
    public function __construct($db_host,$db_port,$db_name,$db_user,$db_password,$className = null)
    {
        if(!$this->pdo)
        {
            $this->pdo = new PDO(
                'mysql:host=' . $db_host . ';port=' . $db_port . ';dbname=' . $db_name, $db_user, $db_password, 
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8';",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
	    }
	    $this->className = $className;
	}
    
        
    public static function updateFieldMap($field)
    {
        return '`' . $field . '`=:' . $field;
    }
    
    public static function changeFieldMap($field)
    {
        return '`' . $field . '`=`' . $field . '`+:' . $field;
    }
    
    public static function toCol($array)
    {
        return reset($array);
    }
    
    /**
     * 比对对象和样本，看是匹配
     *
     * @param object $object
     * @param object $sample
     */
    public static function matchObjectSample($object, $sample)
    {
        foreach ($sample as $prop=>$value)
        {
            if(empty($value) || $object->$prop != $value)
            {
                return false;
            }
        }
        
        return true;
    }

    
    /**
     * 添加一个对象到数据库
     * @param Object $object 对象
     * @param array $fields 对象的属性数组
     * @param string $onDuplicate 主键或唯一键冲突时执行的更新语句
     * @return int 添加这条记录生成的主键值
     */
    public function add($object, $fields, $onDuplicate = null)
    {
        $strFields = '`' . implode('`,`', $fields) . '`';
        $strValues = ':' . implode(', :', $fields);
        
        $query = 'INSERT INTO `'. $this->tableName . '`(' . $strFields . ') VALUES (' . $strValues . ')';
        
        if ($onDuplicate != null) $query .= ' ON DUPLICATE KEY UPDATE '. $onDuplicate;
        
        $statement = $this->pdo->prepare($query);
        $params = array();
        
        foreach ($fields as $field)
        {
            $params[$field] = $object->$field;
        }
        
        $statement->execute($params);
        
        return $this->pdo->lastInsertId();
    }

	/**
     * 指定数据库表去添加一个对象 add by suwin zhong (20090105)
	 * @param string tbl_name 要插入的数据库表名
     * @param array $data 数组
     * @param array $fields 数组的下标
     * @param string $onDuplicate 主键或唯一键冲突时执行的更新语句
     * @return int 添加这条记录生成的主键值
     */
    public function simpleAdd($tbl_name, $data, $fields, $onDuplicate = null)
    {
        $strFields = '`' . implode('`,`', $fields) . '`';
        $strValues = ':' . implode(', :', $fields);
        
        $query = 'INSERT INTO `'. $tbl_name . '`(' . $strFields . ') VALUES (' . $strValues . ')';
        
        if ($onDuplicate != null) $query .= 'ON DUPLICATE KEY UPDATE '. $onDuplicate;
        
        $statement = $this->pdo->prepare($query);
        $params = array();
        
        foreach ($fields as $field)
        {
            $params[$field] = $data[$field];
        }
        
        $statement->execute($params);
        
        return $this->pdo->lastInsertId();
    }
 
    /**
     * REPLACE模式添加一个对象到数据库
     * @param Object $object 对象
     * @param array $fields 对象的属性数组
     * @return int 添加这条记录生成的主键值
     */
    public function replace($object, $fields)
    {
        $strFields = '`' . implode('`,`', $fields) . '`';
        $strValues = ':' . implode(', :', $fields);
        
        $query = 'REPLACE INTO `'. $this->tableName . '`(' . $strFields . ') VALUES (' . $strValues . ')';
        $statement = $this->pdo->prepare($query);
        $params = array();
        
        foreach ($fields as $field)
        {
            $params[$field] = $object->$field;
        }
        
        $statement->execute($params);
        
        return $this->pdo->lastInsertId();
    }
   
    /**
     * 更新所有符合条件的对象
     *
     * @param array $fields
     * @param array $params
     * @param string $where
     */
    public function update($fields, $params, $where, $change=false)
    {
        if ($change)
        {
            $updateFields = array_map(__CLASS__ . '::changeFieldMap', $fields);
        } else {
            $updateFields = array_map(__CLASS__ . '::updateFieldMap', $fields);
        }
        
        $strUpdateFields = implode(',', $updateFields);		
        $query = 'UPDATE `' . $this->tableName . '` SET ' . $strUpdateFields . ' WHERE ' . $where;
        
        $statement = $this->pdo->prepare($query);
        return $statement->execute($params);
    }

	/**
     * 简单的更新 add by suwin zhong (20081213)
     *
     * @param array $fields
     * @param array $params
     * @param string $where
     */
    public function simpleUpdate($strUpdateFields, $params, $where)
    {
        $query = 'UPDATE `' . $this->tableName . '` SET ' . $strUpdateFields . ' WHERE ' . $where;
        
		$statement = $this->pdo->prepare($query);
        return $statement->execute($params);
    }

	/**
     * 指定表明更新所有符合条件的对象 add by suwin zhong (20090112)
     *
     * @param array $fields
     * @param array $params
     * @param string $where
     */
    public function simpleUpdate2($tbl_name, $fields, $params, $where, $change=false)
    {
        if ($change)
        {
            $updateFields = array_map(__CLASS__ . '::changeFieldMap', $fields);
        } else {
            $updateFields = array_map(__CLASS__ . '::updateFieldMap', $fields);
        }
        
        $strUpdateFields = implode(',', $updateFields);		
        $query = 'UPDATE `' . $tbl_name . '` SET ' . $strUpdateFields . ' WHERE ' . $where;
        
        $statement = $this->pdo->prepare($query);
        return $statement->execute($params);
    }

	/**
     * 指定表明进行直接的更新 add by suwin zhong (20090116)
     *
	 * @param $string $tbl_name
     * @param $string $strUpdateFileds
     * @param array $params
     * @param string $where
     */
    public function simpleUpdate3($tbl_name, $strUpdateFields, $params, $where)
    {
        $query = 'UPDATE `' . $tbl_name . '` SET ' . $strUpdateFields . ' WHERE ' . $where;
        
		$statement = $this->pdo->prepare($query);
        return $statement->execute($params);
    }
    
    public function fetchArray($where = '1', $params = null, $fields = '*', $orderBy = null, $limit = null)
    {
        $query = "SELECT " . $fields . " FROM `" . $this->tableName . "` WHERE " . $where;
        if($orderBy)
        {
            $query .= " order by " .$orderBy;
        }
        
        if($limit)
        {
            $query .= " limit " . $limit;
        }
        
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetchAll();
    }
    
    /**
     * 获取满足条件的所有结果集，不包含数字键
     * 		add by xingzeng jiang (20081226)
     */
	public function fetchArrayOnlyAssoc($where = '1', $params = null, $fields = '*', $orderBy = null, $limit = null, $lock = null)
    {
        $query = "SELECT " . $fields . " FROM `" . $this->tableName . "` WHERE " . $where;
        if($orderBy)
        {
            $query .= " order by " .$orderBy;
        }
        
        if($limit)
        {
            $query .= " limit " . $limit;
        }
        
		if ($lock)
		{
			$query .= " " . $lock;
		}
		
        $statement = $this->pdo->prepare($query);
        
    	if(!$statement->execute($params))
        {
        	throw new Exception(Language::GetText(Language::MSG_CODE_ID_102901));
        }
        
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetchAll();
    }
    
    public function fetchCol($where = '1', $params = null, $fields = '*', $orderBy = null, $limit = null)
    {
        $results = $this->fetchArray($where, $params, $fields, $orderBy, $limit);
        
        return empty($results) ? array() : array_map('reset', $results);
    }
    
    /**
     * 取得所有符合条件的对象
     *
     * @param string $where sql条件
     * @param array $params sql参数
     * @param string $fields sql字段
     * @return array 对象数组
     */
    public function fetchAll($where = '1', $params = null, $fields = '*', $orderBy = null, $limit = null)
    {
        $query = "SELECT " . $fields . " FROM `" . $this->tableName . "` WHERE " . $where;

        if($orderBy)
        {
            $query .= " order by " .$orderBy;
        }
        
        if($limit)
        {
            $query .= " limit " . $limit;
        }
        
        $statement = $this->pdo->prepare($query);
        
        if(!$statement->execute($params))
        {
        	throw new Exception(Language::GetText(Language::MSG_CODE_ID_102901));
        }
       
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetchAll();
    }

	/**
     * 指定表名取得所有符合条件的对象
     *
     * @param string $where sql条件
     * @param array $params sql参数
     * @param string $fields sql字段
     * @return array 对象数组
     */
    public function simpleFetchAll($tbl_name, $where = '1', $params = null, $fields = '*', $orderBy = null, $limit = null, $lock = null)
    {
        $query = "SELECT " . $fields . " FROM `" . $tbl_name . "` WHERE " . $where;

        if($orderBy)
        {
            $query .= " order by " .$orderBy;
        }
        
        if($limit)
        {
            $query .= " limit " . $limit;
        }

		if ($lock)
		{
			$query .= " " . $lock;
		}
        
        $statement = $this->pdo->prepare($query);
        
        if(!$statement->execute($params))
        {
        	throw new Exception(Language::GetText(Language::MSG_CODE_ID_102901));
        }
       
        $statement->setFetchMode(PDO::FETCH_ASSOC, $this->className);
        return $statement->fetchAll();
    }

    /**
     * 根据样本查找对象
     *
     * @param object sample
     * @param string $fields
     * @return array
     */
    public function fetchAllBySample($sample, $fields = '*', $orderBy = null, $limit = null)
    {
        $where = self::createWhereBySample($sample);
        $params = self::createParamsBySample($sample);
        
        return $this->fetchAll($where, $params, $fields, $orderBy, $limit);
    }
    
    /**
     * 根据样本找到一个对象
     *
     * @param object $sample
     * @param string $fields
     * @return object
     */
    public function fetchOneBySample($sample, $fields = '*', $orderBy = null)
    {
        $where = self::createWhereBySample($sample);
        $params = self::createParamsBySample($sample);

        return $this->fetchObject($where, $params, $fields, $orderBy);
    }
    
    /**
     * 根据条件返回一个对象 add lock by zl (20090106)
     *
     * @param string $where
     * @param array $params
     * @param string $fields
     * @return object
     */
    public function fetchObject($where = '1', $params = null, $fields = '*', $orderBy = null, $lock = '' )
    {
        $query = "SELECT " . $fields . " FROM `" . $this->tableName . "` WHERE " . $where;

        if($orderBy)
        {
            $query .= " order by " .$orderBy;
        }
        
        $query .= " limit 1";
        $query .= $lock;
		$this->query = $query;
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch();
    }
    
    /**
     * 指定数据库表根据条件返回一个对象 add by suwin zhong (20090105)
     *
     * @param string $where
     * @param array $params
     * @param string $fields
     * @return object
     */
    public function simpleFetchObject($tbl_name, $where = '1', $params = null, $fields = '*', $orderBy = null)
    {
        $query = "SELECT " . $fields . " FROM `" . $tbl_name . "` WHERE " . $where;

        if($orderBy)
        {
            $query .= " order by " .$orderBy;
        }
        
        $query .= " limit 1";        
		$this->query = $query;
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch();
    }

    /**
     * 取得符合条件的第一条记录的第一个值
     *		modify:增加事务读锁支持 	modify by xingzeng.jiang 2009-3-13
     * @param string $where
     * @param array $params
     * @param string $fields
     * @return unknown
     */
    public function fetchValue($where = '1', $params = null, $fields = '*', $lock = '' )
    {
        $query = "SELECT ".$fields." FROM `".$this->tableName."` WHERE " . $where . " limit 1";
        
    	$query .= $lock;
        
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetchColumn();
    }
    
    /**
     * 取得获取符合条件的记录数
     * @param string $field
     * @param string $where
     * @param array $params
     * @return count
     */
    public function count( $field, $where = '1', $params = null )
    {
        $query = "SELECT count(". $field . ") FROM `" . $this->tableName . "` WHERE " . $where;
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetchColumn();  
    }
	
	/**
	 * 取得获取符合条件的总和
	 * @param string $field
	 * @param string $where
	 * @param array $params
	 * @return sum
	 */
    public function sum( $field, $where = '1', $params = null )
    {
        $query = "SELECT sum(". $field . ") FROM `" . $this->tableName . "` WHERE " . $where;
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetchColumn();  
    }
    
    /**
     * 删除符合条件的记录 (modify by suwin zhong 2009-06-09)
     *
     * @param string $where
     * @param array $params
	 * @param string $tableName
     */
    public function remove($where, $params, $tableName = '')
    {
        $where = trim($where);
        if (empty($where)) return;

		if ('' != $tableName)
			$query = "DELETE FROM `" . $tableName . "` WHERE " . $where;
		else
			$query = "DELETE FROM `" . $this->tableName . "` WHERE " . $where;

        $statement = $this->pdo->prepare($query);
        return $statement->execute($params);
    }
    
    /**
     * 更新所有符合条件的对象(如果实际更新到的行数为0，则返回失败)
     *		add by xingzeng jiang (20090106)
     * @param array $fields
     * @param array $params
     * @param string $where
     */
    public function updateReal($fields, $params, $where, $change=false)
    {
    	if ($change)
            $updateFields = array_map(__CLASS__ . '::changeFieldMap', $fields);
        else
            $updateFields = array_map(__CLASS__ . '::updateFieldMap', $fields);
        
        $strUpdateFields = implode(',', $updateFields);		
        $query = 'UPDATE `' . $this->tableName . '` SET ' . $strUpdateFields . ' WHERE ' . $where;
        
        $statement = $this->pdo->prepare($query);
        $re = $statement->execute($params);
        return $re === true && $statement->rowCount() > 0;
    }
    
    /**
     * 简单的更新 (如果实际更新到的行数为0，则返回失败)
     *		add by xingzeng jiang (20090106)
     * @param array $fields
     * @param array $params
     * @param string $where
     */
 	public function simpleUpdateReal($strUpdateFields, $params, $where)
    {
        $query = 'UPDATE `' . $this->tableName . '` SET ' . $strUpdateFields . ' WHERE ' . $where;
        
		$statement = $this->pdo->prepare($query);
        $re = $statement->execute($params);
        return $re === true && $statement->rowCount() > 0;
    }
    
    private static function createWhereBySample($sample)
    {
        $where = '';

        foreach ($sample as $prop=>$value)
        {
            if(empty($value))
            {
                continue;
            }
            
            if(!empty($where))
            {
                $where .= ' AND ';
            }

            $where .= '`' . $prop . '`=:' . $prop;
        }
        
        return $where;
    }
    
    private static function createParamsBySample($sample)
    {
        $params = array();
        
        foreach ($sample as $prop=>$value)
        {
            if(empty($value))
            {
                continue;
            }
            $params[$prop] = $value;
        }

        return $params;
    }

	/**
	 * 返回所有符合条件的记录
	 * @param unknown_type $sql
	 * @param unknown_type $params
	 * @return multitype:
	 */
    public function fetchAllRecord($sql, $params = null)
    {
        $statement = $this->pdo->prepare($sql);
		$statement->execute($params);
       
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetchAll();
    }
    
    /**
     * 返回一条记录
     * @param unknown_type $sql
     * @param unknown_type $params
     * @return mixed
     */
    public function fetchOneRecord($sql, $params = null)
    {
    	$statement = $this->pdo->prepare($sql);
    	$statement->execute($params);
    	 
    	$statement->setFetchMode(PDO::FETCH_ASSOC);
    	return $statement->fetch();
    }
        
    /**
     * 执行某条SQL语句
     * @param unknown_type $sql
     * @param unknown_type $params
     * @return boolean
     */
	public function executeSql($sql, $params = null)
    {
        $statement = $this->pdo->prepare($sql);
        return $statement->execute($params); 
	}
	
	public function addRecord($sql, $params = null)
	{
		$statement = $this->pdo->prepare($sql);
		if ($statement->execute($params))
		{
			return $this->pdo->lastInsertId();
		}
		return false;
	}
	
	public function execute_ret_value($sql, $params = null)
    {
		$statement = $this->pdo->prepare($sql);
		$statement->execute($params);
		return $statement->fetchColumn();
    }
}
?>
