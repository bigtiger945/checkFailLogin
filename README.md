用php写的防止通过ssh暴力登录linux的脚本.
Script written in PHP to prevent violent login to Linux via SSH.

树莓派上面用fail2ban对资源消耗太大，导致速度严重受影响。所以用php写了个脚本， 不再检查体积庞大的auth.log文件，而是通过lastb的消息进行检查。将爆破的ip写入 hosts.deny文件，效率明显比 fail2ban高。
用crontab每隔几个小时运行一次。
