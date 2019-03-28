<?php
/**
 * 从数据库抓取用户信息
 * User: 石鹏
 * Date: 2018/11/11
 * Time: 3:04
 */
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";

session_start();
$openid = $_SESSION['openid'];

$sqlStr = "SELECT * FROM userInfo WHERE openid = '$openid'";
$newSql = new Mysql();
$rtn = $newSql->selectTable($sqlStr,true);
if ($rtn){
    echo json_encode($rtn,JSON_UNESCAPED_UNICODE);
}else{
    echo "error";
}