<?php header("content-type:text/html;charset=utf-8");
require_once "/home/www/htdocs/disk/home/privite/lib/mysql/mysql.php";

session_start();
$taskType = $_POST["type"];
$money = $_POST['money'];
$time = $_POST['time_limit'];
$ground = $_POST['ground'];
$dest = $_POST['dest'];
$ldest = $_POST['ldest'];
$rtnDate = "0";

//先检查用户是否绑定了手机号和学校
if(isset($_SESSION['openid'])){
    $openid = $_SESSION['openid'];
    //检查用户是否存在于数据库
    $sqlStr = "SELECT tel,school FROM userInfo WHERE openid = '$openid'";
    $newSql = new Mysql();
    $rtnSql = $newSql->selectTable($sqlStr,true);
    if($rtnSql['tel'] && $rtnSql['school']){
        //将tel和school保存到session
        $_SESSION['tel'] = $rtnSql['tel'];
        $_SESSION['school']=$rtnSql['school'];
				$school = $rtnSql['school'];
				if($ground == 'on'){
						$sqlStr = "insert into task(openid,task_type,money,time_limit,ground,dest,ldest,school)
											VALUES ('$openid','$taskType','$money','$time',1,'$dest','$ldest','$school')";
							}else{
								$sqlStr = "insert into taskSchool(openid,task_type,money,time_limit,ground,dest,ldest,school)
													VALUES ('$openid','$taskType','$money','$time',0,'$dest','$ldest','$school')";
							}
				$newSql = new Mysql();
				$rtnSql = $newSql->insertTable($sqlStr);
				if ($rtnSql) {
						$rtnDate = "1";
				} else {
						$rtnDate = "0";
				}
			}else{
				$rtnDate = "2";
			}
}
echo json_encode($rtnDate,JSON_UNESCAPED_UNICODE);
