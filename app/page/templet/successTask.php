<?php
/**
 * 查询订单信息
 * User: 石鹏
 * Date: 2018/11/17
 * Time: 16:27
 */
namespace app\page\templet;
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";
header("content-type:text/html;charset=utf-8");
header("access-control-allow-origin: *");
$orderNum = $_POST['task_num'];
getTaskInfo($orderNum);

function getTaskInfo($orderNum){
    $sqlStr = "SELECT * FROM doingTask WHERE task_num = '$orderNum'";
    $newSql = new \Mysql();
    $rtn = $newSql->selectTable($sqlStr,true);
    if ($rtn){
        $rtnstr = $rtn;
    }else{
        $rtnstr = "";
    }
    echo json_encode($rtnstr,JSON_UNESCAPED_UNICODE);
}