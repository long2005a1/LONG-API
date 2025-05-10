<?php
/*
Plugin Name:百度收录量
Version:1.0
Description:根据域名返回百度收录量
*/
//header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
header('Content-type: application/json');


$domain = (isset($_GET['domain']))?$_GET['domain']:$_POST['domain'];
//if(empty($domain))  echo '查询域名不能为空';
//error_reporting(0);
!empty($_GET['domain']) ? $_GET['domain'] : exit(json_encode(
array("code"=>202,"msg"=>"请输入网址！"),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

$baidu=curl('https://www.baidu.com/s?ie=utf-8&tn=baidu&wd=site:'.$domain); 
$baidu = str_replace(array("rn", "r", "n", '    ','',','),null, $baidu); 
preg_match('/<b style="colo:#333">(.*?)<\/b>/i',$baidu,$count);
if ($count[1]==null) preg_match('/找到相关结果数约(.*?)个/i',$baidu,$count);
$baidu=(preg_match("/^[1-9][0-9]*$/" ,$count[1])?$count[1]:'0'); //百度收录数量
//print_r($baidu);exit;

 //搜狗收录数量   
$sougou=BD_curl('https://www.sogou.com/tx?ie=utf-8&query=site:'.$domain);
preg_match_all('/找到约(.*?)条/i',$sougou,$count);
//print_r($sougou);exit;
$sougou=(preg_match("/^[1-9][0-9]*$/",$count[1][0])?$count[1][0]:$count[1][1]); //搜狗收录数量
$sougou = str_replace([",","."],null,$sougou);


//360
/*$haoso=curl('https://www.so.com/s?ie=utf-8&fr=so.com&src=home_www&nlpv=basesc&q=site:'.$domain); 
$haoso = str_replace(array("rn", "r", "n", '    ','',','),null, $haoso); 

preg_match('/<p class=\"info\">该网站约(.*?)个网页被360搜索收录<\/p>/',$haoso,$count);
print_r($haoso);exit;
if ($count[1]==null) preg_match('/<p class=\"info\">该网站约(.*?)个网页被360搜索收录<\/p>/',$haoso,$count);
$haoso=(preg_match("/^[1-9][0-9]*$/" ,$count[1])?$count[1]:'0'); //百度收录数量*/


////////////////////////////////////////////////////////////////////////////////
$json=array( 'code'=>200,
'baidu'=>round($baidu),
'sougou'=>round($sougou),
//'haoso'=>round($haoso)
);
exit(json_encode($json,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

/*function BD_curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}*/
/////////////////////////////////////
function curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}
///////////////////////////////////
function showjson($arr){
 header("Content-Type: application/json; charset=utf-8");
 exit(json_encode($arr,320));
}
///////////////////////////////////////////////
/*$data=curl('https://w96.eruu.cn/',[
'GetCookie'=>'1',
'nobody'=>1
    ]);
echo $data['code'];*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////
function BD_curl($url, $paras = []){ 
//$dl=array("82.156.212.16","8.142.171.21"); //代理列表
$dl=array("X-FORWARDED-FOR:220.181.".rand(1,230).".".rand(1,230), "CLIENT-IP:220.181.".rand(1,230).".".rand(1,230));
shuffle($dl);
if($paras['daili']){ $url='http://'.$dl[0] .'/?url='.$url; $paras['post']=$paras; }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    if ($paras['Header']) { //伪造Header
        $Header = $paras['Header'];
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
    
  if(!$paras['loadurl']){curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); }//默认跟随跳转抓取
    
    if ($paras['post']) { //POST提交
//'post'=>'id=1&key=key'或者'post'=>[ 1=>'内容',]，第二种键名必须对上号，有些网址不允许数组方式
if(is_array($paras['post'])){ $paras['post']=http_build_query($paras['post']); } //若为数组，则执行参数拼接，防止有些头部固定这种格式
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
    }
    if ($paras['header']) { //查看返回Header信息
        curl_setopt($ch, CURLOPT_HEADER, true);
    }
if($paras['cookie']) { //携带Cookie，必须用;分隔
if(is_array($paras['cookie'])){  foreach($paras['cookie'] as $key=>$value){ 
if(preg_match("/^[1-9][0-9]*$/",$key)&&strlen($key)<=2){ $cookie.=$value.';'; 
}else{ $cookie.=$key.'='.urlencode($value).';'; }  }
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
    if ($paras['GetCookie']&&!$paras['daili']) {  //获取请求的全部信息
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
        preg_match_all("/Set-Cookie: (.*?);/m", $result, $matches);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $headerSize);
        $body = substr($result, $headerSize);
        $ret = [
"Cookie" => $matches, "body" => $body, "header" => $header, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE), //code是响应状态码
        ];
        curl_close($ch);
        return $ret;
    }
    $ret = curl_exec($ch);
    if ($paras['loadurl']&&!$paras['daili']) { //查看301跳转过去的网址
        $Headers = curl_getinfo($ch);
        if ($Headers['redirect_url']) {
            $ret = $Headers['redirect_url'];
        } else {
            $ret = false;
        }
    }
    curl_close($ch);
if($paras['GetCookie']&&$paras['daili']){  return json_decode($ret,true);  }
    return $ret; }
?>