<?php
/**
 * 微信网页OAuth2.0授权获取用户信息,并保存到数据库
 * User: 石鹏
 * Date: 2018/10/29
 * Time: 21:42
 */
namespace lib;
require_once "/home/www/htdocs/disk/home/privite/lib/mysql/mysql.php";
require_once "/home/www/htdocs/disk/home/privite/lib/wx_api/curl.php";
$nowUrl = "http://xiaoyuanfeixia.com/privite/html/app/task.html";
    if (isset($_GET["code"])){
        $abc =  new getUserInfo();
        session_start();
        $rtn = $abc->getAccessToken($_GET["code"]);
        $_SESSION['openid'] = $rtn["openid"];
        //$abc->backPage($nowUrl);
        header("Location:".$nowUrl);
    }
//网页授权基类
class getUserInfo{
    private $appid = "wxa507747c7a15f546";
    private $appsecret = "11d3dceb35352885375d7bcc82801ed0";


    public function getCode($redirect,$scope){
//        if ($scope){
//            $scope = "snsapi_userinfo";
//        }else{
//            $scope = "snsapi_base";
//        }
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appid&redirect_uri=$redirect&response_type=code&scope=$scope#wechat_redirect";
        $result = curlGet($url);
        if($result["errcode"]){
            echo "<h2>系统内部错误，请求微信接口获取code失败</h2>";
            die();
        }
    }
    //通过coe换取网页授权的access_token和openid
    public function getAccessToken($code){
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsecret&code=$code&grant_type=authorization_code";
        $result = curlGet($url);
        if (isset($result['access_token'])){
            return $result;
        }else{
            echo "获取access_token失败！";
            die();
            /*result的内容，json格式
            参数	                                 描述
            access_token	    网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
            expires_in	        access_token接口调用凭证超时时间，单位（秒）
            refresh_token	    用户刷新access_token
            openid	            用户唯一标识，请注意，在未关注公众号时，用户访问公众号的网页，也会产生一个用户和公众号唯一的OpenID
            scope	            用户授权的作用域，使用逗号（,）分隔
            */
        }
    }
    //跳转回请求页面
    public function backPage($url){
        header($url);
    }
}
