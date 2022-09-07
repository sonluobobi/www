<?php

$g_actcode_use_tbl_conf = array(
	50 => 1,
	176 => 2,
	178 => 3,
	180 => 4,
	181 => 5,
	211 => 6,
	210 => 6,
	220 => 6,
	209 => 7,
	47 => 7,
	57 => 7,
	216 => 8,
	215 => 8,
	214 => 8,
	213 => 8,
	212 => 9,
	140 => 9,
	141 => 9,
	133 => 9,
	168 => 9,
	
);

//激活码库表特殊配置
$g_code_lib_tbl_conf = array(
		'tbl_activation_code' => array(176,177,178,179,180,181,217,218,219,220),
		);

function getActcodeTblNameByBatchId($batch_id)
{
	global $g_actcode_use_tbl_conf;
	$tbl_idx = $g_actcode_use_tbl_conf[$batch_id];
	if (!$tbl_idx)
		return 'tbl_activation_code_use';
	else
		return 'tbl_activation_code_use_' . $tbl_idx;
}
?>
