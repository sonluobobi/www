<?php

//api.php
$q = isset($_GET["q"]) ? trim($_GET["q"]) : '';

if (empty($q))
{
	echo '';exit;
}

$opt = isset($_GET['opt']) ? trim($_GET['opt']) : '';
$list = array();

switch ($opt) 
{
	case 'equip':
		$target_file = ACTIVITY_DIR.'/equip.inc';

		if (file_exists($target_file))
		{
			$equip_list = require_once $target_file;
			
			if (!empty($equip_list))
			{
				foreach ($equip_list as $equip)
				{
					if (strpos($equip['id'],$q) !== false || strpos($equip['title'],$q) !== false)
					{
						$list[] = $equip;
					}
				}
			}
		}

		break;
	case 'monster':
		$monster_file = '/data/moyu/www/common/data/monster.php';
		$monster_list = array();

		if (file_exists($monster_file))
		{
			$monster_list = require_once $monster_file;

			if (!empty($monster_list))
			{
				foreach ($monster_list as $k => $monster_detail)
				{
					if (strpos($monster_detail['id'],$q) !== false || strpos($monster_detail['nick'],$q) !== false)
					{
						$monster_detail['title'] = $monster_detail['nick'];
						$list[] = $monster_detail;
					}
				}
			}
		}

		break;
	default:
		break;
}


if (count($list) <= 0)
{
	echo '';exit;
}

foreach ($list as $value) 
{
	echo $value['title'] . ',' . $value['id'] . '|'. $value['id']. "\n";
}

