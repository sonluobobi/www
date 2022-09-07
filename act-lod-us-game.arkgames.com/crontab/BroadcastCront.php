<?php
require '../config/config.php';
require '../config/static_config.php';
require '../libs/class_broadcast/class.broadcast.inc.php';
require_once('../libs/mysql.config.inc.php');

$broadcastObj = new ClsBroadcast($DB);

$ret_code = $broadcastObj->publishAll(GAME_SERVER_URL);
if ($ret_code != RSP_MSG_CODE_OK) {
	$path = LOGS_DIR."/pubBroadcast_".date('Ymd').".log";
	file_put_contents($path, date('Y-m-d H:i:s')."\t".$arr_rsp_msg[$ret_code]."($ret_code)"."\n", FILE_APPEND);
}
?>