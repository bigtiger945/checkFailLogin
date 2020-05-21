<?php
$maxFailNum = 10;
$lastbfile = "./lastb.txt";
$descfile = "./desc.txt";
$enablefile = "./enableip.txt";
$denyfile = "./deny.txt";
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
$jb = fopen($descfile, 'w');   //把文件清空
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
                        $str .= 'sshd:'.$k .':deny'. "\n";          //将ip记录下来，准备写入文件
                    }
                }
            }
        }
        if (strlen($str) > 0) {
            fwrite($jb, $str);
            $jb2 = fopen($denyfile, 'a');
            fwrite($jb2, $str);
            fclose($jb2);
        }
    }
}
fclose($jb);
