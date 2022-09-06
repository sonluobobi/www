<?php
/**
 * @filesource PhpMail.php
 * @desc 提供公用发送邮件类
 * @author xiaoyang qi
 * @date 2010-07-29
 * Usage:
 * $Mail = new PhpMail();
 * $Mail->addMailAddress(array('xiaoyang.qi@kunlun-inc.com','juezhong.long@kunlun-inc.com'));
 * $Mail->addMailAttachment('/tmp/ttt.tar.gz');  此项不是必须设置的
 * $Mail->sendMail('测试邮件','测试测试');
 */
namespace common;

function __autoload($class_name){
	require ($class_name == "GMMailer") ? "../lib/mail/mail.class.php" : "../lib/mail/{$class_name}.class.php";
}

class PhpMail {
	
	private $mailMod = null;
	
	private $mailAdd = array();
	
	/**
	 * 构造函数
	 */
	public  function __construct() 
	{
		$this->mailMod = new GMMailer();
	}
	/**
	 * 析构函数
	 */
	public function __destruct(){
		$this->mailMod = null;
	}
	
	/**
	 * 发送Mail
	 * @param String $title 邮件标题
	 * @param String $body  邮件主题
	 * @return true
	 */
	public function sendMail($title,$body){
		$this->mailMod->AttachAll();
		$this->mailMod->IsHTML(true);
		$this->mailMod->Subject = $title;
		$this->mailMod->Body = $body;
		$this->mailMod->AltBody = $body;
		$this->mailMod->AltBody = $body;
		$result = $this->mailMod->Send();
		return true;
	}
	
	/**
	 * 添加Maill地址
	 * @param Array $address  邮件地址 array('xiaoyang.qi@kunlun-inc.com','juezhong.long@kunlun-inc.com')
	 * @return 
	 */
	public function addMailAddress($address = array()){
		(is_array($address) && !empty($address)) && $this->mailAdd = $address;
		foreach ($this->mailAdd as $add){
			$this->mailMod->AddAddress($add);
		}
	}
	
	/**
	 * 添加Maill附件
         * @param String $fileName 储件地址
	 * @return 
	 */
	public function addMailAttachment($fileName){
		$this->mailMod->AddAttachment($fileName);
	}
	
}
