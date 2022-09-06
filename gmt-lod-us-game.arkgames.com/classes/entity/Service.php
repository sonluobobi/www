<?php
namespace entity;

class Service {

	const TABLE_NAME = 'gm_servers';
	
	 /**
	 * 服务器ID
	 * @var Int
	 */
	public $serverId    = 'serverId';

	/**
	 * 产品 ID
	 * @var Int
	 */
	public $productId   = 'productId';
	
	/**
	 * 大区ID
	 */	
	public $regionId    = 'regionId';
	
	/**
	 * 服务器URL
	 * @var String
	 */	
	public $serverUrl   = 'serverUrl';

	/**
	 * 服务器名字
	 * @var String
	 */	
	public $serverName  = 'serverName';

	/**
	 * 服务器IP
	 * @var String
	 */	
	public $serverIp    = 'serverIp';

	/**
	 * 服务器类型
	 * @var String
	 */	
	public $serverType  = 'serverType';

	/**
	 * 大区名字
	 * @var String
	 */	
	public $regionName  = 'regionName';

	/**
	 * 大区URL
	 * @var String
	 */	
	public $regionUrl   = 'regionUrl';

	/**
	 * 大区IP
	 * @var String
	 */	
	public $regionIp    = 'regionIp';

	/**
	 * 服务器组
	 * @var String
	 */	
	public $serverGroup = 'serverGroup';
	
	/**
	 * 服务器状态
	 * @var Int
	 */	
	public $status      = 'status';

	/**
	 * 排序ID
	 * @var Int
	 */	
	public $orderId     = 'orderId';	

}