<?php
/**
 * 跳转学校页面的菜单--静默授权
 * User: 石鹏
 * Date: 2018/11/12
 * Time: 23:01
 */
require_once "/home/www/htdocs/disk/home/privite/lib/wx_api/curl.php";
$nowUrl = "http://xiaoyuanfeixia.com/privite/html/app/poolSchool.html";
$abc = new getUserInfo();
$rtn = $abc->getAccessToken($_GET["code"]);
$_SESSION['openid'] = $rtn["openid"];
header("Location:".$nowUrl);
//网页授权基类
class getUserInfo
{
    private $appid = "wxa507747c7a15f546";
    private $appsecret = "11d3dceb35352885375d7bcc82801ed0";

    //通过coe换取网页授权的access_token和openid
    public function getAccessToken($code)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsecret&code=$code&grant_type=authorization_code";
        $result = curlGet($url);
        if (isset($result['access_token'])) {
            return $result;
        } else {
            echo "获取access_token失败！";
            die();
        }
    }

}