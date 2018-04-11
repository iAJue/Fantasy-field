<?php
namespace framework\core;

/**
 * 工厂类
 * 根据传递的模型类，返回单例模型对象
 */
class Factory {

	private static $instance = [];

	public static function M($name) {
		if (empty(self::$instance[$name])) {
			$class = "\application\model\\$name";
			self::$instance[$name] = new $class;
		}
		return self::$instance[$name];
	}
}
