/*代理退出登入*/
function logou() {
	layer.confirm('主人别离开我~>_<~', {
		btn: ['确定', '取消'],
		closeBtn: 0,
		icon: 3
	},
	function() {
		var ii = layer.load(1, {
			shade: [0.1, '#fff']
		});
		$.ajax({
			type: "GET",
			url: "ajax.php?act=login&logout",
			dataType: 'json',
			success: function(data) {
				layer.close(ii);
				if (data.code == 1) {
					layer.msg(data.msg, {
						icon: 1,
						time: 2000,
						end: function() {
							window.location.href = "login.php"
						}
					});
				}
			}
		});
	},
	function() {});
};
/*代理登陆*/
$("#login_submit").click(function() {
	var user = $("input[name='user']").val();
	var pass = $("input[name='pass']").val();
	var qq = $("input[name='qq']").val();
	var code = $("input[name='code']").val();
	if (!user || !pass || !code) {
		class_Tips('确保没一项不能为空哟！', 'info');
		return false;
	}
	load = layer.load(1);
	$.ajax({
		type: "POST",
		url: "ajax.php?act=login",
		data: {
			"user": user,
			"pass": pass,
			"qq": qq,
			"code": code
		},
		dataType: "json",
		success: function(data) {
		layer.close(load);
			if (data.code == 1) {
				var down = layer.confirm(data.msg, {
					btn: ['确定', '取消'],
					closeBtn: 0,
					icon: 1,
					title: '登陆成功'
				},
				function() {
					$.ajax({
						type: "get",
						url: "index.php",
						dataType: "html",
						success: function(html) {
							window.location.href = "index.php";
						}
					});
					layer.close(down);
				},
				function() {
					$.ajax({
						type: "get",
						url: "ajax.php?act=login&logout",
						dataType: "json",
						success: function(data) {
							if (data.code == 0) {
								layer.msg(data.msg, {
									icon: 1,
									anim: 6,
									time: 2000,
									end: function() {
										window.location.href = "login.php"
									}
								});
							}
						}
					});
				});
			} else {
				class_Tips(data.msg, 'error');
			}
		}
	});
});
function send() { //代理登陆验证
	if (!$("#qq").val()) {
		class_Tips('QQ输入不能为空！', 'info');
		return false;
	}
	load = layer.load(1);
	$.ajax({
		type: "POST",
		async: true,
		url: "ajax.php?act=login_mail",
		data: {
			qq: $("#qq").val(),
			csrf_token: $("input[name='csrf_token']").val()
		},
		dataType: "json",
		success: function(data) {
			layer.close(load);
			if (data.code == 1) {
				layer.msg(data.msg, {
					icon: 6,
					anim: 6
				});
			} else {
				layer.msg(data.msg, {
					icon: 5,
					anim: 6
				});
			}
		}
	});
}
	
function password() { //修改密码
	var pass = $("#pass").val();
	var geetest_challenge = $("input[name='geetest_challenge']").val();
	var geetest_validate = $("input[name='geetest_validate']").val();
	var geetest_seccode = $("input[name='geetest_seccode']").val();
	var ii = layer.load(1, {
		shade: [0.1, '#fff']
	});
	$.ajax({
		type: "POST",
		url: "ajax.php?act=pass",
		data: {
			pass: pass,
			geetest_challenge: geetest_challenge,
			geetest_validate: geetest_validate,
			geetest_seccode: geetest_seccode
		},
		dataType: 'json',
		success: function(data) {
			layer.close(ii);
			if (data.code == 1) {
				layer.msg(data.msg, {
					icon: 6,
					anim: 6
				});
				setTimeout(function() {
					location.href = "/";
				},
				1000); //延时1秒跳转
			} else {
				layer.msg(data.msg, {
					icon: 5,
					anim: 6
				});
			}
		},
		error: function(data) {
			layer.close(ii);
			layer.msg('服务器错误');
		}
	});
}

/* 获取验证码 */
$('#btnGetCode').click(function() {
    var $btn = $(this);
    var $qq = $('input[name="qq"]');
    var email = $qq.val();
    if (!email) {
        layer.tips('请输入QQ账号！', $qq, {
            tips: [1, '#ff4c4c']
        });
        return;
    }
    var layIndex = layer.open({
        type: 1,
        title: false,
        shade: 0.1,
        closeBtn: false,
        content: ['<div class="layer-get-code">', '<div class="layui-form-item">', '   <p>验证码将发送到您的邮箱，点击按钮即可发送！</p></br>', '      	<div class="layui-row">', '      		<div class="layui-col-xs7">', '      			<input type="text" id="code" name="code" lay-verify="required" lay-vertype="tips" value="" placeholder="请输入邮箱验证码！" class="layui-input">', '          </div>', '      	  <div class="layui-col-xs5">', '	          <div style="margin-left: 10px;">', '		          <input type="button" class="layui-btn layui-btn-normal" onclick="forget_mail()" value="发送验证码"/>', '		      </div>', '	      </div>', '	  </div>', '   </div><a type="button" class="layui-btn layui-btn-normal layui-btn-fluid" onclick="forget()" >确定找回</a></div>', '</div>'].join(''),
    })
});

/* 找回密码 */
function forget_mail() {
	var ii = layer.load(3, {shade:[0.1,'#fff']});
	$.ajax({
		type: "POST",
		url: "ajax.php?act=forget_mail",
		data: {
			qq: $("#qq").val(),
			csrf_token: $("#csrf_token").val()
		},
		dataType: "json",
		success: function(data) {
			layer.close(ii);
			if (data.code == 1) {
				layer.msg(data.msg, {
					icon: 6,
					anim: 6
				});
			} else {
				layer.msg(data.msg, {
					icon: 5,
					anim: 6
				});
			}
		}
	});
}
/* 找回密码 */
function forget() {
	var qq = $("input[name='qq']").val();
	var code = $("input[name='code']").val();
	if (!qq || !code) {
		class_Tips('主要参数不能为空！','error');
        return;
	}
	var ii = layer.load(3, {shade:[0.1,'#fff']});
	$.ajax({
		type: "POST",
		url: "ajax.php?act=forget",
		data: {
			qq: qq,
			code: code
		},
		dataType: "json",
		success: function(data) {
			layer.close(ii);
			if (data.code == 1) {
				layer.confirm('账号信息</br>' + data.forget, {
					icon: 6,
					anim: 6
				});
			} else {
				layer.msg(data.msg, {
					icon: 5,
					anim: 6
				});
			}
		}
	});
}

function token() {
    var ii = layer.load(3, {shade:[0.1,'#fff']});
    $.ajax({
        type: "GET",
        url: "ajax.php?act=api_token",
        dataType: "json",
        success: function(data) {
            layer.close(ii);
            if (data.code == 0) {
               layer.msg(data.msg, {icon: 6});
               setTimeout(function(){
									    	 window.location.reload();
									    },1000)
            } else {
                layer.msg(data.msg, {icon: 5});
            }
        }
    });
};
function ghtoken() {
	layer.confirm('更换后则之前的TOKEN将失效！<br>确认更换？', {icon: 3, title:'提示'}, function(index){
    var ii = layer.load(3, {shade:[0.1,'#fff']});
    $.ajax({
        type: "GET",
        url: "ajax.php?act=api_token",
        dataType: "json",
        success: function(data) {
            layer.close(ii);
            if (data.code == 0) {
               layer.msg(data.msg, {icon: 6});
               setTimeout(function(){
									    	 window.location.reload();
									    },1000)
            } else {
                layer.msg(data.msg, {icon: 5});
            }
        }
    });
    layer.close(index);
});
};
function api_ip() {
    var ii = layer.load(3, {shade:[0.1,'#fff']});
    $.ajax({
        type: "GET",
        url: "ajax.php?act=api_ip",
        dataType: "json",
        success: function(data) {
            layer.close(ii);
           
               if(data.code == 0){
				layer.open({
				  type: 1,
				  title: '白名单设置',
				  skin: 'layui-layer-rim',
				  maxmin: true,
				  content: data.data
				  
				});
			}else{
				layer.msg(data.msg, {icon: 5});
			}
        }
    });
};
function saoma() { //扫码登陆
	qqcode = layer.open({
		type: 1,
		offset: '100px',
		anim: 5,
		shadeClose: true,
		closeBtn: 0,
		title: 'TIM快捷扫码登录!',
		content: '<div class="form-group" style="text-align: center;"><div style="margin-top:1rem;margin-bottom:1rem;color:#666" id="login"><span id="loginmsg">TIM手机版扫描二维码</span><span id="loginload" style="color: #790909;">.</span></div><div id="qrimg"></div><script src="/assets/js/qrlogin.js?ver=VERSION"><\/script>'
	});
}
$("#qq_login").click(function() {
			layer.alert('确定使用QQ快捷登陆吗！', {
				title: '快捷登陆',
				icon: '3',
				btn: ['确定', '算了'],
				btn1: function(layero, index) {
					layer.msg('正在调起QQ登陆……', {
						icon: 1,
						time: 4000
					});
					window.location.href = './connect.php?bind=1';
				}
			});
		});
/* 代理首页公告 */
function show(id) {
	$.ajax({
		type : 'get',
		url : 'ajax.php?act=msginfo&id='+id,
		dataType : 'json',
		success : function(data) {
			if(data.code==1){
				layer.open({
                  type: 1,
                  title: '公告内容',
                  skin: 'layui-layer-admin',
                  //closeBtn: true,
                  area: '350px',
                  anim: 5,
                  shadeClose: true,
                  content: '<div style="padding:20px;"><fieldset class="layui-elem-field layui-field-title"><legend>'+data.title+'</legend></fieldset><blockquote class="layui-elem-quote"><b style="color:red">公告内容：</b></br>'+data.content+'</blockquote></br><blockquote class="layui-elem-quote">发布时间：'+data.date+'</blockquote></div>',
				  end: function(){
					  window.location.reload()
				  }
            });
			}else{
				layer.alert(data.msg);
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}	

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
			var endtime = $("select[name='endtime']").val();
			var time = $("#time").val();
			addkm(count,endtime,time);
		},	
		end: function(){
			$('.kmform').hide(500);
		}
	  });
}

function addkm(count) { //后台添加卡密
    if(count==''){
	 return layer.tips('请输入数量', '#count', {
          tips: [3, '#0099FF'],
          time: 1500
        });
	}
	var ii = layer.load(2);
	$.ajax({
		type: "post",
		url: "ajax.php?act=add_km",
		data: {
			count: count
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