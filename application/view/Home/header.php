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
    <link rel="stylesheet" type="text/css" href="<?php echo PATH_VIEW;?>Home/style/main.css">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <title><?php echo $title;?></title>
  </head>
  <body>
    <nav class="navbar navbar-inverse navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo PATH_URL;?>"><?php echo $GLOBALS['appconfig']['title'];?></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li<?php echo $active == 'Explore' ? ' class="active"':'';?>><a href="<?php echo PATH_URL;?>Home/Index/ExploreAction.html"> <span class="glyphicon glyphicon-picture"></span> 探索 <span class="sr-only">(current)</span></a></li>
            <li<?php echo $active == 'Newest' ? ' class="active"':'';?>><a href="<?php echo PATH_URL;?>Home/Index/NewestAction.html"><span class="glyphicon glyphicon-time"></span> 最新</a></li>
            <li<?php echo $active == 'Rand' ? ' class="active"':'';?>><a href="<?php echo PATH_URL;?>Home/Index/RandAction.html"><span class="glyphicon glyphicon-random"></span> 随机</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
        <?php foreach ($navbar as $v) :?>
            <li><a href="<?php echo $v['url'];?>"> <span class="<?php echo $v['icon'];?>"></span> <?php echo $v['naviname'];?></a></li>
        <?php endforeach;if($AUTH !=''):?>
            <li class="dropdown">
              <a href="javascript:volid(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $AUTH;?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo PATH_URL;?>Admin/Index/IndexAction.html">个人中心</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo PATH_URL;?>Home/User/LogoutAction.html">退出</a></li>
              </ul>
            </li>
        <?php else: ?>
            <li><a href="<?php echo PATH_URL;?>"> <span class="glyphicon glyphicon-send"></span> 注册 / 登录</a></li>
        <?php endif;?>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>