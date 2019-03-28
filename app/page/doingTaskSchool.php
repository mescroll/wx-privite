<?php
/**
 * 当抢单按钮被按下时的处理程序，先检查是否已被抢；
 * 没有被抢：先得到任务数据，再删除任务，最后插入任务到新表；
 * 已被抢，返回前台被抢了
 * User: 石鹏
 * Date: 2018/11/4
 * Time: 15:48
 */
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";
session_start();
$newSql = new Mysql();
$id = $_GET['id'];

$openid = $_SESSION['openid'];
$nowTime = time();
$message = "4";//1，抢单成功；2，任务已被抢了；3，需要完善资料;4,抢单失败
//在任务表查找此任务是否存在
	$sqlStr = "SELECT * FROM taskSchool WHERE `id` = $id";
	$rtn = $newSql->selectTable($sqlStr,true);

if ($rtn){
    //如果此条任务存在，先从task表删除，再将这条任务储存到doingTask表中，
    //生成订单号
    $order_number = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    $_SESSION['order_number'] = $order_number;//订单号保存
    $s_openid = $rtn['openid'];
    $_SESSION['s_openid']=$s_openid;//发布者openid保存
    $taskType = $rtn['task_type'];
    $_SESSION['task_type']=$taskType;//任务类型保存
    $money = $rtn['money'];
    $_SESSION['money'] = $money;//保存金额
    $time_limit = $rtn['time_limit'];
    $ground = $rtn['ground'];
    $dest = $rtn['dest'];
    $ldest = $rtn['ldest'];
    $school = $rtn['school'];
    //删除task表的此条任务
        $sqlStr = "DELETE FROM taskSchool WHERE `id` = $id";
        $rtn = $newSql->dropTable($sqlStr);
		
        if ($rtn) {
            $sqlStr = "insert into doingTask(task_num,s_openid,w_openid,task_type,money,time_limit,time_now,ground,dest,ldest,school)
                  VALUES ('$order_number','$s_openid','$openid','$taskType','$money','$time_limit','$nowTime','$ground','$dest','$ldest',$school) ";
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