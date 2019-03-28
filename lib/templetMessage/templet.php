<?php
/**
 * 任务领取成功通知
 * User: 石鹏
 * Date: 2018/11/13
 * Time: 22:43
 */
namespace lib\templet;
session_start();
require_once "/data1/www/htdocs/311/flyingman/1/php_unit_public/lib/wx_api/curl.php";
header("content-type:text/html;charset=utf-8");

class templet{
    /**************************************************
     * 接单提醒模板消息
     * 发给发布人，跳转页面展示接单人的信息
     **************************************************/
		//发给发布者的通知
    public function success($nick){
        $w_openid = $_SESSION['openid'];
        $s_openid= $_SESSION['s_openid'];
        $orderNum= $_SESSION['order_number'];
        $task_type= $_SESSION['task_type'];
        $money=$_SESSION['money'];
        $token = $_SESSION['token'];
        $money = $money."元";
        $orderNumNew = "O".$orderNum;
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $post_data = array(
            "touser"=>$s_openid,
            "template_id"=>"asEOYBOG8_MWwrlK2Skd3qpdfckSgEny0_FKOu3SdJU",
            "url"=>"https://flyingman.sc2yun.com/php_unit_public/html/app/templet/success.php?openid=".$w_openid."&orderNum=".$orderNum,
            "data"=>array(
                "first"=>array(
                "value"=>"您好,您的任务已被".$nick."成功领取"
                ),
            "keyword1"=>array(
                "value"=>$orderNumNew,
                "color"=>"#FF7F24"
                ),
            "keyword2"=>array(
                "value"=>$money,
                "color"=>"#FF7F24"
                ),
            "keyword3"=>array(
                "value"=>$task_type,
                "color"=>"#FF7F24"
            	),
            "remark"=>array(
                "value"=>"感谢您使用校园飞侠，有任何问题请及时联系客服，点击“详情”查看接单人信息"
            	)
            )
        );
        $arry = json_encode($post_data,JSON_UNESCAPED_UNICODE);
        $logstr = curlPost($url,$arry);
        $logUrl = "/data1/www/htdocs/311/flyingman/1/php_unit_public/log/templet.log";
        file_put_contents($logUrl,"openid:".$s_openid."，error:".$logstr['errcode']."，errmsg:".$logstr['errmsg']."，msgid".$logstr['msgid']."\n",8);
    }
	//发给接单人的提醒
    public function newTask($w_nick,$time,$s_nick){
        $w_openid = $_SESSION['openid'];
        $task_type= $_SESSION['task_type'];
        $token = $_SESSION['token'];
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $post_data = array(
            "touser"=>$w_openid,
            "template_id"=>"fcHM0Z6RlxUza5Lwco-jLThSw3e3oeuMUT83S2_kH8k",
            "url"=>"https://flyingman.sc2yun.com/php_unit_public/html/app/pool.php",
            "data"=>array(
                "first"=>array(
                    "value"=>$w_nick."同学,您已成功领取任务，请尽快处理哦"
                ),
                "keynote1"=>array(
                    "value"=>$time,
                    "color"=>"#173177"
                ),
                "keynote2"=>array(
                    "value"=>$task_type,
                    "color"=>"#173177"
                ),
                "keynote3"=>array(
                    "value"=>$s_nick,
                    "color"=>"#173177"
                ),
                "keynote4"=>array(
                    "value"=>"祝您任务顺利，早日晋升老司机",
                    "color"=>"#173177"
                ),
                "remark"=>array(
                    "value"=>"感谢您使用校园飞侠，有任何问题请及时联系客服，点击“详情”查看任务详情"
                )
            )
        );
        $arry = json_encode($post_data,JSON_UNESCAPED_UNICODE);
        curlPost($url,$arry);
    }
}
