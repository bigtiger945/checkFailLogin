#!/bin/bash
currentDir = $(cd $(dirname $0)
lastb >/dev/shm/lastb.txt
rm /dev/shm/desc.txt
/usr/bin/php /www/checkFailLogin/checkFailLogin.php
if [ -f /dev/shm/desc.txt ]; then 
	cat /dev/shm/desc.txt >> /etc/hosts.deny
fi
