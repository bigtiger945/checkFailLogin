<?php
include "./smtp.class.php";
$maxFailNum = 10;
//$dir="./";
dir="/dev/shm/";
$lastbfile = "{$dir}lastb.txt";
$descfile = "{$dir}desc.txt";
$enablefile = "{$dir}enableip.txt";
$denyfile = "{$dir}deny.txt";

$ipreg = "/((25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)\.){3}(25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)/";
//读取白名单中的ip
$enableIp = [];
if (file_exists($enablefile)) {
    preg_match_all($ipreg, file_get_contents($enablefile), $enableIp);
    if (count($enableIp) > 0) {
        $enableIp = $enableIp[0];
    }
}
//读取已阻止的ip清单
$denyIp = [];
if (file_exists($denyfile)) {
    preg_match_all($ipreg, file_get_contents($denyfile), $denyIp);
    if (count($denyIp) > 0) {
        $denyIp = $denyIp[0];
    }
}
//读取lastb日志
$lastbip = [];
if (file_exists($lastbfile)) {
    preg_match_all($ipreg, file_get_contents($lastbfile), $lastbip);
    if (count($lastbip) > 0) {
        $lastbip = $lastbip[0];
        //开始进行检查
        $str = "";
        $ipCount = array_count_values($lastbip);
        foreach ($ipCount as $k => $v) {
            if ($v > $maxFailNum) {
                if (!in_array($k, $enableIp)) {    //如果ip不在白名单内
                    if (!in_array($k, $denyIp)) {  //ip还没有被记录过
                        $str .= 'ALL:'.$k .':deny'. "\n";          //将ip记录下来，准备写入文件
                    }
                }
            }
        }
        if (strlen($str) > 0) {
            $jb = fopen($descfile, 'w');   //把文件清空
            fwrite($jb, $str);
            fclose($jb);
            $jb2 = fopen($denyfile, 'a');
            fwrite($jb2, $str);
	    fclose($jb2);
	    sendmailto('xxxx@qq.com','PI有新的攻击信息，请迅速查看',$str);
        }
    }
}
