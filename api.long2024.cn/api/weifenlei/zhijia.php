<?php
/**
 * @nick Vance
 * @author 万思API
 * @link http://715652.com/
 * @date 2022年12月25日
 * @msg 获取网站TDK信息
 * @Version 1.2
**/
header("Access-Control-Allow-Origin:*");
header('content-type:application/json');
$url=$_REQUEST["url"]?:"715652.com";
$url=tz($url);
$_REQUEST = ["https://", "http://", "/"]; //去除https
$http_referer = str_replace($_REQUEST, "",$url); 
$data=curl("https://seo.chinaz.com/".$http_referer);
preg_match('/<div class=\"ball color-63\" id=\"site_title\">(.*?)\s*<\/div>/',$data,$title);//标题
preg_match('/<div class=\"ball color-63\" id=\"site_keywords\">\s*(.*?)\s*<\/div>/',$data,$keywords);
preg_match('/<div class=\"ball color-63\" id=\"site_description\">\s*(.*?)\s*<\/div>/',$data,$description);
if($_REQUEST["url"]){
$ret_json["code"]=201;
$ret_json["msg"]="域名请求出错";
$ret_json['tips']="万思API：http://715652.com";
echo ret_json($ret_json);
}else{
$ret_json["code"]=200;
if($description[1]==Null){
    $ret_json["msg"]="查询失败";
}else{
    $ret_json["msg"]="查询成功";
}
$ret_json["url"]=$url;
$ret_json["title"]=$title[1];
$ret_json["keyword"]=$keywords[1]?:"NULL";
$ret_json["description"]=$description[1]?:"NULL";
echo ret_json($ret_json);
//var_dump($data) ;
}
function tz($url){
$ch= curl_init();
curl_setopt($ch, CURLOPT_URL, $url);// 不需要页⾯内容
curl_setopt($ch, CURLOPT_NOBODY, 1);// 不直接输出
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 返回最后的Location
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); curl_exec($ch);
$info= curl_getinfo($ch,CURLINFO_EFFECTIVE_URL); curl_close($ch);
return $info;
}
function ret_json($json){
    return stripslashes(json_encode($json,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}
function curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25"); //设置UA
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate'); // 解码压缩文件
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
	curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 设置超时限制防止死循环
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}