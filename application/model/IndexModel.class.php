<?php
namespace application\model;
use framework\core\Model;
/**
* Index模型类
*/
class IndexModel extends Model{
	
	/**
	 * 返回数据库版本
	 */
	public function getVersion(){
		return $this->mysqli->getVersion();
	}

	/**
	 * 返回数据表前缀
	 */
	public function getPrefix(){
		return $this->prefix;
	}

}