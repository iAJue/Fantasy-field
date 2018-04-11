<?php if(!defined('APP_PATH')) {exit('error!');}?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>添加导航</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
  	<link rel="icon" href="<?php echo PATH_VIEW;?>Home/images/favicon.ico">
	<link rel="stylesheet" href="<?php echo PATH_VIEW;?>Admin/layui/css/layui.css">
</head>
<body class="childrenBody">
<form class="layui-form" style="width:80%;">
	<input type="hidden" class="layui-input navbarId">
	<div class="layui-form-item layui-row layui-col-xs12" style="margin-top: 20px;">
		<label class="layui-form-label">导航名称</label>
		<div class="layui-input-block">
			<input type="text" class="layui-input navbarName" lay-verify="required" placeholder="请输入导航">
		</div>
	</div>
	<div class="layui-form-item layui-row layui-col-xs12">
		<label class="layui-form-label">导航地址</label>
		<div class="layui-input-block">
			<input type="text" class="layui-input navbarUrl" lay-verify="url" placeholder="请输入地址">
		</div>
	</div>
	<div class="layui-form-item navbarHide">
		<label class="layui-form-label"><i class="seraph"></i>是否隐藏</label>
		<div class="layui-input-block">
			<input type="checkbox" name="navbarHide" value="y" lay-skin="switch" lay-text="是|否">
		</div>
	</div>
	<div class="layui-form-item layui-row layui-col-xs12">
		<label class="layui-form-label">导航图标</label>
		<div class="layui-input-block">
			<input type="text" class="layui-input navbarIcon" placeholder="请输入图标(可空)">
			<blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;width: 400px;">图标设置请查阅这里-> <a href="http://glyphicons.com/" target="_blick"> Glyphicons</a></blockquote>
		</div>
	</div>
	<div class="layui-form-item layui-row layui-col-xs12">
		<div class="layui-input-block">
			<button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="addnavbar">立即添加</button>
		</div>
	</div>
</form>
<script src="<?php echo PATH_VIEW;?>Admin/layui/layui.js"></script>
<script type="text/javascript" src="<?php echo PATH_VIEW;?>Admin/js/navbarAdd.js"></script>
</body>
</html>