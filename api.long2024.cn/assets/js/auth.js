function km()
{
	  layer.open({
		type: 1,
		title: "增加卡密",
		btn: ["提交","取消"],
		area: ["280px", "270px"],
		content: $('.kmform'),
		yes: function(){
			var count = $("#count").val();
			var custom = $("#custom").val();
			addkm(count,custom);
		},	
		end: function(){
			$('.kmform').hide(500);
		}
	  });
}

function addkm(count,custom) { //后台添加卡密
    if(count==''){
	 return layer.tips('请输入数量', '#count', {
          tips: [3, '#0099FF'],
          time: 1500
        });
	}
	if(custom==''){
	 return layer.tips('请输入前缀', '#custom', {
          tips: [3, '#0099FF'],
          time: 1500
        });
	}
	var ii = layer.load(2);
	$.ajax({
		type: "post",
		url: "ajax.php?act=add_km",
		data: {
			count: count,
			custom: custom
		},
		dataType: 'json',
		//		 timeout:10000,
		success: function(data) {
			layer.close(ii);
			if (data.code == 1) {
				layer.msg(data.msg, {
					icon: 1
				});
				window.location.reload();
			} else {
				layer.msg(data.msg, {
					icon: 2
				});
			}
		},
		error: function(data) {
			layer.close(ii);
			layer.msg('服务器错误');
		}
	});
}



function dels() {
	layer.confirm('你确实要清空已使用卡密吗？', {
		btn: ['确定', '取消'],
		icon: 3
	},
	function() {
		var ii = layer.msg("正在清空数据！", {
			icon: 16
		});
		$.ajax({
			type: 'get',
			url: 'ajax.php?act=del_km&my=s',
			dataType: 'json',
			success: function(data) {
				layer.msg(data.msg, {
					icon: 1
				});
				window.location.reload();
			}
		});
	},
	function() {});

}
function dels_log() {
	layer.confirm('你确实要清空系统日志吗？', {
		btn: ['确定', '取消'],
		icon: 3
	},
	function() {
		var ii = layer.msg("正在清空数据！", {
			icon: 16,
			time: 0
		});
		$.ajax({
			type: 'get',
			url: 'ajax.php?act=del_log&my=s',
			dataType: 'json',
			success: function(data) {
				layer.msg(data.msg, {
					icon: 1
				});
				window.location.reload();
			}
		});
	},
	function() {});
}

function dels_down() {
	layer.confirm('你确实要清空下载日志吗？', {
		btn: ['确定', '取消'],
		icon: 3
	},
	function() {
		var ii = layer.msg("正在清空数据！", {
			icon: 16,
			time: 0
		});
		$.ajax({
			type: 'get',
			url: 'ajax.php?act=del_down&my=s',
			dataType: 'json',
			success: function(data) {
				layer.msg(data.msg, {
					icon: 1
				});
				window.location.reload();
			}
		});
	},
	function() {});
}

//解析教程
function nslook() {
               layer.open({
                        type: 1,
                        title: '解析教程',
                        shadeClose: true,
                        shade: 0.3,
                        area: '85%',
                        offset: '70px',
                        content: "<img src='/assets/img/txt.png' width='100%'/>"
                    });
}

