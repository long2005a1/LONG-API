<?php
/**
 * 登录
**/
include("../includes/common.php");
$isAdmin = isAdmin($_COOKIE["admin_token"]);
if (!empty($isAdmin))exit("<script language='javascript'>window.location.href='./';</script>");


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=$system['sysname']?> - 后台登录</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" type="text/css" href="/assets/iframe/libs/layui/css/layui.css">
  <link rel="stylesheet" href="/assets/iframe/css/nprogress.css" media="all">
  <link rel="stylesheet" href="/assets/iframe/module/admin.css?v=318"/>
 <link rel="stylesheet" href="/assets/iframe/css/laylogin.css"/>
</head>
<body>
<style>
        body {
            background-image: url("/assets/iframe/images/bg-login.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
.logins{
	border: #cecece;
	background: #fff;
	border-radius: 5px;
	box-shadow: 0 0 50px #ccc;
}
</style>
    <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;"
    <div id="divLoading">
    <div class="layadmin-user-login-main">
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h2>管理登录</h2>
        <p>一站式操作API+blog程序</p>
      </div>
     <div class="layui-card layui-form" lay-filter="component-form-element">
        <div class="layui-card-header">
          管理员登录        </div>
     <div class="layui-card-body layui-row layui-col-space10">          
      <div class="layadmin-user-login-box layadmin-user-login-body ">
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-username"></label>
          <input type="text" name="username" placeholder="用户名" class="layui-input" onkeypress="elogin(event)">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-password"></label>
          <input type="password" name="password" placeholder="密码" class="layui-input" onkeypress="elogin(event)">
        </div>
        <div class="layui-form-item">
          <button class="layui-btn layui-btn-fluid layui-btn-normal login" id="login_submit" lay-submit lay-filter="login">登 入</button>
        </div>
      </div>
    </div>
    
    <div class="layui-trans layadmin-user-login-footer">
      <p><font color="#FFFFFF">Copyright © 2022 </font><a href="#" target="_blank"><font color="#FFFFFF"><?=$system['sysname']?> - By author @Mr.Vance.all</font></a></p>
    </div>    
  </div>
  <script type="text/javascript" src="/assets/iframe/libs/layui/layui.js"></script>
<script type="text/javascript" src="/assets/iframe/js/common.js?v=318"></script>
<script src="/assets/iframe/js/nprogress.js"></script>
<script>
   layui.use(['layer', 'form', 'admin', 'notice'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var form = layui.form;
        var admin = layui.admin;
        var notice = layui.notice;
	// 管理登录
    $("#login_submit").click(function() {
    $(".login").html("<i class='layui-icon layui-icon-loading-1 layui-icon layui-anim layui-anim-rotate layui-anim-loop'></i>");
    $('.login').attr('disabled',true);
    var user=$("input[name='username']").val();
    var pass=$("input[name='password']").val();
     if(user == ""){
     layer.msg("请输入用户名", {icon: 2, anim: 6, time:1500},function(){$('.login').attr('disabled',false);$(".login").html("登 录");});
     return false;
     }else if(pass == ""){
     layer.msg("请输入密码", {icon: 2, anim: 6, time:1500},function(){$('.login').attr('disabled',false);$(".login").html("登 录");});
     return false;
     }
     $.ajax({
		type:"post",
		url:"auth.php?act=login",
		data:{username:user,password:pass},
		dataType : 'json',
		success:function(data){
			if(data.code == 1){
				layer.msg(data.msg, {
                     icon: 6
                     ,time:1000
                     }, function(){
                    var index = layer.msg('正在进入后台管理中心', {icon: 16,time:0});
                    location.href='index.php';
                 });
			}else{
				layer.msg(data.msg, {
                     icon: 2
                     ,anim: 6
                     ,time:1000
                     },function(){$('.login').attr('disabled',false);$(".login").html("登 录");});
			}
		}
	});
    });
  });
  function elogin(event) {
    var code = event.charCode || event.keyCode;
    if (code == 13) {
        $('.login').click();
    }
  }
   NProgress.start();
   function neeprog() {
   	NProgress.done();
   }
   window.onload=neeprog;
   
  </script>
</body>
</html>