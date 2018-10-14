<?php if(!defined('APP_PATH')) {exit('error!');}?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php echo $keywords;?>" />
    <meta name="description" content="<?php echo $description;?>" />
    <meta name="author" content="阿珏博客">
    <meta name="generator" content="幻想领域">
    <link rel="icon" href="<?php echo PATH_VIEW;?>Home/images/favicon.ico">
    <title><?php echo $title;?></title>
    <link href="https://cdn.staticfile.org/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
    	@-ms-viewport{width: device-width;}@-o-viewport{width: device-width;}@viewport{width: device-width;}
    </style>
    <style>
    	a,a:focus,a:hover{color: #fff;}.btn-default,.btn-default:hover,.btn-default:focus{color: #333; text-shadow: none; background-color: #fff; border: 1px solid #fff;}html,body{height: 100%; background-color: #333;}body{color: #fff; text-align: center; text-shadow: 0 1px 3px rgba(0,0,0,.5);}/.site-wrapper{display: table; width: 100%; height: 100%;  min-height: 100%; -webkit-box-shadow: inset 0 0 100px rgba(0,0,0,.5); box-shadow: inset 0 0 100px rgba(0,0,0,.5);}.site-wrapper-inner{display: table-cell; vertical-align: top;}.cover-container{margin-right: auto; margin-left: auto;}.inner{padding: 30px;}.masthead-brand{margin-bottom: 10px;}.masthead-nav > li{display: inline-block;}.masthead-nav > li + li{margin-left: 20px;}.masthead-nav > li > a{padding-right: 0; padding-left: 0; font-size: 16px; font-weight: bold; color: #fff;  color: rgba(255,255,255,.75); border-bottom: 2px solid transparent;}.masthead-nav > li > a:hover,.masthead-nav > li > a:focus{background-color: transparent; border-bottom-color: #a9a9a9; border-bottom-color: rgba(255,255,255,.25);}.masthead-nav > .active > a,.masthead-nav > .active > a:hover,.masthead-nav > .active > a:focus{color: #fff; border-bottom-color: #fff;}@media (min-width: 768px){.masthead-brand{float: left;} .masthead-nav{float: right;}}.cover{padding: 0 20px;}.cover .btn-lg{padding: 10px 20px; font-weight: bold;}.mastfoot{color: #999;  color: rgba(255,255,255,.5);}@media (min-width: 768px){ .masthead{position: fixed; top: 0;} .mastfoot{position: fixed; bottom: 0;}  .site-wrapper-inner{vertical-align: middle;}  .masthead, .mastfoot, .cover-container{width: 100%; }}@media (min-width: 992px){.masthead, .mastfoot, .cover-container{width: 700px;}}
    </style>
    <link rel="stylesheet" href="<?php echo PATH_VIEW;?>Home/style/hwLayer.css">
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_VIEW;?>Home/style/main.css">
	<link href="<?php echo PATH_VIEW;?>Home/style/styles.imageuploader.css" rel="stylesheet" type="text/css">
  </head>
  <body class="body">
	<div class="uploade" id="display"><p id="hide">×关闭</p>
	  <div class="uploader__box js-uploader__box l-center-box">
	      <form action="#" method="POST">
	          <div class="uploader__contents">
	              <label class="button button--secondary" for="fileinput">请选择文件</label>
	              <input id="fileinput" class="uploader__file-input" type="file" multiple value="Select Files">
	          </div>
	          <input class="button button--big-bottom" type="submit" value="Upload Selected Files">
	      </form>
	  </div>
	  <textarea class="form-control img-url" rows="3" id="text" onclick="select();"></textarea>
	</div>
    <div class="site-wrapper">
      <div class="site-wrapper-inner"> 
        <div class="cover-container">
          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand"><?php echo configGet('title');?></h3>
              <nav>
                <ul class="nav masthead-nav">
 					<li class="active" <?php echo $AUTH=='' ? '' : 'style="display: none;"';?>><a href="javascript:volid(0)" id="form-btn" data-show-layer="hw-layer-login" role="button">注册 / 登录</a></li>
					<li class="dropdown" <?php echo $AUTH!='' ? '' : 'style="display: none;"';?> id="dropdown">
						<a href="javascript:volid(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="result"><?php echo $AUTH.$tourist;?></span> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo PATH_URL;?>Admin/Index/IndexAction.html">个人中心</a></li>
							<li><a href="javascript:volid(0)" id="logout">退出</a></li>
						</ul>
					</li>
				<?php if($explore=='y'):?>
					<li><a href="<?php echo PATH_URL;?>Home/Index/ExploreAction.html"> <span class="glyphicon glyphicon-picture"></span> 探索</a></li>
				<?php endif;
					foreach($navbar as $v): ?>
					<li><a href="<?php echo $v['url'];?>"> <span class="<?php echo $v['icon'];?>"></span> <?php echo $v['naviname'];?></a></li>
				<?php endforeach; ?>
                </ul>
              </nav>
            </div>
          </div>
          <div class="inner cover">
            <h1 class="cover-heading" style="font-size: 36px;padding-bottom: 15px;">上传与分享您的照片</h1>
            <p class="lead">高速稳定的图片上传和分享服务, 全球CDN加速, 最大10 MB/张 , 无限制的图片外链, BBCode代码, HTML代码, 缩略图, 专属的图片主页, 你要的一切，这里都有</p>
			<p class="lead"><?php echo $prompt;?>不和谐上传删图&amp;账号，且行且珍惜。</p>
            <p class="lead">
              <a href="javascript:volid(0)" id="upload" style="background: transparent;color: #FFF;" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-cloud-upload"></span> 开始上传</a>
            </p>
            <p>本站已托管 <?php echo $count;?> 张图片</p>
          </div>
          <div class="mastfoot">
            <div class="inner bottom">
              <span class="yright"></span><br>
              <span><?php echo $footerinfo;?><br><?php echo $record;?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
	<div class="hw-overlay" id="hw-layer-login">
		<div class="htmleaf-container">
			<div id="wrapper" class="login-page">
			  <div id="login_form" class="form">
			  <span class="close hwLayer-close" aria-label="Close"><span aria-hidden="true">&times;</span></span>
			  <?php if($register == 'y'):?>
			    <form class="register-form" method="post">
			      <input type="text" placeholder="用户名" id="r_user_name" name="r_user_name" />
			      <input type="password" placeholder="密码" id="r_password" name="r_password" />
			      <input type="email" placeholder="电子邮箱" id="r_email" name="r_email" />
			      <button id="create" type="submit" class="register-ok">创建账户</button>
			      <p class="message msg">已经有了一个账户? <a href="#">立刻登录</a></p>
			      <span id="msgt" class="msg"></span>
			    </form>
			   <?php endif;?>
			    <form class="login-form" method="post" id="login-form">
			      <input type="text" placeholder="用户名" name="user" id="user"/>
			      <input type="password" placeholder="密码" name="password" id="password"/>
			      <input type="text" placeholder="验证码" name="verifycode" id="verifycode" style="width: 150px;float: left;">
			      <img src="<?php echo PATH_URL;?>Home/User/MakeCaptcAction/" style="width: 110px;float: right;" title="刷新验证码" onclick="this.src='<?php echo PATH_URL;?>Home/User/MakeCaptcAction?t='+Math.random();">
			      <button id="login" type="submit" class="hwLayer-ok">登　录</button>
			  	<?php if($register == 'y'):?>
			      <p class="message msg">还没有账户? <a href="#">立刻创建</a></p>
			  	<?php endif;?>
			      <span id="msg" class="msg"></span>
			    </form>
			  </div>
			</div>
		</div>
	</div>
    <script src="https://cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
    	(function () {
  'use strict';

  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style')
    msViewportStyle.appendChild(
      document.createTextNode(
        '@-ms-viewport{width:auto!important}'
      )
    )
    document.querySelector('head').appendChild(msViewportStyle)
  }

})();
    </script>
    <script src="<?php echo PATH_VIEW;?>Home/js/jquery.hwLayer.js"></script>
    <script src="<?php echo PATH_VIEW;?>Home/js/jquery.imageuploader.js"></script>
	<script src="<?php echo PATH_VIEW;?>Home/js/main.js"></script>
</body>
</html>
