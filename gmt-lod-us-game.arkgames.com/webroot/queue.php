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
 * 日志
 * @param string $str
 */
function do_log($str='')
{
    $path = "./queue_log.php" ;

    if (file_exists($path)) {
        $fh = fopen($path, 'a');
        fwrite($fh, ' -- ['. date('Y-m-d H:i:s') .'] ---- ' . $str . "\r\n");
    } else {
        $fh = fopen($path, 'wb');
        fwrite($fh,' -- ['. date('Y-m-d H:i:s') .'] ---- ' . $str . "\r\n");
        chmod($path, 0777);
    }
    fclose($fh);
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
	if ($GLOBALS['queueport'] != 0) 
	{
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $ret = socket_bind($sock, "127.0.0.1", $GLOBALS['queueport']);
                
        if (!$ret) 
        {
            printmsg("Can not bind to {$GLOBALS['queueport']}");
            exit;
        }
        socket_listen($sock);
    }
    printmsg("Queue started");
    while (true) 
	{
        if ($GLOBALS['flag_exit'] || $GLOBALS['flag_restart']) 
		{
            if ($GLOBALS['queueport'] != 0) 
			{
                socket_close($sock);
            }
            die(date("H:i:s") . ' Shutdown Queue On '.date('Y-m-d H:i:s') . "!\n");
        }
		notify_ppid();
        $queueList = array();
        //实例化主库数据库操作对象
        $mainPDO = \framework\data\pdo\PDOManager::getInstance('default');
        $querueHelper = new \framework\data\pdo\PDOHelper('entity\\Queue');
        $serverHelper = new \framework\data\pdo\PDOHelper('entity\\Service');
        $querueHelper->setPdo($mainPDO);
        $serverHelper->setPdo($mainPDO);
        $queueList = $querueHelper->fetchAll(" 1 AND (status=0 or status=4) ",null," * "," id asc ","0,100");
        if (!empty($queueList) && is_array($queueList) && count($queueList) >= 1) 
		{

            do_log('要发的邮件数据'.json_encode($queueList));
			foreach ($queueList as $key => $queueEtt) {
                $serverList = array();
                $q_start = microtime();
                $tmp_is_all = false;
                $db_status = $queueEtt['status'];



                if ($queueEtt['serverList'] == 9999)
                {
                    $tmp_is_all = true;
                    //所有服
                    $tmp_where = " productId='{$queueEtt['productId']}' AND serverGroup='{$queueEtt['serverGroup']}'  ";
                    $tmp_all_server = $serverHelper->fetchAll($tmp_where,null," serverId ");
                    if (!empty($tmp_all_server))
                    {
                        foreach($tmp_all_server as $tmp_info)
                        {
                            $serverList[] = $tmp_info['serverId'];
                        }

                        //@file_put_contents('/tmp/log_gmt_queue.log', json_encode($serverList)."\r\n", FILE_APPEND);
                    }
                }
                else
                {
                    if(strstr($queueEtt['serverList'],','))
    				{
                        $serverList = explode(',',$queueEtt['serverList']);
                    }else{
                        $serverList[] = $queueEtt['serverList'];
                    }
                }

                do_log('服务切列表'.json_encode($serverList));
            	//实例化运营方数据库操作对象
	            $operPDO = \framework\data\pdo\PDOLogManager::getInstance('default',$queueEtt['serverGroup']."_".$queueEtt['productId']);
    	        $operHelper = new \framework\data\pdo\PDONewHelper();
        	    $operHelper->setPdo($operPDO);
            	$operHelper->setTableName("actionlog");
	            $restParm = unserialize($queueEtt['dataResult']);
	            
    	        if(empty($restParm['queueData']) && isset($restParm['fileUrl'])  && !empty($restParm['fileUrl']))
				{
                	$restParm['queueData'] = base64_encode(file_get_contents($restParm['fileUrl']));
                	unset($restParm['fileUrl']);
            	}
				$optarr=array('Rest_Awards'=>'发送道具','Rest_setShop'=>'商城配置');	
                $cnt_fail = 0;
                $cnt_succ = 0;
                $cnt_total = 0;
                $msg_fail = '';
                foreach($serverList as $sid)
				{
                    $cnt_total++;
					$tmp_param = $restParm;
					$tmp_param['record'] = $queueEtt;
					$db_status == 4 && $tmp_param['do_recall'] = 1;

                	$GameUrl = $serverHelper->fetchEntity(" serverId='{$sid}' AND productId='{$queueEtt['productId']}' AND serverGroup='{$queueEtt['serverGroup']}'  ",null," serverUrl ");
	                $reusult = \common\Rest::CallRestInterFace($queueEtt['interfaceName'],$GameUrl->serverUrl.RESTSUFFIX,$tmp_param);
                    do_log('发送的服务器地址信息'.json_encode(" serverId='{$sid}' AND productId='{$queueEtt['productId']}' AND serverGroup='{$queueEtt['serverGroup']}'  ",null," serverUrl ".$queueEtt['interfaceName']."#".$GameUrl->serverUrl.RESTSUFFIX."#".$tmp_param));
    	            $reStatus = $reusult['retcode'] == 0 ? 1 : 2;

                    if ($db_status == 4)
                    {
                        $reStatus = $reusult['retcode'] == 0 ? 5 : 6;
                    }

        	        $msg = !empty($reusult['retmsg']) ? $reusult['retmsg'] : '数据操作成功';
                    $iarr = array();
                    $iarr['status'] = $reStatus;
               	 	$iarr['description'] = $msg;
	                $filed  = array('status','description');
    	            $querueHelper->update($filed,$iarr," id='{$queueEtt['id']}' ");
                    if($reStatus == 1)
                    {
                        $cnt_succ++;
                    }
                    else
                    {
                        $msg_fail .= $sid.'('.$msg.'), ';
                        $cnt_fail++;
                    }

        	        $larr->serverId = $sid;
					//TODO 优化
					if($queueEtt['interfaceName'] == 'Rest_Awards') {$larr->actkey = 'gmt_action_33'; $larr->acttitle = '确认道具发送';}
					//if($queueEtt['interfaceName'] == 'Rest_setShop') {$larr->actkey = 'gmt_action_45'; $larr->acttitle = '商城配置修改';}
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

                if ($tmp_is_all)
                {
                    $reStatus = $cnt_succ > 0 ? 1: 2;

                    if ($db_status == 4)
                    {
                        $reStatus = $cnt_succ > 0 ? 5 : 6;
                    }

                    $iarr = array();
                    $iarr['status'] = $reStatus;
                    $iarr['description'] = "总数($cnt_total)|成功($cnt_succ)|失败($cnt_fail)";
                    !empty($msg_fail) && $iarr['description'] .= " -- $msg_fail";

                    $filed  = array('status','description');
                    $querueHelper->update($filed,$iarr," id='{$queueEtt['id']}' ");
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
	mt_srand((double)microtime() * 1000000);
	// setup signal handlers
	pcntl_signal(SIGTERM, "webroot\queue\sig_handler");
	pcntl_signal(SIGINT,  "webroot\queue\sig_handler");
	pcntl_signal(SIGHUP,  "webroot\queue\sig_handler");
	pcntl_signal(SIGCHLD, "webroot\queue\sig_handler");
	pcntl_signal(SIGUSR1, "webroot\queue\sig_handler");

	$pid = 0;

    while (1) 
	{
        $hourmin = date("H:i");
		$islack = ($GLOBALS['flag_lasttime'] > 0 && time() - $GLOBALS['flag_lasttime'] > 10 && ($hourmin >= "00:01" && $hourmin < "03:59" || $hourmin >= "04:
31" && $hourmin < "23:59"));
        if ($pid != 0 && ($GLOBALS['flag_childexit'] || $GLOBALS['flag_restart'] || $GLOBALS['flag_exit'] || $islack)) 
		{
            if (!$GLOBALS['flag_childexit']) 
			{
                posix_kill($pid, SIGHUP);
            }

            $ret = pcntl_waitpid($pid, $status);
            if (!$ret || $pid != $ret) 
			{
                printmsg("waitpid error: $pid, return: $ret $status");
            }

            printmsg("Queue stopped: $pid");
            if ($GLOBALS['flag_lasttime'] == 0) 
			{
                printmsg("Server exit, flag_lasttime = 0");
                exit;
            }

            $pid = 0;
            $GLOBALS['flag_restart'] = true;
            $GLOBALS['flag_lasttime'] = time();
        } else if ($pid == 0 && $GLOBALS['flag_exit']) {
            printmsg("Server exit, flag_exit = true");
            exit;
        } else if ($pid == 0 && $GLOBALS['flag_restart']) {

            $GLOBALS['start_times'] ++;
            $GLOBALS['flag_restart'] = false;
            $GLOBALS['flag_childexit'] = false;

            $pid = pcntl_fork();
            if ($pid == -1) 
			{
                die("Could Not Fork!\n");
            } else if ($pid == 0) {
                if (!posix_setsid()) die("Could Not Detach From Terminal!\n");
                queueLoop();
                exit;
            } else if ($GLOBALS['queueport'] == 0) {
                exit;
            }
        }
		usleep(1000);
	}
}

main();
?> 
