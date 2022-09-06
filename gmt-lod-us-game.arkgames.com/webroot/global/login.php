<?php 
require 'common.php';
require 'base.php';

$login_path = CURRENT_PATH. '/data/login/';
!is_dir($login_path) && mkdir_recyle($login_path);

$is_login = false;
$retmsg = '';
$php_self = httpGetVal('php_self');
empty($php_self) && $php_self = 'gmt.php';

if (!empty($auth_user) && !empty($do_search) && $do_search == 'do')
{
	$login_file = $login_path . 'auth_' . $auth_user . '.php';

	//登录
	$t = httpGetVal('t');
	$s = httpGetVal('s');

	$login_sign = md5($login_key.$t.$login_key);

	if ($login_sign != $s)
	{
		$retmsg = 'auth check fail';
	}

	if ('' == $retmsg)
	{
		//if ($auth_map[$auth_user] && $auth_map[$auth_user] == md5($auth_pwd))
		if ($auth_map[$auth_user])
		{
			$cur_time = time();
			$auth_sign = md5($login_key.$cur_time.$auth_user);
			$auth_info = array();
			$auth_info['t'] = $cur_time;
			$auth_info['ip'] = $ip;
			$auth_info['auth_user'] = $auth_user;
			$auth_info['auth_sign'] = $auth_sign;
			
			//保存登录文件
			$str_log = "<?php \r\n ";
			$str_log .= '//@' . date('Y-m-d H:i:s') . "\r\n";
			$str_log .= "\r". ' $auth_info = ' . var_export($auth_info,true) . ";\r\n";
			$str_log .= '?>';

			//@file_put_contents($login_file, $str_log);

			do_log($auth_user.'--'.$php_self, 'login', 'login');
			$main_url = 'http://'.WEB_SIGN.$domain.'/global/'.$php_self.'?auth_user='.$auth_user.'&auth_sign='.$auth_sign;
			header("location:$main_url");
			exit;
		}
		else
		{
			$retmsg = 'you are not allowed !!!';
		}
	}
}
else
{
	$retmsg = 'params error';
}

//展示登录页面
$smarty->assign("php_self", $php_self, true);
$smarty->assign("retmsg", $retmsg, true);
$smarty->display('login.tpl');
