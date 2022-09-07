<?php
/******************************************************************************
Filename              : logout.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2008-12-05
Purpose               : 推出登录
Description           : 
Revisions             :

******************************************************************************/

require_once('common.php');

$_SESSION['AuthCode'] = '';
$_SESSION['act_platform'] = '';
unset($_SESSION);

Redirect('index.php', '退出登录成功！', '1');
?>