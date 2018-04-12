<?php
namespace framework\core;

/**
 * 框架核心类
 */
class Framework{

    public function __construct(){
        $this->run();
    }

    // 初始化程序
    private function run(){
        $this->init();

    	// 注册自动加载
        spl_autoload_register(array($this, 'loadClass'));
        
        // 是否开启调试模式
        $this->setReporting();

        // 过滤数据
        $this->removeMagicQuotes();

        $this->route();
    }

    private function init(){
        header("Content-Type: text/html; charset=utf-8");
        date_default_timezone_set('PRC'); 
        session_set_cookie_params(24*3600);
        session_start();
        // 加载应用程序配置文件
        $GLOBALS['appconfig'] = require(APP_PATH . 'application/config.php');
        // 站点url地址
        define('PATH_URL',getWebUrl());
        // 视图文件路径
        define('PATH_VIEW',PATH_URL.'application/view/');
    }

    // 路由处理
    private function route(){
        $m = isset($_GET['m']) ? $_GET['m'] : 'Home';// 模块
        $c = isset($_GET['c']) ? $_GET['c'] : 'Index';// 控制器
        $a = isset($_GET['a']) ? $_GET['a'] : 'IndexAction';// 方法
        $suffix = '.html'; //伪静态后缀
        $path = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'],'/') : '';
        if ($path == '') {
            $path = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'],'/') : '';
            $str = $_SERVER['SCRIPT_NAME'];
            if ($str !== '/index.php') {
                $path =  trim(preg_replace('/'.trim(substr($str,0,strpos($str, '/index.php')),'/').'/','',$path),'/');
            }
        }
        if(preg_match('#^/([a-zA-Z0-9.]{25,})#','/'.$path,$pid) && isset($pid[1])){
            $m = 'Home';
            $c = 'Index';
            $a = 'DetailsAction';
            $_GET['pid'] = $pid[1];
        }else{
            $path = preg_replace('/'.$suffix.'/', '', $path, 1);
    		if ($path != '') {
                $path = preg_replace('/[?,=,&]/', '/', $path);
    			$arr = explode('/', $path);
    			$length = count($arr);
    			if ($length == 1) {
    				$m = $arr[0];
    			}elseif ($length == 2) {
    				$m = $arr[0];
    				$c = $arr[1];
    			}elseif ($length == 3) {
    				$m = $arr[0];
    				$c = $arr[1];
    				$a = $arr[2];
    			}else{
    				$m = $arr[0];
    				$c = $arr[1];
    				$a = $arr[2];
    				for ($i=3; $i <$length ; $i+=2) { 
    					$_GET[$arr[$i]] = isset($arr[$i+1]) ? $arr[$i+1] : '';
    				}
    			}
    		}
        }
        $m = ucfirst($m);
        $c = ucfirst($c);
        if (stripos($a,'Action')) {
            $a = preg_replace('/action.*/','Action',ucfirst($a));
        }else{
            $a .= 'Action';
        }
		$path = 'application/controller/'. $m .'/';
        if(!is_dir($path)){
        	exit($m . ' 模块不存在');
        }elseif (!is_file($path.$c.'Controller.class.php')) {
        	exit($c.' 控制器不存在');
        }
        $c = "\application\controller\\".$m."\\" . $c . 'Controller';
        $controller = new $c;
        if (!method_exists($controller, $a)) {
            exit($a . ' 方法不存在');
        }
		$controller->$a();
    }

    // 检测开发环境
    private function setReporting(){
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
        }
    }

    // 转义敏感字符
    private function removeMagicQuotes(){
        $_GET = isset($_GET) ? deepEscape($_GET) : '';
        $_POST = isset($_POST) ? deepEscape($_POST) : '';
        $_COOKIE = isset($_COOKIE) ? deepEscape($_COOKIE) : '';
        $_SESSION = isset($_SESSION) ? deepEscape($_SESSION) : '';
    }

    // 自动加载类
    private function loadClass($className){
		$className = str_replace('\\', '/', $className);
        $file = $className . '.class.php';
        if (!is_file($file)) {
            die($file . ' 类文件不存在');
        }
        require $file;
    }
}
