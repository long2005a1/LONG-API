<?php
/*
Plugin Name:百度收录量
Version:1.0
Description:根据域名返回百度收录量
*/
//header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
header('Content-type: application/json');
$url = (isset($_GET['url']))?$_GET['url']:$_POST['url'];
//if(empty($url))  echo '查询域名不能为空';
!empty($_GET['url']) ? $_GET['url'] : exit(json_encode(
array("code"=>202,"msg"=>"请输入网址！"),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

$baidu=curl('https://www.baidu.com/s?ie=utf-8&tn=baidu&wd=site:'.$url); 
$baidu = str_replace(array("rn", "r", "n", '    ','',','),null, $baidu); 
preg_match('/<b style="colo:#333">(.*?)<\/b>/i',$baidu,$count);
if ($count[1]==null) preg_match('/找到相关结果数约(.*?)个/i',$baidu,$count);
$baidu=(preg_match("/^[1-9][0-9]*$/" ,$count[1])?$count[1]:'0'); //百度收录数量
//print_r($baidu);exit;
//搜狗收录数量   
$sougou=curl('https://www.sogou.com/tx?ie=utf-8&query=site:'.$url);
preg_match_all('/找到约(.*?)条/i',$sougou,$count);
//print_r($sougou);exit;
$sougou=(preg_match("/^[1-9][0-9]*$/",$count[1][0])?$count[1][0]:$count[1][1]); //搜狗收录数量
$sougou = str_replace([",","."],null,$sougou);


//360
$haoso=curl('https://www.so.com/s?ie=utf-8&fr=so.com&src=home_www&nlpv=basesc&q=site:'.$url); 
$haoso = str_replace(array("rn", "r", "n", '    ','',','),null, $haoso); 

preg_match('/<p class=\"info\">该网站约(.*?)个网页被360搜索收录<\/p>/',$haoso,$count);
//print_r($haoso);exit;
if ($count[1]==null) preg_match('/<p class=\"info\">该网站约(.*?)个网页被360搜索收录<\/p>/',$haoso,$count);
$haoso=(preg_match("/^[1-9][0-9]*$/" ,$count[1])?$count[1]:'0'); //百度收录数量

$json=array( 'code'=>200,
'baidu'=>round($baidu),
'sougou'=>round($sougou),
'360'=>round($haoso),
);
exit(json_encode($json,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

// function curl($url){
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1");
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     $ret = curl_exec($ch);
//     curl_close($ch);
//     return $ret;
// }


// function curl($url){
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1");
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
//     curl_setopt($ch, CURLOPT_URL, $url); //设置传输的 url
    
//     // if ($paras['header']) { //伪造Header
//     //     $Header = $paras['header'];
//     // } else {
//     //     $Header[] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
//     //     $Header[] = "Accept-Encoding:gzip, deflate, br";
//     //     $Header[] = "Accept-Language:zh-CN,zh;q=0.9";
//     //     $Header[] = "Connection:max-age=0";
//     // }
    
    
    
// // 	curl_setopt($ch, CURLOPT_HTTPHEADER, $Header); //发送 http 报头
// // 	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25"); //设置UA
// // 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// // 	curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate'); // 解码压缩文件
// // 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
// // 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
// // 	curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 设置超时限制防止死循环
    
    
//     $ret = curl_exec($ch);
//     curl_close($ch);
//     return $ret;
// }

function showjson($arr){
 header("Content-Type: application/json; charset=utf-8");
 exit(json_encode($arr,320));
}


// function curl($url, $paras = []){ 
// $paras = array_change_key_case($paras, CASE_LOWER); //键名全部转小写
// //$dl=array("X-FORWARDED-FOR:220.181.".rand(1,230).".".rand(1,230), "CLIENT-IP:220.181.".rand(1,230).".".rand(1,230));
// // $dl=array("82.156.212.19","8.142.171.20","42.193.126.5"); //代理列表

// $dl=array("82.156.".rand(1,230).".".rand(1,230)."","8.142.".rand(1,230).".".rand(1,230)."","42.193.".rand(1,230).".".rand(1,230)."");


// shuffle($dl);
// if($paras['daili']){ 
//     $url='http://'.$dl[0] .'/?url='.$url; 
//     $paras['post']=$paras; $paras['post']=array_merge($paras['post'],['daili_status'=>1]);
//     unset($paras['post']['daili'],$paras['header']); }
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//     if ($paras['header']) { //伪造Header
//         $Header = $paras['header'];
//     } else {
//         $Header[] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
//         $Header[] = "Accept-Encoding:gzip, deflate, br";
//         $Header[] = "Accept-Language:zh-CN,zh;q=0.9";
//         $Header[] = "Connection:max-age=0";
//     }
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $Header);
//     if ($paras['ctime']) { // 连接超时
//         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $paras['ctime']);
//     } else {
//         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
//     }
//     if ($paras['rtime']) { // 读取超时
//         curl_setopt($ch, CURLOPT_TIMEOUT, $paras['rtime']);
//     }

//     if ($paras['ip']) { //伪造IP
//     $num=count(explode('.',$paras['ip']));   //获取数组长度
//     if($num!=4&&$num!=6||!filter_var($paras['ip'], FILTER_VALIDATE_IP)){
// curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:220.181.".rand(1,230).".".rand(1,230), "CLIENT-IP:220.181.".rand(1,230).".".rand(1,230)));
//     }else{  curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:".$paras['ip'], "CLIENT-IP:".$paras['ip'])); }
//     }
    
//  if(!$paras['loadurl']){ curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); }//默认跟随跳转抓取
    
//     if ($paras['post']) { //POST提交
// //'post'=>'id=1&key=key'或者'post'=>[ 1=>'内容',]，第二种键名必须对上号，有些网址不允许数组方式
// if(is_array($paras['post'])){ $paras['post']=http_build_query($paras['post']); } //若为数组，则执行参数拼接，防止有些头部固定这种格式
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
//     }
//     if ($paras['get_header']) { //查看返回Header信息
//         curl_setopt($ch, CURLOPT_HEADER, true);
//     }
// if($paras['cookie']) { //携带Cookie，必须用;分隔
// if(is_array($paras['cookie'])){  foreach($paras['cookie'] as $key=>$value){ 
// if(preg_match("/^[1-9][0-9]*$/",$key)&&strlen($key)<=2){ $cookie.=$value.'; '; 
// }else{ $cookie.=$key.'='.$value.'; '; }  } //有些需要urlencode编码格式
// }else{ $cookie=$paras['cookie']; }
//         curl_setopt($ch, CURLOPT_COOKIE, $cookie);
//     }
//     if ($paras['refer']) { //伪造来访网址
//         if ($paras['refer'] == 1) {
//             curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
//         } else {
//             curl_setopt($ch, CURLOPT_REFERER, $paras['refer']);
//         }
//     }
//     if ($paras['ua']) {  //伪造UA
//         curl_setopt($ch, CURLOPT_USERAGENT, $paras['ua']); 
//     } else {
//         curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 11; zh-cn; PEGT00 Build/RKQ1.200903.002) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/83.0.4103.106 MQQBrowser/11.8 Mobile Safari/537.36"); //默认QQ手机浏览器UA值
//     }
//     if ($paras['nobody']&&!$paras['daili']) { //不返回网页源代码信息
//         curl_setopt($ch, CURLOPT_NOBODY, 1);
//     }
//     curl_setopt($ch, CURLOPT_ENCODING, "gzip");
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
//     if (($paras['getcookie']||$paras['get_cookie'])&&!$paras['daili']) {  //获取请求的全部信息
//         curl_setopt($ch, CURLOPT_HEADER, 1);
//         $result = curl_exec($ch);
//         preg_match_all("/Set-Cookie: (.*?);/m", $result, $matches);
//         $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
//         $header = substr($result, 0, $headerSize);
//         $body = substr($result, $headerSize);
//         $ret = [
// "Cookie"=>$matches,"cookie"=>$matches, "body" => $body, "header" => $header, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE), //code是响应状态码
//         ]; curl_close($ch);
//         if($paras['daili_status']){ return json_encode($ret);  }
//         return $ret; }
        
//     $ret = curl_exec($ch);
//     if ($paras['loadurl']&&!$paras['daili']) { //查看301跳转过去的网址
//     $Headers = curl_getinfo($ch);
//     if ($Headers['redirect_url']) { $ret=$Headers['redirect_url'];
//     } else { $ret = false; }  }
//     curl_close($ch); 
// if(($paras['getcookie']||$paras['get_cookie'])&&$paras['daili']){  return json_decode($ret,true);  }
//     return $ret; }




// function curl($a, $b = '', $c = '', $d = ''){
// //curl模拟get请求
//   $e = curl_init();
//   $f = array("82.156.".rand(1,230).".".rand(1,230)."","8.142.".rand(1,230).".".rand(1,230)."","42.193.".rand(1,230).".".rand(1,230)."");
//   //mt_rand(11, 191) . "." . mt_rand(0, 240) . "." . mt_rand(1, 240) . "." . mt_rand(1, 240);
//   $i[] = "CLIENT-IP:" . $f;
//   $i[] = "X-FORWARDED-FOR:" . $f;
//   $i[] = "User-agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11";
//   $i[] = "X-Requested-With: XMLHttpRequest";
//   if (!empty($d)) {
//     $i[] = "Cookie: " . $d;
//   }
//   curl_setopt($e, CURLOPT_HTTPHEADER, $i);
//   curl_setopt($e, CURLOPT_RETURNTRANSFER, true);
//   curl_setopt($e, CURLOPT_TIMEOUT, 180);
//   curl_setopt($e, CURLOPT_SSL_VERIFYPEER, false);
//   curl_setopt($e, CURLOPT_SSL_VERIFYHOST, false);
//   if (!empty($c)) {
//     curl_setopt($e, CURLOPT_REFERER, $c);
//   }
//   if (!empty($b)) {
//     curl_setopt($e, CURLOPT_POST, 1);
//     curl_setopt($e, CURLOPT_POSTFIELDS, $b);
//   }
//   curl_setopt($e, CURLOPT_URL, $a);
//   curl_setopt($e, CURLOPT_ENCODING, "gzip");
//   $j = curl_exec($e);
//   curl_close($e);
//   return $j;
// }

// function curl($url){
    
    
// //     $httpheader[] = "Host: www.baidu.com";
// //     $httpheader[] = "Connection: keep-alive";
// //     $httpheader[] = "Upgrade-Insecure-Requests: 1";
// // 	$httpheader[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
// // 	$httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
    
    
    
    
    
    
// 	$header[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
//     $header[] = "Accept-Encoding: gzip, deflate, sdch, br";
//     $header[] = "Accept-Language: zh-CN,zh;q=0.8";
    
//     $header[] = 'X-FORWARDED-FOR:'.$ip;
//     $header[] = 'CLIENT-IP:'.$ip;
    
// 	$ch = curl_init();
// 	curl_setopt($ch, CURLOPT_URL, $url); //设置传输的 url
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //发送 http 报头
// 	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25"); //设置UA
// 	//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1"); //设置UA
	
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 	curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate'); // 解码压缩文件
// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
// 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
// 	curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 设置超时限制防止死循环
// 	$output = curl_exec($ch);
// 	curl_close($ch);
// 	return $output;
// }










// function curl($url){
//     $ch = curl_init();     // Curl 初始化
//     $timeout = 3;     // 超时时间：30s
//     // $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
//     // if($ip != ""){
//     //     $arr = explode(",",$ip);
//     //     $ip = $arr[0];
//     // }else{
//     //     $ip = $_SERVER["REMOTE_ADDR"];
//     // }
    
    
    
// //     if ($paras['ip']) { //伪造IP
// //     $num=count(explode('.',$paras['ip']));   //获取数组长度
// //     if($num!=4&&$num!=6||!filter_var($paras['ip'], FILTER_VALIDATE_IP)){
// // curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:220.181.".rand(1,230).".".rand(1,230), "CLIENT-IP:220.181.".rand(1,230).".".rand(1,230)));
// //     }else{  curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:".$paras['ip'], "CLIENT-IP:".$paras['ip'])); }
// //     }
    
    
    
    
//     //yuanxian
//     //$ua='Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36';
//     //baidu
//     //$ua="Mozilla/5.0 (Linux; U; Android 11; zh-cn; PEGT00 Build/RKQ1.200903.002) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/83.0.4103.106 MQQBrowser/11.8 Mobile Safari/537.36";
    
    
//     $ua="Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1";
    
//     //sougou
//     //$ua="Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25";
//     //360
//     //$ua="Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11";
    
    
    
    
//     $header = array("X-FORWARDED-FOR:220.181.".rand(1,230).".".rand(1,230), "CLIENT-IP:220.181.".rand(1,230).".".rand(1,230));
//     //array("82.156.212.19","8.142.171.20","42.193.126.5");
//     //array("82.156.".rand(1,230).".".rand(1,230)."","8.142.".rand(1,230).".".rand(1,230)."","42.193.".rand(1,230).".".rand(1,230)."");
//     //array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip);
    

//     //curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:220.181.".rand(1,230).".".rand(1,230), "CLIENT-IP:220.181.".rand(1,230).".".rand(1,230)));
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//     curl_setopt($ch, CURLOPT_ENCODING, "");
//     curl_setopt($ch, CURLOPT_REFERER, $url);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//     curl_setopt($ch, CURLOPT_USERAGENT, $ua);
//     curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//     $content = curl_exec($ch);
//     curl_close($ch);
//     return $content;}




















// function curl($url){ //Curl GET
//     $ch = curl_init();     // Curl 初始化  
//     $timeout = 3;     // 超时时间：30s  
//     $ua='Mozilla/5.0( Linux; Android 8.1.0; PBCM30 Build/OPM1.171019011; wv)Apple Webkit/ 537.36(KHTML, like Gecko) Version/4.0 Chrome/62.0.3202. 84 Mobile Safari/537.36';    // 伪造抓取 UA  
//         //$ip = mt_rand(11, 191) . "." . mt_rand(0, 240) . "." . mt_rand(1, 240) . "." . mt_rand(1, 240);
        
//         $ip = array("82.156.".rand(1,230).".".rand(1,230)."","8.142.".rand(1,230).".".rand(1,230)."","42.193.".rand(1,230).".".rand(1,230)."");
//     curl_setopt($ch, CURLOPT_URL, $url);              // 设置 Curl 目标  
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      // Curl 请求有返回的值  
//     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);     // 设置抓取超时时间  
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);        // 跟踪重定向  
//     curl_setopt($ch,CURLOPT_REFERER,$url);   // 伪造来源网址  
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip));  //伪造IP  
//     curl_setopt($ch, CURLOPT_USERAGENT, $ua);   // 伪造ua   
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts  
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
//     curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0); //强制协议为1.0
//     curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); //强制使用IPV4协议解析域名
//     $content = curl_exec($ch);   
//     curl_close($ch);    // 结束 Curl  
//     return $content;    // 函数返回内容  
// }






// function curl($url, $paras = []){ 
// //$dl=array("82.156.212.16","8.142.171.21"); //代理列表

// $dl=array("X-FORWARDED-FOR:220.181.".rand(1,230).".".rand(1,230), "CLIENT-IP:220.181.".rand(1,230).".".rand(1,230));
// shuffle($dl);
// if($paras['daili']){ $url='http://'.$dl[0] .'/?url='.$url; $paras['post']=$paras; }
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//     if ($paras['Header']) { //伪造Header
//         $Header = $paras['Header'];
//     } else {
//         // $Header[] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
//         // $Header[] = "Accept-Encoding:gzip, deflate, br";
//         // $Header[] = "Accept-Language:zh-CN,zh;q=0.9";
//         // $Header[] = "Connection:max-age=0";
//     $Header[] = "Upgrade-Insecure-Requests: 1";
// 	$Header[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
// 	$Header[] = "Accept-Language: zh-CN,zh;q=0.8";
//     }
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $Header);
//     if ($paras['ctime']) { // 连接超时
//         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $paras['ctime']);
//     } else {
//         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
//     }
//     if ($paras['rtime']) { // 读取超时
//         curl_setopt($ch, CURLOPT_TIMEOUT, $paras['rtime']);
//     }

//     if ($paras['ip']) { //伪造IP
//     $num=count(explode('.',$paras['ip']));   //获取数组长度
//     if($num!=4&&$num!=6||!filter_var($paras['ip'], FILTER_VALIDATE_IP)){
// curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:175.181.".rand(1,230).".".rand(1,230), "CLIENT-IP:196.181.".rand(1,230).".".rand(1,230)));
//     }else{  curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:".$paras['ip'], "CLIENT-IP:".$paras['ip'])); }
//     }
//     var_dump($paras['ip']);
//   if(!$paras['loadurl']){curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); }//默认跟随跳转抓取
    
// //     if ($paras['post']) { //POST提交
// // //'post'=>'id=1&key=key'或者'post'=>[ 1=>'内容',]，第二种键名必须对上号，有些网址不允许数组方式
// // if(is_array($paras['post'])){ $paras['post']=http_build_query($paras['post']); } //若为数组，则执行参数拼接，防止有些头部固定这种格式
// //         curl_setopt($ch, CURLOPT_POST, 1);
// //         curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
// //     }
//     if ($paras['header']) { //查看返回Header信息
//         curl_setopt($ch, CURLOPT_HEADER, true);
//     }
// if($paras['cookie']) { //携带Cookie，必须用;分隔
// if(is_array($paras['cookie'])){  foreach($paras['cookie'] as $key=>$value){ 
// if(preg_match("/^[1-9][0-9]*$/",$key)&&strlen($key)<=2){ $cookie.=$value.';'; 
// }else{ $cookie.=$key.'='.urlencode($value).';'; }  }
// }else{ $cookie=$paras['cookie']; }
//         curl_setopt($ch, CURLOPT_COOKIE, $cookie);
//     }
//     if ($paras['refer']) { //伪造来访网址
//         if ($paras['refer'] == 1) {
//             curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
//         } else {
//             curl_setopt($ch, CURLOPT_REFERER, $paras['refer']);
//         }
//     }
//     if ($paras['ua']) {  //伪造UA
//         curl_setopt($ch, CURLOPT_USERAGENT, $paras['ua']); 
//     } else {
//         //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 11; zh-cn; PEGT00 Build/RKQ1.200903.002) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/83.0.4103.106 MQQBrowser/11.8 Mobile Safari/537.36"); //默认QQ手机浏览器UA值
        
//         curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1");
        
//     }
//     // if ($paras['nobody']&&!$paras['daili']) { //不返回网页源代码信息
//     //     curl_setopt($ch, CURLOPT_NOBODY, 1);
//     // }
//     curl_setopt($ch, CURLOPT_ENCODING, "gzip");
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     if ($paras['GetCookie']&&!$paras['daili']) {  //获取请求的全部信息
//         curl_setopt($ch, CURLOPT_HEADER, 1);
//         $result = curl_exec($ch);
//         preg_match_all("/Set-Cookie: (.*?);/m", $result, $matches);
//         $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
//         $header = substr($result, 0, $headerSize);
//         $body = substr($result, $headerSize);
//         $ret = [
// "Cookie" => $matches, "body" => $body, "header" => $header, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE), //code是响应状态码
//         ];
//         curl_close($ch);
//         return $ret;
//     }
//     $ret = curl_exec($ch);
//     if ($paras['loadurl']&&!$paras['daili']) { //查看301跳转过去的网址
//         $Headers = curl_getinfo($ch);
//         if ($Headers['redirect_url']) {
//             $ret = $Headers['redirect_url'];
//         } else {
//             $ret = false;
//         }
//     }
//     curl_close($ch);
// if($paras['GetCookie']&&$paras['daili']){  return json_decode($ret,true);  }
//     return $ret; }
    
    
   
   
 
/**
 * @author 教书先生
 * @link https://blog.oioweb.cn
 * @date 2021年6月13日10:29:04
 * @msg PHPCurl封装的方法
 */
function curl($url, $paras = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    if (isset($paras['Header'])) {
        $Header = $paras['Header'];
    } else {
        $Header[] = "Accept:*/*";
        $Header[] = "Accept-Encoding:gzip,deflate,sdch";
        $Header[] = "Accept-Language:zh-CN,zh;q=0.8";
        $Header[] = "Connection:close";
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $Header);
    if (isset($paras['ctime'])) { // 连接超时
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $paras['ctime']);
    } else {
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    }
    if (isset($paras['rtime'])) { // 读取超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $paras['rtime']);
    }
    if (isset($paras['post'])) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
    }
    if (isset($paras['header'])) {
        curl_setopt($ch, CURLOPT_HEADER, true);
    }
    if (isset($paras['cookie'])) {
        curl_setopt($ch, CURLOPT_COOKIE, $paras['cookie']);
    }
    if (isset($paras['refer'])) {
        if ($paras['refer'] == 1) {
            curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $paras['refer']);
        }
    }
    if (isset($paras['ua'])) {
        curl_setopt($ch, CURLOPT_USERAGENT, $paras['ua']);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
    }
    if (isset($paras['nobody'])) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (isset($paras['GetCookie'])) {
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
        preg_match_all("/Set-Cookie: (.*?);/m", $result, $matches);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $headerSize); //状态码
        $body = substr($result, $headerSize);
        $ret = [
            "Cookie" => $matches, "body" => $body, "header" => $header, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        ];
        curl_close($ch);
        return $ret;
    }
    $ret = curl_exec($ch);
    if (isset($paras['loadurl'])) {
        $Headers = curl_getinfo($ch);
        if (isset($Headers['redirect_url'])) {
            $ret = $Headers['redirect_url'];
        } else {
            $ret = false;
        }
    }
    curl_close($ch);
    return $ret;
} 