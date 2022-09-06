<?php
define('JD_KUNLUN_COM', true);
define('CURRENT_PATH', str_replace('\\', '/', dirname(__FILE__)));
define('ROOT_PATH', dirname(dirname(CURRENT_PATH)));
define('WEB_SIGN', 'gmt');
define('TOKENKEY', 'r1mJoMyquiyspM_BJ4BPs0');
define('INTERFACE_TOKEN', 's#2E1!m3Y');
define('SERVER_FOR_BACKEND', '/for_backend/index.php');
define('PL_FOR_SERVER', '/for_server/index.php');

$common_config_file = '/data/sanxiao/www/common/config.php';

if (!file_exists($common_config_file))
{
	echo "common config file is not exists !!!";exit;
}

require $common_config_file;

require CURRENT_PATH . '/configs/config.php';
require CURRENT_PATH . '/configs/account.php';
require CURRENT_PATH . '/libs/func.php';
require CURRENT_PATH . '/smarty/Smarty.class.php';

$smarty = new Smarty;

//$smarty->force_compile = true;
//$smarty->debugging = true;
//$smarty->caching = true;
//$smarty->cache_lifetime = 120;

$smarty->assign("web_sign", WEB_SIGN, true);
$smarty->assign("title", "魔域2项目之", true);

$auth_user = httpGetVal('auth_user');
$auth_pwd = httpGetVal('auth_pwd');
$auth_sign = httpGetVal('auth_sign');
$smarty->assign("auth_sign", $auth_sign, true);
$smarty->assign("auth_user", $auth_user, true);

$cur_time = time();
$sign = md5($login_key.$cur_time.$login_key);
$smarty->assign("s", $sign, true);
$smarty->assign("t", $cur_time, true);

$ip = $_SERVER["REMOTE_ADDR"];
$pageid = httpGetVal('pageid');
$per_page_num = 50;
$pageNums = $total = 0;
