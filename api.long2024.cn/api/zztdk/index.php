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

//去除https
$_REQUEST = ["https://", "http://", "/"]; 
$http_referer = str_replace($_REQUEST, "",$url); 
$data=curl("https://seo.chinaz.com/".$http_referer);

// preg_match('/<div class=\"ball color-63\" id=\"site_title\">(.*?)\s*<\/div>/',$data,$title);//标题
// preg_match('/<div class=\"ball color-63\" id=\"site_keywords\">\s*(.*?)\s*<\/div>/',$data,$keywords);
// preg_match('/<div class=\"ball color-63\" id=\"site_description\">\s*(.*?)\s*<\/div>/',$data,$description);//描述

preg_match('/id="site_title">(.*?)<\/div>/',$data,$title);//标题
preg_match('/id="site_keywords">\s*(.*?)\s*<\/div>/',$data,$keywords);//关键词
preg_match('/id="site_description">\s*(.*?)\s*<\/div>/',$data,$description);//描述



//str_replace('<div class="ball color-63" id="site_keywords">', ' ',$data);



if($_REQUEST["url"]){
$ret_json["code"]=201;
$ret_json["msg"]="域名请求出错";
$ret_json['tips']="万思API：http://715652.com";
echo ret_json($ret_json);
}else{
$ret_json["code"]=200;
$ret_json["url"]=$url;
$ret_json["title"]=$title[1];
$ret_json["keyword"]=$keywords[1]?:"NULL";
$ret_json["description"]=$description[1]?:"NULL";
echo ret_json($ret_json);


// echo json_encode(
//     array(
//     'code' => 1,
//     'msg'  => '获取成功',
//     'title' => $title[1],
//     'keywords' => $keywords[1],
//     'description' => $description[1]),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE,320); 
   //var_dump($data) ;
   
   
   //echo json_encode($data);

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

// function curl($url,$post=0,$referer=1,$cookie=0,$header=0,$ua=0,$nobaody=0){
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL,$url);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// if(stripos($url, "https://") !== false) {
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
// curl_setopt($ch, CURLOPT_SSLVERSION, 1);
// }
// $httpheader[] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
// $httpheader[] = "Accept-Encoding:gzip,deflate";
// $httpheader[] = "Accept-Language:zh-CN,zh;q=0.9";
// $httpheader[] = "Connection:close";
// $httpheader[] = "Upgrade-Insecure-Requests: 1";

// curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
// curl_setopt($ch, CURLOPT_TIMEOUT, 5);
// curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
// if($post){
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
// }
// if($header){
// curl_setopt($ch, CURLOPT_HEADER, TRUE);
// }
// if($cookie){
// curl_setopt($ch, CURLOPT_COOKIE, $cookie);
// }
// if($referer){
// if($referer==1){
// curl_setopt($ch, CURLOPT_REFERER,$_SERVER['HTTP_HOST']);
// }else{
// curl_setopt($ch, CURLOPT_REFERER, $referer);
// }
// }
// if($ua){
// curl_setopt($ch, CURLOPT_USERAGENT,$ua);
// }else{
// curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Linux; Android 6.0.1; OPPO R9s Build/MMB29M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/55.0.2883.91 Mobile Safari/537.36');
// }
// if($nobaody){
// curl_setopt($ch, CURLOPT_NOBODY,1);
// }
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// curl_setopt($ch, CURLOPT_ENCODING, "gzip");
// curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
// $ret = curl_exec($ch);
// if (curl_errno($ch)) {
// return '[内部错误]'.curl_error($ch);//捕抓异常
// }else{
// return $ret;
// }
// curl_close($ch);
// }




function curl($url, $paras = []){ 
$paras = array_change_key_case($paras, CASE_LOWER); //键名全部转小写
$dl=array("82.156.212.19","8.142.171.20","42.193.126.5"); //代理列表
shuffle($dl);
if($paras['daili']){ $url='http://'.$dl[0] .'/?url='.$url; 
$paras['post']=$paras; $paras['post']=array_merge($paras['post'],['daili_status'=>1]); unset($paras['post']['daili'],$paras['header']); }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    if ($paras['header']) { //伪造Header
        $Header = $paras['header'];
    } else {
        $Header[] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
        $Header[] = "Accept-Encoding:gzip, deflate, br";
        $Header[] = "Accept-Language:zh-CN,zh;q=0.9";
        $Header[] = "Connection:max-age=0";
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $Header);
    if ($paras['ctime']) { // 连接超时
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $paras['ctime']);
    } else {
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    }
    if ($paras['rtime']) { // 读取超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $paras['rtime']);
    }

    if ($paras['ip']) { //伪造IP
    $num=count(explode('.',$paras['ip']));   //获取数组长度
    if($num!=4&&$num!=6||!filter_var($paras['ip'], FILTER_VALIDATE_IP)){
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:220.181.".rand(1,230).".".rand(1,230), "CLIENT-IP:220.181.".rand(1,230).".".rand(1,230)));
    }else{  curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:".$paras['ip'], "CLIENT-IP:".$paras['ip'])); }
    }
    
 if(!$paras['loadurl']){ curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); }//默认跟随跳转抓取
    
    if ($paras['post']) { //POST提交
//'post'=>'id=1&key=key'或者'post'=>[ 1=>'内容',]，第二种键名必须对上号，有些网址不允许数组方式
if(is_array($paras['post'])){ $paras['post']=http_build_query($paras['post']); } //若为数组，则执行参数拼接，防止有些头部固定这种格式
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
    }
    if ($paras['get_header']) { //查看返回Header信息
        curl_setopt($ch, CURLOPT_HEADER, true);
    }
if($paras['cookie']) { //携带Cookie，必须用;分隔
if(is_array($paras['cookie'])){  foreach($paras['cookie'] as $key=>$value){ 
if(preg_match("/^[1-9][0-9]*$/",$key)&&strlen($key)<=2){ $cookie.=$value.'; '; 
}else{ $cookie.=$key.'='.$value.'; '; }  } //有些需要urlencode编码格式
}else{ $cookie=$paras['cookie']; }
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    if ($paras['refer']) { //伪造来访网址
        if ($paras['refer'] == 1) {
            curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $paras['refer']);
        }
    }
    if ($paras['ua']) {  //伪造UA
        curl_setopt($ch, CURLOPT_USERAGENT, $paras['ua']); 
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 11; zh-cn; PEGT00 Build/RKQ1.200903.002) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/83.0.4103.106 MQQBrowser/11.8 Mobile Safari/537.36"); //默认QQ手机浏览器UA值
    }
    if ($paras['nobody']&&!$paras['daili']) { //不返回网页源代码信息
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    if (($paras['getcookie']||$paras['get_cookie'])&&!$paras['daili']) {  //获取请求的全部信息
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
        preg_match_all("/Set-Cookie: (.*?);/m", $result, $matches);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $headerSize);
        $body = substr($result, $headerSize);
        $ret = [
"Cookie"=>$matches,"cookie"=>$matches, "body" => $body, "header" => $header, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE), //code是响应状态码
        ]; curl_close($ch);
        if($paras['daili_status']){ return json_encode($ret);  }
        return $ret; }
        
    $ret = curl_exec($ch);
    if ($paras['loadurl']&&!$paras['daili']) { //查看301跳转过去的网址
    $Headers = curl_getinfo($ch);
    if ($Headers['redirect_url']) { $ret=$Headers['redirect_url'];
    } else { $ret = false; }  }
    curl_close($ch); 
if(($paras['getcookie']||$paras['get_cookie'])&&$paras['daili']){  return json_decode($ret,true);  }
    return $ret; }