#!/bin/bash
 
PHPSCRIPTDIR="/opt/php5/bin/php"
ROOT="/data/vhost/test.xiao.kunlun.com/game_admin"
cd $ROOT
cd crontab
 
$PHPSCRIPTDIR ./BroadcastCront.php
$PHPSCRIPTDIR ./NoticeCront.php