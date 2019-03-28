<?php
/**
 * 删除已经完成的任务
 * User: 石鹏
 * Date: 2018/11/11
 * Time: 18:47
 */
require_once "/home/www/htdocs/disk/home/privite/lib/mysql/mysql.php";

$num = $_POST['id'];
$rtnMsg = "0";
$sqlStr = "DELETE FROM doingTask WHERE `id`='$num'";
$newSql = new Mysql();
$rtn = $newSql->dropTable($sqlStr);
if ($rtn){
    $rtnMsg = "1";
}else{
    $rtnMsg = "0";
}
echo json_encode($rtnMsg,JSON_UNESCAPED_UNICODE);