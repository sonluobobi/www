<?php
/**
 * 内部使用账户（因为部分越南同事没有工号，无法分配GMT权限）
 */

class InternalAccount
{
	
	/**
	 * 配置内部使用账户
	 * 
	 */
	public static $account_config = array(
		//'moyu'		=> '407257209de8f69d70cdb90c2a65cff6',
		'jianzhu'		=> 'e940ddeb946fa9e078ee64bcc1e2d90a',
		'liujianzhu'		=> 'e10adc3949ba59abbe56e057f20f883e',
		'jiancheng' =>'e10adc3949ba59abbe56e057f20f883e',
	);
	
	/**
	 * 配置用户需要过滤的权限
	 * 
	 */
	public static $power_filter_config = array (
		//7: 操作管理  74: 权限分配 86: 发送功能道具 88: 添加充值记录
		'moyu'         => array(7, 74, 86, 88),
		'jianzhu' => array(7, 74),
		'xiaohui.xu' => array(7, 74, 86, 88,94),//许晓慧
		'Raffaella' => array(7),//贾依
		'jiancheng' => array(),
	);
	
	/**
	 * 联运平台登录配置
	 * @var unknown_type
	 */
	public static $plaform_config = array(
			
			"37wan" => array(
					'ip' => array('116.28.63.108'),
					'key'=>'kunlunA34DF*&*A34DF*&*9D37wanFT@EF*$U9DFU*37wan',
					
					),
			"kl" => array(
					'ip' => array('113.111.194.172','116.28.63.108'),
					'key'=>'kunlunA34DF*&*A34DF*&*9D37wanFT@EF*$U9DFU*37wan',
						
			),
	);
	
	
	public static function getClientIp()
	{
		if (isset($_SERVER))
		{
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			elseif (isset($_SERVER["HTTP_CLIENT_IP"]))
			$realip = $_SERVER["HTTP_CLIENT_IP"];
			else
				$realip = $_SERVER["REMOTE_ADDR"];
		}
		else
		{
			if (getenv('HTTP_X_FORWARDED_FOR'))
				$realip = getenv('HTTP_X_FORWARDED_FOR');
			elseif (getenv('HTTP_CLIENT_IP'))
			$realip = getenv('HTTP_CLIENT_IP');
			else
				$realip = getenv('REMOTE_ADDR');
		}
	
		return addslashes($realip);
	}
	
	
	
}

?>
