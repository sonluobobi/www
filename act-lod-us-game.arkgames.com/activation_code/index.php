<?php
/**
 * 激活码处理入口
 * @author fuqian.liao
 */ 
require_once '../config/config.php'; 
require_once '../functions/Utils.php';
require_once '../config/server.inc.php';
require_once 'ActivationCodeService.php'; 

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

//错误码定义, 同步游戏文件 errorCodes.lua 中 errorCodes.ACTIVATION_CODE_CENTER_BEGIN = 5101
define('ACTIVATION_CODE_SERVER_ERROR', 3151);  //服务器异常
define('ACTIVATION_CODE_PARAM_ERROR', 3152); //传递参数有误
define('ACTIVATION_CODE_UNKNOW_HANDLE', 3153); //未知操作类型
define('ACTIVATION_CODE_UNKNOW_BATCH', 3154); //激活码批次不存在
define('ACTIVATION_CODE_UNKNOW_CODE', 3155); //激活码不存在
define('ACTIVATION_CODE_NOT_INTIME', 3156); //该激活码还未到使用有效期
define('ACTIVATION_CODE_IS_OUTDATE', 3157); //该激活码已过使用期
define('ACTIVATION_CODE_LEVEL_MORE', 3158); //您的等级太高，不能使用该激活码
define('ACTIVATION_CODE_LEVEL_LESS', 3159); //您的等级太低，不能使用该激活码
define('ACTIVATION_CODE_USED_FAIL', 3160); //激活码使用失败
define('ACTIVATION_CODE_USED_SUCC', 3161); //激活码使用成功
define('ACTIVATION_CODE_SYS_WEIHU', 3162); //激活码系统维护中
define('ACTIVATION_CODE_USED_OTHER', 3163);  //该激活码已被使用
define('ACTIVATION_CODE_USED_SELF', 3164);  //该激活码你已使用
define('ACTIVATION_CODE_USED_SAME_BATCH', 3165);  //你已经使用了同批次激活码1个，不能使用该激活码
define('ACTIVATION_CODE_USED_ERROR_AREA', 3166);  //你所在大区不能使用该激活码

try {
	
	//file_put_contents("/tmp/moyu_code_interface.log", var_export($_GET,true),FILE_APPEND);
	
	$allow_act_config = array(
			'ActivationCodeService.validActivationCode',
			'ActivationCodeService.rollback',
			);
	$key = "22xafjlajjlj^&*^*%*%1";
	
	//参数 act=ActivationCodeService.validActivationCode&cid=xx&activation_code=xx&pid=xx&area_id=xx&callback_data=xx&token=xx
	//返回结果 cid=xx&activation_code=xx&pid=xx&area_id=xx&callback_data=xx&token=xx&ret_code=xx
		
	//参数字符转义
	Utils::args_addslashes();
	
	/*$act = $_GET['act'];
	
	if ($act == 'ActivationCodes.validActivationCode') {
		$act = 'ActivationCodeService.validActivationCode';
	}*/

	$act = 'ActivationCodeService.validActivationCode'; 
	
	$cid = $_GET['cid'];
	$activation_code = $_GET['activation_code'];
	$pid= $_GET['pid'];
	$area_id = $_GET['server_id'];
	//$callback_data= $_GET['callback_data'];
	//$token = $_GET['token'];
	
	$result = array();
	/*$result['cid'] = $cid;
	$result['pid'] = $pid;
	$result['area_id'] = $area_id;
	$result['activation_code'] = $activation_code;
	$result['callback_data'] = $callback_data;*/
	$result['ret_msg'] = 'false';
	//$result['token'] = $token;
	$result['ret_code'] = ACTIVATION_CODE_SERVER_ERROR;

	//激活系统维护
	//throw new Exception('',ACTIVATION_CODE_SYS_WEIHU);
	
	//$md5_token = md5($key.'_'.$pid.'_'.$cid.'_'.$activation_code.'_'.$area_id);
	
	//处理激活码注入问题
	if(preg_match('/[^0-9a-zA-Z]/', $activation_code))
	{
		throw new Exception('',ACTIVATION_CODE_PARAM_ERROR);
	}
			
	/*if ($token != $md5_token)
	{
		throw new Exception('', ACTIVATION_CODE_PARAM_ERROR);
	}*/
	
	/*if (!in_array($act,$allow_act_config))
	{
		throw new Exception('',ACTIVATION_CODE_PARAM_ERROR);
	}*/
	
	if (!Utils::str_is_int($cid) || !Utils::str_is_int($pid)
			|| empty($area_id) ||   empty($activation_code))
	{
		throw new Exception('',ACTIVATION_CODE_PARAM_ERROR);
	}
	
	if (is_integer(strpos($act,'ActivationCodeService')))
	{
		$arr_act = explode('.', $act);
		if (is_array($arr_act) && count($arr_act) == 2)
		{
			$action = $arr_act[1];
			$activationCodeService = new ActivationCodeService();
			$act_ret = $activationCodeService->$action();
			
			if ($act_ret['flag'] == true)
			{
				$result['reward'] = $act_ret['reward'];
				$result['ret_msg'] = 'success';
				$result['ret_code'] = ACTIVATION_CODE_USED_SUCC; //操作成功
			}
		}
		else
		{
			throw new Exception('', ACTIVATION_CODE_UNKNOW_HANDLE);
		}
	}
	else 
	{
		throw new Exception('', ACTIVATION_CODE_UNKNOW_HANDLE);
	}
	
}catch (Exception $e) {
	
	if ($e->getCode() > 0) {
		$result['ret_code'] = $e->getCode();
	}else {
		$result['ret_code'] = ACTIVATION_CODE_USED_SUCC;
	}
}

echo json_encode($result);

$stats_log_file = '/tmp/activation_code.log';
$time_end = microtime_float();
$time_diff = $time_end - $time_start;



$stats_log_str = ' - begin - ['.date('Y-m-d H:i:s') . '] - end - ['.date('Y-m-d H:i:s') . '] - use - ' . $time_diff . " seconds -".json_encode($_GET)."- result = ".var_export($result,true)."\r\n\r\n";

@file_put_contents($stats_log_file, $stats_log_str, FILE_APPEND);

?>
