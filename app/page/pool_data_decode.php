<?php header("content-type:text/html;charset=utf-8");
/**
 * 前台抢单池请求数据库的任务列表，返回处理过的数据
 * User: 石鹏
 * Date: 2018/10/14
 * Time: 21:58
 */
session_start();
require_once "/home/www/htdocs/disk/home/privite/lib/mysql/mysql.php";
$page = $_GET["page"];
$size = $_GET["size"];
$dataIndex = $_GET["dataIndex"];
$start = $page * $size;
$openid = $_SESSION['openid'];

$newSql = new Mysql();
//0:抢单页;1:已抢页
if ($dataIndex == 0) {
	$sqlStr = "SELECT * FROM task  order by `id` desc limit {$start},{$size}";
	$result = $newSql->selectTable($sqlStr,false);
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
}else if ($dataIndex == 1){
    $sqlStr = "SELECT * FROM doingTask WHERE w_openid = '$openid' LIMIT {$start},{$size}";
    $result = $newSql->selectTable($sqlStr,false);
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}