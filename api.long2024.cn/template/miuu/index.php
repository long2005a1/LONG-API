<?php
include("./includes/common.php");
$count = $DB->getColumn("SELECT count(id) FROM `lvxia_apilist` WHERE `status`='1'");
$views = $DB->getColumn("SELECT SUM(views) FROM `lvxia_apilist` WHERE `status`='1'");
$apilist = $DB->getAll("SELECT * FROM `lvxia_apilist` WHERE `status`='1' order by `views` desc");
@header('Content-Type: text/html; charset=UTF-8');

$yllist = $DB->query("SELECT * FROM api_youlian ORDER BY id ASC");

?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <title><?=$system['title']?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="<?=$system['keywords']?>">
    <meta name="keywords" content="<?=$system['description']?>">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=theme?>static/css/naranja.min.css">
    <link rel="stylesheet" href="<?=theme?>static/css/layui.css">
    <link rel="stylesheet" href="<?=theme?>static/css/main.css">
    <link rel="stylesheet" href="<?=theme?>static/css/load.css">
    <link rel="stylesheet" href="<?=theme?>static/css/style.css">
    <link href="https://cdn.staticfile.org/font-awesome/5.2.0/css/all.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?=theme?>static/libs/jquery/jquery-3.2.1.min.js"></script>
</head>
<body>
<!-- header -->
<div class="ew-header">
     <a href="<?=url?>">
        <img class="layui-logo"alt="<?=$system['title']?>" title="<?=$system['sysname']?>" src="<?=$system['logo']?>" style="height:40px;padding: 10px;">
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
<div class="section" style="padding-bottom: 15px;margin-top: 15px;box-shadow: 0 0 6px rgba(0,0,0,.101562);    border-radius: 10px;">
    <div class="section-title">
        <p>系统共收录了<span style="color:#fa6400;font-weight: bold;"><?=$count?></span> 个接口项目</p>
        <p style="font-weight: bold;"><?=$system['sysname']?> 共被调用 <span style="color:#fa6400;"><?=$views?></span> 次</p>
        <!--<h2 style="color: #999;font-weight: bold;"><?=$system['sysname']?>接口搜索</h2>-->
        <p>拥有多年管理系统产品开发经验</p>
    </div>
    <div class="layui-container">
        <form class="layui-form contact">
            <div class="layui-form-item">
                <input name="keywords" class="layui-input layui-input-lg" placeholder="搜索API关键词，例如：短网址" lay-vertype="tips" lay-verify="required" required/="">
            </div>
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-primary layui-btn-fluid" lay-filter="searchSubmit" lay-submit="">搜索</button>
            </div>
        </form>
    </div>
</div>
        <!--<div class="layui-col-md8">-->

<div class="section" nav-id="product" >
    <div class="layui-container" style="padding-bottom: 10px;">
        <div class="layui-row layui-col-space30">
            <div class="layui-row layui-col-space30" id="APIList"></div>
        </div>
        <blockquote class="layui-elem-quote layui-text" style="margin-top:5px;text-align: center;">
            <script type="text/javascript" src="https://api.long2024.cn/api/yiyan/?code=js"></script>
            <script>yiyan()</script>
        </blockquote>
    </div>
    <!----youlian---->
    <div class="friend-links container">
            <div class="list-plane-title">
                <div>友情链接 <span class="list-plane-linksdescribe"></span></div>
            </div>
          
            <div class="friend-links-list friend-links-card-list">
               <?php foreach($yllist as $res){?>
                    <a class="friend-links-item-card" href="<?php echo $res['domain']?>" target="_blank">
                        <div class="friend-links-item-icon">
                            <img src="https://yuanxiapi.cn/api/?id=28&key=943_1eb9289ebc071ab93c17958851b2a6b7&url=<?php echo urlencode($res['domain']); ?>">
                        </div>
                        <div class="friend-links-item-main">
                            <div class="friend-links-item-title"><?php echo $res['title']?></div>
                            <div class="friend-links-item-description"><?php echo $res['content']?></div>
                        </div>
                    </a>
                <?php }?>
    		</div>

    </div>
    <!----youlian--ned-->
</div>
<script type="text/html" id="APIItem">
    <div class="layui-col-md4 layui-col-sm6">
        <div class="product-card" style="border-radius: 6px;overflow: hidden;">
            <div class="product-cover">
                <div class="product-tools">
                    <a href="<?=url?>api.php?alias={{d.alias}}" class="layui-btn layui-btn-primary">详情</a>
                </div>
            </div>
            <div class="product-body">
                <a href="<?=url?>api.php?alias={{d.alias}}" class="product-title">{{d.name}}</a>
                <p class="product-desc">{{d.desc}}</p>
                <span class="layui-badge-rim">浏览量 {{d.views}}</span>
            </div>
        </div>
    </div>
</script>
        </div>
    </div>
<!--</div>-->
    
    <!-- footer -->
<div class="ew-footer">
    <div class="layui-container">
        <div class="layui-row layui-col-space30">
            <div class="layui-col-md6">
                <h4 class="footer-item-title">关于我们</h4>
                <p>
                    <i class="layui-icon layui-icon-login-qq"></i>
                    <a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$system['zzqq']?>&site=qq&menu=yes" target="_blank">问题咨询QQ:<?=$system['zzqq']?></a>
                </p>
                <p><a href="/" target="_blank">Copyright © 2025 龙氏API <?=date('Y')?>  Powered by Vance</a></p>
                <p><a href="https://beian.miit.gov.cn/" target="_blank" rel="nofollow"><img src="<?=theme?>static/picture/icp.png" style="height: 2em; "><?=$system['icp']?></a>&nbsp;&nbsp;&nbsp;
                </p>
            </div>
            <div class="layui-col-md4">
                <h4 style="font-size: 17px;" class="footer-item-title">项目开源</h4>

                <p><i class="layui-icon layui-icon-component"></i><a href="https://gitee.com/vances/xiaoyi" target="_blank">码云下载</a></p>
                <p><i class="layui-icon layui-icon-component"></i><a href="https://www.long2024.cn" target="_blank">站长主页</a></p>
     
            </div>
            <div class="layui-col-md2">
                <h2 style="font-size: 17px;" class="footer-item-title">其他项目</h2>
                                <p><i class="layui-icon layui-icon-component"></i><a href="https://long2024.cn" target="_blank">主网站</a></p>
                                <p><i class="layui-icon layui-icon-component"></i><a href="https://yunpan.long2024.cn" target="_blank">龙氏云盘</a></p>
                                <p><i class="layui-icon layui-icon-component"></i><a href="https://kk.long2024.cn" target="_blank">龙氏解析网站</a></p>
                            </div>
        </div>
    </div>
</div>
<!-- Js 部分 -->
<script type="text/javascript" src="<?=theme?>static/libs/layui/layui.js"></script>
<script type="text/javascript" src="<?=theme?>static/js/common.js"></script>
<script type="text/javascript" src="<?=theme?>static/js/style.js"></script>
<script>
    layui.use(['layer'], function () {
        var layer = layui.layer;
        layer.open({
            type: 1,
            anim: 4,
            title: '<?=$system['sysname']?>服务公告',
            closeBtn: false,
            area: '300px;',
            btn: ['关闭提示'],
            moveType: 1,
            content: '<div style="padding: 40px; line-height: 20px; background-color: #393D49; color: #fff; font-weight: 150;"><b>欢迎使用龙氏API<br>公益API数据接口调用服务平台<br> 致力于为用户提供稳定、快速的免费API数据接口服务。</b></div>',    
            success: function(layero) {
                var btn = layero.find('.layui-layer-btn');
            }
        });
    });
</script>
<script>
    layui.use(["jquery", "element", "util",'form', 'dataGrid','layer'], function() {
        var $ = layui.jquery;
        var layer = layui.layer;
        var dataGrid = layui.dataGrid;
        var form = layui.form;
        var f = layui.jquery;
        var e = layui.element;
        var d = layui.util;
        var c = layui.admin;

        if (f(".ew-header").length > 0) {
            var b = [];
            f("[nav-id]").each(function() {
                b.push(f(this).attr("nav-id"))
            });
            if (b.length > 0)
                d.fixbar({
                    bgcolor: '#3EC483',
                    bar1: '&#xe606;',
                    click: function(g) {
                        if (g == "bar1") {
                            window.open("http://wpa.qq.com/msgrd?v=3&uin=<?=$system['zzqq']?>&site=qq&menu=yes")
                        }
                    }
                })
        }

        dataGrid.render({
            elem: '#APIList',
            templet: '#APIItem',
            data: './wansi/ajax.php?act=ApiallInfo',
            loadMore: {limit: 9}
        });

        // 表单提交
        form.on('submit(searchSubmit)', function (obj) {
            var loadIndex = layer.msg('请求中...', {icon: 16, shade: 0.01, time: false});
            $.post('./wansi/serch.php?act=Apiserch', obj.field, function (res) {
                if (200 === res.code) {
                    layer.msg(res.msg, {icon: 1, time: 1500});
                    dataGrid.render({
                        elem: '#APIList',
                        templet: '#APIItem',
                        data: res.data,
                        loadMore: {limit: 9}
                    });
                } else {
                    layer.msg(res.msg, {icon: 2, anim: 6});
                }
            }, 'JSON');
            return false;
        });
    });
</script>
</body>
</html>

</body>
</html>
