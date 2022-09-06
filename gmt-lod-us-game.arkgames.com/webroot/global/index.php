<?php
	require 'common.php';

	$smarty->assign("name", "数据统计", true);
	$smarty->assign("platform_map", array_values($platform_map));
	$smarty->display('index.tpl');
?>
