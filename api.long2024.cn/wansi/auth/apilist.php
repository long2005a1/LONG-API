<?php
/**
 * 授权列表
**/
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/common.php';
$title='授权列表';
$isAdmin = isAdmin($_COOKIE["admin_token"]);
if (empty($isAdmin))exit("<script language='javascript'>window.location.href='./login.php';</script>");
$count=$DB->getColumn("SELECT count(*) from auth_site WHERE 1");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
	<meta name="renderer" content="webkit">
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
<?php
$my=isset($_GET['my'])?$_GET['my']:null;
if(!$my=='edit') { 
?>
      <div class="layui-fluid">
		<div class="layui-row layui-col-space15">
			<div class="layui-col-md12">
				<div class="layui-card">
					<div class="layui-card-header">授权表格共有 <b><?=$count?></b> 个域名</div>
					<div class="layui-card-body">				
						<!-- 表格工具栏 -->
						<form class="layui-form toolbar">
							<div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label w-auto">选择类型</label>
                                    <div class="layui-input-block">
                                        <select name="type">
                                            <option value="0">全部</option>
                                            <option value="1">Q Q</option>
                                            <option value="2">域名</option>
                                            <option value="3">授权码</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-inline">
									<label class="layui-form-label w-auto">搜索数据：</label>
									<div class="layui-input-inline mr0">
										<input type="text" name="kw" class="layui-input" placeholder="请输入你所要搜索的内容！" />
									</div>
								</div>
                                <div class="layui-inline">
                                    <label class="layui-form-label w-auto">搜索类别</label>
                                    <div class="layui-input-block">
                                        <select name="method">
                                            <option value="0">精确搜索</option>
                                            <option value="1">模糊搜索</option>
                                        </select>
                                    </div>
                                </div>
								<div class="layui-inline">
									<button class="layui-btn icon-btn" lay-filter="roleTbSearch" lay-submit>
										<i class="layui-icon">&#xe615;</i>搜索
									</button>
								</div>
							</div>
						</form>
						<!-- 数据表格 -->
						<table class="layui-hide" id="site_list" lay-filter="site_list"></table>
						<script id="table_button" type="text/html">
							<a lay-event="edit" class="layui-btn layui-btn-normal layui-btn-xs"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                            <a lay-event="del" class="layui-btn layui-btn-danger layui-btn-xs"><i class="layui-icon layui-icon-delete"></i>删除</a>
						</script>
					</div>
				</div>
			</div>
		</div>
<?php		
}
?> 	
<?php  
$my=isset($_GET['my'])?$_GET['my']:null;
if($my=='edit') { 
$id = daddslashes($_GET['id']);
$row=$DB->get_row("SELECT * FROM auth_site WHERE id='$id' limit 1");
?>
    <div class="layui-fluid">
    <div id="divLoading">
     <div class="layui-card">
      <div class="layui-card-header">修改授权</div>
        <div class="layui-card-body">
            <form class="layui-form layui-form-pane" id="formBasForm" lay-filter="formBasForm">
                <div class="layui-form-item">
                    <label class="layui-form-label">QQ</label>
                    <div class="layui-input-block">
                    <input type="text" name="uid" id="uid" value="<?=$row['uid']?>" placeholder="请填写授权QQ账号[必填]" class="layui-input" />
                    </div>
                </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">域名</label>
                    <div class="layui-input-block">
                    <input type="text" name="url" id="url" value="<?=$row['url']?>" placeholder="请填写需要授权的域名不带http://" class="layui-input" />
                    </div>
                </div>
                
                <div class="layui-form-item">
                <label class="layui-form-label">授权码：</label>
                <div class="layui-input-block">
                    <input id="authcode" name="authcode" value="<?=$row['authcode']?>" placeholder="授权码！" class="layui-input"/>
                </div>
            </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">授权IP</label>
                    <div class="layui-input-block">
                    <input type="text" name="ip" id="ip" value="<?=$row['ip']?>" placeholder="IP留空自动获取！" class="layui-input" />
                    </div>
                </div>            
                                <div class="layui-form-item">
                    <label class="layui-form-label">特征码</label>
                    <div class="layui-input-block">
                    <input type="text" value="<?=$row['sign']?>" placeholder="特征码" class="layui-input" lay-tips="特征码不支持自定义！" lay-direction="1" lay-verify="required" readOnly/>
                    </div>
                </div>            
                
            <div class="layui-form-item">
                    
                   <div  id="embed-captcha">
                   <div id="wait"></div>
                    </div>
                </div>
                    
                    <div class="layui-form-item layui-row layui-col-space10 ">
                    <div class="layui-col-md2">
                    <button type="button" class="layui-btn layui-btn-fluid" lay-submit lay-filter="noticeBtn">&emsp;修改授权&emsp;</button>
                    </div>
                    <div class="layui-col-md2">
                    <button type="reset" id="formreset" class="layui-btn layui-btn-primary layui-btn-fluid">&emsp;重置表单&emsp;</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
}
?>       
		<script type="text/javascript" src="/assets/frame/libs/layui/layui.js"></script>
        <script type="text/javascript" src="/assets/frame/libs/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/assets/frame/js/common.js?v=318"></script>
        <script src="/assets/frame/js/nprogress.js"></script>
        <script src="/assets/frame/js/gt.js"></script>
		<script>
			layui.use(['layer', 'notice', 'laydate', 'form','formX','admin', 'table'],function() {
				var $ = layui.jquery;
				var layer = layui.layer;
				var notice = layui.notice;
				var laydate = layui.laydate;
				var form = layui.form;
				var admin = layui.admin;
				var table = layui.table;	
				var formX = layui.formX;	
				var insTb = table.render({
					elem: '#site_list',
					url: './ajax.php?act=site_list',
					text: {
            			none: '哇哦没发现数据哟 T^T ！' //默认：无数据。注：该属性为 layui 2.2.5 开始新增
            		},
					page: true,
					toolbar: ['<p>', '<button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del_table"><i class="layui-icon layui-icon-delete" style="font-size:20px;"></i>删除</button>&nbsp;', '</p>'].join(''),
					cellMinWidth: 100,
					limit: 10,
					cols: [[{
						type: 'checkbox',
					},					
					{
						field: 'uid',
						title: '授权QQ',
						sort: true
					},
					{
						field: 'url',
						title: '授权域名',
						sort: true
					},
					{
						field: 'authcode',
						title: '授权代码',
						sort: true
					},
					{
						field: 'date',
						title: '授权时间',
						sort: true
					},				
					{
						field: 'ip',
						title: '授权IP',
						sort: true
					},
					{
                        field: 'active',
                        title: '状态',
                        templet: function(data) {
                        if (data.active == 1) {
                        return '<input type="checkbox" name="close" lay-skin="switch" value="' + data.id + '" lay-filter="switchSite" lay-text="正常|封禁" checked/>';
                        } else {
                        return '<input type="checkbox" name="close" lay-skin="switch" value="' + data.id + '" lay-filter="switchSite" lay-text="正常|封禁" >';
                        }
                        },
                        sort: true
                    },
                    {
						field: 'boss',
						title: '添加用户',
						width: 110
					},
					{
						field: "action",
						title: "功能操作",
						toolbar: "#table_button",
						width: 150
					}]]
				});
				/* 表格搜索 */
				form.on('submit(roleTbSearch)',function(data) {
					var ii = layer.msg("正在查找数据……", {
						icon: 16
					});
					insTb.reload({
						where: data.field,
						page: {
							curr: 1
						}
					});
					layer.close(ii);
					return false;
				});
				/* 修改状态 */
            	form.on('switch(switchSite)',function(data) {
            		$.ajax({
            			url: './ajax.php?act=switch_site&id=' + data.value,
            			dataType: 'json',
            			success: function(data) {
            				if (data.code == 1) {
            					notice.msg(data.msg, {
            						icon: 1
            					});
            				} else {
            					notice.msg(data.msg, {
            						icon: 2
            					});
            				}
            			}
            		});
            	});
            	/* 批量删除 */
                    table.on('toolbar(site_list)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      var data = checkStatus.data;
      if(obj.event === "del_table"){
          if(data.length == 0){
          layer.msg('请选择数据');
      }else{
          layer.confirm('确定要删除吗？', {icon: 3,shade: 0,title: '提示'
		},
		function() {
        $.ajax({
            type:'POST',
            url:'ajax.php?act=del_site',
            data : {data:data},
            dataType:'json',
            success:function (data){
                if(data.code == 1){
                    setTimeout(function (){
                        location.href = './list.php'
                    },1000);
                    notice.msg(data.msg,{icon: 1,time: 2000, shade:0.3});
                }else{
                    notice.msg(data.msg,{icon: 2,time: 2000, shade:0.3});
                     }
                   }
                 });			
	           });
              }
            }
         });
			    /* 表格工具栏 */
				table.on('tool(site_list)',function(obj) {
					var data = obj.data;
					id = data['id'];
					if (obj.event === "del") {
                        layer.confirm('你确实要删除此授权吗？', {
                                btn: ['确定', '取消'],
                                closeBtn: 0,
                                icon: 3
                            },
                            function() {
                                var ii = layer.load(2, {
                                    shade: [0.1, '#fff']
                                });
                                $.ajax({
                                    type: "POST",
                                    url: "ajax.php?act=del_site",
                                    data: {
                                        id: id
                                    },
                                    dataType: "json",
                                    success: function(data) {
                                        layer.close(ii);
                                        if (data.code == 1) {
                                            notice.msg(data.msg,{icon: 1});
                                            window.location.reload();
                                        } else {
                                            notice.msg(data.msg,{icon: 2});
                                            window.location.reload();
                                        }
                                    }
                                });
                            },function() {});
                    } else if (obj.event === "edit") {
			window.location.href = "list.php?my=edit&id=" + id;
		}
	});
});
</script>
<script>
layui.use(['form', 'element', 'jquery', 'admin', 'notice'], function () {
    var form = layui.form;
    var $ = layui.jquery;
    var laydate = layui.laydate;
    var admin = layui.admin;
    var notice = layui.notice;
    $('#formreset').click(function () {
        document.getElementById("formBasForm").reset();
        notice.destroy();
        layer.msg('重置表单成功！', {animateInside: true, icon: 1});
    });
    form.on('submit(noticeBtn)', function (data) {
        var uid = $("input[name='uid']").val();  
        var url = $("input[name='url']").val();
        var authcode = $("input[name='authcode']").val();
        var ip = $("input[name='ip']").val();
        var geetest_challenge = $("input[name='geetest_challenge']").val();
	var geetest_validate = $("input[name='geetest_validate']").val();
	var geetest_seccode = $("input[name='geetest_seccode']").val(); 
        admin.btnLoading('[lay-filter="noticeBtn"]',' 修改中');
        admin.showLoading('#divLoading', 2, '.8');
        notice.destroy();
        $.ajax({
            type: "POST",
            url: "ajax.php?act=edit_site",
		    data: {
		    "id": <?=$row['id']?>,
		    "uid": uid,
			"url": url,
			"authcode": authcode,
			"ip": ip
		   },
            dataType: "json",
            success: function(data) {
                admin.removeLoading('#divLoading', true, true);
                admin.btnLoading('[lay-filter="noticeBtn"]', false);
                if (data.code == 1) {
                    layer.msg(data.msg, {animateInside: true, icon: 1});
                } else {
                    layer.msg(data.msg, {animateInside: true, icon: 2});
                }
            },
            error:function(data){
                layer.msg('服务器错误！', {animateInside: true, icon: 2});
                return false;
            }
        });
        return false;
    });
 });
  NProgress.start();
   function neeprog() {
   	NProgress.done();
   }
   window.onload=neeprog;
 </script>
</body>
</html>

