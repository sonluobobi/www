<?php
/**
 * 道具接口
 * 
 * @author Andy Cai(huayi.cai@kunlun-inc.com)
 * @since 2009-10-29
 * @filesource equip_api.php
 * @version $Id: equip_api.php,v 1.5 2009/11/13 07:30:11 huayi Exp $
 *
 */

require('common.php');
require_once('mysql.config.inc.php');
$target_file = ACTIVITY_DIR.'/equip.inc';


$q = trim($_GET["q"]);
if (!$q) return;
$opt = trim($_GET['opt']);

switch ($opt) 
{
	case 'equip':
		$equip_list = require_once $target_file;
		
		if ($equip_list)
		{
			foreach ($equip_list as $equip)
			{
				if (strpos($equip['id'],$q) !== false || strpos($equip['title'],$q) !== false)
				{
					$list[] = $equip;
				}
			}
		}
		break;
	case 'npcMonster':      // 怪物 NPC
		require_once('class_npc/ClsNpcMonster.php');
		$npcMonsterObj = new ClsNpcMonster($DB);
		$condition = " AND (`title` LIKE '" . $q . "%' OR `id` LIKE '". $q ."%')";
		
		$list = $npcMonsterObj->getSimpleNpcList($condition, '', 500);
		break;
	case 'scene':
		require_once('class_scene/ClsScene.php');
		$sceneObj = new ClsScene($DB);
		$condition = " AND (scene.title LIKE '" . $q . "%' OR scene.id LIKE '". $q ."%')";
		
//		$list = $sceneObj->getSimpleSceneList($condition, '', 500);
		$list = $sceneObj->getSceneListByNation($condition, 500);
		break;
	case 'scene_group':
		require_once('class_scene_grp/ClsSceneGrp.php');
		$sceneGrpObj = new ClsSceneGrp($DB);
		$condition = "AND (nation_id =1 OR nation_id = 0) AND (`title` LIKE '" . $q . "%' OR `id` LIKE '". $q ."%')";
		
		$list = $sceneGrpObj->getSimpleSceneGrpList($condition, '', 500);
		break;
	default:
		break;
}

if (count($list) <= 0) return;

if ($opt == 'scene') {
	foreach ($list as $value) {
		echo $value['gtitle'] . '-' . $value['title'] . ',' . $value['id'] . '|'. $value['id']. "\n";
	}
} else {
	foreach ($list as $value) {
		echo $value['title'] . ',' . $value['id'] . '|'. $value['id']. "\n";
	}
}