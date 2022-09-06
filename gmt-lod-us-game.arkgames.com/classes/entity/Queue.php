<?php
namespace entity;
class Queue {
	const TABLE_NAME = 'gm_queue';
	/**
	 * ID
	 */
	public $id = 'id';
	/**
	 * 接口名字
	 */
	public $interfaceName = 'interfaceName';
	/**
	 * 服务器列表
	 */
	public $serverList = 'serverList';
	/**
	 * 队列发送的数据
	 */
	public $dataResult = 'dataResult';
	/**
	 * 说明
	 */
	public $description = '';
	/**
	 * 队列状态
	 */
	public $statis = '';
}