<?php 
header('Access-Control-Allow-Origin: *');
header('Content-type:text/json');
ini_set("user_agent","Mozilla/4.0 (compatible; MSIE 5.00; Windows 98)");


$url = isset($_GET['url']) ? addslashes(trim($_GET['url'])) : '';

// $url = $_REQUEST['url'];
// //去除https
// $_REQUEST = ["https://", "http://", "/"]; 
// $http_referer = str_replace($_REQUEST, "",$url); 

if(!isset($url) || empty($url) || $url==''){
     $pageinfo = array(
        "code" => false,
        "msg" => "请输入网址！"
    );
    echo json_encode($pageinfo,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    exit;
}  

if(!function_exists('http')){
    function http(){return((int)$_SERVER['SERVER_PORT']==443?'https':'http').'://';}}
        
$webcode = Httpcode($url);
if($webcode=='200'){   
    
    // $burl=http().$_SERVER['HTTP_HOST'];
    // $urlok=json_decode($url,true);
    // $error=$urlok['errmsg'];
    // if($error){return $error;}
    
    // $urlok=$urlok['data'];
    // $arr=$urlok;
    // return $arr["result"];
    
  
    
//$http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ||(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))?'https://' : 'http://';

    if(isset($_GET['url'])){
        //$site=$http_type;
         //$http=https();
    
    
        $http =is_ssl() ? 'https://' : 'http://';
        
        
        if(isset($_GET['url'])){
        $url = fix_url($url);
        }else{$url=trim($http.$_GET['url']);}
        $content=file_get_contents($url);
        
       // $content=curl($url);
        
       
    }
        
    if(!empty($content)){
    $charset=mb_detect_encoding($content,"UTF-8, ISO-8859-1, GBK");}
    if($charset!="UTF-8"){$content=iconv('gbk','utf-8',$content);}
    
    
    // $content['title']=_title($content,$title);
    // $content['keywords']=_keywords($content,$keywords);
    // $content['description']=_description($content,$description);
    
    $title=_title($content,$title);
    $key=_keywords($content,$keywords);
    $desc=_description($content,$description);

//   $content = Httpcontent($url);
//   $domain = parse_url($url,PHP_URL_HOST);
//   $contentetarray = get_meta_tags($url); 
//   $keyword = $contentetarray['keywords'];
//   $description = $contentetarray['description'];
   
   $pageinfo = array(
     'code'=>$webcode,
	 'url'=>$url,
	 
	 'u'=>$http,
	 
	 'title'=>$title,
	 'keywords'=>$key,
	 'description'=>$desc,
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
    
    
    
  function _title($content,$title){
    preg_match('/<TITLE>([\w\W]*?)<\/TITLE>/si',$content,$title);
    if(!empty($title[1])){return $title[1];}}
function _keywords($content,$keywords){
    preg_match('/<META\s+name="keywords"\s+content="([\w\W]*?)"/si',$content,$keywords);
    if(empty($keywords[1])){
        preg_match("/<META\s+name='keywords'\s+content='([\w\W]*?)'/si",$content,$keywords);
    }if(empty($keywords[1])){
        preg_match('/<META\s+content="([\w\W]*?)"\s+name="keywords"/si',$content,$keywords);
    }if(empty($keywords[1])){
        preg_match('/<META\s+http-equiv="keywords"\s+content="([\w\W]*?)"/si',$content,$keywords);
    }
    if(!empty($keywords[1])){return $keywords[1];}}
function _description($content,$description){
    preg_match('/<META\s+name="description"\s+content="([\w\W]*?)"/si',$content,$description);
    if(empty($description[1])){
        preg_match("/<META\s+name='description'\s+content='([\w\W]*?)'/si",$content,$description);
        }
    if(empty($description[1])){
        preg_match('/<META\s+content="([\w\W]*?)"\s+name="description"/si',$content,$description);}
    if(empty($description[1])){
        preg_match('/<META\s+http-equiv="description"\s+content="([\w\W]*?)"/si',$content,$description);
    }
    if(!empty($description[1])){return $description[1];}}
    


//自动增加https http
function fix_url($url, $def=false, $prefix=false) {
  $url = trim($url);
  if (empty($url)){
    return $def;
  }
 
  if ( count(explode('://',$url))>1 ){
    return $url;
  }else{
    return $prefix===false ? 'http://'.$url : $prefix.$url;
  }
}  
    
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
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip));  //伪造IP  
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);// 伪造ua   
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// https请求 不验证证书和hosts  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);//强制协议为1.0
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );//强制使用IPV4协议解析域名
    
    // $content = curl_exec($ch);   
    // curl_close($ch);// 结束 Curl  
    // return $content;// 函数返回内容 
    
    $ret = curl_exec($ch);
    curl_getinfo($ch);
    return $ret;
} 

function Httpcode($url){
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl, CURLOPT_HEADER, 1);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($curl, CURLOPT_TIMEOUT,10);
  $content = curl_exec($curl);
  $httpcode = curl_getinfo($curl);
  curl_close($curl);
  return $httpcode['http_code'];
}
function is_ssl() {
      if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
            return true;
      }else if(isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
            return true;
      }
      return false;
}