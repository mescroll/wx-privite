<?php
/**
 * 手动网页授权.
 * User: 石鹏
 * Date: 2018/11/11
 * Time: 12:24
 */
require_once "/home/www/htdocs/disk/home/privite/lib/mysql/mysql.php";
require_once "/home/www/htdocs/disk/home/privite/lib/wx_api/curl.php";
session_start();
//发送请求
$nowUrl = "http://xiaoyuanfeixia.com/privite/html/app/userInfo.html";
$code = $_GET['code'];
$newInfo = new getInfo();
$rtn = $newInfo->getAccesstoken($code);
$result = $newInfo->getInfoNo($rtn['access_token'],$rtn['openid']);
$_SESSION['openid'] = $rtn["openid"];

$rtn = $newInfo->selectUser($result['openid']);
var_dump($rtn);
if ($rtn){
    $rtn = $newInfo->insertInfo($result);
    if($rtn){
        header("Location:".$nowUrl);
    }else{
        echo "<h1>很抱歉，出错了</h1>";
    }
}else{
    header("Location:".$nowUrl);
}


//网页授权，手动同意,由前一个页面带code进来
class getInfo{
    private $appid = "wxa507747c7a15f546";
    private $appsecret = "11d3dceb35352885375d7bcc82801ed0";
    //获取token
    public function getAccesstoken($code){
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
    //拉去用户信息
    public function getInfoNo($token,$openid){
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
        $result = curlGet($url);
        if ($result["errcode"]){
            echo "获取用户信息失败！";
            die();
        }else {
            return $result;
        }
    }
    //将用户信息插入数据库
    public function insertInfo($result){
        $openid = $result["openid"];
        $nickname = $result["nickname"];
        $sex = $result["sex"];
        $city = $result["city"];
        $headimg = $result["headimgurl"];

        $sqlStr = "INSERT INTO userInfo(openid,nick,sex,city,headimg,score)
                  VALUES ('$openid','$nickname','$sex','$city','$headimg','100')";
        $newsql = new Mysql();
        $rtn = $newsql->insertTable($sqlStr);
        if(!$rtn){
            echo "插入数据失败";
            return false;
        }else{
            return true;
        }
    }
    //查找是否已存在数据库
    public function selectUser($openid){
        $sqlStr = "SELECT openid FROM userInfo WHERE openid='$openid'";
        $newSql = new Mysql();
        $rtn = $newSql->selectTable($sqlStr,true);
        if($rtn == ""){
            return true;
        }else{
            return false;//true为不存在，可以插入
        }
    }
}