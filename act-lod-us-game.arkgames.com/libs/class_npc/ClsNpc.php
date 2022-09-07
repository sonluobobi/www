<?php
/******************************************************************************
Filename              : class.npc.inc.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2008-12-10
Purpose               : 
Description           : NPC类
Revisions             : $Id: ClsNpc.php,v 1.2 2010/10/14 02:59:39 mjl-xx Exp $

******************************************************************************/

class ClsNpc
{
	var $DB = null; //数据库句柄

	var $tbl_npc_sort = 'tbl_npc_sort'; //NPC类型表
	var $tbl_npc = 'tbl_npc'; //NPC表

	//NPC类型表字段
	var $tbl_npc_sort_fields = array('id', 'parent_npc_sort_id', 'title', 'intro', 'created', 'updated');
	//NPC表字段
	var $tbl_npc_fields = array('id', 'npc_sort_id', 'picture', 'shop_id', 'nation', 'min_character_level', 
									'title', 'default_dialog', 'intro', 'task_ids', 'scene_ids', 'skill_ids', 'created', 'updated');

	/**
	* 构造函数
	* 
	* @param  object $db
	*/
	function ClsNpc($db)
	{
		$this->DB = $db;
	}

	/**
	* 获取NPC类型总数
	* params : $condition : 查询条件
	*/
	function getNpcSortCount($condition = '')
	{
		$sqlForGetNpcSortCount = "SELECT COUNT(`id`) AS total " . 
								  " FROM " . $this->tbl_npc_sort . 
								 " WHERE 1=1 " . $condition;

		$db_data = $this->DB->query_first($sqlForGetNpcSortCount);

		return $db_data['total'];
	}

	/**
	* 获取NPC类型列表
	* params : $condition : 查询条件
	*		   $order_by : 显示顺序
	*		   $limit : 显示数量
	*		   $offset : 偏移量
	*/
	function getNpcSortList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$str_fields = $this->formatFields($this->tbl_npc_sort_fields);

		$sqlForGetNpcSortList = "SELECT " . $str_fields . 
								 " FROM " . $this->tbl_npc_sort . 
								" WHERE 1=1 " . $condition . 
							 " ORDER BY " . $order_by . " id DESC " . 
								" LIMIT " . $limit . " OFFSET " . $offset;

		$db_data = $this->DB->query($sqlForGetNpcSortList);

		$arr_data = array();
		while ($data = $this->DB->fetch_array($db_data))
		{
			if ('0' == $data['parent_npc_sort_id'])
			{
				$child_count = $this->getNpcSortCount(' AND `parent_npc_sort_id` = ' . $data['id']);
				$data['child_count'] = $child_count;
			}
			$arr_data[] = $data;
		}

		$this->DB->free_result($db_data);

		return $arr_data;
	}

	/**
	* 获取所有的NPC类型
	* params : npc_sort : NPC类型ID
	*			selected_id : 默认选中的ID
	*/
	function getAllNpcSort($npc_sort_id, $default_sort_id = '')
	{
		$str_fields = $this->formatFields($this->tbl_npc_sort_fields);

		$sqlForGetAllNpcSort = "SELECT " . $str_fields . 
								" FROM " . $this->tbl_npc_sort . 
							   " WHERE `parent_npc_sort_id` = " . $npc_sort_id . 
							" ORDER BY " . $order_by . " id ";

		$db_data = $this->DB->query($sqlForGetAllNpcSort);

		$arr_data = array();
		while ($data = $this->DB->fetch_array($db_data))
		{
			if ($data['id'] == $default_sort_id)
				$data['selected'] = 'selected';
			else
				$data['selected'] = '';

			$arr_data[] = $data;
		}

		$this->DB->free_result($db_data);

		return $arr_data;
	}

	/**
	* 根据ID获取一个NPC类型信息
	* params : $id : NPC类型ID
	*/
	function getNpcSortById($id)
	{
		$str_fields = $this->formatFields($this->tbl_npc_sort_fields);

		$sqlForGetNpcSortInfo = "SELECT " . $str_fields . 
								 " FROM " . $this->tbl_npc_sort . 
								" WHERE `id` = " . $id . 
								" LIMIT 1";

		$arr_data = $this->DB->query_first($sqlForGetNpcSortInfo);

		return $arr_data;
	}

	/**
	* 添加新的NPC类型
	* params : $arrData
	*/
	function addNpcSort($arrData)
	{
		$sqlForAddNpcSort = "INSERT INTO " . $this->tbl_npc_sort . "(" . $arrData['fields'] . ") VALUES(" . $arrData['values'] . ")";

		if ($this->DB->query($sqlForAddNpcSort))
			return true;
		else
			return false;
	}

	/**
	* 更新一个NPC类型
	* params : $id : 要更新的ID
	*		   $strData : 要更新的字段串
	*/
	function updateNpcSort($id, $strData)
	{
		$sqlForUpdateNpcSort = "UPDATE " . $this->tbl_npc_sort . 
								 " SET " . $strData . 
							   " WHERE id = " . $id . 
							   " LIMIT 1";

		if ($this->DB->query($sqlForUpdateNpcSort))
			return true;
		else
			return false;
	}

	/**
	* 获取NPC总数
	* params : $condition : 查询条件
	*/
	function getNpcCount($condition = '')
	{
		$sqlForGetNpcCount = "SELECT COUNT(`id`) AS total " . 
							  " FROM " . $this->tbl_npc . " n " . 
							 " WHERE 1=1 " . $condition;

		$db_data = $this->DB->query_first($sqlForGetNpcCount);

		return $db_data['total'];
	}

	/**
	* 获取NPC列表
	* params : $condition : 查询条件
	*		   $order_by : 显示顺序
	*		   $limit : 显示数量
	*		   $offset : 偏移量
	*/
	function getSimpleNpcList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$order_byStr = $order_by == '' ? '' : " ORDER BY " . $order_by . " DESC ";
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;
		
		$sqlForGetNpcList = "SELECT id, title " . " FROM " . $this->tbl_npc .
		" WHERE id in(200907,110301)  " 
		. $condition . $order_byStr . $limitStr . $offsetStr;
		
		$db_data = $this->DB->query($sqlForGetNpcList);

		$arr_data = array();
		while ($data = $this->DB->fetch_array($db_data))
		{
			$arr_data[] = $data;
		}

		$this->DB->free_result($db_data);

		return $arr_data;
	}
	function getNpcList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		global $_CONFIG_COLOR, $_CONFIG_GLOBAL_NATION;

		$sqlForGetNpcList = "SELECT n.id, " . 
								  " n.npc_sort_id, " . 
								  " n.picture, " . 
								  " n.title, " . 
								  " n.nation, " . 
								  " n.min_character_level, " . 
								  " n.default_dialog, " . 
								  " n.intro, " . 
								  " n.shop_id, " . 
								  " n.skill_ids, " . 
								  " n.task_ids, " . 
								  " n.created, " . 
								  " ns.title AS sort_title " . 
							" FROM " . $this->tbl_npc . " n " . 
					   " LEFT JOIN " . $this->tbl_npc_sort . " ns " . 
							  " ON n.npc_sort_id = ns.id " . 
						   " WHERE 1=1 " . $condition . 
						" ORDER BY " . $order_by . " n.id DESC " . 
						   " LIMIT " . $limit . " OFFSET " . $offset;

		$db_data = $this->DB->query($sqlForGetNpcList);

		$arr_data = array();
		while ($data = $this->DB->fetch_array($db_data))
		{
			$data['sotr_title_color'] = $_CONFIG_COLOR[$data['npc_sort_id']];
			$data['picture_small_url'] = SERVER_RESOURCE_DOMAIN_PICTURE_NPC_SMALL . $data['picture'] . PICTURE_EXT_NPC;
			$data['picture_big_url'] = SERVER_RESOURCE_DOMAIN_PICTURE_NPC_BIG . $data['picture'] . PICTURE_EXT_NPC;
			if ('' == $data['shop_id']) $data['shop_id'] = '暂无';
			if ('' == $data['skill_ids']) $data['skill_ids'] = '暂无';
			$data['nation_text_color'] = $_CONFIG_COLOR[$data['nation']];
			$data['nation_text'] = $_CONFIG_GLOBAL_NATION[$data['nation']]['title'];
			$arr_data[] = $data;
		}

		$this->DB->free_result($db_data);

		return $arr_data;
	}

	/**
	* 添加新的NPC
	* params : $arrData
	*/
	function addNpc($arrData)
	{
		$sqlForAddNpc = "INSERT INTO " . $this->tbl_npc . "(" . $arrData['fields'] . ") VALUES(" . $arrData['values'] . ")";

		if ($this->DB->query($sqlForAddNpc))
			return true;
		else
			return false;
	}

	/**
	* 根据ID获取一个NPC信息
	* params : $id : NPCID
	*/
	function getNpcById($id)
	{
		$str_fields = $this->formatFields($this->tbl_npc_fields);

		$sqlForGetNpcInfo = "SELECT " . $str_fields . 
							 " FROM " . $this->tbl_npc . 
							" WHERE `id` = " . $id . 
							" LIMIT 1";

		$arr_data = $this->DB->query_first($sqlForGetNpcInfo);

		$arr_data['picture_small_url'] = SERVER_RESOURCE_DOMAIN_PICTURE_NPC_SMALL . $arr_data['picture'] . PICTURE_EXT_NPC;
		$arr_data['picture_big_url'] = SERVER_RESOURCE_DOMAIN_PICTURE_NPC_BIG . $arr_data['picture'] . PICTURE_EXT_NPC;

		if ('15' == $arr_data['npc_sort_id'])
			$arr_data['scene_ids_disable'] = '';
		else
			$arr_data['scene_ids_disable'] = 'disabled';

		return $arr_data;
	}

	/**
	* 更新一个NPC
	* params : $id : 要更新的npc id号
	*		   $strData : 要更新的字段串
	*/
	function updateNpc($id, $strData)
	{
		$sqlForUpdateNpc = "UPDATE " . $this->tbl_npc . 
							 " SET " . $strData . 
						   " WHERE id = " . $id . 
						   " LIMIT 1";

		if ($this->DB->query($sqlForUpdateNpc))
			return true;
		else
			return false;
	}

	/**
	* 拷贝NPC
	* params : $ids : 根据ID串，拷贝相关数据
	*/
	function copyNpcByIds($ids)
	{
		$str_fields = "`npc_sort_id`, `picture`, `shop_id`, `nation`, `min_character_level`, `title`, `default_dialog`, `intro`, `task_ids`, `scene_ids`, `skill_ids`";

		$sqlForCopyNpcByIds = "INSERT INTO " . $this->tbl_npc . "(" . $str_fields . ") " . 
								  " SELECT " . $str_fields . " FROM " . $this->tbl_npc . " WHERE id IN (0, " . $ids . ")";

		if ($this->DB->query($sqlForCopyNpcByIds))
			return true;
		else
			return false;
	}

	/**
	 * 格式化字段
	 * 
	 * @access private
	 * @param  array
	 * @return string
	 * //$str_fields = $this->formatFields($this->tbl_chatroom_base_fields);
	 */
	private function formatFields($arr_fileds)
	{
		foreach ($arr_fileds AS $field)
		{
			$str_fields .= '`' . $field . '`,';
		}
		//去掉最后的逗号
		$str_fields = substr($str_fields, 0, -1);
		
		return $str_fields;
	}
}
?>
