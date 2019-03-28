<?php header("content-type:text/html;charset=utf-8");
/**
 * 前台抢单池请求数据库的任务列表，返回处理过的数据
 * User: 石鹏
 * Date: 2018/10/14
 * Time: 21:58
 */
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";
session_start();
$page = $_GET["page"];
$size = $_GET["size"];
$dataIndex = $_GET["dataIndex"];
$start = $page * $size;
$openid = $_SESSION['openid'];

$sqlStr = "SELECT school FROM userInfo WHERE openid = 'openid'";
$newSql = new Mysql();
$rtnSql = $newSql->selectTable($sqlStr,true);
if($rtnSql) {
    $school = $rtnSql['school'];

    $newSql = new Mysql();
//0:抢单页;1:已抢页
    if ($dataIndex == 0) {
        $sqlStr = "SELECT * FROM taskSchool WHERE school = '$school' order by `id` desc limit {$start},{$size}";
        $result = $newSql->selectTable($sqlStr, false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else if ($dataIndex == 1) {
        $sqlStr = "SELECT * FROM doingTask WHERE w_openid = '$openid' LIMIT {$start},{$size}";
        $result = $newSql->selectTable($sqlStr, false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}else{
    $result="";
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}