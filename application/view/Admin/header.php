<?php if(!defined('APP_PATH')) {exit('error!');}?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title><?php echo $_SESSION['authen']['role'] == 'admin' ? '管理后台' : '用户中心'?> - <?php echo configGet('title');?></title>
  <link rel="icon" href="<?php echo PATH_VIEW;?>Home/images/favicon.ico">
  <link rel="stylesheet" href="<?php echo PATH_VIEW;?>Admin/layui/css/layui.css">
  <link rel="stylesheet" href="<?php echo PATH_VIEW;?>Admin/style/main.css">
  <script src="<?php echo PATH_VIEW;?>Admin/layui/layui.js"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo"><?php echo configGet('title');echo $_SESSION['authen']['role'] == 'admin' ? '管理后台' : '用户中心';?></div>
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="<?php echo PATH_URL;?>" target="_black">首页</a></li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="<?php $src = is_file('upload/uid_'.$_SESSION['authen']['uid'] . '.jpg') ?  PATH_URL .'upload/uid_'.$_SESSION['authen']['uid'] . '.jpg' : PATH_URL.'application/view/Admin/images/author.jpg';echo $src;?>" class="layui-nav-img">
          <?php echo $_SESSION['authen']['username'];?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="<?php echo PATH_URL;?>Admin/Userinfo/IndexAction.html">基本资料</a></dd>
          <dd><a href="<?php echo PATH_URL;?>Home/User/LogoutAction.html">安全退出</a></dd>
        </dl>
      </li>
    </ul>
  </div>
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <div class="user-photo">
            <a class="img" title="我帅气的头像" href="<?php echo PATH_URL;?>Admin/Userinfo/IndexAction.html"><img src="<?php echo $src;?>" class="userAvatar"></a>
            <p>你好！<span class="userName"><?php echo $_SESSION['authen']['username'];?></span></p>
        </div>
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item"><a href="<?php echo PATH_URL;?>Admin/Index/IndexAction.html"><i class="layui-icon" style="font-size: 16px;">&#xe68e;</i> 后台首页</a></li>
        <li class="layui-nav-item"><a href="<?php echo PATH_URL;?>Admin/Pic/IndexAction.html"><i class="layui-icon">&#xe64a;</i> 我的图库</a></li>
        <li class="layui-nav-item"><a href="<?php echo PATH_URL;?>Admin/Userinfo/IndexAction.html"><i class="layui-icon">&#xe612;</i> 个人中心</a></li>
    <?php if($_SESSION['authen']['role'] == 'admin'):?>
        <li class="layui-nav-item"><a href="<?php echo PATH_URL;?>Admin/User/IndexAction.html"><i class="layui-icon">&#xe613;</i> 用户管理</a></li>
        <li class="layui-nav-item"><a href="<?php echo PATH_URL;?>Admin/Navbar/IndexAction.html"><i class="layui-icon">&#xe63c;</i> 导航设置</a></li>
        <li class="layui-nav-item"><a href="<?php echo PATH_URL;?>Admin/Configure/IndexAction.html"><i class="layui-icon" style="font-size: 16px;">&#xe620;</i> 系统设置</a></li>
    <?php endif;?>
      </ul>
    </div>
  </div>
<div class="layui-body" style="padding: 15px;">