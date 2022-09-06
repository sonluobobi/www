<?php
//公用配置文件
date_default_timezone_set('Europe/Moscow');

//产品id
$common_product_id = 4390;

!defined('COMFIG_PRODUCT_ID') && define('COMFIG_PRODUCT_ID', 4390);

!defined('COMFIG_DB_HOST') && define('COMFIG_DB_HOST', '127.0.0.1');
!defined('COMFIG_DB_PORT') && define('COMFIG_DB_PORT', 3306);
!defined('COMFIG_DB_USER') && define('COMFIG_DB_USER', 'root');
!defined('COMFIG_DB_PWD') && define('COMFIG_DB_PWD', '5HdFf3Y7nmGJiFAA');


!defined('COMFIG_DB_NAME_ACT') && define('COMFIG_DB_NAME_ACT', 'backend_activity');
!defined('COMFIG_DB_NAME_GMT') && define('COMFIG_DB_NAME_GMT', 'backend_gmt');
!defined('COMFIG_DB_NAME_STATS') && define('COMFIG_DB_NAME_STATS', 'backend_stats');
!defined('COMFIG_DB_NAME_PKADMIN') && define('COMFIG_DB_NAME_PKADMIN', 'backend_pkadmin');

//后台ip
$common_backend_id = '107.150.117.37';

//公用域名
$common_second_domain = '-sanxiao9-eu.game-ark.com';

//公用大区标识
$common_area_sign = 'eu9';

//语言列表
$lang_map = array(
	'en' => '英文',
	'tw' => '繁体中文',
	'cn' => '简体中文',
	'fr' => '法语',
	'de' => '德语',
	'it' => '意大利语',
	'pt' => '葡萄牙语',
	'es' => '西班牙语',
	'nl' => '荷兰语',
	'pl' => '波兰语',
	'ru' => '俄语',
	'ko' => '韩语',
	'ja' => '日语',
	'tr' => '土耳其语',
	'id' => '印尼语',
	'th' => '泰语',
);
