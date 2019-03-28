<?php
/**
 * 当抢单按钮被按下时的处理程序，先检查是否已被抢；
 * 没有被抢：先得到任务数据，再删除任务，最后插入任务到新表；
 * 已被抢，返回前台被抢了
 * User: 石鹏
 * Date: 2018/11/4
 * Time: 15:48
 */
require_once "/home/www/htdocs/disk/home/privite/lib/mysql/mysql.php";
$openid = $_GET['openid'];
$newSql = new Mysql();
$idTmp = $_GET['id'];
$id = substr($idTmp,8);
$nowTime = time();
$message = "4";//1，抢单成功；2，任务已被抢了；3，需要完善资料;4,抢单失败
//在任务表查找此任务是否存在
$sqlStr = "SELECT * FROM task WHERE `id` = $id";
$rtn = $newSql->selectTable($sqlStr,true);
if ($rtn){
    //如果此条任务存在，先从task表删除，再将这条任务储存到doingTask表中，
    //生成订单号
    $order_number = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    $s_openid = $rtn['openid'];
    $taskType = $rtn['task_type'];
    $money = $rtn['money'];
    $time_limit = $rtn['time_limit'];
    $ground = $rtn['ground'];
    $dest = $rtn['dest'];
    $ldest = $rtn['ldest'];
    //删除task表的此条任务
        $sqlStr = "DELETE FROM task WHERE `id` = $id";
        $rtn = $newSql->dropTable($sqlStr);
        if ($rtn) {
            $sqlStr = "insert into doingTask(task_num,s_openid,w_openid,task_type,money,time_limit,time_now,dest,ldest)
                  VALUES ('$order_number','$s_openid','$openid','$taskType','$money','$time_limit','$nowTime','$dest','$ldest') ";
            if($rtn = $newSql->insertTable($sqlStr)){
                $message = "1";//插入成功，抢单成功
            }
        }else {
            $message = "4";//删除数据表失败，抢单失败
        }
}else{
   $message = "2" ;//查询不到，任务已经被抢了
}
echo json_encode($message,JSON_UNESCAPED_UNICODE);