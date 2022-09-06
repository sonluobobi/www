<?php // -*-coding:utf-8; mode:php-mode;-*-
namespace entity;

class Buff 
{
	const TABLE_NAME = 't_buff';
	
	/**
	 * ID
	 *
	 * @var int
	 */
	public $id;
	/**
	 * 道具类型ID或者商品ID
	 *
	 * @var int
	 */
	public $propTypeId;
	/**
	 * 作用对象的类型，1英雄，2玩家
	 *
	 * @var int
	 */
	public $targetType;
	/**
	 * 作用对象的ID
	 *
	 * @var int
	 */
	public $targetId;
	/**
	 * 起始作用时间
	 *
	 * @var int
	 */
	public $startTime;
	/**
	 * 结束作用的时间
	 *
	 * @var int
	 */
	public $endTime;
}