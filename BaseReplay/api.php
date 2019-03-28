<?php
require 'replay.php';
define("TOKEN","flyingman");
$wechatObj = new wechatCallBackTest();
$replayMseeg = new ReplyMsageUntion();
    if (!(isset($_GET["echostr"]))){
    $replayMseeg->messageSwitch();
    }else{
    $wechatObj->valid();
    }

class wechatCallBackTest{

//校验签名
        public function valid()
        {
            $signature = $_GET["signature"];//微信返回的加密字符串
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];

            $token = TOKEN;
            $tmpArr = array($token, $timestamp, $nonce);
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode($tmpArr);
            $tmpStr = sha1($tmpStr);

            if ($tmpStr == $signature) {
                echo $_GET["echostr"];
            }
        }
    }


