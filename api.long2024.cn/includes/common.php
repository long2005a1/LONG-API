<?php
//error_reporting(0);//错误提示
if(defined('IN_CRONLITE'))return;
define('SYS_KEY', "IPMkYXHBJSykLc5qb7jFbrRNb8P4rM61");
define('IN_CRONLITE', true);
define('SYSTEM_ROOT', dirname(__FILE__) . '/');
define('ROOT', dirname(SYSTEM_ROOT) . '/');

date_default_timezone_set('Asia/Shanghai');//上海时间
$time = time();//时间缀
$date = date("Y-m-d H:i:s");//日期
$firstDay = date('Y-m-01', strtotime($date));//本月第一天
$lastDay = date('Y-m-d', strtotime("{$firstDay} +1 month -1 day"));//本月最后一天
$pagesize = 15;//列表分页
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].'/';
define('url',$siteurl);
define('CSS',$siteurl.'admin/style/');
define('IMG', $siteurl.'admin/img/');
session_start();
include_once(SYSTEM_ROOT.'database.php');
include_once(SYSTEM_ROOT.'lib/Pdo.class.php');
//连接数据库
$DB = new \lib\PdoHelper($dbconfig);//new的时候传入配置 自动进入初始化方法
$system_list = $DB->getAll("SELECT * FROM `lvxia_system` ");
foreach($system_list as $system_row){
    $system[$system_row['name']] =$system_row['content'];
}

$password_hash = '!@#%!s!0';
include_once(SYSTEM_ROOT.'lib/Pinyin.class.php');
include_once(SYSTEM_ROOT.'function.php');
include_once(SYSTEM_ROOT.'member.php');
include_once(SYSTEM_ROOT.'lib/Smtp.class.php');

$ip = realIp();
if (is_file(SYSTEM_ROOT . '360safe/360webscan.php')) {
    //360网站卫士
    require_once(SYSTEM_ROOT . '360safe/360webscan.php');
}
// //7.1.0
if (version_compare(PHP_VERSION, '5.6.0', '<')) {
    die('require PHP >= 7.1 !');
}
define('THEME', !empty($_GET['theme']) ? $_GET['theme'] : (isset($system['theme']) ? $system['theme'] : 'index'));
define('API_CSS',$siteurl.'template/'.THEME.'/style/');
define('API_IMG', $siteurl.'template/'.THEME.'/img/');

define('theme', $siteurl.'template/'.THEME.'/');

define("TEMPLATE_ROOT", ROOT . "template/");

//houzengjia

?>