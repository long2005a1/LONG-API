layui.use(['admin', 'table', 'element'],function() {
	var $ = layui.jquery;
	var admin = layui.admin;
	var table = layui.table;
	var element = layui.element;
	// 授权查询
	$("#url_submit").click(function() {
		$('.submit').attr("disabled", true);
		$(".submit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>查询中...');
		admin.showLoading('#divLoading', 2, '.8');
		$.ajax({
			type: "GET",
			url: "ajax.php?act=check_url&url=" + $("#url").val(),
			dataType: "json",
			success: function(data) {
				setTimeout(function() {
					$(".submit").html('点我查询');
					$('.submit').attr("disabled", false);
					admin.removeLoading('#divLoading', true, true);
					if (data.code == 1) {
						class_Tips(data.msg, 'success');
					} else {
						class_Tips(data.msg, 'error');
					}
				},
				300);
			}
		});
	});
	// 域名注册查询
	$("#domain_submit").click(function() {
		var index = layer.prompt({
			formType: 3,
			value: '',
			title: '请输入查询域名'
		},	
		function(value, index, elem) {
			admin.showLoading('#divLoading', 2, '.8');
			$.ajax({
				type: "GET",
				url: "ajax.php?act=domain_reg&domain=" + $("#domain").val(),
				async: true,
				typeData: 'json',
				data: {
					domain: value
				},
				success: function(data) {
					setTimeout(function() {
						admin.removeLoading('#divLoading', true, true);
						if (data.code == 200) {
							layer.alert(''+data.msg+',如果你喜欢可以去购买！', {
			title: '域名查询',
			//icon: '6',
			area: '330px;',
			btn: ['购买', '算了'],
			btn1: function(layero, index) {
				window.open("https://dnspod.cloud.tencent.com/", "_blank");
			}
		});
	
						} else {
							class_Tips(data.msg, 'error');
						}
					},
					300);
				},
				error: function() {
					class_Tips('服务器链接失败！', 'error');
				}
			});
		});
	});
	// 代理查询
	$("#user_submit").click(function() {
		var index = layer.prompt({
			formType: 3,
			value: '',
			title: '请输入代理QQ'
		},
		function(value, index, elem) {
			admin.showLoading('#divLoading', 2, '.8');
			$.ajax({
				type: "GET",
				url: "ajax.php?act=check_dl&qq=" + $("#qq").val(),
				async: true,
				typeData: 'json',
				data: {
					qq: value
				},
				success: function(data) {
					setTimeout(function() {
						admin.removeLoading('#divLoading', true, true);
						if (data.code == 1) {
							class_Tips(data.msg, 'success');
						} else {
							class_Tips(data.msg, 'error');
						}
					},
					300);
				},
				error: function() {
					class_Tips('服务器链接失败！', 'error');
				}
			});
		});
	});
	// 更换授权验证
	$("#send_submit").click(function() {
		$('.mail').attr("disabled", true);
		$(".mail").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>获取验证码中...');		
		admin.showLoading('#divLoading', 2, '.8');
		$.ajax({
			type: "POST",
			url: "ajax.php?act=gh_code",
			data: {
				qq: $("#qq").val(),
				csrf_token: $("input[name='csrf_token']").val()
			},
			dataType: "json",
			success: function(data) {
				setTimeout(function() {
				    $(".mail").html('发送验证码');
			        $('.mail').attr("disabled", false);
					admin.removeLoading('#divLoading', true, true);
					if (data.code == 1) {
						class_Tips(data.msg, 'success');
					} else {
						class_Tips(data.msg, 'error');
					}
				},
				300);
			}
		});
	});
	// 更换授权
	$("#replace_submit").click(function() {
	    $('.submit').attr("disabled", true);
		$(".submit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>请求中...');
		var url = $("#url").val();
		var urlauth = $("#urlauth").val();
		var qq = $("#qq").val();
		var code = $("#code").val();
		admin.showLoading('#divLoading', 2, '.8');
		$.ajax({
			type: "POST",
			url: "ajax.php?act=ghsq",
			data: {
				url: url,
				urlauth: urlauth,
				qq: qq,
				code: code
			},
			dataType: 'json',
			success: function(data) {
				setTimeout(function() {
				    $(".submit").html('确定更换域名');
			        $('.submit').attr("disabled", false);
					admin.removeLoading('#divLoading', true, true);
					if (data.code == 1) {
						class_Tips(data.msg, 'success');
					} else {
						class_Tips(data.msg, 'error');
					}
				},
				300);
			},
			error: function(data) {
				layer.close(ii);
				layer.msg('服务器错误');
			}
		});
	});
	// 下载验证
	$("#downfile_submit").click(function() {
	    $('.mail').attr("disabled", true);
		$(".mail").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>获取验证中...');
		var qq = $("#qq").val();
		var csrf_token=$("input[name='csrf_token']").val();
		admin.showLoading('#divLoading', 2, '.8');
		$.ajax({
			type: "POST",
			url: "ajax.php?act=down_code",
			data: {
				qq: qq,
				csrf_token:csrf_token
			},
			dataType: "json",
			success: function(data) {
				setTimeout(function() {
				$(".mail").html('发送验证码');
			    $('.mail').attr("disabled", false);
			    admin.removeLoading('#divLoading', true, true);
					if (data.code == 1) {
						class_Tips(data.msg, 'success');
					} else {
						class_Tips(data.msg, 'error');
					}
				},
				300);
			}
		});
	});
	// 下载源码
	$("#down_file").click(function() {
	    $('.submit').attr("disabled", true);
		$(".submit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>请求中...');
		var qq = $("#qq").val();
		var code = $("#code").val();
		admin.showLoading('#divLoading', 2, '.8');
		$.ajax({
			type: "GET",
			url: "ajax.php?act=down_file",
			data: {
				qq: qq,
				code: code
			},
			dataType: "json",
			success: function(data) {
				setTimeout(function() {
				$(".submit").html('获取源码');
			    $('.submit').attr("disabled", false);
					admin.removeLoading('#divLoading', true, true);
				if (data.code == 1) {
					var confirmobj = layer.confirm('授权QQ:'+data.qq+'<br/>授权码：'+data.authcode+'<br/>特征码：'+data.sign+'', {
                        btn: ['安装包','更新包','取消']
                    }, function(){
                        window.location.href=data.installer;
                    }, function(){
                        window.location.href=data.updater;
                    }, function(){
                        layer.close(confirmobj);
                    });
                }else {
						class_Tips(data.msg, 'error');
					}
				},
				300);
			},
			error: function(data) {
				layer.close(load);
				layer.msg('服务器错误');
			}
		});
	});
	// 卡密授权
	$("#kmsq_submit").click(function() {
	    $('.submit').attr("disabled", true);
		$(".submit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>请求中...');
	var csrf_token=$("input[name='csrf_token']").val();
	var qq = $("#qq").val();
	var url = $("#url").val();
	var km = $("#km").val();
	var geetest_challenge = $("input[name='geetest_challenge']").val();
	var geetest_validate = $("input[name='geetest_validate']").val();
	var geetest_seccode = $("input[name='geetest_seccode']").val();
	admin.showLoading('#divLoading', 2, '.8');
	$.ajax({
		type: "POST",
		url: "ajax.php?act=kmsq",
		data: {
		    csrf_token:csrf_token,
			qq: qq,
			url: url,
			km: km,
			geetest_challenge: geetest_challenge,
			geetest_validate: geetest_validate,
			geetest_seccode: geetest_seccode
		},
		dataType: 'json',
			success: function(data) {
				setTimeout(function() {
			    	$(".submit").html('确定授权');
			        $('.submit').attr("disabled", false);
					admin.removeLoading('#divLoading', true, true);
					if (data.code == 1) {
						class_Tips(data.msg, 'success');
					} else {
						class_Tips(data.msg, 'error');
					}
				},
				300);
			},
			error: function(data) {
				layer.close(ii);
				layer.msg('服务器错误');
			}
		});
	});
	// 找回密码
	$(document).ready(function(){
	$("#retpass_submit").click(function(){
		if ($(this).attr("data-lock") === "true") return;
		var qq=$("input[name='qq']").val();
		var geetest_challenge=$("input[name='geetest_challenge']").val();
		var geetest_validate=$("input[name='geetest_validate']").val();
		var geetest_seccode=$("input[name='geetest_seccode']").val();
		if (!$("#qq").val()) {
			class_Tips('请输入您QQ账号！', 'info');
			return false;
		}
		var reg = /^([a-zA-Z0-9_-])+([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
		if(!reg.test(qq)){
			class_Tips('QQ格式不正确！', 'error');
			return false;
		}
		admin.showLoading('#divLoading', 2, '.8');
	       $.ajax({
			type : "POST",
			url : "ajax.php?act=retpass",
			data : {qq:qq,geetest_challenge:geetest_challenge,geetest_validate:geetest_validate,geetest_seccode:geetest_validate},
			dataType : 'json',
			success: function(data) {
				setTimeout(function() {
					admin.removeLoading('#divLoading', true, true);
					if (data.code == 1) {
						class_Tips(data.msg, 'success');
					} else {
						class_Tips(data.msg, 'error');
					}
				},
				300);
			},
			error: function(data) {
				layer.close(ii);
				layer.msg('服务器错误');
			}
		});
	});
  });
});
   $("#course").click(function() {
		layer.alert('环境安装：<hr/>需支持SG11加密拓展环境<br>宝塔安装SG11加密拓展教程<br>软件商店/运行环境/安装PHP7.3/点击设置/安装拓展/找到sg11加密安装<br><br>信息配置：<hr/>安装完成拓展上传本系统安装包到目录根、访问域名点击在线安装然后填写数据库信息、配置数据库信息页面有一个网站( 授权码 )输入框、授权码去授权站( 下载源码 )里面获取然后填写进输入框保存配置就OK啦！', {
			title: '安装教程',
			//icon: '6',
			area: '330px;',
			btn: ['没看懂', '看懂了'],
			btn1: function(layero, index) {
				window.open("https://api.uomg.com/api/qq.talk?qq=85432394", "_blank");
			}
		});
	});
	
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

var OriginTitile = document.title,titleTime;
document.addEventListener("visibilitychange",
function() {
    if (document.hidden) {
        
        document.title = "页面已崩溃！点击恢复！";
        clearTimeout(titleTime)
    } else {
        
        document.title = "(/≧▽≦/)咦！又好了！ " + OriginTitile;
        titleTime = setTimeout(function() {
            document.title = OriginTitile
        },
        2000)
    }
});

const showFPS = (function () {
 
  // noinspection JSUnresolvedVariable, SpellCheckingInspection
  const requestAnimationFrame =
      window.requestAnimationFrame || // Chromium
      window.webkitRequestAnimationFrame || // Webkit
      window.mozRequestAnimationFrame || // Mozilla Geko
      window.oRequestAnimationFrame || // Opera Presto
      window.msRequestAnimationFrame || // IE Trident?
      function (callback) { // Fallback function
         window.setTimeout(callback, 1000 / 60);
      };
  let dialog;
  let container;
  let fps = 0;
  let lastTime = Date.now();
  function setStyle(el, styles) {
    for (const key in styles) {
      el.style[key] = styles[key];
    }
  }
 
  function init() {
    dialog = document.createElement('dialog');
    setStyle(dialog, {
      display: 'block',
      border: 'none',
      backgroundColor: 'rgba(0, 0, 0, 0.6)',
      margin: 0,
      padding: '4px',      position: 'fixed',
      top: 0,
      right: 'auto,',
      bottom: 'auto',
      left: 0,
      color: '#fff',
      fontSize: '12px',
      textAlign: 'center',
      borderRadius: '0 0 4px 0'
    });
    container.appendChild(dialog);
  }
 
  function calcFPS() {
    let offset = Date.now() - lastTime;
     fps += 1;
    if (offset >= 1000) {
      lastTime += offset;
      displayFPS(fps);
      fps = 0;
    }
    requestAnimationFrame(calcFPS);
  }
 
  function displayFPS(fps) {
    const fpsStr = `${fps} FPS`;
    if (!dialog) {
      init();
    }
    if (fpsStr !== dialog.textContent) {
      dialog.textContent = fpsStr;
    }
  }
  return function (parent) {
    container = parent;
    calcFPS();
  };
}());
showFPS(document.body);