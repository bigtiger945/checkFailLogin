#!/bin/bash
lastb >/dev/shm/lastb.txt
rm /dev/shm/desc.txt
/usr/bin/php /home/3w/sites/checkFailLogin/checkFailLogin.php
if [ -f /dev/shm/desc.txt ]; then 
	cat /dev/shm/desc.txt >> /etc/hosts.deny
fi
