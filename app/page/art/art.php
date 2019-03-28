<?php header("content-type:text/html;charset=utf-8");
/**
 * 获取文章内容，到前段渲染
 * User: 石鹏
 * Date: 2018/11/21
 * Time: 23:36
 */
require_once "/home/www/htdocs/disk/home/public/lib/mysql/mysql.php";
//cookie获取文章类型和文章id
$dataIndex = $_POST['dataIndex'];
$id = $_POST['id'];
$type = $_POST['type'];

if($type == 1){
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
            //热评
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

$sqlStr = "SELECT `dest`,`ldest`,`imageUrl`,`artice`,`time`,`idName`,`headUrl`,`read`,`like` FROM {$db}  
          INNER JOIN `admin_user` ON admin_user.id  = {$db}.author WHERE `art_id` = '$id'";
$newSql = new Mysql();
$rtn = $newSql->selectTable($sqlStr,true);

if($rtn){
    $rtnStr = $rtn;
    $rtnStr["artice"] = stripcslashes($rtnStr["artice"]);
}else{
    $rtn = "0";
}
echo json_encode($rtnStr,JSON_UNESCAPED_UNICODE);
