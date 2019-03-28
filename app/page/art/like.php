<?php header("content-type:text/html;charset=utf-8");
/**
 * 点赞和阅读量
 * User: 石鹏
 * Date: 2018/12/5
 * Time: 2:08
 */
require_once "/home/www/htdocs/disk/home/public/lib/mysql/mysql.php";

$artType = $_POST['artType'];
$dataIndex = $_POST['dataIndex'];
$id = $_POST['id'];
$type = $_POST['dataType'];
$count = $_POST['count'];

if($artType == 1){
    switch ($dataIndex){
        case 0:
            //电脑装备
            $db = "phone";
            break;
        case 1:
            //手机技巧
            $db = "phoneNew";
            break;
        case 2:
            //一抹时光
            $db = "news";
            break;
        case 3:
            //好物推荐
            $db = "goodsArt";
            break;
    }
}else{
    switch ($dataIndex){
        case 0:
            //一抹时光
            $db = "prose";
            break;
        case 1:
            //陌上花开
            $db = "proseTwo";
            break;
        case 2:
            //岁月清浅
            $db = "proseThree";
            break;
    }
}

switch ($type){
    case 1: addRead($db,$id,$count);
    break;
    case 2: addLike($db,$id,$count);
    break;
}

/*阅读+1*/
function addRead($db,$id,$count){
    $count += 1;
    $sqlStr = "UPDATE {$db} SET `read` = '$count' WHERE art_id = '$id'";
    $newSql = new Mysql();
    $newSql->updateTable($sqlStr);
}

/*点赞+1*/
function addLike($db,$id,$count){
    $count += 1;
    $sqlStr = "UPDATE {$db} SET `like` = '$count' WHERE art_id = '$id'";
    $newSql = new Mysql();
    $newSql->updateTable($sqlStr);
}
$rtnMsg = "1";
echo json_encode($rtnMsg,JSON_UNESCAPED_UNICODE);