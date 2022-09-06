<?php
/**
 * @filesource Soap.php
 * @desc Soap接口类
 * @author xiaoyang.qi
 * @date 2010-07-14
 * Usage:
 * common\Soap::CallSaopInterface('通信地址',"接口名字","接口参数"); 
 */
namespace common;
class Soap{
	/**
	 * 调用Soap静态方法
	 * @param String $soapHost
	 * @param String $soapMethod
	 * @param Array $soapParams
	 */
	public static function CallSaopInterface($soapHost,$soapMethod, $soapParams){
		
		$soapToken = self::createSoapToken($soapParams);
		array_unshift($soapParams, $soapToken[0]);
		return self::callSoapClient($soapHost,$soapMethod,$proxyServer=array(), $soapParams);
	}
	/**
	 * 建立soap链接，请求或发送数据
	 * @param String $soapHost
	 * @param String $soapMethod
	 * @param Array $proxyServer
	 * @param Array $soapParams
	 */
	private function callSoapClient($soapHost, $soapMethod, $proxyServer=array(), $soapParams=array()){
		$proxyHost = empty($proxyServer['proxyHost']) ? '' : $proxyServer['proxyHost'];
		$proxyPort = empty($proxyServer['proxyPort']) ? '' : $proxyServer['proxyPort'];
		$proxyUser = empty($proxyServer['proxyUser']) ? '' : $proxyServer['proxyUser'];
		$proxyPass = empty($proxyServer['proxyPass']) ? '' : $proxyServer['proxyPass'];
		$timeOut   =  0;
		$responseTimeout = 600;
		include_once ("../lib/nusoap/nusoap.php");
		$soapClient = new \nusoap_client($soapHost, false, $proxyHost, $proxyPort, $proxyUser, $proxyPass, $timeOut, $responseTimeout);
		$err = $soapClient->getError();
		if ($err)
		{
			return array(false, 'soap:constructor_is_error');
		}
		
		$result = $soapClient->call($soapMethod, $soapParams);
		return array($result);
	}
	/**
	 * 生成soapToken
	 * @param Array $soapParams
	 */
	private  function  createSoapToken($soapParams){
		if (empty($soapParams) || !is_array($soapParams) || count($soapParams)<1 || !TOKENKEY)
		{
			return array(false, 'soap:info_neq_miss');
		}
		$str = SOAPTOKENKEY;
		sort($soapParams,SORT_STRING);
		foreach ($soapParams as $key=>$val) {
			$str .= '|-|'.$val;
		}
		return array(md5($str), $str);
	}
}
