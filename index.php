<?php 
// 应用目录为当前目录
define('APP_PATH', __DIR__ . '/');

// 开启调试模式
define('APP_DEBUG', false);

//幻想领域版本
define('APP_VERSION', 1.21);

// 加载函数库文件
require(APP_PATH . 'framework/helpers/function.base.php');

// 加载框架文件
require(APP_PATH . 'framework/core/Framework.php');

// 实例化框架类
new framework\core\Framework();
