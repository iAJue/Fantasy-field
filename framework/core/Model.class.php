<?php
namespace framework\core;
use framework\database\DAOMySQLi;
/**
 * 基础模型类
 */
class Model{

	protected $mysqli,$prefix;
    public function __construct(){
		$option = require(APP_PATH . 'config.php');
		$this->prefix = $option['prefix'];
		$this->mysqli = DAOMySQLi::getSingleton($option);
    }

}