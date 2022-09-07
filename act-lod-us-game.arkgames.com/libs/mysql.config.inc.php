<?php
/******************************************************************************
Filename              : mysql.config.inc.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2008-06-26
Purpose               : 
Description           : 
Revisions             :

******************************************************************************/

require_once('db_mysql.php');

$DB = new db_MySQL;
$DB->database	= $config_database;
$DB->server		= $config_server;
$DB->user		= $config_user;
$DB->password	= $config_password;

$DB->connect();
$DB->query('SET NAMES UTF8');
?>