<?php
/**
 * 投诉处理
 * 1.邮件发送
 * 2.记录到投诉文件mail.html
 * User: 石鹏
 * Date: 2018/11/17
 * Time: 16:51
 */
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/mailer/emailClass.php";
header("content-type:text/html;charset=utf-8");
header("access-control-allow-origin: *");
$orderNum = $_POST['orderNum'];
date_default_timezone_set("PRC");
$date = date("Y年m月d日 H:i:s");
$text = $_POST['text'];
$con = "<h2>有新的投诉订单：</h2>".
        "<ul>".
            "<li>投诉时间：".$date."</li>".
            "<li>订单号："."O".$orderNum."</li>".
            "<li>投诉内容：".$text."</li>".
        "</ul>"."<hr>";
$tit = "有新的投诉,请注意查看";
$flag=sendMail('capslock_shi@163.com',$tit,$con);
$sendFlag ="<h1>发送状态：</h1>".$flag."<br>";
file_put_contents("/data1/www/htdocs/311/flyingman/1/php_unit_public/log/mail.html",$con,8);
$rtnStr = 1;
echo json_encode($rtnStr,JSON_UNESCAPED_UNICODE);