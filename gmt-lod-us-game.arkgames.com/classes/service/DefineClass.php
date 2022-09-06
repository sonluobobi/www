<?php
class DefineClass
{
	public static $instance;
	public function __construct();

	public static function getInstance()
	{
		if (self::$instance) {
			return self::$instance;
		}
		$class = __CLASS__;
		self::$instance = new stdClass();
		return self::$instance;
	}
}
?>