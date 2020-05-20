#!/bin/bash
lastb >/home/wwwroot/rss/checkFailLogin/lastb.txt
php /home/wwwroot/rss/checkFailLogin/checkFailLogin.php
cat /home/wwwroot/rss/checkFailLogin/desc.txt /etc/hosts.deny

