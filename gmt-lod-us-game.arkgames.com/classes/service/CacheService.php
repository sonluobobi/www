<?php
/**
 * @file   CacheService.php
 * @author xiaoyang.qi <xiaoyang.qi@kunlun-inc.com>
 * @date   Thu Jul 14 16:24:51 2010
 *
 * @brief
 *
 * 常用数据缓存类
 */
namespace service;
use dao;
use framework\util;

class CacheService extends ServersAbs{
	public function __construct(){
		parent::__construct();
	}
	/**
	 * 更新缓存
	 */
	public function main($gup = ''){
		//更新菜单
		$this->menu_recache();
		//更新服务器
		$this->Server_recache($gup);
	}
	/**
	 * 更新服务器列表缓存
	 */
	private function Server_recache($gup = ''){
		
		$gup = $gup != '' ? $gup : $_SESSION['gup']."_".$_SESSION['productId'];		
		$ServerDao = util\Singleton::get("dao\\ServiceDao");
		$serverList = $ServerDao->GetServicesList('',$gup);
		//echo '<pre>',$gup;print_r($serverList);exit;
		$total  = count($serverList);
		$contents  = "\$init['serverCount'] = $total;\r\n";
		$contents .= "\$init['serverList'] = array(\r\n";
		$i = 0 ;
		foreach($serverList as $server)
		{
			$contents.="\t'".$i."' => array(\r\n\t\t'Server_id' => '".intval($server['serverId'])."',\r\n\t\t'productId' => '".intval($server['productId'])."',\r\n\t\t'regionId' => '".intval($server['regionId'])."',\r\n\t\t'orderId' => '".intval($server['orderId'])."',\r\n\t\t'Server_name' => '".addslashes($server['serverName'])."',\r\n\t\t'Server_url' => '".addslashes($server['serverUrl'])."',\r\n\t\t'Server_ip' => '".addslashes($server['serverIp'])."',\r\n\t\t'Server_type' => '".addslashes($server['serverType'])."',\r\n\t\t'Region_name' => '".addslashes($server['regionName'])."',\r\n\t\t'Region_url' => '".addslashes($server['regionUrl'])."',\r\n\t\t'Region_ip' => '".addslashes($server['regionIp'])."',\r\n\t\t'Server_group' => '".addslashes($server['serverGroup'])."',\r\n\t\t'server_text' => '".addslashes($server['serverName']).'-'.addslashes($server['serverType'])."'\r\n\t),\r\n";
			$i++;
		}
		$contents .= ');';
		$this->writetocache('serverlist'.$gup,$contents);
	}
	/**
	 * 生成缓存数组
	 */
	public function menu_recache(){
		$ActionDao = util\Singleton::get("dao\\ActionDao");
		$main = $ActionDao->fetchActionList(0);
		$menudb = array('menuTree'=>$ActionDao->fetchActionList(0),'setupTree'=>$ActionDao->fetchActionList(1));
		foreach ($menudb as $arrName=>$arrVal)
		{
			if (!empty($arrVal) && is_array($arrVal))
			{
				$contents .= "\${$arrName} = array(\r\n";
				foreach ($arrVal AS $key => $val)
				{
					$contents .= "\t{$key} => array(\r\n";
					if ($val['ActRoot'])
					{
						$contents .= "\t\t 'ActRoot' => array(\r\n";
						foreach ($val['ActRoot'] AS $aKey => $aval)
						{
							$contents .= "\t\t\t '{$aKey}' => '{$aval}',\r\n";
						}
						$contents .= "\t\t),\r\n";
					}
					if ($val['ActFirst'])
					{
						$contents .= "\t\t 'ActFirst' => array(\r\n";
						foreach ($val['ActFirst'] AS $fKey => $fval)
						{
							$contents .= "\t\t\t{$fKey} => array(\r\n";
							foreach ($fval as $ffKey => $ffVal)
							{
								$contents .= "\t\t\t\t '{$ffKey}' => '{$ffVal}',\r\n";
							}
							$contents .= "\t\t\t),\r\n";
						}
						$contents .= "\t\t),\r\n";
					}
					if ($val['ActSecond'])
					{
						$contents .= "\t\t 'ActSecond' => array(\r\n";
						foreach ($val['ActSecond'] as $sKey => $sVal)
						{
							$contents .= "\t\t\t{$sKey} => array(\r\n";
							foreach ($sVal as $ssKey => $ssVal)
							{
								$contents .= "\t\t\t\t{$ssKey} => array(\r\n";
								foreach ($ssVal as $sssKey => $sssVal)
								{
									$contents .= "\t\t\t\t\t '{$sssKey}' => '{$sssVal}',\r\n";
								}
								$contents .= "\t\t\t\t),\r\n";
							}
							$contents .= "\t\t\t),\r\n";
						}
						$contents .= "\t\t),\r\n";
					}
					$contents .= "\t),\r\n";
				}
				$contents .= ");\r\n";
			}
		}
	
		$this->writetocache('menu',$contents);
	}
	// 写入缓存文件
	private function writetocache($cachename, $cachedata = '') 
	{
/*		if(in_array($cachename, array('menu','action','serverlist'.$_SESSION['gup']))) 
		{*/
			$cachedir = \framework\core\Context::getRootPath().'/data/cache/';
			//$cachedir = Context::getRootPath'../data/cache/';
			$cachefile = $cachedir.'cache_'.$cachename.'.php';
			if(!is_dir($cachedir)) 
			{
				@mkdir($cachedir, 0777);
			}
			$cachedata = "<?php\r\n//Kunlun Gmtools cache file\r\n//Created on ".date('Y-m-d H:i:s')."\r\n\r\n".$cachedata."\r\n\r\n?>";
			if (!$this->writefile($cachefile, $cachedata)) 
			{
				exit('Can not write to '.$cachename.' cache files, please check cache directory.');
			}
//		}
	}
	
	private  function writefile($filename, $data, $method = 'wb', $chmod = 1) 
	{
		$return = false;
		if($fp = @fopen($filename, $method )) 
		{
			@flock($fp, LOCK_EX);
			$return = fwrite($fp, $data);
			fclose($fp);
			$chmod && @chmod($filename,0777);
		}
		
		return $return;
	}
}
