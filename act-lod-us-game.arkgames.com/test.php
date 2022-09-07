<?php
define('API_TOKEN', 'jdsjA34DF*&*9DFT@EF*$U4399');




function getServerIP()
{
    if (isset($_SERVER) && isset($_SERVER["SERVER_ADDR"]))
    {
        $realip = $_SERVER["SERVER_ADDR"];
    }
    else
    {
        $realip = getenv("SERVER_ADDR");
    }

    return addslashes($realip);
}

function getClientIp()
{
    if (isset($_SERVER) && isset($_SERVER["REMOTE_ADDR"]))
    {
        $realip = $_SERVER["REMOTE_ADDR"];
    }
    else
    {
        $realip = getenv("REMOTE_ADDR");
    }

    return addslashes($realip);
}

var_dump(getServerIP());
var_dump(getClientIP());exit;


$date     = '2013-06-18';
$time     = time();
$num      = 10;

$flag = md5( $date. $time . API_TOKEN ); //禁言


//$ticket = md5( $nickname + $username + $banTime + $time + API_TOKEN ); //封号

//$ticket = md5( $nickname + $time + API_TOKEN ); //踢人下线

$url = 'http://s1-we4399.jd.kunlun.com/platform/interface_4399.php?act=InterfaceCtrl.getGoldUseLog';

//$url = 'http://s1-we4399.jd.kunlun.com/platform/interface_4399.php?act=InterfaceCtrl.forbidTalk';

//$url = 'http://s1-we4399.jd.kunlun.com/platform/interface_4399.php?act=InterfaceCtrl.setOffLine';

$url .= 'time='.$time.'&pkey='.$flag.'&date='.$date;

echo $url."\r\n";


?>
