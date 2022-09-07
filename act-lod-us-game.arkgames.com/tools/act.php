<?php

define('CUR_ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)));
define('BASE_ROOT_PATH', dirname(CUR_ROOT_PATH));

require_once BASE_ROOT_PATH . '/config/config.php'; 
require_once BASE_ROOT_PATH . '/libs/mysql.medoo.php';
require_once BASE_ROOT_PATH . '/functions/Utils.php';

$activation_code_table = str_replace('tbl_', '', CUR_TBL_CODE_LIB);
$activation_code_use_table = str_replace('tbl_', '', CUR_TBL_CODE_USE);

$activation_code_cnt = $medoo_db->count($activation_code_table);
$activation_code_use_cnt = $medoo_db->count($activation_code_use_table);

echo CUR_TBL_CODE_LIB . ' -- ' . $activation_code_cnt . '<br>';
echo CUR_TBL_CODE_USE . ' -- ' . $activation_code_use_cnt . '<br>';