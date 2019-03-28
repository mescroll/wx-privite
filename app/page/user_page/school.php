<?php
/**
 * 绑定学校
 * User: 石鹏
 * Date: 2018/11/11
 * Time: 23:53
 */
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";
session_start();
$openid = $_SESSION['openid'];
$code = $_POST['code'];
$name = $_POST['name'];
$rtnMsg = "0";
if ($openid) {
    $sqlStr = "UPDATE userInfo SET  school= '$code',schoolName='$name' WHERE openid = '$openid'";
    $newSql = new Mysql();
    $rtn = $newSql->updateTable($sqlStr);
    if ($sqlStr) {
        $rtnMsg = "1";
    } else {
        $rtnMsg = "0";
    }
}
echo json_encode($rtnMsg,JSON_UNESCAPED_UNICODE);

