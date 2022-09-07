<?php

require 'medoo.php';

$host = explode(":", $config_server);
empty($host[1]) && $host[1] = 3306; 
$db_options = array();
$db_options['database_type'] = 'mysql';
$db_options['charset'] = 'utf8';
$db_options['database_name'] = $config_database;
$db_options['server'] = $host[0];
$db_options['username'] = $config_user;
$db_options['password'] = $config_password;
$db_options['port'] = $host[1];
$db_options['prefix'] = 'tbl_';
$db_options['option'] = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);

$medoo_db = new medoo($db_options);