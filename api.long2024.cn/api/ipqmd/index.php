<?php $counter = intval(file_get_contents("counter.dat")); ?>
<?php include 'function.php';?>
<?php


header("Content-type: image/JPEG");
$im = imagecreatefromjpeg("xhxh.jpg"); 
$ip = $_SERVER["REMOTE_ADDR"];
$weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
$get=$_GET["s"];
$get=base64_decode(str_replace(" ","+",$get));
//$wangzhi=$_SERVER['HTTP_REFERER'];//这里获取当前网址
//here is ip 
// $url="http://whois.pconline.com.cn/ipJson.jsp?json=true&ip=".$ip; 
// //这里替换成自己的
// $UserAgent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';  
// $curl = curl_init(); 
// curl_setopt($curl, CURLOPT_URL, $url); 
// curl_setopt($curl, CURLOPT_HEADER, 0);  
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  
// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  
// curl_setopt($curl, CURLOPT_ENCODING, '');  
// curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);  
// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);  
// $data = curl_exec($curl);
// $data = json_decode($data, true);
// $city = $data['position'];

function curl_get($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.5 Mobile Safari/533.1');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}


function get_ip_city($ip) {
	$url = 'http://whois.pconline.com.cn/ipJson.jsp?json=true&ip=';
	$city = curl_get($url . $ip);
	$city = mb_convert_encoding($city, "UTF-8", "GB2312");
	$city = json_decode($city, true);
	if ($city['city']) {
		$location = ip_city_str($city['pro']).ip_city_str($city['city']);
	} else {
		$location = ip_city_str($city['pro']);
	}
	if($location) {
		return $location;
	} else {
		return false;
	}
}





//var_dump(get_ip_city($ip));
//定义颜色
$black = ImageColorAllocate($im, 0,0,0);//定义黑色的值
$red = ImageColorAllocate($im, 255,0,0);//红色
$font = 'msyh.ttf';//加载字体
//输出
imagettftext($im, 16, 0, 10, 40, $red, $font,'欢迎您来自'.get_ip_city($ip).'的朋友你好!');
imagettftext($im, 16, 0, 10, 72, $red, $font, '今天是'.date('Y年n月j日')."  星期".$weekarray[date("w")]);//当前时间添加到图片
imagettftext($im, 16, 0, 10, 104, $red, $font,'您的IP是:'.$ip);//ip
imagettftext($im, 16, 0, 10, 140, $red, $font,'您使用的是'.$os.'操作系统');
imagettftext($im, 16, 0, 10, 175, $red, $font,'您使用的是'.$bro.'浏览器');
imagettftext($im, 14, 0, 10, 200, $black, $font,$get); 
//imagettftext($im, 15, 0, 10, 200, $red, $font,'被偷窥'.$counter.'次'); 
ImageGif($im);
ImageDestroy($im);
function ip_city_str($str) {
	return str_replace(array('省','市'),'',$str);
}
?>
<?php
    $counter = intval(file_get_contents("counter.dat"));  
     $_SESSION['#'] = true;  
     $counter++;  
     $fp = fopen("counter.dat","w");  
     fwrite($fp, $counter);  
     fclose($fp); 
 ?>
