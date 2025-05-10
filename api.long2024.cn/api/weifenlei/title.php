<?php
/**
 * @nick vance
 * @author wansiAPI
 * @link http://715652.com/
 * @date 2022年12月24日
 * @msg 网站信息
 * @Version 1.1
**/
header("Access-Control-Allow-Origin:*");
header('content-type:application/json');
$url=$_REQUEST["url"]?:"baidu.com";
$url=tz($url);
$data=get_curl($url,0,$url);
preg_match('/<meta name="keywords" content="(.*?)"/',$data,$keywords);
preg_match('/<title>(.*?)<\/title>/',$data,$t);
if($t[1]==null){
preg_match('/<title>(.*?)<\/title>/',$data,$t);
}
preg_match('/<meta name="description" content="(.*?)"/',$data,$content);
if(!$t[1]){
$ret_json["code"]=201;
$ret_json["msg"]="域名请求出错";
// $ret_json['tips']="万思API：http://715652.com";
echo ret_json($ret_json);
}else{
$ret_json["code"]=200;
$ret_json["url"]=$url;
$ret_json["title"]=$t[1];
$ret_json["keyword"]=$keywords[1]?:"NULL";
$ret_json["description"]=$content[1]?:"NULL";
echo ret_json($ret_json);
}
function tz($url){
$ch= curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// 不需要页⾯内容
curl_setopt($ch, CURLOPT_NOBODY, 1);
// 不直接输出
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 返回最后的Location
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); curl_exec($ch);
$info= curl_getinfo($ch,CURLINFO_EFFECTIVE_URL); curl_close($ch);
return $info;

}
function ret_json($json){
    return stripslashes(json_encode($json,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}
function get_curl($url,$post=0,$referer=1,$cookie=0,$header=0,$ua=0,$nobaody=0){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
if(stripos($url, "https://") !== false) {
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
curl_setopt($ch, CURLOPT_SSLVERSION, 1);
}
$httpheader[] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
$httpheader[] = "Accept-Encoding:gzip,deflate";
$httpheader[] = "Accept-Language:zh-CN,zh;q=0.9";
$httpheader[] = "Connection:close";
$httpheader[] = "Upgrade-Insecure-Requests: 1";

curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
if($post){
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
}
if($header){
curl_setopt($ch, CURLOPT_HEADER, TRUE);
}
if($cookie){
curl_setopt($ch, CURLOPT_COOKIE, $cookie);
}
if($referer){
if($referer==1){
curl_setopt($ch, CURLOPT_REFERER,$_SERVER['HTTP_HOST']);
}else{
curl_setopt($ch, CURLOPT_REFERER, $referer);
}
}
if($ua){
curl_setopt($ch, CURLOPT_USERAGENT,$ua);
}else{
curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Linux; Android 6.0.1; OPPO R9s Build/MMB29M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/55.0.2883.91 Mobile Safari/537.36');
}
if($nobaody){
curl_setopt($ch, CURLOPT_NOBODY,1);
}
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$ret = curl_exec($ch);
if (curl_errno($ch)) {
return '[内部错误]'.curl_error($ch);//捕抓异常
}else{
return $ret;
}
curl_close($ch);
}