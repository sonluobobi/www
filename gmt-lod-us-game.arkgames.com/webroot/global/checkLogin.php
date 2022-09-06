<?php 
if (!defined('JD_KUNLUN_COM'))
{
        header('http/1.0 404 not found');
        die();
}
//验证登录接口

$login_path = CURRENT_PATH. '/data/login/';
!is_dir($login_path) && mkdir_recyle($login_path);

$is_login = false;
$retmsg = '';

if (!empty($auth_user))
{
	$login_file = $login_path . 'auth_' . $auth_user . '.php';
	
	//判断是否已经登录
	//if (file_exists($login_file))
	if ($auth_map[$auth_user])
	{
		$is_login = true;
		/*
		$auth_info = array();
		require $login_file;

		if (!empty($auth_info))
		{
			$login_time = !empty($auth_info['t']) ? $auth_info['t'] : 0;
			$login_ip = !empty($auth_info['ip']) ? $auth_info['ip'] : '';
			$auth_sign_check = !empty($auth_info['auth_sign']) ? $auth_info['auth_sign'] : '';

			if ($auth_sign_check == $auth_sign)
			{
				$expire_t = $login_time + $_expire;
				$cur_time = time();
				if($expire_t > $cur_time)
				{
					$is_login = true;
				}
				else
				{
					$retmsg = '['.$auth_user.'] -- 登录帐号已过期，请重登录 -- --[expire_time] => ' . date('Y-m-d H:i:s', $expire_t) . ' -- [cur_date] => ' . date('Y-m-d H:i:s');
				}
			}
			else
			{
				$retmsg = '['.$auth_user.'] -- 密钥验证失败,请重登录 --[last_sign] => ' . $auth_sign_check . ' -- [current_sign] => ' . $auth_sign;
			}


		}
		//*/
	}
	else
	{
		$retmsg = '['.$auth_user.'] -- 帐号不存在--' . $auth_user;
	}
}

//展示登录页面
if (!$is_login)
{
	empty($php_self) && $php_self = 'gmt.php';
	$smarty->assign("php_self", $php_self, true);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('login.tpl');
	exit;
}