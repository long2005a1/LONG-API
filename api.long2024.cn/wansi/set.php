<?php
include("../includes/common.php");
$title='系统配置';
$isAdmin = isAdmin($_COOKIE["admin_token"]);
if (empty($isAdmin))exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $title?></title>
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/assets/iframe/libs/layui/css/layui.css"/>
  <link rel="stylesheet" href="/assets/iframe/module/admin.css?v=318"/>
  <link rel="stylesheet" href="/assets/iframe/css/nprogress.css" media="all">
  <style type="text/css">
    .layui-card {
        border-radius: 10px;
    }
	</style>
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card">  
    <div id="divLoading">
<?php
$set=isset($_GET['set'])?$_GET['set']:null;
if($set=='site'){
?>
   <div class="layui-card-header">网站信息配置</div>
        <div class="layui-card-body">
            <form class="layui-form layui-form-pane">

                <div class="layui-form-item">
                    <label class="layui-form-label">网站名称</label>
                    <div class="layui-input-block">
                    <input type="text" name="sysname" value="<?=$system['sysname']?>" placeholder="请输入您的网站名称" class="layui-input"/>
                    </div>
                </div>            
                                    
                <div class="layui-form-item">
                    <label class="layui-form-label">网站标题</label>
                    <div class="layui-input-block">
                    <input type="text" name="title" value="<?=$system['title']?>" placeholder="请输入您的网站标题" class="layui-input" />
                    </div>
                </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">关键词</label>
                    <div class="layui-input-block">
                    <input type="text" name="keywords" value="<?=$system['keywords']?>" placeholder="请输入您的网站关键词" class="layui-input"/>
                    </div>
                </div>

               <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">网站描述</label>
                    <div class="layui-input-block">
                    <textarea class="layui-textarea" name="description" placeholder="请输入您的网站描述"><?=$system['description']?></textarea>
                    </div>
                </div>                

                                                
                <div class="layui-form-item">
                    <label class="layui-form-label">客服QQ</label>
                    <div class="layui-input-block">
                    <input type="text" name="zzqq" value="<?php echo $system['zzqq']; ?>" placeholder="请输入您的客服QQ" class="layui-input"/>
                    </div>
                </div>
                

                <div class="layui-form-item">
                    <label class="layui-form-label">联系QQ群</label>
                    <div class="layui-input-block">
                    <input type="text" name="qunurl" value="<?php echo $system['qunurl']; ?>" placeholder="请输入您的QQ群" class="layui-input"/>
                    </div>
                </div>             
                
                <div class="layui-form-item">
                    <label class="layui-form-label">网站备案号</label>
                    <div class="layui-input-block">
                    <input type="text" name="icp" value="<?php echo $system['icp']; ?>" placeholder="请输入您的网站ICP备案号码" class="layui-input"/>
                    </div>
                </div>         
            
            
                <div class="layui-form-item">
                    <label class="layui-form-label">ICO图标</label>
                  <div class="layui-input-block">
                    <input type="text" class="layui-input" name="ico" id="img_ico" value="<?=$system['ico'] ?>" />
                     <div style="display:none;"><input id="photoFile_ico" type="file" onchange="upload('ico')"></div>
                    <button class="layui-btn layui-btn-normal" type="button" onclick="uploadPhoto('ico')">上传图片</button>
                 </div>
               </div>
                

                <div class="layui-form-item">
                    <label class="layui-form-label">LOGO图标</label>
                  <div class="layui-input-block">
                    <input type="text" class="layui-input" name="logo" id="img_logo" value="<?=$system['logo'] ?>" />
                    <div style="display:none;"><input id="photoFile_logo" type="file" onchange="upload('logo')"></div>
                    <button class="layui-btn layui-btn-normal" type="button" onclick="uploadPhoto('logo')">上传图片</button>
                 </div>
               </div>
            
                
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">网站公告：<span style="color:red;">不能增加标签</span></label>
                    <div class="layui-input-block">
                    <textarea class="layui-textarea" name="gonggao" placeholder="请输入公告内容"><?php echo htmlspecialchars($system['gonggao']); ?></textarea>
                    </div>
                </div> 
                
                
                <!--<div class="layui-form-item layui-form-text">-->
                <!--    <label class="layui-form-label">弹窗公告</label>-->
                <!--    <div class="layui-input-block">-->
                <!--    <textarea class="layui-textarea" name="tanc" placeholder="请输入公告内容"><?php echo htmlspecialchars($system['tanc']); ?></textarea>-->
                <!--    </div>-->
                <!--</div> -->
                


                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">禁止IP</label>
                    <div class="layui-input-block">
                    <textarea class="layui-textarea" name="prohibit_ip" placeholder="请输入禁止访问资源分享地址的IP"><?=$system['prohibit_ip']?></textarea>
                    </div>
                </div>           
            
              <div class="layui-inline">
                <div class="layui-form-item">
                    <label class="layui-form-label">QQ跳转浏览器</label>
                    <div class="layui-input-block">
                        <select name="qqjump" default="<php echo $system['qqjump']; ?>" class="layui-input">
                            <option <?php echo $system['qqjump'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                            <option <?php echo $system['qqjump'] == 1 ? 'selected ' : '' ?>value="1">开启</option>
                        </select>
                    </div>
                </div>
              </div>

                <div class="layui-form-item layui-row layui-col-space10 ">
                    <div class="layui-col-md2">
                    <button type="button" class="layui-btn layui-btn-fluid" lay-submit lay-filter="account">&emsp;保存配置&emsp;</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
}elseif($set=='pwd'){
$title='修改密码';
?>
<div class="layui-fluid">
    <div class="layui-card">
	<div class="layui-card-header">修改密码</div>
        <div class="layui-card-body">
            <!-- 表单开始 -->
<form method="post" class="layui-form" id="formAdvForm" lay-filter="formAdvForm" role="form">
<div class="layui-form-item">
                    <label class="layui-form-label">原密码:</label>
                    <div class="layui-input-block">
<input type="password" maxlength="16" name="oldpassword" class="layui-input"/>
</div></div>

<div class="layui-form-item">
                    <label class="layui-form-label">新密码:</label>
                    <div class="layui-input-block">
<input type="password"  maxlength="16" name="newpassword" placeholder="不修改请留空" class="layui-input">
</div></div>

<div class="layui-form-item">
                    <label class="layui-form-label">确认新密码:</label>
                    <div class="layui-input-block">
<input type="password" name="newpasswordr" class="layui-input" placeholder="不修改请留空">
</div></div>

<div class="layui-form-item text-right">
        <button class="layui-btn" type="button" lay-submit lay-filter="pass">&emsp;提交&emsp;</button>
     </div>
  </form>
</div>
</div>
<?php
}elseif($set=='theme'){
$title='模板设置';

$temp = [];
$file_path = '../template/';//模板目录
$handler = opendir($file_path);
while($file_name = readdir($handler)){
    if($file_name != "." && $file_name != ".."){
        $temp[] = $file_name;
    }
}
closedir($handler);
?>
<div class="layui-card-header">模板配置</div>
        <div class="layui-card-body">
            <form class="layui-form layui-form-pane">
                <div class="layui-inline">
                 <div class="layui-form-item">
                    <label class="layui-form-label">选择模板</label>
                    <div class="layui-input-block">
                        <select name="theme" default="<php echo $system['theme']; ?>" class="layui-input">
                           <?php foreach($temp as $v): ?>
                            <option <?php if($system['theme'] == $v): ?>selected<?php endif ?>><?php echo $v; ?></option>
                           <?php endforeach ?>
                        </select>
                    </div>
                </div>
                </div>
                <div class="layui-form-item layui-row layui-col-space10 ">
                    <div class="layui-col-md2">
                    <button type="button" class="layui-btn layui-btn-fluid" lay-submit lay-filter="theme">&emsp;保存配置&emsp;</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>
<?php 
include "foot.php";
?>  
<script type="text/javascript">
layui.use(['form', 'element', 'jquery', 'admin', 'laydate', 'notice'], function () {
    var form = layui.form;
    var $ = layui.jquery;
    var laydate = layui.laydate;
    var admin = layui.admin;
    var notice = layui.notice;
    form.on('submit(account)', function (data) {
        admin.showLoading('#divLoading', 2, '.8');
        notice.destroy();
        admin.btnLoading('[lay-filter="account"]',' 修改中');
        $.post('./ajax.php?act=systemForm', data.field, function (data) {
            admin.removeLoading('#divLoading', true, true);
            admin.btnLoading('[lay-filter="account"]', false);
            if(data.code == 200){
                notice.msg(data.msg, {animateInside: true, icon: 1});
            } else {
                notice.msg(data.msg, {animateInside: true, icon: 2});
            }
        });
        return false;
    });
    //修改密码
    form.on('submit(pass)', function (data) {
        admin.btnLoading('[lay-filter="pass"]',' 修改中');
        admin.showLoading('#divLoading', 2, '.8');
        notice.destroy();
        $.post('ajax.php?act=passwordForm', data.field, function (data) {
        admin.removeLoading('#divLoading', true, true);
        admin.btnLoading('[lay-filter="pass"]', false);
            if(data.code == 200){
                notice.msg(data.msg, {animateInside: true, icon: 1});
                top.location.replace(location.href = './login.php');
            } else {
                notice.msg(data.msg, {animateInside: true, icon: 2});
            }
        });
        return false;
    });
    //模板设置
    form.on('submit(theme)', function (data) {
        admin.btnLoading('[lay-filter="theme"]',' 修改中');
        admin.showLoading('#divLoading', 2, '.8');
        notice.destroy();
        $.post('ajax.php?act=systemForm', data.field, function (data) {
        admin.removeLoading('#divLoading', true, true);
        admin.btnLoading('[lay-filter="theme"]', false);
            if(data.code == 200){
                notice.msg('模板设置成功', {icon: 1});
                //top.location.replace(location.href = './index.php');
            } else {
                notice.msg(data.msg, {animateInside: true, icon: 2});
            }
        });
        return false;
    });
});
</script>
<script>
    /**
     * 上传图片
     */
     
    function uploadPhoto(id) {
        $("#photoFile_"+id).click();
    }
    function upload(id) {
        if ($("#photoFile_"+id).val() == '') {
            return;
        }
        var formData = new FormData();
        var ii = layer.load(0, {shade: false,time: 35000}); //0代表加载的风格，支持0-2
        formData.append('upfile', document.getElementById('photoFile_'+id).files[0]);
        $.ajax({
            url:"ajax.php?act=uploadImages",
            type:"post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                layer.close(ii);
                if (data.code == 200) {
                    layer.msg(data.msg, {icon: 1, time: 2000, shade: 0.4});
                    $("#preview_photo_"+id).attr("src", data.data);
                    $("#img_"+id).val(data.path);
                } else {
                    layer.msg(data.msg, {icon: 2, time: 2000, shade: 0.4});
                }
            },
            error:function(data) {
                layer.close(ii);
                layer.alert("网络连接错误");
            }
        });
    }
</script>