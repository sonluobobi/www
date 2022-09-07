<?php
/******************************************************************************
Filename             :  class.scene.inc.php
Author               :  lei.zhang@globalnet-inc.com
Date/time            :  2008-12-12
Purpose              : 
Description          :  
Revisions            : $Id: ClsScene.php,v 1.3 2009/11/13 07:30:11 huayi Exp $

******************************************************************************/
class ClsScene
{
	private $DB = null;
	private $tbl_scene = 'tbl_scene';
	private $tbl_scene_grp = 'tbl_scene_group';
	private $tbl_npc = 'tbl_npc';
	private $tbl_npc_monster = 'tbl_npc_monster';
	private $tbl_scene_group = 'tbl_scene_group';
	
	private $tbl_insert_fields = array(
								'picture',
								'icon',
								'title',
								'intro',
								'scene_group_id',
								'is_default',
								'state',
								'is_subline',
								'is_safe',
								'is_contest',
								'level_up',
								'level_low',
								'x1',
								'y1',
								'collect_type',
								'collect_level',
								'collect_pakages',
								'jump_ids',
								'npc_ids',
								'npc_monster_ids',
								'adventure_ids',
								'action_ids',
								'updated',
								);
	private $tbl_mod_fields = array(
								'id',
								'picture',
								'icon',
								'title',
								'intro',
								'scene_group_id',
								'is_default',
								'state',
								'is_subline',
								'is_safe',
								'is_contest',
								'level_up',
								'level_low',
								'x1',
								'y1',
								'collect_type',
								'collect_level',
								'collect_pakages',
								'jump_ids',
								'npc_ids',
								'npc_monster_ids',
								'adventure_ids',
								'action_ids',
								'updated',
								);
	
	/**
	  * 
	  *  
	  * @param  object $db
	  */
	public function ClsScene($db)
	{
		$this->DB = $db;
	}
	
	public function get_all()
	{
		$sql = "SELECT * FROM ".$this->tbl_scene." WHERE 1=1 ORDER BY id " ;

		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data))){
			if ('1' == $data['is_default'])
				$data['is_default_text']  = '是';
			else
				$data['is_default_text'] = '否';
				
			if( '1' == $data['is_subline'])
				$data['is_subline_text']  = '是';
			else
				$data['is_subline_text']  = '否';
				
			if( '1' == $data['is_safe'])
				$data['is_safe_text']  = '是';
			else
				$data['is_safe_text']  = '否';
				
			$arr_data[] = $data;
			
		}
		$this->DB->free_result($db_data);
		return $arr_data;
	}

	// 获取场景列表
	function getSimpleSceneList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$order_byStr = $order_by == '' ? '' : " ORDER BY " . $order_by . " DESC ";
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;
		
		$sqlForGetEquipList = "SELECT id, title" . 
							   " FROM " . $this->tbl_scene . 
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
	function getSceneListByNation($condition = '', $limit)
	{
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$sqlForGetEquipList = "SELECT scene.id, scene.title, sg.title gtitle FROM " .$this->tbl_scene_group. " sg, " .$this->tbl_scene. 
								" scene WHERE scene.scene_group_id = sg.id AND (sg.nation_id = 1 OR sg.nation_id = 0)" . 
								$condition . $limitStr;
		$db_data = $this->DB->query($sqlForGetEquipList);
		$arr_data = array ();
		while ( $data = $this->DB->fetch_array ( $db_data ) ) {
			$arr_data [] = $data;
		}
		$this->DB->free_result ( $db_data );
		
		return $arr_data;
	}
	
	public function get_scenes_list($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$sql = "SELECT * FROM ".$this->tbl_scene." WHERE 1=1 ".$condition." ORDER BY id ". " LIMIT " . $limit . " OFFSET " . $offset; ;

		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data))){
			if ('1' == $data['is_default'])
				$data['is_default_text']  = '是';
			else
				$data['is_default_text'] = '否';
				
			if( '1' == $data['is_subline'])
				$data['is_subline_text']  = '是';
			else
				$data['is_subline_text']  = '否';
				
			if( '1' == $data['is_safe'])
				$data['is_safe_text']  = '是';
			else
				$data['is_safe_text']  = '否';
				
			$arr_data[] = $data;
			
		}
		$this->DB->free_result($db_data);
		return $arr_data;
	}
	
	/**
	* 获取记录总数
	* params : $condition : 查询条件
	*/
	function getScenesCount($condition = '')
	{
		$sql = "SELECT count(`id`) as total FROM ".$this->tbl_scene." WHERE 1=1 ".$condition ;

		$db_data = $this->DB->query_first($sql);

		return $db_data['total'];
	}
	
	public function get($id)
	{
		$sql = "SELECT * FROM ".$this->tbl_scene." WHERE id=" . $id;
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data))){
			if ('1' == $data['is_default'])
				$data['is_default_text']  = '是';
			else
				$data['is_default_text'] = '否';
				
			if( '1' == $data['is_subline'])
				$data['is_subline_text']  = '是';
			else
				$data['is_subline_text']  = '否';
				
			if( '1' == $data['is_safe'])
				$data['is_safe_text']  = '是';
			else
				$data['is_safe_text']  = '否';
				
			$arr_data[] = $data;
		}
		$this->DB->free_result($db_data);
		return $arr_data;
	}
	
	public function get_by_group_id($gid)
	{
		$sql = "SELECT * FROM ".$this->tbl_scene." WHERE scene_group_id=" . $gid;
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);
		return $arr_data;
	}

	public function get_all_state()
	{
		global $_CONFIG_GLOBAL_SCENE_STATE;
		return array_slice($_CONFIG_GLOBAL_SCENE_STATE, 1);
	}

	public function get_scene_grp_ids()
	{
		$sql = "SELECT id,title FROM ".$this->tbl_scene_grp." WHERE 1 ";
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);
		return $arr_data;	
	}

	public function get_scene_grp_info($gid)
	{
		$sql = "SELECT id,title,nation_id FROM ".$this->tbl_scene_grp." WHERE id=" .$gid;
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);
		return $arr_data;	
	}
	
	public function get_jump_ids($sid,$gid)
	{
		$sql = "SELECT id,title FROM ".$this->tbl_scene." WHERE scene_group_id=" . $gid
					. " AND id<>" . $sid;
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);
		return $arr_data;
	}
	
	public function get_child_scenes($gid)
	{
		$sql = "SELECT id,title FROM ".$this->tbl_scene." WHERE scene_group_id=" . $gid;
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);
		return $arr_data;
	}

	public function get_npc_ids()
	{
		$sql = "SELECT id,title FROM ".$this->tbl_npc." WHERE 1 ";
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);
		return $arr_data;
	}
	
	public function get_monster_ids()
	{
		$sql = "SELECT id,title FROM ".$this->tbl_npc_monster." WHERE 1 ";
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);
		return $arr_data;
	}
	
	public function update_group_default($gid, $id)
	{
		$sql = "UPDATE ". $this->tbl_scene_grp . " SET default_scene_id=" . $id . " WHERE id=" . $gid;
		$this->DB->query($sql);
	}

	public function reset_group_default($gid)
	{
		$sql = "UPDATE ". $this->tbl_scene_grp . " SET default_scene_id=0 WHERE id=" . $gid;
		$this->DB->query($sql);
	}

	public function set_group_default($gid, $sid)
	{
		$sql = "SELECT default_scene_id FROM ".$this->tbl_scene_grp." WHERE id=" . $gid;
		$db_data = $this->DB->query($sql);
		$grp_info = $this->DB->fetch_array($db_data);
		if( $grp_info['default_scene_id'] != $sid )
		{
			$sql = "UPDATE " . $this->tbl_scene." SET is_default=0 WHERE id=" . $grp_info['default_scene_id'];
			$this->DB->query($sql);
		}
		$this->update_group_default($gid, $sid);
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
		$sql = "insert into ". $this->tbl_scene . " (".$fields.") values (". $values. ")";
		if( $this->DB->query($sql) )
			return $this->DB->insert_id();
		else
			return 0;
	}
	
	public function del($id)
	{
		$sql = "SELECT is_default,scene_group_id FROM ".$this->tbl_scene." WHERE id=" . $id;
		$db_data = $this->DB->query($sql);
		$arr_data = array();
		while (($data = $this->DB->fetch_array($db_data)))
			$arr_data[] = $data;
		$this->DB->free_result($db_data);

		$sql = "delete from  " . $this->tbl_scene . " WHERE `id` = " . $id . "";

		if ($this->DB->query($sql))
		{
			if( $arr_data[0] )
			{
				if( $arr_data[0]['is_default'] )	
					$this->reset_group_default( $arr_data[0]['scene_group_id'] );
			}
			return true;
		}
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
		$sql = "replace into ". $this->tbl_scene .
								" (".$fields.") values (". $values. ")";
		if ($this->DB->query($sql))
			return true;
		else
			return false;
	}
}
?>
