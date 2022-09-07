<?php
/******************************************************************************
Filename             :  class.scene_grp.inc.php
Author               :  lei.zhang@globalnet-inc.com
Date/time            :  2008-12-12
Purpose              : 
Description          :  
Revisions            :

******************************************************************************/
class ClsSceneGrp
{
	private $DB = null;
	private $tbl_scene = 'tbl_scene';
	private $tbl_scene_group = 'tbl_scene_group';
	
	private $tbl_insert_fields = array(
								'picture',
								'title',
								'intro',
								'nation_id',
								'is_subline',
								'left_top_x',
								'left_top_y',
								'right_bottom_x',
								'right_bottom_y',
								'level_up',
								'level_low',
								'is_contest',
								'updated',
								);
	private $tbl_mod_fields = array(
								'id',
								'picture',
								'title',
								'intro',
								'nation_id',
								'default_scene_id',
								'is_subline',
								'left_top_x',
								'left_top_y',
								'right_bottom_x',
								'right_bottom_y',
								'level_up',
								'level_low',
								'is_contest',
								'updated',
								);
	
	/**
	  * 构造函数
	  *  
	  * @param  object $db
	  */
	public function __construct($db)
	{
		$this->DB = $db;
	}

	public function get_ex($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$sql = "SELECT * FROM ".$this->tbl_scene_group." WHERE 1=1 ".$condition." ORDER BY id ". " LIMIT " . $limit . " OFFSET " . $offset; ;

		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data))){
			$arr_data[] = $data;
			
		}
		$this->DB->free_result($db_data);
		return $arr_data;
	}
	
	public function get_all($default_grp_id = '')
	{
		$sql = "SELECT * FROM ".$this->tbl_scene_group." WHERE 1=1 ORDER BY id " ; 

		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data))){
			if ($data['id'] == $default_grp_id)
				$data['selected'] = 'selected';
			else
				$data['selected'] = '';
			$arr_data[] = $data;
		}
		$this->DB->free_result($db_data);
		return $arr_data;
	}

	// 获取场景组列表
	function getSimpleSceneGrpList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$order_byStr = $order_by == '' ? '' : " ORDER BY " . $order_by . " DESC ";
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;
		
		$sqlForGetEquipList = "SELECT id, title" . 
							   " FROM " . $this->tbl_scene_group . 
							  " WHERE 1=1 " . $condition . 
						   $order_byStr . $limitStr . $offsetStr;

		$db_data = $this->DB->query($sqlForGetEquipList);
		
		$arr_data = array ();
		while ( $data = $this->DB->fetch_array ( $db_data ) ) {
			$arr_data [] = $data;
		}
//		die($sqlForGetEquipList);
//		print_r($arr_data);die();
		
		$this->DB->free_result ( $db_data );
		
		return $arr_data;
	}

	/**
	* 获取记录总数
	* params : $condition : 查询条件
	*/
	function getCount($condition = '')
	{
		$sql = "SELECT count(`id`) as total FROM ".$this->tbl_scene_group." WHERE 1=1 ".$condition ;

		$db_data = $this->DB->query_first($sql);

		return $db_data['total'];
	}
	
	public function get($id)
	{
		$sql = "SELECT * FROM ".$this->tbl_scene_group." WHERE id=" . $id;
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);
		return $arr_data;
	}
	
	public function get_all_nation()
	{
		global $_CONFIG_GLOBAL_NATION;
		return $_CONFIG_GLOBAL_NATION;
	}

	public function get_scenes_by_gid( $gid )
	{
		$sql = "SELECT id,title,intro FROM ".$this->tbl_scene." WHERE scene_group_id=" . $gid;
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);
		return $arr_data;
	}
	
	public function add($arr)
	{
		$fields = implode( "`,`", $this->tbl_insert_fields );
		$fields = ("`".$fields."`");
		$values = '';
		foreach ( $arr as $value )
		{
			if (is_int($value))
				$values .= ($value.",");
			else 
				$values .= ("'".$value."',");
		}
		$values = substr($values, 0, strlen($values)-1);
		$sql = "insert into ". $this->tbl_scene_group .
								" (".$fields.") values (". $values. ")";
		if ($this->DB->query($sql))
			return $this->DB->insert_id();
		else
			return 0;
	}
	
	public function del($id)
	{
		$sql = "delete from  " . $this->tbl_scene . " WHERE `scene_group_id` = " . $id . "";
		if ( !$this->DB->query($sql) )
			return false;

		$sql = "delete from  " . $this->tbl_scene_group . " WHERE `id` = " . $id . "";
		if ($this->DB->query($sql))
			return true;
		else
			return false;
	}
	
	public function mod($arr)
	{
		$fields = implode( "`,`", $this->tbl_mod_fields );
		$fields = ("`".$fields."`");
		$values = '';
		foreach ( $arr as $value )
		{
			if (is_int($value))
				$values .= ($value.",");
			else 
				$values .= ("'".$value."',");
		}
		$values = substr($values, 0, strlen($values)-1);
		$sql = "REPLACE INTO ". $this->tbl_scene_group .
								" (".$fields.") values (". $values. ")";
		if ($this->DB->query($sql))
			return true;
		else
			return false;
	}
}
?>
