<?php    
$str=file_get_contents('https://cn.bing.com/HPImageArchive.aspx?idx=0&n=1');    
if(preg_match("/<url>(.+?)<\/url>/",$str,$matches)){       
  $imgurl='https://cn.bing.com'.$matches[1];  
}   
if($imgurl){        
  header('Content-Type: image/JPEG');      
  @ob_end_clean();       
  @readfile($imgurl);      
  @flush(); @ob_flush();     
  exit();   
}else{    
  $json = ['code' => '-1', 'msg' => '必应图片获取失败!'];
  exit(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}
?>