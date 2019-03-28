<?php
require_once 'wether.php';//包含文件，以使可以调用该文件的方法
//$wetherReplay = new wetherReplay();
//回复消息类
require_once '/home/www/htdocs/disk/home/privite/app/get_token.php';

class ReplyMsageUntion{
//回复消息选择器
    public function messageSwitch()
    {
        $postStr = file_get_contents('php://input');
        $path = "/home/www/htdocs/disk/home/privite/logs/replay.log";
//        $hadle = fopen($path,'w+');
        $str = "收到的数据是：".$postStr."\n";
//        fwrite($hadle,$str);
//        fclose($hadle);
        file_put_contents($path,$str,8);

        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

            switch ($postObj->MsgType) {
                case 'event':
                    if (strtolower($postObj->Event) == 'subscribe'){
                        $this->replaySub($postObj);
                    }
                case 'text':
                    $this->replayText($postObj);
                    break;
                case  'image':
                    $this->replayImage($postObj);
                    break;
                case 'voice':
                    $this->replayAudio($postObj);
                case 'video';
                    $this->replayVideo($postObj);
            }
        }else
            echo "";
    }
    //文本消息回复函数
    private function replayText($postObj)
    {
        $wetherReplay = new wetherReplay();//new一个对象才可以调用生成URL方法
        $fromUser = $postObj->FromUserName;
        $toUser = $postObj->ToUserName;
        $mType = $postObj->MsgType;
        $keyWord = trim($postObj->Content);
        $time = date("Y:m:d H:i:s", time());

        //如果消息中包含天气，则回复天气预报
        if(strstr($keyWord,"天气")){//strstr()用来检测是否有固定字符串出现
            $lenthContent = mb_strlen($keyWord,'utf-8');//判断用户输入的字符串长度
            $pos = mb_substr($keyWord,0,$lenthContent-2,'utf-8');//截取城市名字
            $wetherRet = $wetherReplay->wetherCallBackTest($pos);//调用天气生成URL方法
            $textStr = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName> 
                <FromUserName><![CDATA[%s]]></FromUserName> 
                <CreateTime>%s</CreateTime> 
                <MsgType><![CDATA[%s]]></MsgType> 
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag>
            </xml>";
            $resultStr = sprintf($textStr,$fromUser,$toUser, $time, $mType,$wetherRet);
            echo $resultStr;
        }else{
 //       $time = date("Y:m:d H:i:s", time());

            $textStr = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName> 
                <FromUserName><![CDATA[%s]]></FromUserName> 
                <CreateTime>%s</CreateTime> 
                <MsgType><![CDATA[%s]]></MsgType> 
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag>
            </xml>";
            // if (!empty($keyWord)){
            $contentStr = "已收到您的消息:".$postObj->Content ."\n" ."发送时间" .$time;
            $resultStr = sprintf($textStr,$fromUser,$toUser, $time, $mType,$contentStr);
            echo $resultStr;
        }
    }
     //图片消息回复函数
    private function replayImage($postObj){
        $fromUser = $postObj->FromUserName;
        $toUser = $postObj->ToUserName;
        $mType = $postObj->MsgType;

        $time = date("Y:m:d H:i:s", time());
        $imageStr = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Image>
                <MediaId><![CDATA[%s]]></MediaId>
            </Image>
            </xml>";
        //$contentStr = "您发送的是一张图片，点击以下链接查看："."\n" .$postObj->MediaId;
        //$resultStr = sprintf($imageStr,$fromUser,$toUser,$time,$mType,$contentStr);
        echo $resultStr;
    }
    //回复语音消息
    private function replayAudio($postObj){
        $fromUser = $postObj->FromUserName;
        $toUser = $postObj->ToUserName;
        $mType = $postObj->MsgType;
        $time = date("Y:m:d H:i:s", time());

        $audeoStr = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Voice>
                <MediaId><![CDATA[%s]]></MediaId>
            </Voice>
        </xml>";
        $resultStr = sprintf($audeoStr,$fromUser,$toUser,$time,$mType,$postObj->MediaId);
        echo $resultStr;
    }
    //回复视频消息
    private function replayVideo($postObj){
        $fromUser = $postObj->FromUserName;
        $toUser = $postObj->ToUserName;
        $mType = $postObj->MsgType;
        $time = time();

        $videoStr = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Video>
                <MediaId><![CDATA[%s]]></MediaId>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
            </Video>
            </xml>";

          //  $contentTitle = "视频消息";
         //   $contentDesc = "点击即可观看";
            $resultStr = sprintf($videoStr,$fromUser,$toUser,$time,$mType,$postObj->MediaId);
            echo $resultStr;
    }
    //关注自动回复
    private function replaySub($postObj){
        $TOKEN = getToken();
        $fromUser = $postObj->FromUserName;
        $toUser = $postObj->ToUserName;
        $mType = "text";
        $time = date("Y:m:d H:i:s", time());
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$TOKEN."&openid=".$fromUser;
        $result = $this->curlGet($url);
        $name = $result["nickname"];
        $sex = $result["sex"];
        if (sex == 1){
            $sexStr = "小哥哥";
        }elseif ($sex == 2){
            $sexStr = "小姐姐";
        }else{
            $sexStr = "同学";
        }

        $content = "
⊙亲爱的   $name    $sexStr  欢迎关注校园飞侠。
⊙如果您有什么意见和建议，请后台留言。
⊙目前我们提供了一个简单的天气查询，在后台回复城市+天气即可查询。
⊙还可以尝鲜体验抢单，发布任务功能。
";

        $textStr = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName> 
                <FromUserName><![CDATA[%s]]></FromUserName> 
                <CreateTime>%s</CreateTime> 
                <MsgType><![CDATA[%s]]></MsgType> 
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag>
            </xml>";
        $resultStr = sprintf($textStr,$fromUser,$toUser, $time, $mType,$content);
        echo $resultStr;
    }
    private function curlGet($url){
        $ch = curl_init();//c初始化一个cURL会话
        curl_setopt($ch, CURLOPT_URL, $url);//将URL设置为我们需要的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);//获取json返回数据
        curl_close($ch);
        //返回json_decode处理过的数组
        return(json_decode($output, true));
    }
}

