<?php
/**
 * 批量添加多服数据，队列实现
 *
 */
namespace webroot\queue;

use \common;
use \framework\data\pdo;

//define('SCRIPT_NAME', 'Queue');
//define('ROOT_PATH', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..').DIRECTORY_SEPARATOR);

if (!defined('QUEUE_PORT')) define('QUEUE_PORT', 10917);

$GLOBALS['flag_exit'] = false;
$GLOBALS['flag_restart'] = true;
$GLOBALS['flag_childexit'] = true;
$GLOBALS['flag_lasttime'] = 0;
$GLOBALS['start_times'] = 0;
$GLOBALS['queueport'] = QUEUE_PORT;

declare(ticks = 1);

/**
 * 进程信号处理
 * @param int $signo
 */
function sig_handler($signo)
{
    if ($signo == SIGINT || $signo == SIGTERM) 
	{
        // 中断信号
        printmsg("Interrupt Signal Catched!");
        $GLOBALS['flag_exit'] = true;
        printmsg("Restart Signal Catched!");
        $GLOBALS['flag_restart'] = true;
    } else if ($signo == SIGCHLD) {
        // 子进程存在
        printmsg("Child exit!");
        $GLOBALS['flag_childexit'] = true;
    } else if ($signo == SIGUSR1) {
        $GLOBALS['flag_lasttime'] = time();
    }
}

/**
 * 输出信息
 * @param string $msg
 */
function printmsg($msg)
{
    $timestr = date("H:i:s");
    $thispid = posix_getpid();
    print "$timestr [$thispid] $msg\n";

}

/**
 * 通知父级进程
 */
function notify_ppid()
{
    static $lasttime = 0;

    $ppid = posix_getppid();
    $curtime = time();
    if ($curtime - $lasttime >= 1 && $GLOBALS['queueport'] != 0) {
        $ret = posix_kill($ppid, SIGUSR1);
        if (!$ret) 
		{
            die(date("H:i:s") . " Parent dead, exit!\n");
        } 
        $lasttime = $curtime;
    }
}

/**
 * 队列主循环
 */
function queueLoop()
{
	
    while (true) 
	{
        $queueList = array();
        //实例化主库数据库操作对象
        $mainPDO = \framework\data\pdo\PDOManager::getInstance('default');
        $querueHelper = new \framework\data\pdo\PDOHelper('entity\\Queue');
        $serverHelper = new \framework\data\pdo\PDOHelper('entity\\Service');
        $querueHelper->setPdo($mainPDO);
        $serverHelper->setPdo($mainPDO);
        $queueList = $querueHelper->fetchAll(" 1 AND status=0 ",null," * "," id asc ","0,100");
        
        if (!empty($queueList) && is_array($queueList) && count($queueList) >= 1) 
		{
            foreach ($queueList as $key => $queueEtt) {
                $serverList = array();
                $q_start = microtime();
                if(strstr($queueEtt['serverList'],','))
				{
                    $serverList = explode(',',$queueEtt['serverList']);
                }else{
                    $serverList[] = $queueEtt['serverList'];
                }
            	//实例化运营方数据库操作对象
	            $operPDO = \framework\data\pdo\PDOLogManager::getInstance('default',$queueEtt['serverGroup']."_".$queueEtt['productId']);
    	        $operHelper = new \framework\data\pdo\PDONewHelper();
        	    $operHelper->setPdo($operPDO);
            	$operHelper->setTableName("actionLog");
	            $restParm = unserialize($queueEtt['dataResult']);
    	        if(empty($restParm['queueData']) && isset($restParm['fileUrl'])  && !empty($restParm['fileUrl']))
				{
                	$restParm['queueData'] = base64_encode(file_get_contents($restParm['fileUrl']));
                	unset($restParm['fileUrl']);
            	}
		$optarr=array('Rest_Awards'=>'发送道具','Rest_setShop'=>'商城配置');	
                foreach($serverList as $sid)
				{
                	$GameUrl = $serverHelper->fetchEntity(" serverId='{$sid}' AND productId='{$queueEtt['productId']}' AND serverGroup='{$queueEtt['serverGroup']}'  ",null," serverUrl ");
	                $reusult = \common\Rest::CallRestInterFace($queueEtt['interfaceName'],$GameUrl->serverUrl.RESTSUFFIX,$restParm);
    	            $reStatus = $reusult['retcode'] == 0 ? 1 : 2;
        	        $msg = !empty($reusult['retmsg']) ? $reusult['retmsg'] : '数据操作成功';
            	    $iarr['status'] = $reStatus;
               	 	$iarr['description'] = $msg;
	                $filed  = array('status','description');
    	            $querueHelper->update($filed,$iarr," id='{$queueEtt['id']}' ");
        	        $larr->serverId = $sid;
					//TODO 优化
					if($queueEtt['interfaceName'] == 'Rest_Awards') {$larr->actkey = 'gmt_action_47'; $larr->acttitle = '确认道具发送';}
					if($queueEtt['interfaceName'] == 'Rest_setShop') {$larr->actkey = 'gmt_action_45'; $larr->acttitle = '商城配置修改';}
					//file_put_contents('/home/xingzeng.jiang/www/t1.jd.kunlun.com/gmt/cyz.log', "\r\nqueueEtt" . json_encode($queueEtt) , FILE_APPEND);
	                $larr->content = "队列ID".$queueEtt['id']."<br>\r\n$msg";
    	            $larr->username = 'admin';
        	        $larr->fullname = '超极管理员';
					$larr->operationObject = '上传文件';
            	    $larr->ip = \common\Functions::getClientIP();
	               	$larr->logDate = date("Y-m-d H:i:s");
    	            $lfiled = array('serverId','actkey','acttitle','content','username','fullname','operationObject','ip','logDate');
        	        $operHelper->add($larr,$lfiled);
            	    unset($GameUrl,$reusult,$reStatus,$iarr,$filed,$larr,$lfiled,$msg);
            	}   
            	unset($serverList,$operPDO,$operHelper,$restParm);
            	unset($queueList[$key]);
        		$q_end = microtime();
    		}
		}
		notify_ppid();	
    	sleep(1);
	}
}


function main()
{
	$reward_queue = array(); //存放发奖队列

    while (1) 
	{
        
        queueLoop();
           
       
		usleep(1000);
	}
}

main();
?> 
