<?php
include("./includes/common.php");
$alias = trim(strip_tags(daddslashes($_GET['alias'])));
$content = $DB->getRow("SELECT * FROM `lvxia_apilist` WHERE `alias`='{$alias}' AND `status`='1' LIMIT 1");
if(empty($content)){exit('<script language="javascript">window.location.href="/404.html";</script>');}
$views = $DB->getColumn("SELECT SUM(views) FROM `lvxia_apilist` WHERE `status`='1'");
ApiViews($alias);
@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
		<meta name="renderer" content="webkit">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title><?=$content['name']?> - <?=$system['sysname']?></title>
		<meta name="keywords" content="<?=$system['keywords']?>">
		<meta name="description" content="<?=$system['description']?>">
		<meta property="og:description" content="<?=$system['description']?>">
		<meta property="og:site_name" content="<?=$system['title']?>">
		<meta property="og:title" content="<?=$system['title']?>">
		<meta property="og:url" content="https://api.lxurl.net/" />
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
		<link rel="stylesheet" href="<?=theme?>style/layui/css/layui.css">
		<link rel="stylesheet" href="<?=theme?>style/css/style4.0.css">
		<link href="<?=theme?>style/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
	</head>

	<body>
		<div class="layui-fluid" style="padding: 0;margin: 0;">
			<div class="layui-row">
				<div class="layui-col-md8 layui-col-md-offset2" style="height: 100%;background:rgba(0, 0, 0, 0.3);padding: 38px 0px 0px 18px;">
					<h1 class="title"><a href="<?=$content['alias']?>.html" title="<?=$content['remarks']?>"><?=$content['name']?></a></h1>
					<div class="navigation layui-anim layui-anim-scaleSpring">
						<a class="home" href="/"><i class="layui-icon layui-icon-home"></i> 首页 </a> >> 
						<a class="this" href="<?=$content['alias']?>.html"><i class="layui-icon layui-icon-location"></i> <?=$content['name']?> </a>
						<h2 class="content"><?=$content['remarks']?></h2>
						<span class="hot"><i class="layui-icon layui-icon-fire"> </i><?=$content['views']?></span>
						<span class="auther"><i class="layui-icon layui-icon-username"> </i><?=$system['sysname']?></span>
					</div>
					<hr class="layui-bg-orange">
					<div class="apihead layui-anim layui-anim-scaleSpring">
						<h2 class="api">接口地址</h2>
						<h3 class="apicode"><span id="text"><?=$content['apiurl']?></span></h3>
						<h2 class="return">返回格式</h2>
						<h3 class="returncode"><span id="text"><?=$content['apiformat']?></span></h3>
						<h2 class="request">请求方式：</h2>
						<h3 class="requestcode"><span id="text"><?=$content['request']?></span></h3>
						<h2 class="example">请求示例：</h2>
						<h3 class="examplecode"><span id="text"><?=$content['apirequest']?></span></p>
					</div>
					<div class="apicon layui-anim layui-anim-up">
						<h2 class="canshu">参数说明</h2>
						<table class="layui-table" style="display: inline-block;background-color: rgba(0, 0, 0, 0);color: #ffffff;">
							<colgroup>
								<col width="150">
								<col width="200">
								<col>
							</colgroup>
							<thead>
								<tr>
									<th>名称</th>
									<th>必填</th>
									<th>类型</th>
									<th>说明</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?=$content['explain']?>
								</tr>
							</tbody>
						</table>
						<h2 class="result">返回数据</h2>
						<pre class="layui-code"><?=$content['return']?></pre>
						
						<h2 class="diaoyong">调用实例</h2>
						<pre class="layui-code"><?=htmlspecialchars($content['example'])?></pre>
						
						<h2 class="request">示例代码</h2>
						<pre class="layui-code"><?=$content['examples']?>
						</pre>
					</div>
					<div class="footer">
						<p style="font-weight: bold;"><?=$system['sysname']?> 共被调用 <span style="color:#fa6400;"><?=$views?></span> 次</p>
						<p><a href="https://beian.miit.gov.cn/" target="_blank"><?=$system['icp']?></a></p>
						<p><a href="/" target="_blank">Copyright © <?=date('Y')?> <?=$system['sysname']?>. All Rights Reserved.</a></p>
					</div>
				</div>
			</div>
		</div>
		<script src="<?=theme?>style/layui/layui.js"></script>
		<script src="<?=theme?>style/js/clipboard.min.js"></script>
		<script>
			layui.use(['jquery', 'layer'], function() {
				var $ = layui.$,
					layer = layui.layer;
				$("h3 span").click(function() {
					var clipboard = new ClipboardJS('#text', {
						text: function(res) {
							var url = res.innerHTML;
							var zzre = url.replace(/amp;/g, "");
							return zzre
						}
					});
					clipboard.on('success', function(e) {
						layer.msg('复制成功!')
					});
					clipboard.on('error', function(e) {
						layer.msg('复制失败!')
					})
				})
			});
		</script>
	</body>
</html>
