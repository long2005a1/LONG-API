<?php
/**
 * @nick 域名IP获取API
 * @author 万思(Vance)
 * @link http://715652.com/
 * @date 2022年12月25日
 * @msg 域名IP获取API
 * @Version 1.1
**/
// 跨域设置
header('Access-Control-Allow-Origin:*');
// 响应类型  
//header('Access-Control-Allow-Methods:*');
// 响应头设置  
//header('Access-Control-Allow-Headers:*');
// 数据返回格式
header('Content-Type: application/json');
//header("content-type:application/json; charset=utf-8");
$url = isset($_GET['url']) ? addslashes(trim($_GET['url'])) : '';

if(!isset($url) || empty($url) || $url==''){
     $pageinfo = array(
        "code" => false,
        "msg" => "请输入网址！"
    );
    echo json_encode($pageinfo,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    exit;
} 
//去除https
$url = $_REQUEST['url'];
$_REQUEST = ["https://", "http://", "/"]; 
$http_referer = str_replace($_REQUEST, "",$url); 
$webcode = Httpcode($url);
if($webcode=='200'){
  $content = $url;
  $ip = gethostbyname($http_referer);
  $http=xy($url);

  if(isset($_GET['url'])){
      $url = fix_url($url);
  }else{
  
  }
  $pageinfo = array(
     'code'=>$webcode,
     "msg"=>"查询成功",
	 'url'=>$http_referer,
	 'ip'=>$ip,
	 'http'=>$http,
	 'Api版权'=>'万思API接口站-为站长提供方便快捷公共API接口 查询站点为：'.$http,
	 "tips"=> "万思API：http://www.715652.com",
  );
}elseif($webcode=='403'){
  $pageinfo = array(
     'code'=>403,
	 "msg"=>"查询失败，目标网站无法打开",
	 'Api版权'=>'万思API接口站-为站长提供方便快捷公共API接口 '.$http,
	 "tips"=> "万思API：http://www.715652.com",
  );
}elseif($webcode=='201'){
  $pageinfo = array(
     'code'=>201,
	 "msg"=>"查询失败，目标网站无法打开",
	 'Api版权'=>'万思API接口站-为站长提供方便快捷公共API接口 '.$http,
	 "tips"=> "万思API：http://www.715652.com",
  );
}elseif($webcode=='null'){
  $pageinfo = array(
     'code'=>404,
	 "msg"=>"目标网站无法打开",
	 'Api版权'=>'万思API接口站-为站长提供方便快捷公共API接口 http://www.715652.com',
	 //'Api版权'=>'万思API接口站-为站长提供方便快捷公共API接口 '.$http,
	 "tips"=> "万思API：http://www.715652.com",
  );
}else{
  $pageinfo = array(
     'code'=>$webcode,
	 "msg"=>"目标网站无法打开",
  ); 
}
echo json_encode($pageinfo,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);



function ret_json($json){
    return stripslashes(json_encode($json,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}


function get_host($url){
//首先替换掉http://
$url=str_replace("http:" or "https:","",$url);
//获得去掉http://url的/最先出现的位置
$position=strpos($url,"/");
//如果没有斜杠则表明url里面没有参数，直接返回url，
//否则截取字符串
if($position==false){
    echo $url;
 }else{
     echo substr($url,0,$position);
}}



//状态
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

// http://双协议
function xy($url){
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
//自动增加https http
function fix_url($url, $def=false, $prefix=false) {
  $url = trim($url);
  if (empty($url)){
    return $def;
  }
  if ( count(explode('://',$url))>1 ){
    return $url;
  }else{
    return $prefix===false ? 'http://'.$url : 'https://'.$url;
  }
}  

//获取客户端真实ip地址
function get_real_ip()
{
    static $realip;
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_CLIENT_IP')) {
            $realip = getenv('HTTP_CLIENT_IP');
        } else {
            $realip = getenv('REMOTE_ADDR');
        }
    }
    return $realip;
}
?>