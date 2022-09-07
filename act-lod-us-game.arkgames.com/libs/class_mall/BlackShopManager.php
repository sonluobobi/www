<?php
/**
 * 商城管理
 * 
 * @author mjl
 * @version $Id: MallManager.php,v 1.2 2011/05/12 00:39:20 mjl-xx Exp $
 *
 */
class VipBlackShopItem
{	

    public $id;				//ID	
	public $sort;			//商店类型	
	public $faction_ids = 0;//门派id串	
	public $level_min;		//等级下限	
	public $level_max;		//等级上限	
	public $prop_sys;		//相对概率
	public $prop_user;		//相对概率
	
	public $order_by;		//位置	
	public $equip_id;		//道具id	
	public $equip_title;	//道具名称	
	public $middle_stone;	//需要灵石	
	public $high_stone;		//需要昆仑玉	
	
	public $is_bind = 1;		//是否绑定	
	public $is_can_expire = 0;	//是否会过期
	public $begin_time;			//有效开始时间
	public $end_time;			//有效结束时间(失效时间)	
	public $onsales = 0;		//折扣(1-100)
	public $onsales_begin_time;	//打折开始时间
	public $onsales_end_time;	//打折结束时间
	public $server;			//有效服务器
    
    public $updated;   			//更新日期       
	public $created;   			//创建日期
    
    public function __construct()
    {
    	if(!$this->id)
    	{
    		$now_date = date('Y-m-d H:i:s');
	    	$this->created = $now_date;
	    	$this->begin_time = $now_date;
	    	$this->end_time = $now_date;
	    	$this->onsales_begin_time = $now_date;
	    	$this->onsales_end_time = $now_date;
    	}    	 	
    }    
}

class BlackShopManager 
{
	const NORMAL_SORT_ID  = 1;//普通商店
	const VIP_SORT_ID  = 2;//VIP商店
	
	private $DB; 			//数据库句柄
	private $table_name = 'tbl_blackmarket_vip'; 	//表名
	private $entity_class = 'VipBlackShopItem'; 

	public function __construct($_db=null) 
	{
		if(!$_db)
		{
			global $DB;
			if($DB)
			{
				$_db = &$DB;
			}else 
			{
				$_db = new db_MySQL;;
			}			
		}
		$this->DB = &$_db;
	}
	private function fetch_all($sql)
	{
		$arr_data = array ();
		$db_data = $this->DB->query ( $sql );
		$data = $this->DB->fetch_array($db_data);
		while($data)
		{
			$arr_data [] = $data;
			$data = $data = $this->DB->fetch_array($db_data);
		}
		$this->DB->free_result ( $db_data );		
		return $arr_data;
	}
	
	public function setTableName($table_name)
	{
		$this->table_name = $table_name;  
	}
	
	public function getTableName()
	{
		return $this->table_name;
	}
	
	/**
	 * 根据商城id获取该商场的商品数目(所有商品:包括过期的)
	 * @param	$mall_id  商城id
	 * @return	活动总数 
	 */
	public function getMallItemCount($where) 
	{
		$sql = "SELECT COUNT(`id`) AS total " . " FROM " . $this->table_name . " WHERE $where ";		
		$db_data = $this->DB->query_first ( $sql );		
		return $db_data ['total'];
	}
	
	
	/**
	 * 获取商场商品列表
	 * 
	 * @param	$condition	查询条件
	 * @param	$order_by	显示顺序
	 * @param	$limit		显示数量
	 * @param	$offset		偏移量
	 * @return	object array
	 * 
	 */
	public function getMallItemList($condition = '', $order_by = '', $limit = '', $offset = '') 
	{

		if($condition == '')
		{
			$condition = 1;
		}
		
		if($order_by == '')
		{
			$order_by = " ORDER BY `sort`,`order_by`";
		}else
		{
			$order_by = " ORDER BY " . $order_by;
		}
		
		if($limit)
		{
			$limit = " LIMIT " . intval($limit);
		}else
		{
			$limit = '';
		}
		
		if($offset)
		{
			$offset = " OFFSET " . intval($offset);
		}else
		{
			$offset = '';
		}
		
		$sql = "SELECT * FROM " . $this->table_name . " WHERE " . $condition . $order_by . $limit . $offset;
		
		return $this->fetch_all($sql);
	}
	
	public function fetch_all_object($where=' 1 ')
	{
		$sql = "SELECT * FROM " . $this->table_name . ' where ' . $where . " ORDER BY `sort`,`order_by`";
		$arr_data = array ();
		$db_data = $this->DB->query ( $sql );
		$data = mysql_fetch_object($db_data,$this->entity_class);
		while($data)
		{
			$arr_data [] = $data;
			$data = mysql_fetch_object($db_data,$this->entity_class);
		}
		$this->DB->free_result ( $db_data );		
		return $arr_data;
	}
	
	/**
	 * 添加新的商城物品
	 * 
	 * @param	MallItem  $item
	 * @return	插入数据库的最新记录ID
	 * 
	 */
	public function addMallItem($item) 
	{
		foreach($item as $property => $value)
		{
			if($value !== NULL)
			{
				$fields[] = $property;
				if(is_numeric($value))
				{
					$values[] = $value;
				}else
				{
					$values[] = "'" . $value . "'";
				}				
			}
		}		
		$strFields = '`' . implode('`,`', $fields) . '`';
        $strValues = implode(",", $values);        
        $query = 'REPLACE INTO `'. $this->table_name . '`(' . $strFields . ') VALUES (' . $strValues . ')';
		if ($this->DB->query ( $query ))
		{
			return $this->DB->insert_id ();
		}
		return false;
	}
	
	/**
	 * 根据ID获取一个活动信息
	 * 
	 * @param	Int $id 活动ID
	 * @return	MallItem 活动的数据（关联数组）
	 * 
	 */
	public function getMallItemById($id) 
	{		
		$sql = "SELECT * FROM " . $this->table_name . " WHERE  `id` = " . $id . " LIMIT 1";		
		$item = $this->DB->query_first($sql);
		return $item;
	}
	
	/**
	 * 更新一个商场物品
	 * 
	 * @param	Int $id 要更新的物品 id号
	 * @param	String $strData 要更新的参数
	 * @return	Boolean
	 * 
	 */
	public function updateMallItemById($id, $params) 
	{
		if($id and $params)
		{
			$strData = '';
			foreach ($params as $field => $value)
			{
				$strData .= ',`' . $field . '`=';
				if(is_numeric($value))
				{
					$strData .= $value;
				}else
				{
					$strData .= "'".$value."'";
				}
			}			
			$strData = substr($strData,1);			
			$sql = "UPDATE " . $this->table_name . " SET " . $strData . " WHERE id = " . $id . " LIMIT 1";		
			if ($this->DB->query ( $sql ))
			{
				return true;
			}
		}
		return false;
	}
	
	public function quary($sql)
	{
		return $this->fetch_all($sql);
	}
	
	public function removeMallItemById($id) 
	{
		$sql = " delete from " . $this->table_name . " where id=" . $id . " limit 1 ";
		return $this->DB->query ( $sql );
	}
}

