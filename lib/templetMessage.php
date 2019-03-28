<?php
/**
 * 发送模板消息：任务已被领取
 * User: 石鹏
 * Date: 2018/11/6
 * Time: 0:42
 */
namespace lib;
header("content-type:text/html;charset=utf-8");
require_once "/home/www/htdocs/disk/home/privite/lib/mysql/mysql.php";
require_once "/home/www/htdocs/disk/home/privite/lib/wx_api/curl.php";

class templetMessage
{
    private $token = getToken();
    function taskOver()
    {

        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->token;
        $name = "石鹏";
        $arry=array(
            "touser" => "oZdZj0mZxErooxrIkUpiDSwAB52Q",
            "template_id"=>"Olh2bDcYsVcoT3ih06HRBhsI3KCfVRB6ZRXIXtfHyL8",
            "url"=>"www.baidu.com",
            "data" => array(
                "name"=>array(
                    "value"=>$name,
                    "color"=>"#173177",
                ),

            ),
        );
        $arry = json_encode($arry,JSON_UNESCAPED_UNICODE);
        echo(curlPost($url,$arry));
    }
}
$a = new templetMessage();
$a->taskOver();