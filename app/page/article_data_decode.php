<?php
/**
 * 文章列表处理
 * User: 石鹏
 * Date: 2018/10/27
 * Time: 15:47
 */
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";
//$word = $_GET["curWord"];
header("content-type:text/html;charset=utf-8");
header("access-control-allow-origin: *");
$dataIndex = $_GET["dataIndex"];//要获取的文章类型
//0：电脑装备  1：手机技巧  2：一抹时光  3：好物推荐
$page = $_GET["page"];
$size = $_GET["size"];
$start = $page * $size;
switch ($dataIndex){
    case 0:
        $db = "phone";
        break;
    case 1:
        $db = "phone";
        break;
    case 2:
        $db = "prose";
        break;
    case 3:
        $db = "phone";
        break;
}
$sqlStr = "SELECT * FROM  {$db} order by `id` desc LIMIT {$start},{$size}";
$newSql = new Mysql();
$rtn = $newSql->selectTable($sqlStr,false);
if($rtn){
    $str = $rtn;
}else{
    $str="";
}
echo json_encode($str,JSON_UNESCAPED_UNICODE);