<?php
/**
 * 幻想领域安装程序
 * @author: 阿珏
 * @link: http://img.52ecy.cn
 */
$act = isset($_GET['action']) ? $_GET['action'] : '';

if (PHP_VERSION < '5.6'){
    Msg('您的php版本过低，请选用支持PHP5.6的环境安装幻想领域。');
}

if($act == 'install'){
	//获取表单提交数据
	$hostname = isset($_POST['hostname']) ? $_POST['hostname'] : '';
	$dbuser = isset($_POST['dbuser']) ? $_POST['dbuser'] : '';
	$dbpwd = isset($_POST['dbpwd']) ? $_POST['dbpwd'] : '';
	$dbname = isset($_POST['dbname']) ? $_POST['dbname'] : '';
	$dbprefix = isset($_POST['dbprefix']) ? $_POST['dbprefix'] : '';
	$user = isset($_POST['user']) ? $_POST['user'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$password2 = isset($_POST['password2']) ? $_POST['password2'] : '';

	if($dbprefix == ''){
		Msg('数据库表前缀不能为空!');
	}elseif(!preg_match("/^[\w_]+_$/",$dbprefix)){
		Msg('数据库表前缀格式错误!');
	}elseif($user == '' || $password == ''){
		Msg('登录名和密码不能为空!');
	}elseif(strlen($password) < 6){
		Msg('登录密码不得小于6位');
	}elseif($password!=$password2)	 {
		Msg('两次输入的密码不一致');
	}

	$mysqli = @new mysqli($hostname, $dbuser, $dbpwd, $dbname);

	if($mysqli->connect_error){
		Msg('数据库连接失败');
	}
    // if($mysqli->query("SHOW TABLES LIKE '" . $dbprefix . "user'")->fetch_array(MYSQLI_ASSOC) != null){
    // 	Msg('看起来你的幻想领域已经安装过了。请先清空原有数据在进行安装！');
    //  }
	$mysqli->query("SET NAMES UTF8");
	$time = time();
	$password = md5($password);
	$sql ="
CREATE TABLE `{$dbprefix}pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` varchar(128) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `date` bigint(20) NOT NULL,
  `ip` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{$dbprefix}navi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naviname` varchar(30) NOT NULL DEFAULT '',
  `url` varchar(75) NOT NULL DEFAULT '',
  `hide` enum('n','y') NOT NULL DEFAULT 'n',
  `icon` varchar(125) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `{$dbprefix}navi` VALUES (1,'博客','https://www.52ecy.cn','n','glyphicon glyphicon-home'),(2,'关于','http://www.52ecy.cn/post-68.html','n',''),(3,'帮助','http://www.52ecy.cn/post-70.html','n','');

CREATE TABLE `{$dbprefix}user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `role` varchar(60) NOT NULL DEFAULT '' COMMENT '身份',
  `time` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(128) NOT NULL DEFAULT '',
  `isseal` enum('n','y') NOT NULL DEFAULT 'n' COMMENT '封号',
  `photo` varchar(128) NOT NULL DEFAULT '' COMMENT '头像',
  `email` varchar(60) NOT NULL DEFAULT '',
  `activation` enum('n','y') NOT NULL DEFAULT 'n' COMMENT '激活',
  `activatecode` varchar(64) NOT NULL DEFAULT '' COMMENT '激活码',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

REPLACE INTO `{$dbprefix}user` VALUES (1,'{$user}','{$password}','admin','{$time}','127.0.0.1','n','','','y','');
";

	$array_sql = preg_split("/;[\r\n]/", $sql);
	foreach($array_sql as $sql){
	    $sql = trim($sql);
	    if ($sql){
	       $mysqli->query($sql);
	    }
	}
$config = "<?php return array(
	'host'		=>	'{$hostname}',
	'username'	=>	'{$dbuser}',
	'password'	=>	'{$dbpwd}',
	'dbname'	=>	'{$dbname}',
	'port'		=>	3306,
	'charset'	=>	'utf8',
	'prefix'	=>	'{$dbprefix}'
);";

	$fp = @fopen('config.php', 'w');
    $fw = @fwrite($fp, $config);
	fclose($fp);
    if (!$fw){
        Msg('配置文件(config.php)不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请联系管理员，将此文件设为可写');
    }
    
	$result = "
        <p style=\"font-size:24px; border-bottom:1px solid #E6E6E6; padding:10px 0px;\">恭喜，安装成功！</p>
        <p>您的幻想领域图床已经安装好了，现在可以开始您的创作了，就这么简单!</p>
		<p>桥豆麻袋，你得先到后台配置一下基本信息才能使用en~en~</p>
        <p><b>用户名</b>：{$user}</p>
        <p><b>密 码</b>：您刚才设置的密码</p>";
    if (!@unlink('./install.php')){
        $result .= '<p style="color:red;margin:10px 20px;">警告：请手动删除根目录下安装文件：install.php</p> ';
    }
    $result .= "<p style=\"text-align:right;\"><a href=\"./\">访问首页</a> | <a href=\"http://img.52ecy.cn\">官方首页</a></p>";
    Msg($result, 'no');
}
/** 错消息提示
 *  $msg  提示信息
 *  $page 是否返回上一级
*/
function Msg($msg,$page = 'yes'){
	
	echo <<<EOT
	<!DOCTYPE html>
	<head>
	<meta charset='utf-8'>
	<title>提示信息</title>
	<style type='text/css'>
		body {
			background-color:#F7F7F7;
			font-family: Arial;
			font-size: 12px;
			line-height:150%;
		}
		.main {
			background-color:#FFFFFF;
			font-size: 12px;
			color: #666666;
			width:650px;
			margin:60px auto 0px;
			border-radius: 10px;
			padding:30px 10px;
			list-style:none;
			border:#DFDFDF 1px solid;
		}
		.main p {
			line-height: 18px;
			margin: 5px 20px;
		}

	</style>
	</head>
	<body>
		<div class='main'>
			<p>{$msg}</p>
EOT;
    if ($page == 'yes') {
        echo '<p><a href="javascript:history.back(-1);">&laquo;点击返回</a></p>';
    }
    echo <<<EOT
</div>
</body>
</html>
EOT;
exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>幻想领域安装程序</title>
		<style type="text/css">
			li{
				list-style-type:none;
				margin-top:6px;
				margin-bottom:20px;
			}
			.box-div{
				width:700px;
				margin:0 auto;
				border:1px solid #c0c0c0;
				padding-left:8px;
				padding-right:8px;
				margin-bottom:30px;
				margin-top:20px;
			}
			.submit{
				width:100px;
				height:30px;
				margin:0 auto;
				display:block;
				margin-bottom:20px;
			}
			span{
				color:#0066CC;
				font-size:5px;
			}
			input {
				border: 1px solid #CCCCCC;
				font-family: Arial;
				font-size: 18px;
				height:28px;
				background-color:#F7F7F7;
				color: #666666;
				margin:0px 0px 0px 25px;
			}
		</style>
	</head>
	<body>
		<div class="box-div"><br>
		<div style="text-align:center;"><a href="https://img.52ecy.cn/"><img src="upload/logo.png"></a><h4>幻想领域 1.2.0- 安装程序</h4><br></div>
			<form method="post" action="install.php?action=install">
				<h3>MySQL数据库设置</h3><hr>
				数据库地址：<li><input name="hostname" type="text" value="localhost"><span>(通常为 localhost/127.0.0.1， 不必修改)</span></li>
				数据库用户名：<li><input name="dbuser" type="text" ></li>
				数据库密码：<li><input name="dbpwd" type="text"></li>
				数据库名：<li><input name="dbname" type="text"><span> (程序不会自动创建数据库，请提前创建一个空数据库或使用已有数据库)</span></li>
				数据库表前缀：<li><input name="dbprefix" type="text" value="tu_"><span> (通常默认即可，不必修改。由英文字母、数字、下划线组成，且必须以下划线结束)</span></li>
				<h3>管理员设置</h3><hr>
				登录名：<li><input name="user" type="text"></li>
				登录密码：<li><input name="password" type="password"><span>(不小于6位)</span></li>
				再次输入登录密码：<li><input name="password2" type="password"></li>
				<input type="submit" class="submit" value="开始安装">
			</form>
		</div>
	</body>
</html>
