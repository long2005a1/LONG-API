<?php
include("./includes/common.php");
// $alias = trim(strip_tags(daddslashes($_GET['alias'])));
$alias = daddslashes($_GET['alias']);
$content = $DB->getRow("SELECT * FROM `lvxia_apilist` WHERE `alias`='{$alias}' AND `status`='1' LIMIT 1");
if(empty($content)){exit('<script language="javascript">window.location.href="/404.html";</script>');}
$views = $DB->getColumn("SELECT SUM(views) FROM `lvxia_apilist` WHERE `status`='1'");
ApiViews($alias);
@header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <title><?=$content['name']?> - <?=$system['sysname']?></title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="API接口站(api.long2024.cn)是一个公益API数据接口调用平台,提供<?=$content['desc']?>">
    <meta name="keywords" content="<?=$content['name']?>,<?=$system['keywords']?>">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=theme?>static/css/naranja.min.css">
    <link rel="stylesheet" href="<?=theme?>static/css/layui.css">
    <link rel="stylesheet" href="<?=theme?>static/css/main.css">
    <link rel="stylesheet" href="<?=theme?>static/css/load.css">
</head>
<body>
<!-- header -->
<div class="ew-header">
    <a href="<?=url?>">
        <img class="layui-logo" src="<?=$system['logo']?>" style="height:40px;padding: 10px;">
    </a>
    <div class="ew-nav-group">
        <div class="nav-toggle"><i class="layui-icon layui-icon-more-vertical"></i></div>
        <ul class="layui-nav" lay-filter="ew-header-nav">
            <li class="layui-nav-item">
                <a href="<?=url?>">首页</a>
            </li>
                        <li class="layui-nav-item"><a href="/wansi">登录</a></li>
                    </ul>
    </div>
</div>

<div class="layui-container body-card">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8">
            <div class="layui-card">
                <div class="layui-card-header">
                    <span class="layui-breadcrumb" style="visibility: visible;">
                        <a href="<?=url?>">全部接口</a><span lay-separator="">/</span>
                        <a><cite><?=$content['name']?></cite></a>
                    </span>
                </div>

                <div class="layui-card-body goods-desc-card">
                    <div style="text-align: center;margin: 15px 0 20px 0;">
                        <span style="padding: 10px 15px;border-top: 2px solid #1890ff;border-bottom: 2px solid #1890ff;display: inline-block;font-size: 16px;color: #555;">
                            接口信息
                        </span>
                    </div>
                    <div style="padding: 15px 20px;background-color: #F4F7F7;border-left: 4px solid #1890ff;margin-top: 15px;font-size: 14px;color: #333;">
                        接口地址：<div class="layui-table-body layui-table-main"><a href="<?=$content['apiurl']?>" style="color:#1890ff;" target="_blank"><?=$content['apiurl']?></a></div>
                    </div>
                    <div style="padding: 15px 20px;background-color: #F4F7F7;border-left: 4px solid #ff6c00;margin-top: 15px;font-size: 14px;color: #333;">
                        返回格式：json/js/txt/img</div>
                    <div style="padding: 15px 20px;background-color: #F4F7F7;border-left: 4px solid #ff0000;margin-top: 15px;font-size: 14px;color: #333;">
                        请求方式：GET/POST</div>
                    <div style="padding: 15px 20px;background-color: #F4F7F7;border-left: 4px solid #ee00ff;margin-top: 15px;font-size: 14px;color: #333;">
                        请求示例：<div class="layui-table-body layui-table-main"><a href="<?=$content['apirequest']?>" style="color:#1890ff;" target="_blank"><?=$content['apirequest']?></a></div>
                    </div>
                    <hr>
                                        <div style="text-align: center;margin: 15px 0 20px 0;">
                        <span style="padding: 10px 15px;border-top: 2px solid #1890ff;border-bottom: 2px solid #1890ff;display: inline-block;font-size: 16px;color: #555;">
                            请求参数说明
                        </span>
                    </div>
                    <div class="layui-table-body layui-table-main">
                    <table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>名称</th>
        <th>参数</th>
        <th>必填</th>
        <th>说明</th>
    </tr>
    </thead>
    <tbody>
    <?=$content['explain']?>
    
    </tbody>
</table>                    </div>
                                        <div style="text-align: center;margin: 15px 0 20px 0;">
                        <span style="padding: 10px 15px;border-top: 2px solid #1890ff;border-bottom: 2px solid #1890ff;display: inline-block;font-size: 16px;color: #555;">
                            返回参数说明
                        </span>
                    </div>
                    <div class="layui-table-body layui-table-main">
                    <table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>名称</th>
        <th>参数</th>
        <th>必填</th>
        <th>说明</th>
    </tr>
    </thead>
    <tbody>
    <?=$content['explain']?>
    </tbody>
</table>                    </div>
                                        <div style="text-align: center;margin: 15px 0 20px 0;">
                        <span style="padding: 10px 15px;border-top: 2px solid #1890ff;border-bottom: 2px solid #1890ff;display: inline-block;font-size: 16px;color: #555;">
                            返回数据
                        </span>
                    </div>
                    <div style="padding: 20px 25px;color: #555;line-height: 26px;background-color: #F4F7F7;border-radius: 5px;overflow-x: auto;">
                        <pre style="min-width: 550px;"><?php if($content['return']==""){echo '暂无返回数据请自行调用查看返回数据';}else{echo $content['return'];}?></pre>
                    </div>
                                        <div style="font-size: 15px;line-height: 30px;margin-top: 5px;">
                    </div>
                    
                    
                    
                     <div style="text-align: center;margin: 15px 0 20px 0;">
                        <span style="padding: 10px 15px;border-top: 2px solid #1890ff;border-bottom: 2px solid #1890ff;display: inline-block;font-size: 16px;color: #555;">
                           <?=$content['name']?>演示 
                        </span>
                    </div>
                    <div style="padding: 20px 25px;color: #555;line-height: 26px;background-color: #F4F7F7;border-radius: 5px;overflow-x: auto;">
                        <pre style="min-width: 550px;"><?php if($content['examples']==null){echo '暂无演示自行调用演示';}else{echo $content['examples'];}?></pre>
                    </div>
                            <div style="font-size: 15px;line-height: 30px;margin-top: 5px;"></div>
                 </div>
            </div>
        </div>
        <div class="layui-col-md4">
            <div class="layui-card">
                <div class="layui-card-header">生活优惠</div>
                <div class="layui-card-body goods-card">
                    <a href="https://res.szfx.top/" target="_blank"><img src="https://img.szfx.top/banner/szres.jpg" style="width:330px;margin-left:-5px;border-radius:8px;box-shadow: 0 calc(40vmin / 40) calc(40vmin / 10) 0 rgba(0, 0, 0, 0.2);"/></a>
                    <h1 style="color: #ff6700" class="goods-title"><?=$content['name']?></h1>
                    <p class="goods-desc"><?=$content['desc']?></p>
                    <div class="goods-spec-group">

                                                <div class="goods-spec-item-title">服务级错误码参照</div>
                        <div class="goods-spec-item-list">
                            <div class="layui-table-body layui-table-main">
                            <table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>错误码</th>
        <th>说明</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>200</td>
        <td>返回</td>
    </tr>
    <tr>
        <td>201</td>
        <td>输出参数不能为空</td>
    </tr>
    <tr>
        <td>202</td>
        <td>输出异常</td>
    </tr>
    </tbody>
</table>                            </div>
                        </div>
                                            </div>
                    <div class="goods-price-group"></div>
                    <div class="goods-btn-group">
                        <span class="layui-btn layui-btn-lg layui-btn-fluid layui-btn-primary">
                            <i class="layui-icon layui-icon-username"></i>所属管理员：admin                        </span>
                    </div>
                </div>
            </div>
                        <div class="layui-card">
                <div class="layui-card-header"><?=$content['name']?>调用实例</div>
                <div class="layui-card-body">
                    <div style="padding: 20px 25px;color: #555;line-height: 26px;background-color: #F4F7F7;border-radius: 5px;overflow-x: auto;">
                        <pre style="min-width: 550px;"><?php 
                        if($content['example']==null){
                        echo htmlspecialchars('<?php
//请求表头自写
$result = file_get_contents("自行填写本网址接口" . "填写要查询的网址");
echo $result;
?>');}else{echo htmlspecialchars($content['example']);}?></pre>
                    </div>

                </div>
            </div>
                        <div class="layui-card">
                <div class="layui-card-header">每日心语~</div>
                <div class="layui-card-body text-center">
                    <div style="padding: 15px 20px;background-color: #F4F7F7;border-left: 4px solid #1890ff;margin-top: 15px;font-size: 14px;color: #333;">
                        <script type="text/javascript" src="https://api.long2024.cn/api/yiyan/?code=js"></script>
            <script>yiyan()</script></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.php");
?>
</body>
</html>