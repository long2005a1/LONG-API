function class_Tips(msg,type) {
    layui.use(['form', 'notice', 'element'], function () {
        var $ = layui.jquery;
        var form = layui.form;
        var notice = layui.notice;
        var admin = layui.admin;
        //提示类型
		if (type == 'success') {
            notice.success({
                title: msg,
                message: '您有一条新的消息注意查收！',
                position: 'topCenter',//显示位置 
                animateInside: true,//动画效果 开启 true 关闭 false
                displayMode: '2',//同类型就显示一行
                balloon: true,//气泡效果 开启 true 关闭 false
                audio: '2'//播放音效
            });
		} else if (type == 'error') {
            notice.error({
                title: msg,
                message: '您有一条新的消息注意查收！',
                position: 'topCenter',//显示位置 
                animateInside: true,//动画效果 开启 true 关闭 false
                displayMode: '2',//同类型就显示一行
                balloon: true,//气泡效果 开启 true 关闭 false
                audio: '2'//播放音效
            });			
		} else if (type == 'info') {
            notice.info({
                title: msg,
                message: '您有一条新的消息注意查收！',
                position: 'topCenter',//显示位置 
                animateInside: true,//动画效果 开启 true 关闭 false
                displayMode: '2',//同类型就显示一行
                balloon: true,//气泡效果 开启 true 关闭 false
                audio: '2'//播放音效
            });		
		} else if (type == '') {
            notice.show({
                title: msg,
                message: '您有一条新的消息注意查收！',
                position: 'topCenter',//显示位置 
                animateInside: true,//动画效果 开启 true 关闭 false
                displayMode: '2',//同类型就显示一行
                balloon: true,//气泡效果 开启 true 关闭 false
                audio: '2'//播放音效
            });		
		}
    });
}
/*
layui.use(['admin', 'table', 'element'],function() {
	var $ = layui.jquery;
	var admin = layui.admin;
	var table = layui.table;
	var element = layui.element;

	admin.showLoading('#divLoading', 3, '.8');
	setTimeout(function() {
		admin.removeLoading('#divLoading', true, true);
	},
	1000);
});
*/