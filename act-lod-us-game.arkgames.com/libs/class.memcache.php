<?php
/******************************************************************************
Filename              : class.memcache.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2008-12-24
Purpose               : 
Description           : 
Revisions             :

******************************************************************************/

class MyMemcache
{
	var $memcache = null;

	function __construct()
	{
		$this->memcache = new Memcache;
		@$this->memcache->connect(CONFIG_MEMCACHE_SERVER_IP, CONFIG_MEMCACHE_SERVER_PORT) or $this->connect_error();
	}

	function connect_error()
	{
		$connect_error = 'Could not connect memcache server : ' . 
							'ip[<font color="red">"' . CONFIG_MEMCACHE_SERVER_IP . '"</font>], ' . 
							'port[<font color="red">"' . CONFIG_MEMCACHE_SERVER_PORT . '"</font>]';

		echo $connect_error;
		die();
	}
}
?>