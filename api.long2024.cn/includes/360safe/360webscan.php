<?php
webscan_error();
//引用配置文件
require_once('webscan_cache.php');
//防护脚本版本号
define("WEBSCAN_VERSION", '0.1.2.9');
//防护脚本MD5值
define("WEBSCAN_MD5", md5(@file_get_contents(__FILE__)));
//get拦截规则
$getfilter = "\\<.+javascript:window\\[.{1}\\\\x|<.*=(&#\\d+?;?)+?>|<.*(data|src)=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|\\b(group_)?concat[\\s\\/\\*]*?\\([^\\)]+?\\)|\bcase[\s\/\*]*?when[\s\/\*]*?\([^\)]+?\)|load_file\s*?\\()|<[a-z]+?\\b[^>]*?\\bon([a-z]{4,})\s*?=|^\\+\\/v(8|9)|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)|<.*(iframe|frame|style|embed|object|frameset|meta|xml|a|img)";
//post拦截规则
$postfilter = "<.*=(&#\\d+?;?)+?>|<.*data=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|\\b(group_)?concat[\\s\\/\\*]*?\\([^\\)]+?\\)|\bcase[\s\/\*]*?when[\s\/\*]*?\([^\)]+?\)|load_file\s*?\\()|<[^>]*?\\b(onerror|onmousemove|onload|onclick|onmouseover)\\b|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)|<.*(iframe|frame|style|embed|object|frameset|meta|xml|a|img)";
//cookie拦截规则
$cookiefilter = "benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\(|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//referer获取
$webscan_referer = empty($_SERVER['HTTP_REFERER']) ? array() : array('HTTP_REFERER'=>$_SERVER['HTTP_REFERER']);

class webscan_http {

  var $method;
  var $post;
  var $header;
  var $ContentType;

  function __construct() {
    $this->method = '';
    $this->cookie = '';
    $this->post = '';
    $this->header = '';
    $this->errno = 0;
    $this->errstr = '';
  }

  function post($url, $data = array(), $referer = '', $limit = 0, $timeout = 30, $block = TRUE) {
    $this->method = 'POST';
    $this->ContentType = "Content-Type: application/x-www-form-urlencoded\r\n";
    if($data) {
      $post = '';
      foreach($data as $k=>$v) {
        $post .= $k.'='.rawurlencode($v).'&';
      }
      $this->post .= substr($post, 0, -1);
    }
    return $this->request($url, $referer, $limit, $timeout, $block);
  }

  function request($url, $referer = '', $limit = 0, $timeout = 30, $block = TRUE) {
    $matches = parse_url($url);
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
    $port = $matches['port'] ? $matches['port'] : 80;
    if($referer == '') $referer = URL;
    $out = "$this->method $path HTTP/1.1\r\n";
    $out .= "Accept: */*\r\n";
    $out .= "Referer: $referer\r\n";
    $out .= "Accept-Language: zh-cn\r\n";
    $out .= "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n";
    $out .= "Host: $host\r\n";
    if($this->method == 'POST') {
      $out .= $this->ContentType;
      $out .= "Content-Length: ".strlen($this->post)."\r\n";
      $out .= "Cache-Control: no-cache\r\n";
      $out .= "Connection: Close\r\n\r\n";
      $out .= $this->post;
    } else {
      $out .= "Connection: Close\r\n\r\n";
    }
    if($timeout > ini_get('max_execution_time')) @set_time_limit($timeout);
    $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
    $this->post = '';
    if(!$fp) {
      return false;
    } else {
      stream_set_blocking($fp, $block);
      stream_set_timeout($fp, $timeout);
      fwrite($fp, $out);
      $this->data = '';
      $status = stream_get_meta_data($fp);
      if(!$status['timed_out']) {
        $maxsize = min($limit, 1024000);
        if($maxsize == 0) $maxsize = 1024000;
        $start = false;
        while(!feof($fp)) {
          if($start) {
            $line = fread($fp, $maxsize);
            if(strlen($this->data) > $maxsize) break;
            $this->data .= $line;
          } else {
            $line = fgets($fp);
            $this->header .= $line;
            if($line == "\r\n" || $line == "\n") $start = true;
          }
        }
      }
      fclose($fp);
      return "200";
    }
  }

}

/**
 *   关闭用户错误提示
 */
function webscan_error() {
  if (ini_get('display_errors')) {
    ini_set('display_errors', '0');
  }
}

/**
 *  参数拆分
 */
function webscan_arr_foreach($arr) {
  static $str;
  static $keystr;
  if (!is_array($arr)) {
    return $arr;
  }
  foreach ($arr as $key => $val ) {
    $keystr=$keystr.$key;
    if (is_array($val)) {

      webscan_arr_foreach($val);
    } else {

      $str[] = $val.$keystr;
    }
  }
  return implode($str);
}
/**
 *  新版文件md5值效验
 */
function webscan_updateck($ve) {
  if($ve!=WEBSCAN_MD5)
  {
    return true;
  }
  return false;
}

/**
 *  防护提示页
 */
function webscan_pape(){
    $result = array("code" => -1, "msg" => "输入内容存在危险字符，安全起见，已被本站拦截");
    exit(json_encode($result));
}

/**
 *  攻击检查拦截
 */
function webscan_StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq,$method) {
  $StrFiltValue=webscan_arr_foreach($StrFiltValue);
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){
    exit(webscan_pape());
  }
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){
    exit(webscan_pape());
  }

}
/**
 *  拦截目录白名单
 */
function webscan_white($webscan_white_name,$webscan_white_url=array()) {
  $url_path=$_SERVER['SCRIPT_NAME'];
  $url_var=$_SERVER['QUERY_STRING'];
  if (preg_match("/".$webscan_white_name."/is",$url_path)==1&&!empty($webscan_white_name)) {
    return false;
  }
  foreach ($webscan_white_url as $key => $value) {
    if(!empty($url_var)&&!empty($value)){
      if (stristr($url_path,$key)&&stristr($url_var,$value)) {
        return false;
      }
    }
    elseif (empty($url_var)&&empty($value)) {
      if (stristr($url_path,$key)) {
        return false;
      }
    }

  }

  return true;
}

/**
 *  curl方式提交
 */
function webscan_curl($url , $postdata = array()){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
  $response = curl_exec($ch);
  $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
  curl_close($ch);
  return array('httpcode'=>$httpcode,'response'=>$response);
}

if ($webscan_switch&&webscan_white($webscan_white_directory,$webscan_white_url)) {
  if ($webscan_get) {
    foreach($_GET as $key=>$value) {
      webscan_StopAttack($key,$value,$getfilter,"GET");
    }
  }
  if ($webscan_post) {
    foreach($_POST as $key=>$value) {
      webscan_StopAttack($key,$value,$postfilter,"POST");
    }
  }
  if ($webscan_cookie) {
    foreach($_COOKIE as $key=>$value) {
      webscan_StopAttack($key,$value,$cookiefilter,"COOKIE");
    }
  }
  if ($webscan_referre) {
    foreach($webscan_referer as $key=>$value) {
      webscan_StopAttack($key,$value,$postfilter,"REFERRER");
    }
  }
}

?>
