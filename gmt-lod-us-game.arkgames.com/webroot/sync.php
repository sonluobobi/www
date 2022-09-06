<?php
namespace webroot\sync;

use common;
use entity;
use framework\data\pdo;

// 打开报错，设定报错等级
ini_set("display_errors",'On');
// 设定报错级别
error_reporting(E_ALL ^ E_NOTICE);

$common_config_file = '/data/sanxiao/www/common/config.php';

if (!file_exists($common_config_file))
{
	echo "common config file is not exists !!!";exit;
}

require_once $common_config_file;

define('CONFIG_PLATFORM_SERVER_FILE', '/data/syslog/serverlist/server_list.php');

class Sync
{
	private $pdoServer; //游戏服
	private $pdoGroup; //游戏运营方
	private $pdo;
	private $reqUrl = 'http://dc.zs.kunlun.com/api.php';
	private $serverInfo;
	private $serverList = array();
	private $groupList  = array();
	private $operationArray = array();
	private $product_id;
    private static $logOpDB = array();
    
    private static $gameProductConfig = array();
	
       
	function __construct($common_product_id) 
	{
		$this->pdo = pdo\PDOManager::getInstance("default");
		$this->pdoServer = new pdo\PDOHelper("entity\\Service");
		$this->pdoGroup = new pdo\PDOHelper("entity\\Group");
       	$this->pdoServer->setPdo($this->pdo);
       	$this->pdoGroup->setPdo($this->pdo);  

		self::$logOpDB = array(
				'DB_PROTOCOL' => 'mysql',
				'DB_HOST' => '127.0.0.1',
				'DB_PORT' => '3306',
				'DB_PASS' => 'NoNeed4Pass32768',
				'ENCODING' => 'UTF8',
				'DB_USER' => 'moyu',
				'DB_LIBR' => 'backend_gmt',
		);

		self::$gameProductConfig = array(
			$common_product_id
		);
	}
	
	function getPlatformServerList($product_id, $partner_id='')
	{
		$arr_server_list = array();

		if (!file_exists(CONFIG_PLATFORM_SERVER_FILE)) return array();

		$tableInfo = require CONFIG_PLATFORM_SERVER_FILE;
		//echo "<pre>";print_r($tableInfo);exit;
		if (empty($tableInfo)) return array();
		$ret = array();
		
		foreach($tableInfo as $aid => $info)
		{
			if ($info['product_id'] == $product_id && (empty($partner_id) || empty($info['partner_id']) || $info['partner_id']== $partner_id))
			{
				$ret[$aid] = $info;
			}
		}
		
		return $ret;
	}
		
	/**
	 * 更新游戏服数据表
	 * @return unknown_type
	 */
	public function syncServers()
	{
		$server_list = array();
		$groupList = \oemark::$oeMark;
		
		foreach($groupList as $v)
		{
			$this->serverInfo = $this->getServerList($v['gupId'],$v['productId']);
			
			$this->product_id=$v['productId'];
			if(empty($this->serverInfo))
			{
				$this->sendMail();
			}
			else
			{
				//删除服务器列表,因为更新的时候不会把废弃的游戏服删除,added by fuqian.liao
				$this->deleteServers($v['gupId']);
				
				$this->updateServers($this->serverInfo);
				$this->updateGroup($v['gupId'],$v['Langage'],$v['gupFlag'],$v['productId']);
			}
			
			$server_list[] = $this->serverInfo;
		}
		$this->updateCache();
		
		return $server_list;
	}
	
	
	/**
	 * 生成GMT系统使用的配置文件（免去手工配置）：added by fuqian.liao
	 */
	public function makeGmtInfOemark()
	{
		$server_status = array(0,1);
		
		$platform_list = array();
		$oeMark        = array();
			
		$mark = 'kl';
		$productName = '昆仑';
		
		//echo '<pre>';print_r(self::$gameProductConfig);exit;
		foreach (self::$gameProductConfig as $product_id)
		{
			$server_list = $this->getPlatformServerList($product_id);
			
			//echo '<pre>';print_r($server_list);exit;
			if (!is_array($server_list) || count($server_list) < 1)
			{
				$oeMark = array();
				break;
			}
			//echo '<pre>';print_r($server_list);exit;			
			foreach ($server_list as $server)
			{
				if (!in_array($server['server_status'], $server_status)) continue;
					
				$key = $server['partner_id'].'_'.$product_id;
				//$key = '_'.$product_id;
			
				if (!isset($oeMark[$key]))
				{
					$oeMark[$key]['productId'] = $server['product_id'];
					$oeMark[$key]['Langage']   = 'zh';
					$oeMark[$key]['gupFlag']   = $mark;
					$oeMark[$key]['gupId']     = $server['partner_id'];
					$oeMark[$key]['oemark']    = $mark;
					$oeMark[$key]['productName']  = $productName;
					$oeMark[$key]['timeZone']     = date_default_timezone_get();
					$oeMark[$key]['regionOemark'] = $mark;
				}
			}
			
		}
		if (count($oeMark) > 0)
		{
			usort($oeMark, array(__CLASS__,'userCmp'));
						
			//echo '<pre>';print_r($oeMark);exit;		
			$outPhp = "<?php\nclass oemark\n{\n\tpublic static \$oeMark = array(\n\t\t\t";
			foreach($oeMark as $k => $v)
			{
				$outPhp .= "'$k' => array(\n\t\t\t\t";
				foreach($v as $m => $n)
				{
					$outPhp .= "'$m' => '$n',\n\t\t\t\t";
				}
				$outPhp .= "),\n\t\t\t";
			}
			$outPhp .=");\n}\n?>";
			file_put_contents(\framework\core\Context::getRootPath().'/inf/oemark.php',$outPhp);
		}
				
		echo " make gmt config ok.\r\n";
	
	}
	
	private function userCmp($a,$b)
	{
		$result = strncmp($a['productName'], $b['productName'], 5);
		
		return $result;
	}
	
	/**
	 * 删除旧的服务器列表
	 * @param unknown_type $group_id
	 */
	private function deleteServers($group_id)
	{
		$where = "`serverGroup`='".$group_id."'";
		$this->pdoServer->remove($where, null);
	}
	
	/**
	 * 更新游戏服务器数据表
	 */
	private function updateServers($serverInfo)
	{
		if(!empty($serverInfo))
		{
			$tmpRegionIds = array();
			foreach($serverInfo as $tmp)
			{
				//过滤掉已经停运的游戏服，0准备开服 1运营 2维护 3停运
				//if ($tmp['server_status'] == 3) continue;
				if (!in_array($tmp['server_status'], array(0,1))) continue;

				if (empty($tmp['server_url']) && !empty($tmp['login_url']))
				{
					$url_arr = parse_url($tmp['login_url']);
					$tmp['server_url'] = $url_arr['host'];
				}

				empty($tmp['partner_id']) && $tmp['partner_id'] = $tmp['product_id'];

				$entity = new entity\Service;
				$entity->serverId    = $tmp['server_id'];
				$entity->productId   = $tmp['product_id'];
				$entity->regionId    = $tmp['server_id'];
				$entity->serverUrl   = $tmp['server_url'];
				$entity->serverName  = $tmp['server_name'];
				$entity->serverIp    = $tmp['server_ip'];
				$entity->regionName  = $tmp['server_name'];
				$entity->regionUrl   = '';
                $entity->serverGroup = $tmp['partner_id'];
                $entity->regionIp    = '';
				$entity->status      = $tmp['server_status'] == 1 ? 0 : 1 ;
                $entity->orderId     = 0;

                $tmp_test_server = false;
                if ($tmp['server_id'] % 1000 > 900)
                {
                	$tmp_test_server = true;
                }

                if (!$tmp_test_server)
                {
                	$first  = strtolower(substr($tmp['server_name'],0,1));
                	$first != 's' && $tmp_test_server = true;
                }
                $serverType = $tmp_test_server ? 0 : 1;
                $entity->serverType = $serverType;
				
				try {
				$this->pdoServer->replace($entity,(array) new entity\Service);
				} catch (\Exception $e) {
						throw new \Exception($e->getCode());
				}
			}
		}
	}
	
	private function parseUrl($url)
	{
		$block = parse_url($url);
		return $block['scheme'].'://'.$block['host'];
	}

	/**
	 * 更新游戏运营方数据表
	 */
	private function updateGroup($groupId,$languages,$flag,$product_id)
	{
		$entity = new entity\Group;
		$entity->groupId   = $groupId;
		$entity->groupName = $flag;
		$entity->flag      = $flag;
		$entity->languages = $languages;
		
		//echo '<pre>';print_r($entity);exit;
		$this->isNewTeam($entity,$product_id);
		
		try {
			$this->pdoGroup->replace($entity,(array) new entity\Group);
		} catch (\Exception $e) {
			throw new \Exception($e->getCode());					
		}
		if(!empty($this->operationArray))
			$this->writeOp();
	}
	
	/**
	 * 判断是否是新添加的运营方
	 */
	private function isNewTeam($entity,$product_id)
	{
		$where = "groupId = {$entity->groupId}";
		$exist = $this->pdoGroup->fetchEntity($where);
		
		if($exist == false)
		{
			/*
			$dbname = GAME.'_log_'.$entity->groupName;
		 	$user = GAME.'_log_user';
			$exeFile = \framework\core\Context::getRootPath().'/data/shell/CreateDB.sh' ;
			popen("/bin/bash $exeFile $dbname $user ".self::$logOpDB['DB_HOST']." ".self::$logOpDB['DB_PASS'],r);
			self::$logOpDB['DB_USER'] = $user; 
			self::$logOpDB['DB_LIBR'] = $dbname; 
			*/
			
			$this->operationArray[$entity->groupId."_".$product_id] = self::$logOpDB;
		}
		
	}

	/**
     * 有新的运营方式写入配置文件
 	 */
	private function writeOp()
	{
		$opInfo = \operation::$operationDataServer + $this->operationArray;
		$outPhp = "<?php\nclass operation\n{\n\tpublic static \$operationDataServer = array(\n\t\t\t";
		foreach($opInfo as $k => $v)
		{
			$outPhp .= "'$k' => array(\n\t\t\t\t";
			foreach($v as $m => $n)
			{
				$outPhp .= "'$m' => '$n',\n\t\t\t\t";
			}
			$outPhp .= "),\n\t\t\t";
		}
		$outPhp .=");\n}\n?>";
		file_put_contents(\framework\core\Context::getRootPath().'/inf/operation.php',$outPhp);
	}

	/**
	 * 从DC获取游戏服务器信息
	 */
	private function getServerList($partner_id,$product_id)
	{
		/*
		$params = array('partners'=>$game,'product'=>$type);
		if($slist = @file_get_contents($this->reqUrl.'?'.http_build_query($params))){
			return json_decode($slist,true);
		}
		else {
			return false;
		}
		//*/
		
		return $this->getPlatformServerList($product_id, $partner_id);
	}		

	/**
	 * 游戏服务器列表缓存更新
	 */
	private function updateCache()
	{
		$groupBy = "serverGroup,productId";
        	$glist = $this->pdoServer->fetchAll(1,null,"productId,serverGroup",null,null,$groupBy);
        	
        	if(!empty($glist))
        	{
            		$cache = new \service\CacheService;
            		foreach($glist as $v)
            		{
                		$cache->main($v['serverGroup'].'_'.$v['productId']);
            		}
        	}
	}
	
	/**
	 * 发送EMAIL
	 */
	private function sendMail()
	{
		$to = "hua.gao@kunlun-inc.com"; 
		$subject = "GMT Server Synchronous fail";
		$message = "Hello! everyone, GMT Server Synchronous fail.Please check it[xksj].";
		$from = 'gmt.admin@kunlunlun-inc.com';
		$headers = "From: $from";
		mail($to,$subject,$message,$headers);
	}
}

$sync = new Sync($common_product_id);
$sync->makeGmtInfOemark();
$server_list = $sync->syncServers();
print_r($server_list);
