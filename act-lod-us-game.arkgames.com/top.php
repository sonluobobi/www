<?php
/******************************************************************************
Filename              : top.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2007-07-25
Purpose               : 辅助栏
Description           : 
Revisions             :

******************************************************************************/
############################ 初始化数据 start ###############################
//模板文件
$template_name = 'top.html';
require('common.php');


$tpl->assign('top_year', date('Y'));
$month = date('n')-1;
$tpl->assign('top_month',$month);
$tpl->assign('top_date', date('j'));
$tpl->assign('top_hour', date('G'));
$tpl->assign('top_minute', date('i'));
$tpl->assign('top_seconds', date('s'));

$time_zone_info = date_default_timezone_get();
$tpl->assign('time_zone', $time_zone_info);
############################ 初始化数据 end #################################
$accountname = $_SESSION['accountname'];
$tpl->assign("accountname",$accountname);
$tpl->output();
?>
