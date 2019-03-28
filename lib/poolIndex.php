<?php
/**
 * 抢单池首页
 * User: 石鹏
 * Date: 2018/11/4
 * Time: 21:17
 */
namespace lib;
require_once "/home/www/htdocs/disk/home/privite/lib/mysql/mysql.php";
require_once "/home/www/htdocs/disk/home/privite/lib/wx_api/curl.php";
$nowUrl = "http://xiaoyuanfeixia.com/privite/html/app/pool.php";
if (isset($_GET["code"])){
    $abc =  new getUserInfo();
    session_start();
    $rtn = $abc->getAccessToken($_GET["code"]);
    $_SESSION['openid'] = $rtn["openid"];
    header("Location:".$nowUrl);
}
//网页授权基类
class getUserInfo
{
    private $appid = "wxa507747c7a15f546";
    private $appsecret = "11d3dceb35352885375d7bcc82801ed0";

    public function getCode($redirect, $scope)
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appid&redirect_uri=$redirect&response_type=code&scope=$scope#wechat_redirect";
        $result = curlGet($url);
        if ($result["errcode"]) {
            echo "<h2>系统内部错误，请求微信接口获取code失败</h2>";
            die();
        }
    }

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
        //跳转回请求页面
        public function backPage($url)
        {
            header($url);
        }
    }