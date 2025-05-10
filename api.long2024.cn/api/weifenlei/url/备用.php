<?php

// $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
// $url = $http_type . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// echo $url;






// //主动判断是否HTTPS

// //判断是否HTTPS
// function isHttps(){
//     if (defined('HTTPS') && HTTPS) return true;
//     if (!isset($_SERVER)) return FALSE;
//     if (!isset($_SERVER['HTTPS'])) return FALSE;
//     if ($_SERVER['HTTPS'] === 1) {  //Apache
//         return TRUE;
//     } elseif ($_SERVER['HTTPS'] === 'on') { //IIS
//         return TRUE;
//     } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
//         return TRUE;
//     }
//     return FALSE;
// }
// $host_config = (isHttps() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; //获取域名
// echo  $host_config;

$url = isset($_GET['url']) ? addslashes(trim($_GET['url'])) : '';
if(!isset($url) || empty($url) || $url==''){
     $pageinfo = array(
        "code" => false,
        "msg" => "请输入网址！"
    );
    echo json_encode($pageinfo,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    exit;
} 
$webcode = tz($url);
if($webcode=='200'){
   $content = curl($url);
   $domain = parse_url($url,PHP_URL_HOST);
   $metarray = get_meta_tags($url); 
   $keyword = $metarray['keywords'];
   $description = $metarray['description'];
   
   preg_match('/<title>(\s*.*)<\/title>/i', $content, $titlearr);

   preg_match('/name=\"keywords\" content=\"(.*?)\"/',$content,$keywords);
   preg_match('/name=\"description\" content=\"(.*?)\"/',$content,$description);
   $pageinfo = array(
     'code'=>$webcode,
	 'url'=>$url,
	 'title'=>$titlearr[1],
	 'keywords'=>$keywords[1],
	 'description'=>$description[1],
   );
}else{
  $pageinfo = array(
     'code'=>$webcode,
	 'title'=>'null',
	 'keyword'=>'null',
	 'description'=>'null',
   );
}
echo json_encode($pageinfo,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);








function curl($url){ //Curl GET
    $ch = curl_init();     // Curl 初始化  
    $timeout = 300;     // 超时时间：30s  
    $ua='Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36';// 伪造抓取 UA  
    $ip = mt_rand(11, 191) . "." . mt_rand(0, 240) . "." . mt_rand(1, 240) . "." . mt_rand(1, 240);
    curl_setopt($ch, CURLOPT_URL, $url);// 设置 Curl 目标  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// Curl 请求有返回的值  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);// 设置抓取超时时间  
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 跟踪重定向  
    curl_setopt($ch, CURLOPT_REFERER, 'http://www.baidu.com/');//模拟来路
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip)); //伪造IP
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);// 伪造ua   
    
    
     
    
    if(stripos($url, "https://") !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
    curl_setopt($ch, CURLOPT_SSLVERSION, 1);
    }else{
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// https请求 不验证证书和hosts  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    
    
    
    
    
    
    
    
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);//强制协议为1.0
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );//强制使用IPV4协议解析域名
    
    // $content = curl_exec($ch);   
    // curl_close($ch);// 结束 Curl  
    // return $content;// 函数返回内容 
    
    $ret = curl_exec($ch);
    curl_getinfo($ch);
    return $ret;
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