/** EasyWeb iframe v3.1.7 date:2020-03-11 License By http://easyweb.vip */
layui.config({
    defaultTheme: 'theme-colorful', // 默认主题
    defaultLoading: 3,  //加载动画
    navArrow: 'arrow',             // 侧边栏导航箭头
    base: getProjectUrl() + '/static/module/'
}).extend({
    steps: "steps/steps",
    notice: "notice/notice",
    cascader: "cascader/cascader",
    dropdown: "dropdown/dropdown",
    fileChoose: "fileChoose/fileChoose",
    Split: "Split/Split",
    Cropper: "Cropper/Cropper",
    tagsInput: "tagsInput/tagsInput",
    citypicker: "city-picker/city-picker",
    introJs: "introJs/introJs",
    zTree: "zTree/zTree"
}).use(["layer", "admin"],
function() {
    var c = layui.jquery;
    var b = layui.layer;
    var a = layui.admin
});
function getProjectUrl() {
    var c = layui.cache.dir;
    if (!c) {
        var e = document.scripts,
        b = e.length - 1,
        f;
        for (var a = b; a > 0; a--) {
            if (e[a].readyState === "interactive") {
                f = e[a].src;
                break
            }
        }
        var d = f || e[b].src;
        c = d.substring(0, d.lastIndexOf("/") + 1)
    }
    return c.substring(0, c.indexOf("static"))
};