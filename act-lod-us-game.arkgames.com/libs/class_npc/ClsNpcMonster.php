<?php
/******************************************************************************
Filename              : class.monster.inc.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2008-12-11
Purpose               : 
Description           : 怪物NPC类
Revisions             : $Id: ClsNpcMonster.php,v 1.2 2009/11/05 08:26:27 huayi Exp $

******************************************************************************/

class ClsNpcMonster
{
	var $DB = null; //数据库句柄

	var $tbl_monster = 'tbl_npc_monster '; //怪物表

	//怪物表字段
	var $tbl_monster_fields = array(
					'id', 'monster_sort_id', 'category', 'picture', 'title', 
					'exp_radix', 'hp', 'mp', 'level', 'nation', 'min_character_level', 'action_speed', 
					'attack_outside', 'attack_inside',
					'deffence_outside', 'deffence_inside', 
					'hit', 'dodge', 'critical_hit', 
					'sun_attack', 'cool_attack', 'dark_attack', 'poison_attack',
					'sun_deffence', 'cool_deffence', 'dark_deffence', 'poison_deffence',
					'vertigo_deffence', 'blind_deffence', 'static_deffence',
					'ysy_deffence', 'vapors_deffence', 'slow_deffence',
					'trigger_task_condition_id', 'trigger_task_id', 'skill_ids',
					'attack_odds', 'scene_ids', 'relive_interval', 'plunder_package_ids',
					'created', 'updated');

	/**
	* 构造函数
	* 
	* @param  object $db
	*/
	function ClsNpcMonster($db)
	{
		$this->DB = $db;
	}

	/**
	* 获取怪物总数
	* params : $condition : 查询条件
	*/
	function getMonsterCount($condition = '')
	{
		$sqlForGetMonsterCount = "SELECT COUNT(`id`) AS total " . 
								  " FROM " . $this->tbl_monster . 
								 " WHERE 1=1 " . $condition;

		$db_data = $this->DB->query_first($sqlForGetMonsterCount);

		return $db_data['total'];
	}

	// 获取怪物列表
	function getSimpleNpcList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$order_byStr = $order_by == '' ? '' : " ORDER BY " . $order_by . " DESC ";
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;
		
		$sqlForGetEquipList = "SELECT id, title" . 
							   " FROM " . $this->tbl_monster . 
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
	* 获取怪物列表
	* params : $condition : 查询条件
	*		   $order_by : 显示顺序
	*		   $limit : 显示数量
	*		   $offset : 偏移量
	*/
	function getMonsterList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		global $_CONFIG_GLOBAL_MONSTER, $_CONFIG_GLOBAL_MONSTER_CATEGORY, $_CONFIG_COLOR, $_CONFIG_GLOBAL_NATION;

		$str_fields = $this->formatFields($this->tbl_monster_fields);

		$sqlForGetMonsterList = "SELECT " . $str_fields . 
								 " FROM " . $this->tbl_monster . 
								" WHERE 1=1 " . $condition . 
							 " ORDER BY " . $order_by . " id DESC " . 
								" LIMIT " . $limit . " OFFSET " . $offset;

		$db_data = $this->DB->query($sqlForGetMonsterList);

		$arr_data = array();
		while ($data = $this->DB->fetch_array($db_data))
		{
			$data['sotr_title'] = $_CONFIG_GLOBAL_MONSTER[$data['monster_sort_id']]['title'];
			$data['sotr_title_color'] = $_CONFIG_COLOR[$data['monster_sort_id']];

			$data['category_title'] = $_CONFIG_GLOBAL_MONSTER_CATEGORY[$data['category']]['title'];
			$data['category_title_color'] = $_CONFIG_COLOR[$data['category']];
			if ('2' == $data['category']) //主动怪
				$data['category_title'] .= '<font color="red">[' . $data['attack_odds'] . '%]</font>';

			$data['picture_small_url'] = SERVER_RESOURCE_DOMAIN_PICTURE_MONSTER_SMALL . $data['picture'] . PICTURE_EXT_MONSTER;
			$data['picture_big_url'] = SERVER_RESOURCE_DOMAIN_PICTURE_MONSTER_BIG . $data['picture'] . PICTURE_EXT_MONSTER;

			$data['nation_text_color'] = $_CONFIG_COLOR[$data['nation']];
			$data['nation_text'] = $_CONFIG_GLOBAL_NATION[$data['nation']]['title'];

			$arr_data[] = $data;
		}

		$this->DB->free_result($db_data);

		return $arr_data;
	}

	/**
	* 添加新的怪物
	* params : $arrData
	*/
	function addMonster($arrData)
	{
		$sqlForAddMonster = "INSERT INTO " . $this->tbl_monster . "(" . $arrData['fields'] . ") VALUES(" . $arrData['values'] . ")";

		if ($this->DB->query($sqlForAddMonster))
			return true;
		else
			return false;
	}

	/**
	* 根据ID获取一个怪物信息
	* params : $id : 怪物ID
	*/
	function getMonsterById($id)
	{
		$str_fields = $this->formatFields($this->tbl_monster_fields);

		$sqlForGetMonsterInfo = "SELECT " . $str_fields . 
								 " FROM " . $this->tbl_monster . 
								" WHERE `id` = " . $id . 
								" LIMIT 1";

		$arr_data = $this->DB->query_first($sqlForGetMonsterInfo);

		$arr_data['picture_small_url'] = SERVER_RESOURCE_DOMAIN_PICTURE_MONSTER_SMALL . $arr_data['picture'] . PICTURE_EXT_MONSTER;
		$arr_data['picture_big_url'] = SERVER_RESOURCE_DOMAIN_PICTURE_MONSTER_BIG . $arr_data['picture'] . PICTURE_EXT_MONSTER;

		return $arr_data;
	}

	/**
	* 更新一个怪物
	* params : $id : 要更新的怪物 id号
	*		   $strData : 要更新的字段串
	*/
	function updateMonster($id, $strData)
	{
		$sqlForUpdateMonster = "UPDATE " . $this->tbl_monster . 
								 " SET " . $strData . 
							   " WHERE id = " . $id . 
							   " LIMIT 1";

		if ($this->DB->query($sqlForUpdateMonster))
			return true;
		else
			return false;
	}

	/**
	* 拷贝怪物
	* params : $ids : 根据ID串，拷贝相关数据
	*/
	function copyMonsterByIds($ids)
	{
		$str_fields = "`monster_sort_id`, `category`, `picture`, `title`, 
					`exp_radix`, `hp`, `mp`, `level`, `nation`, `min_character_level`, `action_speed`, 
					`attack_outside`, `attack_inside`,
					`deffence_outside`, `deffence_inside`, 
					`hit`, `dodge`, `critical_hit`, 
					`sun_attack`, `cool_attack`, `dark_attack`, `poison_attack`,
					`sun_deffence`, `cool_deffence`, `dark_deffence`, `poison_deffence`,
					`vertigo_deffence`, `blind_deffence`, `static_deffence`,
					`ysy_deffence`, `vapors_deffence`, `slow_deffence`,
					`trigger_task_condition_id`, `trigger_task_id`, `skill_ids`,
					`attack_odds`, `scene_ids`, `relive_interval`";

		$sqlForCopyMonsterByIds = "INSERT INTO " . $this->tbl_monster . "(" . $str_fields . ") " . 
								  " SELECT " . $str_fields . " FROM " . $this->tbl_monster . " WHERE id IN (0, " . $ids . ")";

		if ($this->DB->query($sqlForCopyMonsterByIds))
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