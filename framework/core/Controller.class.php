<?php
namespace framework\core;
/**
 * 基础控制器
 */
class Controller{

	private $var = array();

	/**
	 * 定义模板变量
	 * @param	string	$name	变量名
	 * @param	string	$value	值
	 */
	public function assign($name, $value){
		$this->var[$name] = $value;
	}
	/**
	 * 引入模板文件
	 * @param	string	$file	模板文件路径
	 */
	public function display($file){
		if(is_file($file)){
			//转换变量
			extract($this->var);
			require $file;
		}else{
			die('视图文件不存在' . $file);
		}
	}

	/**
	 * 检测session是否存在
	 * @param  boolean $role 是否为管理员
	 * @return [type]        [description]
	 */
	public function checksession($role=false){
		if(isset($_SESSION['authen']) && isset($_SESSION['authen']['uid']) && isset($_SESSION['authen']['username']) && isset($_SESSION['authen']['role'])){
			if($role && $_SESSION['authen']['role'] != 'admin'){
				Msg('权限不足！','error');
			}
		}else{
			Msg('未登录！','error');
		}
	}
}