<?php header("content-type:text/html;charset=utf-8");
/**
 * 创建curl请求API
 */
function curlGet($url){
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
function curlPost($url,$date){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,1);//设置post模式
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$date);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    $output = curl_exec($ch);
    if(curl_errno($ch)){
        echo curl_errno($ch)."<br>";
    }
    var_dump($output);
    curl_close($ch);
    return(json_decode($output,true));
}