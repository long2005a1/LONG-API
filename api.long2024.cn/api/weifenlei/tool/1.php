<?php
header("content-type:application/json; charset=utf-8");
$url = $_REQUEST['url'];
$data=curl($url);

preg_match('/<span id=\"webpage_tdk_title\">(.*?)<\/span>/',$data,$title);//标题
preg_match('/<span id=\"webpage_tdk_keywords\">(.*?)<\/span>/',$data,$keywords);//关键词
preg_match('/<span id=\"webpage_tdk_description\">(.*?)<\/span>/',$data,$description);//描述






echo json_encode(array('code' => 1,'msg'  => '获取成功','title' => $title[1],'keywords' => $keywords[1],'description' => $description[1]),320);   

function curl($url){ //Curl GET
    $ch = curl_init();     // Curl 初始化  
    $timeout = 30;     // 超时时间：30s  
    $ua='Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36';// 伪造抓取 UA  
    $ip = mt_rand(11, 191) . "." . mt_rand(0, 240) . "." . mt_rand(1, 240) . "." . mt_rand(1, 240);
    curl_setopt($ch, CURLOPT_URL, $url);// 设置 Curl 目标  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// Curl 请求有返回的值  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);// 设置抓取超时时间  
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 跟踪重定向  
    curl_setopt($ch, CURLOPT_REFERER, 'http://www.baidu.com/');//模拟来路
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip));  //伪造IP  
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);// 伪造ua   
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// https请求 不验证证书和hosts  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);//强制协议为1.0
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );//强制使用IPV4协议解析域名
    $content = curl_exec($ch);   
    curl_close($ch);// 结束 Curl  
    return $content;// 函数返回内容  
}