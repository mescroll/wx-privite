<?php
/**
 * 文章列表处理
 * User: 石鹏
 * Date: 2018/12/6
 * Time: 14:21
 */
require_once "/home/www/htdocs/disk/home/public/lib/mysql/mysql.php";
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
        $db = "prose";
        break;
    case 1:
        $db = "proseTwo";
        break;
    case 2:
        $db = "proseThree";
        break;
}
$sqlStr = "SELECT `art_id`,`dest`,`ldest`,`imageUrl` FROM  {$db} ORDER BY `art_id` DESC LIMIT {$start},{$size}";

$newSql = new Mysql();
$rtn = $newSql->selectTable($sqlStr,false);

if($rtn){
    $str = $rtn;
}else{
    $str="";
}
echo json_encode($str,JSON_UNESCAPED_UNICODE);
