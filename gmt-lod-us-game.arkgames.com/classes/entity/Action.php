<?php
namespace entity;
class Action {
	
	const TABLE_NAME = "gm_actions";
	/**
	 * id
	 * @var Int
	 */
	public $id = 'id';
	/**
	 * 排序ID
	 * @var Int
	 */
	public $orderid = 'orderid';
	/**
	 * 父极ID
	 * @var Int
	 */
	public $pid = 'pid';
	/**
	 * 动作类型
	 * @var Enum
	 */
	public $acttype = 'acttype';
	/**
	 * 图标类型（menuDash，menuEye，menuGoals，menuHelp）
	 * @var Enum
	 */
	public $actico = 'actico';
	/**
	 * 提交的动作
	 * @var Varchar
	 */
	public $actcode = 'actcode';
	/**
	 * 动作标题
	 * @var Varchar
	 */
	public $acttitle = 'acttitle';
	/**
	 * 快捷菜单
	 * @var Tinyint
	 */
	public $shortcut ='shortcut';
	/**
	 * 是否显示子节点
	 * @var actdisplay
	 */
	public $actdisplay = 'actdisplay';
}