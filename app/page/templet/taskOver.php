<?php
/**
 * 确认收货处理
 * User: 石鹏
 * Date: 2018/11/17
 * Time: 18:24
 */
namespace app\page\templet;
header("content-type:text/html;charset=utf-8");
header("access-control-allow-origin: *");
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";
$orderNum = $_POST['orderNum'];
$w_openid = $_POST['w_openid'];
$task_old = $_POST['task_old'];
changeFlag($orderNum,$w_openid,$task_old);

//状态改变
function changeFlag($orderNum,$w_openid,$task_old){
    $task_old+=1;
    $sqlStr = "UPDATE  `doingTask` SET `task_flag` = 1 WHERE  `task_num` = '$orderNum'";
    $newSql = new \Mysql();
    $rtn = $newSql->updateTable($sqlStr);
    if ($rtn){
        taskOld($w_openid,$task_old);
        $rtnstr = 1;
    }else{
        $rtnstr = 0;
    }
    echo json_encode($rtnstr,JSON_UNESCAPED_UNICODE);
}
//抢单人完成任务数+1
function taskOld($w_openid,$task_old){
    $sqlStr = "UPDATE  `userInfo` SET `task_old`='$task_old' WHERE  `openid` = '$w_openid'";
    $newSql = new \Mysql();
    $newSql->updateTable($sqlStr);
}