<?php
/**
 * 获取抢单人的手机号，头像，姓名,信用分,历史订单数
 * User: 石鹏
 * Date: 2018/11/17
 * Time: 16:02
 */
namespace page\templet;
header("content-type:text/html;charset=utf-8");
header("access-control-allow-origin: *");
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";
session_start();
$w_openid = $_POST['w_openid'];
getInfo($w_openid);

function getInfo($w_openid){
    $newSql = new \Mysql();
    $sqlStr ="SELECT `nick`,tel,headimg,task_old,score FROM userInfo WHERE openid = '$w_openid'";
    $rtn = $newSql->selectTable($sqlStr,true);
    if($rtn){
        $rtnstr = $rtn;
    }else{
        $rtnstr = "";
    }
    echo json_encode($rtnstr,JSON_UNESCAPED_UNICODE);
}

