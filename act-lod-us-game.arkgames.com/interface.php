<?php

/**
 * 游戏接口类
 * 参数 c class 标识 默认 Default
 * 参数 a class 方法 默认 DefaultAction
 */
ini_set('display_errors', 'Off');
error_reporting(E_ALL);
set_time_limit(0);

try {
	define('KUNLUN_COM', true);
	define('JD_KUNLUN_COM', true);
	define('ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)));

	require ROOT_PATH . '/config/config.php';
	require ROOT_PATH . '/config/static_config.php';
	require ROOT_PATH . '/libs/func.php';
	require ROOT_PATH . '/class/Base.php';

	$path_data = ROOT_PATH . '/data/';
	!is_dir($path_data) && mkdir_recyle($path_data);

	$path_logs = ROOT_PATH . '/logs/';
	!is_dir($path_logs) && mkdir_recyle($path_logs);

	define('PATH_DATA', $path_data);
	define('PATH_LOGS', $path_logs);

	//操作类型
	$_service = isset($_GET['c']) ? ucfirst(httpGetVal('c')) : "Default";
	$_do = isset($_GET['a']) ? ucfirst(httpGetVal('a')) : "DefaultAction";
	$check_ip_flag = true;

	//命令行形式
	if (!empty($_SERVER['argv']) && !empty($_SERVER['argv'][1]))
	{
		$_service = ucfirst(trim($_SERVER['argv'][1]));
		!empty($_SERVER['argv'][2]) && $_do = ucfirst(trim($_SERVER['argv'][2]));

		$check_ip_flag = false;
	}

	if ($check_ip_flag)
	{
		//ip 验证
		$client_ip = $_SERVER['REMOTE_ADDR'];

		//参数密钥验证
		$params_t = httpGetVal('t');
		$params_s = httpGetVal('s');
		$check_s = md5(INTERFACE_TOKEN.$params_t.INTERFACE_TOKEN);

		if ($check_s != $params_s)
		{
			throw new Exception('token check fail');
		}
	}

	if (empty($_service))
	{
		throw new Exception('params error -- service');
	}

	if (empty($_do))
	{
		throw new Exception('params error -- do');
	}

	$class_name = $_service . 'Service';
	$class_file = ROOT_PATH . '/class/'.$class_name.'.php';

	if (!file_exists($class_file))
	{
		throw new Exception('class file is not exists -- ' . $class_file);
	}

	require $class_file;

	$ctrl = new $class_name();
		
	if (!method_exists($ctrl, $_do))
	{
		throw new Exception('action is not exists -- ' . $_do);
	}
	
	$ctrl->$_do();

}catch (Exception $e) {
	$err_msg = $e->getMessage();
	do_log($err_msg, 'interface' , 'interface');
	show_error(505, $err_msg);
}