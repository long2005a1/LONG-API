<?php
include("./includes/common.php");
include("./includes/con.php");
$count = $DB->getColumn("SELECT count(id) FROM `lvxia_apilist` WHERE `status`='1'");
$views = $DB->getColumn("SELECT SUM(views) FROM `lvxia_apilist` WHERE `status`='1'");
$apilist = $DB->getAll("SELECT * FROM `lvxia_apilist` WHERE `status`='1' order by `views` desc");
@header('Content-Type: text/html; charset=UTF-8');


?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title><?=$system['title']?></title>
		<meta name="keywords" content="<?=$system['keywords']?>">
		<meta name="description" content="<?=$system['description']?>">
		<meta property="og:description" content="<?=$system['description']?>">
		<meta property="og:site_name" content="<?=$system['title']?>">
		<meta property="og:title" content="<?=$system['title']?>">
		<meta property="og:url" content="" />
		<link rel="shortcut icon" type="image/x-icon" href="<?=$system['ico']?>">
		<link rel="stylesheet" href="<?=theme?>style/layui/css/layui.css">
		<link rel="stylesheet" href="<?=theme?>style/css/style.css">
		<link href="<?=theme?>style/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">

	</head>
	<body>
		<div></div>
		<div style="background-color: rgba(0, 0, 0, 0.3);height: 100vh;width: 100vw;position: fixed;z-index: -1;top:0px;"></div>
		<div class="layui-fluid" style="padding: 0;margin: 0;">
			<div class="layui-row">
				<div class="layui-col-md8 layui-col-md-offset2">
					<div class="hansheader">
						<a class="hanlogo" href="/" title="<?=$system['sysname']?>"><img class="logo" src="<?=$system['logo']?>" alt="<?=$system['sysname']?>"></a>
						<ul class="rightico">
							<li><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$system['zzqq']?>&site=qq&menu=yes" target="_blank" title="站长QQ"><i class="fa fa-qq fa-2x" style="color:#fff"></i><span class="hans-hidden">联系站长</span></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="layui-row">
				<div class="layui-col-md8 layui-col-md-offset2">
					<h1 style="margin-top: 10vh;text-align: center;">
						<div class="layui-anim layui-anim-scaleSpring"><strong><?=$system['sysname']?></strong></div>
					</h1>
					<h4 style="text-align: center;margin-top: 26px;"><strong>免费为各站长提供API接口服务</strong></h4>
					<p style="text-align: center;font-weight: bold;">共 <span style="color:#ff7070;"><?=$count?></span> 个接口</p>
					<div class="hansdiv layui-anim layui-anim-scale">
						<div class="hansgg">
							<h3>站点公告</h3>
							<h2 class="hanshr"><?=$system['gonggao']?><h2>
						</div>
					</div>
					<input id="search" type="text" placeholder="找不到？搜一下看看~" class="layui-input" style="background: rgba(0, 0, 0, 0);color: #ffffff;margin-top: 30px;">
					<section class="theme-feature-container layui-anim layui-anim-upbit">
						<ul>
						    <?php foreach($apilist as $row){ ?>
							<li>
							    <a href="/api/<?=$row['alias']?>.html" target="_blank" title="<?=$row['name']?>">
									<div class="item-box">
										<i class="fa <?=$row['faimg']?> fa-2x" style="color:#fff"></i>
										<br><br><br>
										<h3><?=$row['name']?></h3>
										<span class="hans-hidden"><?=$row['remarks']?></span>
									</div>
								</a>
							</li>
							<?php }?>
						</ul>
					</section>
				</div>
			</div>
		</div>
		<div class="footer">
			<ul>
				<li><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$system['zzqq']?>&site=qq&menu=yes" target="_blank" title="QQ联系"><i class="fa fa-qq fa-2x" style="color:#fff"></i><span class="hans-hidden">QQ</span></a></li>
			</ul>
			<div class="hancentext">
				<p style="font-weight: bold;"><?=$system['sysname']?> 共被调用 <span style="color:#fa6400;"><?=$views?></span> 次</p>
				<p><a href="https://beian.miit.gov.cn/" target="_blank"><?=$system['icp']?></a></p>
				<p><a href="/" target="_blank">Copyright © <?=date('Y')?> <?=$system['sysname']?>. All Rights Reserved.</a></p>
			</div>
		</div>
		<div class="layui-row">
			<div class="layui-col-md12">
				<svg class="hans-container" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none">
					<defs><path id="hans-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path></defs>
					<g class="hans-parallax">
						<use xlink:href="#hans-wave" x="50" y="0" fill="rgba(224,233,239,.5)"></use>
						<use xlink:href="#hans-wave" x="50" y="3" fill="rgba(224,233,239,.5)"></use>
						<use xlink:href="#hans-wave" x="50" y="6" fill="rgba(224,233,239,.5)"></use>
					</g>
				</svg>
			</div>
		</div>
		<script src="<?=theme?>style/layui/layui.js"></script>
		<!--<script src="/assets/js/index.js"></script>-->
		<script src="<?=theme?>style/js/code.js"></script>
		<script>
			function hanMsg() {
				layer.alert(
					'<div><?=$system['gonggaos']?></div>'
				);
			} //hanMsg();
		</script>
</script>
	</body>
</html>
