<?php
/* $Id: ClsEquip.php,v 1.2 2009/11/05 07:04:57 huayi Exp $ */
/******************************************************************************
Filename              : class.equip.inc.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2008-12-15
Purpose               : 
Description           : 道具类
Revisions             :

******************************************************************************/

class ClsEquip
{
	var $DB = null; //数据库句柄

	var $tbl_equip_sort = 'tbl_equip_sort'; //道具类型表
	var $tbl_equip = 'tbl_equip'; //道具表

	//道具类型表字段
	var $tbl_equip_sort_fields = array('id', 'parent_equip_sort_id', 'title', 'intro', 'created', 'updated');
	//道具表字段
	var $tbl_equip_fields = array('id', 'equip_sort_id', 'child_equip_sort_id', 'picture', 'title', 'stack_num', 'is_charge', 'world_shop_id', 'useful_day',
									'buy_price', 'buy_gold_price', 'sale_price', 'nation_ids', 'faction_ids', 'character_level', 'reputation',
									'quality', 'star', 'hold', 'niko', 'valuable',
									'is_embed', 'is_drop', 'is_exchange', 'is_bind', 'is_auction', 'is_upgrade_star', 'is_death_protect', 
									'attack_outside', 'extra_attack_outside', 'extra_attack_outside_percent', 
									'attack_inside', 'extra_attack_inside', 'extra_attack_inside_percent', 
									'deffence_outside', 'extra_deffence_outside', 'extra_deffence_outside_percent',
									'deffence_inside', 'extra_deffence_inside', 'extra_deffence_inside_percent',
									'hit','dodge','critical_hit',
									'hp', 'hp_percent', 'mp', 'mp_percent', 
									'sun_attack', 'cool_attack', 'dark_attack', 'poison_attack',
									'sun_deffence', 'cool_deffence', 'dark_deffence', 'poison_deffence',
									'power', 'ttk', 'wakan', 'firm', 'nicety', 'fct', 
									'vertigo_attack_odds', 'blind_attack_odds', 'static_attack_odds', 'ysy_attack_odds', 'vapors_attack_odds', 'slow_attack_odds', 
									'vertigo_deffence', 'blind_deffence', 'static_deffence', 'ysy_deffence', 'vapors_deffence', 'slow_deffence',
									'action_speed', 'drop_odds', 
									'spy_hp', 'spy_hp_percent', 'spy_mp', 'spy_mp_percent', 'spy_energy', 'spy_energy_percent', 'spy_buffer_id', 
									'red_hp', 'red_character_hp_percent', 'red_cool_time', 'blue_mp', 'blue_character_mp_percent', 'blue_cool_time', 
									'jewel_level', 'jewel_equip_level',
									'book_target_equip_id', 'book_compose_cost', 'book_compose_by',
									'intro', 
									'created', 'updated');

	/**
	* 构造函数
	* 
	* @param  object $db
	*/
	function ClsEquip($db)
	{
		$this->DB = $db;
	}
	
	// 获取道具列表
	function getSimpleEquipList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$limitStr = $limit == '' ? '' : " LIMIT " . $limit;
		$order_byStr = $order_by == '' ? '' : " ORDER BY " . $order_by . " DESC ";
		$offsetStr = $offset == '' ? '' : " OFFSET " . $offset;
		
		$sqlForGetEquipList = "SELECT id, title" . 
							   " FROM " . $this->tbl_equip . 
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
	* 获取道具类型总数
	* params : $condition : 查询条件
	*/
	function getEquipSortCount($condition = '')
	{
		$sqlForGetEquipSortCount = "SELECT COUNT(`id`) AS total " . 
								  " FROM " . $this->tbl_equip_sort . 
								 " WHERE 1=1 " . $condition;

		$db_data = $this->DB->query_first($sqlForGetEquipSortCount);

		return $db_data['total'];
	}

	/**
	* 获取道具类型列表
	* params : $condition : 查询条件
	*		   $order_by : 显示顺序
	*		   $limit : 显示数量
	*		   $offset : 偏移量
	*/
	function getEquipSortList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		$str_fields = $this->formatFields($this->tbl_equip_sort_fields);

		$sqlForGetEquipSortList = "SELECT " . $str_fields . 
								   " FROM " . $this->tbl_equip_sort . 
								  " WHERE 1=1 " . $condition . 
							   " ORDER BY " . $order_by . " id DESC " . 
								  " LIMIT " . $limit . " OFFSET " . $offset;

		$db_data = $this->DB->query($sqlForGetEquipSortList);

		$arr_data = array();
		while ($data = $this->DB->fetch_array($db_data))
		{
			if ('0' == $data['parent_equip_sort_id'])
			{
				$child_count = $this->getEquipSortCount(' AND `parent_equip_sort_id` = ' . $data['id']);
				$data['child_count'] = $child_count;
			}
			$arr_data[] = $data;
		}

		$this->DB->free_result($db_data);

		return $arr_data;
	}

	/**
	* 获取所有的道具类型
	* params : equip_sort : 道具类型ID
	*		   selected_id : 默认选中的ID
	*/
	function getAllEquipSort($equip_sort_id, $default_sort_id = '')
	{
		$str_fields = $this->formatFields($this->tbl_equip_sort_fields);

		$sqlForGetAllEquipSort = "SELECT " . $str_fields . 
								  " FROM " . $this->tbl_equip_sort . 
								 " WHERE `parent_equip_sort_id` = " . $equip_sort_id . 
							  " ORDER BY " . $order_by . " id ";

		$db_data = $this->DB->query($sqlForGetAllEquipSort);

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
	* 根据ID获取一个道具类型信息
	* params : $id : 道具类型ID
	*/
	function getEquipSortById($id)
	{
		$str_fields = $this->formatFields($this->tbl_equip_sort_fields);

		$sqlForGetEquipSortInfo = "SELECT " . $str_fields . 
								   " FROM " . $this->tbl_equip_sort . 
								  " WHERE `id` = " . $id . 
								  " LIMIT 1";

		$arr_data = $this->DB->query_first($sqlForGetEquipSortInfo);

		return $arr_data;
	}

	/**
	* 添加新的道具类型
	* params : $arrData
	*/
	function addEquipSort($arrData)
	{
		$sqlForAddEquipSort = "INSERT INTO " . $this->tbl_equip_sort . "(" . $arrData['fields'] . ") VALUES(" . $arrData['values'] . ")";

		if ($this->DB->query($sqlForAddEquipSort))
			return true;
		else
			return false;
	}

	/**
	* 更新一个道具类型
	* params : $id : 要更新的ID
	*		   $strData : 要更新的字段串
	*/
	function updateEquipSort($id, $strData)
	{
		$sqlForUpdateEquipSort = "UPDATE " . $this->tbl_equip_sort . 
								 " SET " . $strData . 
							   " WHERE id = " . $id . 
							   " LIMIT 1";

		if ($this->DB->query($sqlForUpdateEquipSort))
			return true;
		else
			return false;
	}

	/**
	* 添加新的道具
	* params : $arrData
	*/
	function addEquip($arrData)
	{
		$sqlForAddEquip = "INSERT INTO " . $this->tbl_equip . "(" . $arrData['fields'] . ") VALUES(" . $arrData['values'] . ")";

		if ($this->DB->query($sqlForAddEquip))
			return true;
		else
			return false;
	}

	/**
	* 更新道具
	* params : $id : 要更新的ID
	*		   $strData : 要更新的字段串
	*/
	function updateEquip($id, $strData)
	{
		$sqlForUpdateEquip = "UPDATE " . $this->tbl_equip . 
						 	   " SET " . $strData . 
							 " WHERE id = " . $id . 
							 " LIMIT 1";

		if ($this->DB->query($sqlForUpdateEquip))
			return true;
		else
			return false;
	}

	/**
	* 获取道具总数
	* params : $condition : 查询条件
	*/
	function getEquipCount($condition = '')
	{
		$sqlForGetEquipCount = "SELECT COUNT(`id`) AS total " . 
								" FROM " . $this->tbl_equip . " e " . 
							   " WHERE 1=1 " . $condition;

		$db_data = $this->DB->query_first($sqlForGetEquipCount);

		return $db_data['total'];
	}

	/**
	* 获取道具列表
	* params : $condition : 查询条件
	*		   $order_by : 显示顺序
	*		   $limit : 显示数量
	*		   $offset : 偏移量
	*/
	function getEquipList($condition = '', $order_by = '', $limit = '', $offset = '')
	{
		global $_CONFIG_GLOBAL_NATION_FOR_CHECKBOX, $_CONFIG_GLOBAL_FACTION_FOR_CHECKBOX;

		$sqlForGetEquipList = "SELECT e.id, e.equip_sort_id, e.picture, " . 
									" e.title, e.stack_num, e.is_charge, e.world_shop_id, e.buy_gold_price, " . 
									" e.nation_ids, e.faction_ids, e.character_level, " . 
									" e.reputation, e.quality, e.star, e.hold, " . 
									" e.spy_buffer_id, " . 
									" e.red_hp, e.red_character_hp_percent, e.red_cool_time, " . 
									" e.blue_mp, e.blue_character_mp_percent, e.blue_cool_time, " . 
									" e.jewel_level, e.jewel_equip_level, " . 
									" e.book_target_equip_id, e.book_compose_by, e.book_compose_cost, " . 
									" e.intro, " . 
									" es.title AS equip_sort_text " .
							   " FROM " . $this->tbl_equip . " e " . 
						  " LEFT JOIN " . $this->tbl_equip_sort . " es " . 
								 " ON e.equip_sort_id = es.id " . 
							  " WHERE 1=1 " . $condition . 
						   " ORDER BY " . $order_by . " e.id DESC " . 
							  " LIMIT " . $limit . " OFFSET " . $offset;

		$db_data = $this->DB->query($sqlForGetEquipList);

		$arr_data = array();
		while ($data = $this->DB->fetch_array($db_data))
		{
			//图片
			$data['picture_small_url'] = SERVER_RESOURCE_DOMAIN_PICTURE_EQUIP_SMALL . $data['picture'] . PICTURE_EXT_EQUIP;
			$data['picture_big_url'] = SERVER_RESOURCE_DOMAIN_PICTURE_EQUIP_BIG . $data['picture'] . PICTURE_EXT_EQUIP;

			//国家
			$arr_nation_id = explode(',', $data['nation_ids']);
			$nation_text = '';
			if (is_array($arr_nation_id))
			{
				foreach ($arr_nation_id AS $nation_id)
				{
					$nation_id = trim($nation_id);
					if ('' != $nation_id)
						$nation_text .= ',' . $_CONFIG_GLOBAL_NATION_FOR_CHECKBOX[$nation_id]['title'];
				}
			}

			if ('' != $nation_text)
				$nation_text = substr($nation_text, 1);
			$data['nation_text'] = $nation_text;

			//门派
			$arr_faction_id = explode(',', $data['faction_ids']);
			$faction_text = '';
			if (is_array($arr_faction_id))
			{
				foreach ($arr_faction_id AS $faction_id)
				{
					$faction_id = trim($faction_id);
					if ('' != $faction_id)
						$faction_text .= ',' . $_CONFIG_GLOBAL_FACTION_FOR_CHECKBOX[$faction_id]['title'];
				}
			}

			if ('' != $faction_text)
				$faction_text = substr($faction_text, 1);
			$data['faction_text'] = $faction_text;

			//大红
			if ('0' != $data['red_hp'])
			{
				$data['store_total'] = $data['red_hp'];
				$data['character_percent'] = $data['red_character_hp_percent'];
				$data['cool_time'] = $data['red_cool_time'];
			}

			//大蓝
			if ('0' != $data['blue_mp'])
			{
				$data['store_total'] = $data['blue_mp'];
				$data['character_percent'] = $data['blue_character_mp_percent'];
				$data['cool_time'] = $data['blue_cool_time'];
			}

			//合成书
			if ('' != $data['book_compose_by'])
			{
				$data['book_compose_by_text'] = '';

				$arr_tmp = explode(',', $data['book_compose_by']);
				foreach ($arr_tmp AS $value)
				{
					$arr_tmp2 = explode('_', $value);
					$now_equip_id  = $arr_tmp2[0];
					$now_equip_num = $arr_tmp2[1];

					$data['book_compose_by_text'] .= '&nbsp;材料ID：' . $now_equip_id . '，需要数量：' . $now_equip_num . '<br>';
				}
			}

			$arr_data[] = $data;
		}

		$this->DB->free_result($db_data);

		return $arr_data;
	}

	/**
	* 根据ID获取一个道具信息
	* params : $id : 道具ID
	*/
	function getEquipById($id)
	{
		global $_CONFIG_GLOBAL_NATION_FOR_CHECKBOX, $_CONFIG_GLOBAL_FACTION_FOR_CHECKBOX;

		$str_fields = $this->formatFields($this->tbl_equip_fields);

		$sqlForGetEquipInfo = "SELECT " . $str_fields . 
							   " FROM " . $this->tbl_equip . 
							  " WHERE `id` = " . $id . 
							  " LIMIT 1";

		$arr_data = $this->DB->query_first($sqlForGetEquipInfo);

		//道具类型
		$equip_sort_id = $arr_data['equip_sort_id'];
		$arr_equip_sort = $this->getEquipSortById($equip_sort_id);
		$arr_data['equip_sort_text'] = $arr_equip_sort['title'];

		//国家
		$arr_nation_id = explode(',', $arr_data['nation_ids']);
		$nation_text = '';
		if (is_array($arr_nation_id))
		{
			foreach ($arr_nation_id AS $nation_id)
			{
				$nation_id = trim($nation_id);
				if ('' != $nation_id)
					$nation_text .= ',' . $_CONFIG_GLOBAL_NATION_FOR_CHECKBOX[$nation_id]['title'];
			}
		}

		if ('' != $nation_text)
			$nation_text = substr($nation_text, 1);
		$arr_data['nation_text'] = $nation_text;

		//门派
		$arr_faction_id = explode(',', $arr_data['faction_ids']);
		$faction_text = '';
		if (is_array($arr_faction_id))
		{
			foreach ($arr_faction_id AS $faction_id)
			{
				$faction_id = trim($faction_id);
				if ('' != $faction_id)
					$faction_text .= ',' . $_CONFIG_GLOBAL_FACTION_FOR_CHECKBOX[$faction_id]['title'];
			}
		}

		if ('' != $faction_text)
			$faction_text = substr($faction_text, 1);
		$arr_data['faction_text'] = $faction_text;

		//是否镶嵌
		if ('1' == $arr_data['is_embed'])
			$arr_data['is_embed_text'] = '是';
		else
			$arr_data['is_embed_text'] = '否';

		//是否交易
		if ('1' == $arr_data['is_exchange'])
			$arr_data['is_exchange_text'] = '是';
		else
			$arr_data['is_exchange_text'] = '否';

		//装备绑定
		if ('1' == $arr_data['is_bind'])
			$arr_data['is_bind_text'] = '是';
		else
			$arr_data['is_bind_text'] = '否';

		//可否拍卖
		if ('1' == $arr_data['is_auction'])
			$arr_data['is_auction_text'] = '是';
		else
			$arr_data['is_auction_text'] = '否';

		//是否销毁
		if ('1' == $arr_data['is_drop'])
			$arr_data['is_drop_text'] = '是';
		else
			$arr_data['is_drop_text'] = '否';

		//可否升星
		if ('1' == $arr_data['is_upgrade_star'])
			$arr_data['is_upgrade_star_text'] = '是';
		else
			$arr_data['is_upgrade_star_text'] = '否';

		//死亡保护
		if ('1' == $arr_data['is_death_protect'])
			$arr_data['is_death_protect_text'] = '是';
		else
			$arr_data['is_death_protect_text'] = '否';

		//是否付费
		if ('1' == $arr_data['is_charge'])
			$arr_data['is_charge_text'] = '是';
		else
			$arr_data['is_charge_text'] = '否';

		//合成书
		if ('' != $arr_data['book_compose_by'])
		{
			$no = 1;
			$arr_tmp = explode(',', $arr_data['book_compose_by']);
			foreach ($arr_tmp AS $value)
			{
				$arr_tmp2 = explode('_', $value);
				$now_equip_id  = $arr_tmp2[0];
				$now_equip_num = $arr_tmp2[1];

				$arr_data['equips_' . $no] = $now_equip_id;
				$arr_data['equips_num_' . $no] = $now_equip_num;

				$no++;
			}
		}

		return $arr_data;
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