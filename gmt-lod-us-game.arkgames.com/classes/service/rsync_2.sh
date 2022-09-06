#!/bin/bash
cd  /www/wwwroot/lod-us-game.arkgames.com/cfg/
if [ -f "/www/wwwroot/lod-us-game.arkgames.com/cfg/b.txt" ]; then
    rm -rf /www/wwwroot/lod-us-game.arkgames.com/cfg/b.txt
    rsync  -rltpDvP --password-file /tmp/password.txt ./notice/ rsync://global-zlcs-static@us-forward.sync.kunlun.com:30011/global-zlcs-static/cfg/notice
fi

