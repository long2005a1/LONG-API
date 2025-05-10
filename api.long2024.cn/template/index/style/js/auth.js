function keyEnter(info){
    //回车键的键值为13
    if (event.keyCode==13){
        if(info=='login'){
            login();
        }
        if(info=='register'){
            register();
        }
        if(info=='recover'){
            recover();
        }
        
    }
}

//注册
function register() {
    if($("input[name='username']").val()==''){layer.alert('请输入用户名！',{skin: 'closeBtn: 1',anim: 6,icon: 2});return false;}
    if($("input[name='email']").val()==''){layer.alert('请输入邮箱！',{skin: 'closeBtn: 1',anim: 6,icon: 2});return false;}
    if($("input[name='pass']").val()==''){layer.alert('请输入密码！',{skin: 'closeBtn: 1',anim: 6,icon: 2});return false;}
    if($("input[name='password']").val()==''){layer.alert('请输入确认密码！',{skin: 'closeBtn: 1',anim: 6,icon: 2});return false;}
    if($("input[name='pass']").val()!=$("input[name='password']").val()){layer.alert('两次密码不一致！',{skin: 'closeBtn: 1',anim: 6,icon: 2});return false;}
    var ii = layer.load(1, {shade: false,time: 5000}); //0代表加载的风格，支持0-2
    var form_data = $("#register_form").serialize();
    $.ajax({
        url: 'auth.php?act=register',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        success: function (data) {
            layer.close(ii);
            if (data.code == 1) {
                layer.msg(data.msg, {icon: 1, time: 2000, shade: 0.4}, function () {location.href = "./login.php";});
            } else {
                layer.msg(data.msg, {icon: 2, time: 2000, shade: 0.4});
            }
        },
        // error:function(data){
        //     layer.msg('服务器错误,请稍后重试',{skin: 'closeBtn: 1',anim: 6,icon: 2});
        //     return false;
        // }
    });
}

//登录
function login() {
    if($("input[name='username']").val()==''){layer.alert('请输入用户名！',{skin: 'closeBtn: 1',anim: 6,icon: 2});return false;}
    if($("input[name='password']").val()==''){layer.alert('请输入密码！',{skin: 'closeBtn: 1',anim: 6,icon: 2});return false;}
    var ii = layer.load(1, {shade: false,time: 5000}); //0代表加载的风格，支持0-2
    var form_data = $("#login_form").serialize();
    $.ajax({
        url: 'auth.php?act=login',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        success: function (data) {
            layer.close(ii);
            if (data.code == 1) {
                layer.msg(data.msg, {icon: 1, time: 2000, shade: 0.4}, function () {location.href = "./index.php";});
            } else {
                layer.msg(data.msg, {icon: 2, time: 2000, shade: 0.4});
            }
        },
        // error:function(data){
        //     layer.msg('服务器错误,请稍后重试',{skin: 'closeBtn: 1',anim: 6,icon: 2});
        //     return false;
        // }
    });
}

//找回密码
function recover() {
    if($("input[name='email']").val()==''){layer.alert('请输入邮箱！',{skin: 'closeBtn: 1',anim: 6,icon: 2});return false;}
    var ii = layer.load(1, {shade: false,time: 5000}); //0代表加载的风格，支持0-2
    $.ajax({
        url: 'auth.php?act=recover',
        type: 'POST',
        dataType: 'json',
        data: {
            email: $("input[name='email']").val()
        },
        success: function (data) {
            layer.close(ii);
            if (data.code == 1) {
                layer.msg(data.msg, {icon: 1, time: 2000, shade: 0.4}, function () {location.href = './login.php';});
            } else {
                layer.msg(data.msg, {icon: 2, time: 2000, shade: 0.4});
            }
        },
        // error:function(data){
        //     layer.msg('服务器错误,请稍后重试',{skin: 'closeBtn: 1',anim: 6,icon: 2});
        //     return false;
        // }
    });
}