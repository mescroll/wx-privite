<?php header("content-type:text/html;charset=utf-8");
/**
 * 获取学校和手机号
 * 1.用户都没有储存到数据库
 * 2.储存到数据库了但是没有绑定信息
 * User: 石鹏
 * Date: 2018/11/12
 * Time: 22:13
 */
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mysql/mysql.php";
session_start();
$rtnMsg = "";
if(isset($_SESSION['openid'])){
    $openid = $_SESSION['openid'];
    //检查用户是否存在于数据库
    $sqlStr = "SELECT tel,school FROM userInfo WHERE openid = '$openid'";
    $newSql = new Mysql();
    $rtnSql = $newSql->selectTable($sqlStr,true);
    if($rtnSql){
        //不为空，存在于数据库
        $rtnMsg = $rtnSql;
        //将tel和school保存到session
        $_SESSION['tel'] = $rtnSql['tel'];
        $_SESSION['school']=$rtnSql['school'];
    }
}
var_dump($rtnMsg);
echo json_encode($rtnMsg,JSON_UNESCAPED_UNICODE);
