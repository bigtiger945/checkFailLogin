#!/bin/bash
lastb >/dev/shm/lastb.txt
/usr/bin/php /home/3w/sites/checkFailLogin/checkFailLogin.php

if [ -f deny.txt ]; then 
	cat /dev/shm/deny.txt >> /etc/hosts.deny;
fi
