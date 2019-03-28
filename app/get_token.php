<?php header("content-type:text/html;charset=utf-8");
require_once "/home/www/htdocs/disk/home/privite/lib/wx_api/curl.php";
require_once "/home/www/htdocs/disk/home/privite/lib/mysql/mysql.php";
/*
 * 获取access_token并保存数据库,每1.5小时刷新一次，返回值为可以使用的TOKEN。
 * */
function getToken()
{
    $newSql = new Mysql();
    $sqlStr = "SELECT access_token,timestr FROM token";
    $sqlObj = $newSql->selectTable($sqlStr,true);
    //获取时间戳和token
    $tokenSql = $sqlObj['access_token'];
    $timeSql = $sqlObj['timestr'];

    $timeNow = time();
    if($timeNow < $timeSql+5400){
        $TOKEN = $tokenSql;
//        echo "时间还没到，不用获取！";
//        echo "<br>";
    }else{
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxa507747c7a15f546&secret=11d3dceb35352885375d7bcc82801ed0";
        $tokenArry = curlGet($url);

        $TOKEN = $tokenArry["access_token"];

        $sqlStr = "UPDATE token SET access_token = '$TOKEN',timestr = '$timeNow'";
        $newSql->updateTable($sqlStr);
    }
    return $TOKEN;
}
