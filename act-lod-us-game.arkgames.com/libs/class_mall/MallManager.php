<?php
/**
 * 商城管理
 * 
 * @author mjl
 * @version $Id: MallManager.php,v 1.1 2010/09/29 08:58:11 mjl-xx Exp $
 *
 */
class MallItem
{	
	public $id;        			//id
	public $sort_id = 1;   		//道具所在商城id
	public $order_by;  			//道具所在分页的排序号
	public $equip_id;  			//道具id
	
	public $buy_gold;  			 //出售需要的元宝数量
	public $use_voucher_gold; 		//是否必须使用充值魔石
	public $once_num = 1;     //每个商品对应的道具数量
	public $rebate_gold;  			//折扣后的元宝数量
	public $is_hot = 0;  			    //是否热卖(0 不热卖, 1 热卖)
	public $rebate_start;  			//打折开始时间
	public $rebate_end;  			//打折结束时间
	public $sale_start;  			//限卖开始日期
	public $sale_end;  			    //限卖结束日期
	public $vip_level=0;            //VIP等级
	
	public $srv_limit_type =0;      //全服限购类型 0 不限卖；1 永久性限购 2 按天限购
	public $srv_limit_cnt = 0;  	//全服限买数量
	public $ch_limit_type;  		//角色限购类型

	public $buy_gold_add = 0; //价格增量
	public $buy_gold_add_times_limit = 0; //价格增长次数限制

	//vip购买数量限制
	public $vip0 = 0; 	
	public $vip1 = 0; 
	public $vip2 = 0; 
	public $vip3 = 0; 
	public $vip4 = 0; 
	public $vip5 = 0; 
	public $vip6 = 0; 
	public $vip7 = 0; 
	public $vip8 = 0; 
	public $vip9 = 0; 
	public $vip10 = 0; 
	public $vip11 = 0; 
	public $vip12 = 0; 
	
	public $rebate_equip_id = 0;    //可用折扣券道具ID
	public $intro;  			    //商城道具描述
	public $server_ids;  			//有效游戏服ID串
	public $created ;               //创建日期
	public $updated ;               //更新日期
	
    public function __construct()
    {
    	if(!$this->id)
    	{
    		$now_date = date('Y-m-d H:i:s');
	    	$this->created = $now_date;
	    	$this->sale_start = $now_date;
	    	$this->sale_end = $now_date;
	    	$this->rebate_start = $now_date;
	    	$this->rebate_end = $now_date;
    	}    	 	
    }    
}

class MallManager 
{
	const MALL_ID_VIP = 9;//				--VIP专区
	
	private $DB; 				//数据库句柄
	private $table_name = 'tbl_activity_mall'; 	//表名
	private $entity_class = 'MallItem'; 

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
			$order_by = " ORDER BY `sort_id`,`order_by`";
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
		//var_dump($sql);
		return $this->fetch_all($sql);
	}
	
	public function fetch_all_object($where=' 1 ')
	{
		$sql = "SELECT * FROM " . $this->table_name . ' where ' . $where . " ORDER BY `sort_id`,`order_by`";
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
	
	public function getMallData($where=' 1 ')
	{
		$sql = "SELECT * FROM " . $this->table_name . ' where ' . $where . " ORDER BY `sort_id`,`order_by`";
		return $this->fetch_all($sql);
	}
	
	/**
	 * 添加新的商城物品
	 * 
	 * @param	MallItem  $item
	 * @return	插入数据库的最新记录ID
	 * 
	 */
	public function addMallItem(MallItem  $item) 
	{
		foreach($item as $property => $value)
		{
			if($value !== NULL)
			{
				$fields[] = $property;
				if(is_numeric($value))
				{
					$values[] = $value;
				}
				else
				{
					$values[] = "'" . $value . "'";
				}				
			}
		}		
		$strFields = '`' . implode('`,`', $fields) . '`';
        $strValues = implode(",", $values);        
        $query = 'REPLACE INTO `'. $this->table_name . '`(' . $strFields . ') VALUES (' . $strValues . ')';
        if (function_exists('act_do_log'))
		{
			act_do_log('add mall item sql | ' . $query, 'mall');
		}
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
			if (function_exists('act_do_log'))
			{
				act_do_log('update mall item sql | ' . $sql, 'mall');
			}
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
		if (function_exists('act_do_log'))
		{
			act_do_log('delete mall item sql | ' . $sql, 'mall');
		}
		return $this->DB->query ( $sql );
	}
	public function removeMallItemsByServers($str_selected_servers)
	{
		if($str_selected_servers)
		{
			$str_selected_servers = str_replace("'",'',$str_selected_servers);
			$str_selected_servers = str_replace(",","','",$str_selected_servers);
			$str_selected_servers = "'" . $str_selected_servers . "'";			
			$sql = " delete from " . $this->table_name . " where server in(" . $str_selected_servers . ") ";
			return $this->DB->query ( $sql );
		}
	}
}

