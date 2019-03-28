<?php header("content-type:text/html;charset=utf-8");
require_once "../lib/wx_api/curl.php";
require_once "./get_token.php";
/**
 * 自定义菜单
 */
$date =
'{
    "button": [
        {
            "name": "乐于助人",
            "sub_button": [
                {
                    "type": "view",
                    "name": "全国抢单池",
                    "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxa507747c7a15f546&redirect_uri=http%3a%2f%2fxiaoyuanfeixia.com%2fprivite%2flib%2fpoolIndex.php&response_type=code&scope=snsapi_base&state=1#wechat_redirect"
                },
                {
                    "type": "view",
                    "name": "本校抢单池",
                    "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxa507747c7a15f546&redirect_uri=https%3a%2f%2fflyingman.sc2yun.com%2fphp_unit_privite%2flib%2fautho%2fpoolSchool.php&response_type=code&scope=snsapi_base&state=1#wechat_redirect"
                },
                {
                    "type": "view",
                    "name": "寻求帮助",
                    "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxa507747c7a15f546&redirect_uri=http%3a%2f%2fxiaoyuanfeixia.com%2fprivite%2flib%2fgetUserInfo.php&response_type=code&scope=snsapi_base&state=1#wechat_redirect"
                }]
            },
            {
                "name": "我的",
                "sub_button": [
                {
                    "type": "view",
                    "name": "个人中心",
                    "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxa507747c7a15f546&redirect_uri=http%3a%2f%2fflyingman.sc2yun.com%2fphp_unit_privite%2flib%2fautho%2fallInfo.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect"
                },
                {
                    "type": "view",
                    "name": "黑科技",
                    "url":"http://xiaoyuanfeixia.com/privite/html/app/sence/article.html"
                },
                {
                    "type": "view",
                    "name": "百度网",
                    "url" : "https://www.baidu.com"
                }]
            }
    ]
}';
$TOKEN = getToken();
$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$TOKEN;
$ret =curlPost($url,$date);
//var_dump($ret);
if($ret['errcode'] == 0){
    echo "请求新建菜单成功";
}else{
    echo $ret['errmsg'];
    echo "请求新建菜单成功";
}
