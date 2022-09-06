<?php // -*-coding:utf-8; mode:php-mode;-*-
namespace entity;

class User
{
	const TABLE_NAME = 'gm_users';
	
	/**
	 * ID
	 *
	 * @var int
	 */
	public $id;

	/**
	 * 用户的全名
	 *
	 * @var string
	 */
	public $fullname;
	
	/**
	 * 用户登录的账号
	 *
	 * @var int
	 */
	public $username;
	
	/**
	 * 用户登陆密码
	 */
	public $password;
	
	/**
	 * 创建用户的时间
	 *
	 * @var int
	 */
	public $createDate;
	/**
	 * 用户组
	 */
	public $usergroup;
	/**
	 * 最后一次登陆时间
	 */
	public $lastlogin;
	/**
	 * 用户权限
	 */
	public $rank;
	/**
	 * 权限快捷键
	 */
	public $shortcuts;
	/**
	 * 用户状态
	 */
	public $status;
	
	/**
	 * 加密用户密码
	 * @param String $password
	 */
	public static function encryptPassword($password)
	{
		return md5($password);
	}
}