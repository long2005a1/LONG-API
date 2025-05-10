<?php include 'head.php';
include("../includes/common.php");
$count=$DB->getColumn("SELECT count(*) from lvxia_apilist WHERE 1");
$zy=$DB->getColumn("SELECT count(*) from api_down WHERE 1");
$yl=$DB->getColumn("SELECT count(*) from api_youlian WHERE 1");
$views = $DB->getColumn("SELECT SUM(views) FROM `lvxia_apilist` WHERE `status`='1'");
ApiViews($alias);
?>
<!-- 正文开始 -->
<div class="layui-fluid ew-console-wrapper">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    API接口<span class="layui-badge layui-badge-green pull-right">个</span>
                </div>
                <div class="layui-card-body">
                    <p class="lay-big-font"><?=$count?></p>
                    <p>停用接口<span class="pull-right">0 个</span></p>
                </div>
            </div>
        </div>
        <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    调用接口<span class="layui-badge layui-badge-blue pull-right">次</span>
                </div>
                <div class="layui-card-body">
                    <p class="lay-big-font"><?=$views?></p>
                    <p>今日调用<span class="pull-right">0 次</span></p>
                </div>
            </div>
        </div>
        <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    文章资源<span class="layui-badge layui-badge-red pull-right">个</span>
                </div>
                <div class="layui-card-body">
                    <p class="lay-big-font"><?=$zy?></p>
                    <p>置顶文章<span class="pull-right">0 个</span></p>
                </div>
            </div>
        </div>
        <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    公告<span class="layui-badge layui-badge-red pull-right">条</span>
                </div>
                <div class="layui-card-body">
                    <p class="lay-big-font">1</p>
                    <p>友情链接<span class="pull-right"><?=$yl?>个</span></p>
                </div>
            </div>
        </div>
    </div>
<div class="layui-row layui-col-space15">
        <div class="layui-col-md8 layui-col-sm6">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md6">
                        <div class="layui-card">
                            <div class="layui-card-header">程序信息</div>
                            <div class="layui-card-body">
                            <table class="layui-table layui-text">
                                <colgroup>
                                    <col width="90">
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td>系统名称</td>
                                        <td>龙氏API发布程序</td>
                                    </tr>
                                    <tr>
                                        <td>系统作者</td>
                                        <td>Mr.Long</td>
                                    </tr>
                                <tr>
                                    <td>当前版本</td>
                                    <td>Version 3.0.1</td>
                                </tr>
                                <tr>
                                    <td>前端基于</td>
                                    <td>使用者可自行开发定制【均无加密】</td>
                                </tr>
                                <tr>
                                    <td>后端基于</td>
                                    <td>PHP原生，EasyWeb框架</td>
                                </tr>
                                <tr>
                                    <td>主要特色</td>
                                    <td>Api管理程序两个板块Api和资源下载;程序功能可能写的不好,请见谅,更多问题咨询请加群;感谢使用！</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
<div class="layui-col-md6">
                        <div class="layui-card">
                            <div class="layui-card-header">系统信息</div>
                            <div class="layui-card-body">
                            <table class="layui-table layui-text">
                                <colgroup>
                                    <col width="90">
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td>PHP版本</td>
                                        <td><?php echo PHP_VERSION;?></td>
                                    </tr>
                                    <tr>
                                        <td>zend版本</td>
                                        <td><?php echo zend_version();?></td>
                                    </tr>
                                <tr>
                                    <td>操作系统</td>
                                    <td><?php echo PHP_OS;?></td>
                                </tr>
                                <tr>
                                    <td>服务器</td>
                                    <td><?php echo $_SERVER ['SERVER_SOFTWARE'];?></td>
                                </tr>
                                <tr>
                                    <td>上传限制</td>
                                    <td><?php echo get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件";?></td>
                                </tr>
                                <tr>
                                    <td>执行时间</td>
                                    <td><?php echo get_cfg_var("max_execution_time")."秒 ";?></td>
                                </tr>
                                <tr>
                                    <td>运行内存</td>
                                    <td><?PHP echo get_cfg_var ("memory_limit")?get_cfg_var("memory_limit"):"无"?></td>
                                </tr>
                                 </tbody>
                            </table>
                        </div>
                    </div>
                </div>
</div></div>
<div class="layui-col-md4 layui-col-sm6">
    <div class="layui-card">
        <div class="layui-card-header">更新检测</div>
            <div class="layui-card-body"><div class="layui-elem-quote"><font color="red">当前魔改版本</font> 最新版本：V3.0.1 (龙氏5-9)</div><hr/>                                
                    </div>
    </div>
            <div class="layui-card">
                <div class="layui-card-header">官方内容</div>
                <div class="layui-card-body">
                    <div class="layui-carousel admin-carousel admin-news" id="workplaceNewsCarousel">
                        <div carousel-item>
                            <div>
                                <a href="http://api.long2024.cn" target="_blank"
                                   style="color:#fff;background-color: #009fde;background-image: linear-gradient(to right,#009fde,#00beff);">
                                    龙氏APi程序使用教程</a>
                            </div>
                            <div>
                                <a href="https://api.long2024.cn/QYWXJL.png" target="_blank"
                                   style="color:#fff;background-color: #009688;background-image: linear-gradient(to right,#009688,#5fb878);">
                                    点击链接加入群聊【企业微信『龙氏交流群』】</a>
                            </div>
                            <div>
                                <a href="https://qm.qq.com/q/zvajBIw8Ce" target="_blank"
                                   style="color:#fff;background-color: #34363f;background-image: linear-gradient(to right,#34363f,#676c7c);">
                                   点击链接加入群聊【龙氏api网站交流群】</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- js部分 -->
<script type="text/javascript" src="/assets/iframe/libs/layui/layui.js"></script>
<script type="text/javascript" src="/assets/iframe/js/common.js?v=318"></script>
<script>
    layui.use(['layer', 'carousel', 'element'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var carousel = layui.carousel;
        var device = layui.device();

        // 渲染轮播
        carousel.render({
            elem: '#workplaceNewsCarousel',
            width: '100%',
            height: '70px',
            arrow: 'none',
            autoplay: true,
            trigger: device.ios || device.android ? 'click' : 'hover',
            anim: 'fade'
        });

    });
</script>
</body>
</html>