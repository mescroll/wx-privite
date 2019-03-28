<?php
/**
 * 用来处理发送模板消息的函数
 * 1:接单提醒-发布任务人;订单提醒-领取任务人
 *
 * User: 石鹏
 * Date: 2018/11/14
 * Time: 20:41
 */
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/templetMessage/templet.php";
require "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/app/get_token.php";

header("content-type:text/html;charset=utf-8");
$tem = new \lib\templet\templet();
session_start();
$messageFlag = $_GET['flag'];//前台请求的模板类型
$openid = $_SESSION['openid'];//当前抢单者的openid
$token = getToken();
$_SESSION['token']=$token;
$logurl = "/data1/www/htdocs/311/flyingman/1/php_unit_public/log/err.log";
file_put_contents('/data1/www/htdocs/311/flyingman/1/php_unit_public/log/err.log',$messageFlag,8);
if($messageFlag == '1'){
    //接单提醒，发给任务发布者的，即s_openid
    $s_openid= $_SESSION['s_openid'];//任务发布者的openid
    $order_number= $_SESSION['order_number'];
    $taskType= $_SESSION['task_type'];
    $money=$_SESSION['money'];
    $nick = getNick($openid);
    date_default_timezone_set("PRC");
    $time = date("Y年m月d日 H:i:s");
    //file_put_contents($logurl,$nick,8);
    //$tem->success($token,$openid,$s_openid,$nick,$order_number,$money,$taskType);
    //发给任务发布者
    $tem->success($nick);
    //新订单提醒，发给抢单者，即openid
    $s_nick = getNick($s_openid);//客户nick
    $tem->newTask($nick,$time,$s_nick);
    //销毁部分session变量
    unset($_SESSION['s_openid']);
    unset($_SESSION['order_number']);
    unset($_SESSION['task_type']);
    unset($_SESSION['money']);
    $message = "1";

}else{
    file_put_contents('/data1/www/htdocs/311/flyingman/1/php_unit_public/log/err.log',"没有执行上面函数",8);
    $message = "0";
}
echo json_encode($message,JSON_UNESCAPED_UNICODE);

function getNick($copenid){
    $sqlStr1 = "SELECT nick FROM userInfo WHERE openid = '$copenid'";
    $newSql1 = new Mysql();
    $rtn1 = $newSql1->selectTable($sqlStr1,true);
    return $rtn1['nick'];
}