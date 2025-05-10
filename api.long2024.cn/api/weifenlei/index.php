<?php
/**
 * 自写tdk获取
 * 网站TDK信息查询
 */
header("content-type:application/json; charset=utf-8");

// $url = $_REQUEST['url'];
// //去除https
// $_REQUEST = ["https://", "http://", "/"]; 
// $http_referer = str_replace($_REQUEST, "",$url); 
$url = isset($_GET['url']) ? addslashes(trim($_GET['url'])) : '';
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
   $content = Httpcontent($url);
   $domain = parse_url($url,PHP_URL_HOST);
   
   if(isset($_GET['url'])){
       $metarray = get_meta_tags(fix_url($url));
       $url = fix_url($url);
   }else{
       $metarray = get_meta_tags($url);
   }
   
   
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

function Httpcontent($url){
  $curl = curl_init();
  $headers = array(
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36 ",
  );
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
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
function trimall($str){
  $qian=array(" ","　","&nbsp;","\t","\n","\r",",","，","-","'",'"');
  $hou=array("","","","","","","","","","");
  return str_replace($qian,$hou,$str);    
}