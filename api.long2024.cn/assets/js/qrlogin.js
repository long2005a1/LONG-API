var interval1,interval2;
function setCookie(name,value)
{
	var exp = new Date();
	exp.setTime(exp.getTime() + 30*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
}
function getqrpic(force){
	force = force || false;
	cleartime();
	var qrsig = getCookie('qrsig');
	var qrimg = getCookie('qrimg');
	if(qrsig!=null && qrimg!=null && force==false){
		$('#qrimg').attr('qrsig',qrsig);
		$('#qrimg').html('<img id="qrcodeimg" onclick="getqrpic(true)" src="data:image/png;base64,'+qrimg+'" title="点击刷新">');
		if( /Android|SymbianOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Windows Phone|Midp/i.test(navigator.userAgent) && navigator.userAgent.indexOf("QQ/") == -1) {
			$('#mobile').show();
		}
		interval1=setInterval(loginload,1000);
		interval2=setInterval(qrlogin,3000);
	}else{
		var getvcurl='/includes/lib/qrlogin.php?do=getqrpic&r='+Math.random(1);
		$.get(getvcurl, function(d) {
			if(d.saveOK ==0){
				setCookie('qrsig',d.qrsig);
				setCookie('qrimg',d.data);
				$('#qrimg').attr('qrsig',d.qrsig);
				$('#qrimg').html('<img id="qrcodeimg" onclick="getqrpic(true)" src="data:image/png;base64,'+d.data+'" title="点击刷新">');
				if( /Android|SymbianOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Windows Phone|Midp/i.test(navigator.userAgent) && navigator.userAgent.indexOf("QQ/") == -1) {
					$('#mobile').show();
				}
				interval1=setInterval(loginload,1000);
				interval2=setInterval(qrlogin,3000);
			}else{
				//alert(d.msg);
		      	layer.alert(d.msg,{icon:2});
			}
		}, 'json');
	}
}
function qrlogin(){
	if ($('#login').attr("data-lock") === "true") return;
	var qrsig=$('#qrimg').attr('qrsig');
	var url = '/includes/lib/qrlogin.php?do=qrlogin&qrsig='+decodeURIComponent(qrsig)+'&r='+Math.random(1);
	$.get(url, function(d) {
		if(d.saveOK ==0){
			$('#loginmsg').html('QQ已成功登录！');
			$('#login').hide();
			$('#qrimg').hide();
			$('#submit').hide();
			$('#login').attr("data-lock", "true");
			$.get("/User/ajax.php?act=qrlogin&r="+Math.random(1), function(arr) {
				if(arr.code==1) {
			    layer.msg(arr.msg,{icon:1,time:2500,end:function(){window.location.href=arr.url}});
                layer.close(qqcode);
				}else{
		      	layer.alert(arr.msg,{icon:2});
				layer.close(qqcode);
				}
			}, 'json');
			cleartime();
		}else if(d.saveOK ==1){
			getqrpic(true);
			$('#loginmsg').html('请重新扫描二维码');
		}else if(d.saveOK ==2){
			$('#loginmsg').html('TIM手机版扫描二维码');
		}else if(d.saveOK ==3){
			$('#loginmsg').html('扫描成功，请在手机上确认授权登录');
		}else if(d.saveOK ==4){
			cleartime();
			$('#loginmsg').html('QQ验证失败，请解除登录异常后重试！');
		}else{
			cleartime();
			$('#loginmsg').html(d.msg);
		}
	}, 'json');
}
function loginload(){
	if ($('#login').attr("data-lock") === "true") return;
	var load=document.getElementById('loginload').innerHTML;
	var len=load.length;
	if(len>2){
		load='.';
	}else{
		load+='.';
	}
	document.getElementById('loginload').innerHTML=load;
}
function cleartime(){
	clearInterval(interval1);
	clearInterval(interval2);
}
$(document).ready(function(){
	getqrpic();
});






