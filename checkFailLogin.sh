#!/bin/bash
lastb >/home/checkFailLogin/lastb.txt
php /home/checkFailLogin/checkFailLogin.php
cat /home/checkFailLogin/desc.txt /etc/hosts.deny

