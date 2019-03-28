<?php header("content-type:text/html;charset=utf-8");
/**
 * 将用户的手机号保存到用户个人信息里
 * User: 石鹏
 * Date: 2018/11/11
 * Time: 2:01
 */
session_start();
$openid = $_SESSION['openid'];
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";

$num = $_POST['telNum'];
$rtnMsg = "0";
$sqlStr = "UPDATE userInfo SET tel = '$num' WHERE openid = '$openid'";
$newSql = new Mysql();
$rtn = $newSql->updateTable($sqlStr);
if ($sqlStr){
    $rtnMsg = "1";
}else{
    $rtnMsg = "0";
}
echo json_encode($rtnMsg,JSON_UNESCAPED_UNICODE);


