<?php
namespace entity;
class Log{
	const TABLE_NAME = "gm_logs";
	/**
	 * id
	 * @return Int $id
	 */
	public $id = 'id';
	/**
	 * action的um唯一认证key
	 * @return String $actkey
	 */
	public $actkey = 'actkey';
	/**
	 * action名称
	 * @return String $acttitle
	 */
	public $acttitle = 'acttitle';
	/**
	 * 管理员真实姓名
	 * @return String $Uname
	 */
	public $fullname = 'fullname';
	/**
	 * 管理员登陆账号
	 * @return String $username
	 */
	public $username ='username';
	/**
	 * 操作信息
	 * @return String $handle
	 */
	public $content = 'content';
	/**
	 * 管理员IP
	 * @return String $Ip
	 */
	public $ip ='ip';
	/**
	 * 日志时间
	 * @return string LogDate
	 */
	public $logDate ='logDate';
}