
<!-- footer -->
<div class="ew-footer">
    <div class="layui-container">
        <div class="layui-row layui-col-space30">
            <div class="layui-col-md6">
                <h3 class="footer-item-title">关于我们</h3>
                <p> <span>Copyright © 2025 龙氏API <?=date('Y')?> <?=$system['sysname']?></span></p>
                <p><a href="https://beian.miit.gov.cn/" target="_blank" rel="nofollow"><img src="<?=theme?>static/picture/icp.png" style="height: 2em; "><?=$system['icp']?></a>&nbsp;&nbsp;&nbsp;
                </p>
            </div>
            <div class="layui-col-md4">
                <h4 style="font-size: 17px;" class="footer-item-title">项目开源</h4>

                    <p><i class="layui-icon layui-icon-component"></i><a href="https://gitee.com/vances/xiaoyi" target="_blank">码云下载</a></p>
                    <p><i class="layui-icon layui-icon-component"></i><a href="https://www.long2024.cn" target="_blank">站长主页</a></p>
     
            </div>
            <div class="layui-col-md2">
                <h2 style="font-size: 17px;" class="footer-item-title">其他链接</h2>
                                <p><i class="layui-icon layui-icon-component"></i><a href="https://long2024.cn" target="_blank">主网站</a></p>
                                <p><i class="layui-icon layui-icon-component"></i><a href="https://yunpan.long2024.cn" target="_blank">龙氏云盘</a></p>
                                <p><i class="layui-icon layui-icon-component"></i><a href="https://kk.long2024.cn" target="_blank">龙氏解析网站</a></p>
                            </div>
        </div>
    </div>
</div>
<!-- js部分start -->
<script type="text/javascript" src="<?=theme?>static/libs/layui/layui.js"></script>
<script type="text/javascript" src="<?=theme?>static/js/common.js"></script>
<script>
    layui.use(["jquery", "element", "util",'form'], function() {
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
                            window.open("http://wpa.qq.com/msgrd?v=3&uin=2322796106&site=qq&menu=yes")
                        }
                    }
                })
        }
    });
</script>