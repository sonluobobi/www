<?php
namespace common;
//静态方法调用类

class Statics
{
	//军团仓库操作类型
	public static $gangStorageLogTypeMap = array(1=> '放入', 2 => '返回', 3 => '返回', 4 => '兑换', 5 => '自动返回');

	//装备职业
	public static $equipProfMap = array(1 => '血族', 2 => '法师', 3 => '战士');

	//金钱属性定义
	public static $money_use_gold_type_map = array('' => '全部', 7 => '体力', 8 => '耐力', 9 => '兽魂');

	public static $silver_type_map = array(
		1=>'人物技能升级', 
		2=> '契约使用兽魂', 
		3 =>'付款兑换使用兽魂', 
		4 => '幻兽继承使用兽魂',
		5 => '关卡通关',
		6 => '关卡扫荡',
		7 => '竞技场发起挑战',
		8 => '宝物抢夺',
		71 => '运营活动',
	);
}