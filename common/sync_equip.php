<?php
//同步游戏服道具列表
// php sync_equip.php do 
// 可指定同步游戏服,域名标识,默认 s1， 如 php sync_equip.php do s0
set_time_limit(0);
define('CUR_ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)));
//与游戏服交互token
define('GLOBAL_TOKEN', 's#2E1!m3Y');
$base_folder = 'sync_equip';

if (empty($_SERVER['argv']) || $_SERVER['argv'][1] != 'do')
{
	die('you are not allowed');
}

$path_www = dirname(CUR_ROOT_PATH);
$common_config_file =  CUR_ROOT_PATH. '/config.php';

if (!file_exists($common_config_file))
{
	echo "common config file is not exists !!!";exit;
}

require_once $common_config_file;

//默认加载游戏服
$platform_default_server = array(
	'zh' => 's1', //国内android
	'ios' => 's2', //国内ios
	'yyb' => 's1', //国内应用宝
	'quickios' => 's802', //quickios
	'sgp' => 's0', //新加坡,东南亚
	'en' => 's1', //美国,北美
	'eu' => 's1', //欧洲
	'tw' => 's801', //繁体台湾
	'na' => 's0', //新版北美
	'br' => 's1', //巴西,南美
	'kr' => 's1', //韩国
	'ru' => 's1', //俄罗斯
	'th' => 's801',//泰国越南
);

$sx = 's1';

if (!empty($argv[2]))
{
	$sx = trim($argv[2]);
}	
elseif ($platform_default_server[$common_area_sign])
{
	$sx = $platform_default_server[$common_area_sign];
}

//$base_url = $sx . $common_second_domain . '/for_backend/index.php?c=Csv&a=Equip';
$server_url = 's1-sanxiao9-eu.game-ark.com';
$base_url = $server_url . '/for_backend/index.php?c=Csv&a=Equip';
//echo $base_url;exit;

//$base_url = 't2.sm2.kunlun.com/for_backend/index.php?c=Csv&a=Equip';



function getTokenParams()
{
	$params = array();
	$t = time();
	$params['t'] = $t;
	$params['s'] = md5(GLOBAL_TOKEN.$t.GLOBAL_TOKEN);

	return http_build_query($params);
}
$token_params_str = getTokenParams();
$url = 'http://'. $base_url.'&'.$token_params_str;
//comm_do_gen_log($base_folder, $url);


$try_num = 3;
$cnt = 0;
while($cnt < $try_num && ($result = @file_get_contents($url)) === false)
{
	$cnt++;
}

$bak_result = $result;
$result = @gzuncompress($result);
$arr = @json_decode($result, true);
$log_msg = $url . ' -- ';

var_dump($url);


if (empty($arr) || !is_array($arr))
{
	$log_msg .= $bak_result;
}
else
{
	$log_msg .= !empty($arr['retmsg']) ? $arr['retmsg'] : 'fail';
	
	if (0 == $arr['retcode'])
	{
		if (!empty($arr['data']))
		{
            var_dump('in_data');

			$cur_date_str = date('Y-m-d H:i:s');
			$equip_data = $arr['data'];
			$base_path = CUR_ROOT_PATH . '/data/';
            var_dump($base_path);


            //comm_do_mkdir_recyle($base_path);
            var_dump('in_data_4');
			$equip_file = $base_path . '/equip.php';
			$str_log = "<?php \r\n ";
			$str_log .= '//@' . $cur_date_str . "\r\n";
			$str_log .= "\r". ' return ' . var_export($equip_data,true) . ";\r\n";
			$str_log .= '?>';
			@file_put_contents($equip_file, $str_log);
			$log_msg .= "\r\n" . $equip_file . ' -- done';

            var_dump('in_data_2');
			
			//act 活动后台配置
			$act_equip_path = $path_www . '/act' . $common_second_domain . '/data/activity/';
			//comm_do_mkdir_recyle($act_equip_path);
			$act_equip_file = $act_equip_path . 'equip.inc';
			$str_log = "<?php \r\n ";
			$str_log .= '//@' . $cur_date_str . "\r\n";
			$str_log .= "\r". ' return ' . var_export(array_values($equip_data),true) . ";\r\n";
			$str_log .= '?>';
			@file_put_contents($act_equip_file, $str_log);
			@chmod($act_equip_file, 0777);
			$log_msg .= "\r\n" . $act_equip_file . ' -- done';
			
			$equip_base_data = array();
			
			foreach($equip_data as $equip_id => $detail)
			{
				$tmp = array();
				$tmp['id'] = $equip_id;
				$tmp['title'] = trim($detail['title']);
				$equip_base_data[$equip_id] = $tmp;
			}
			
			$act_equip_base_file = $act_equip_path . 'EquipBase.inc';
			$str_log = "<?php \r\n ";
			$str_log .= '//@' . $cur_date_str . "\r\n";
			$str_log .= "\r". ' return ' . var_export($equip_base_data,true) . ";\r\n";
			$str_log .= '?>';
			@file_put_contents($act_equip_base_file, $str_log);
			@chmod($act_equip_base_file, 0777);
			$log_msg .= "\r\n" . $act_equip_base_file . ' -- done';
				
			//gmt 后台配置
			$gmt_equip_path = $path_www . '/gmt' . $common_second_domain . '/data/';
			//comm_do_mkdir_recyle($gmt_equip_path);


			
			$gmt_equip_file = $gmt_equip_path . 'equip.php';
            var_dump($gmt_equip_file);
			$str_log = "<?php \r\n ";
			$str_log .= '//@' . $cur_date_str . "\r\n";
			$str_log .= "\r". ' return ' . var_export($equip_data,true) . ";\r\n";
			$str_log .= '?>';

            var_dump($gmt_equip_file);
			@file_put_contents($gmt_equip_file, $str_log);
			@chmod($gmt_equip_file, 0777);
			$log_msg .= "\r\n" . $gmt_equip_file . ' -- done';
		}
	}
}

//comm_do_gen_log($base_folder, $log_msg);
echo $log_msg . "\n";

