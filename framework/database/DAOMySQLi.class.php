<?php 
namespace framework\database;
/**
 * mysqli数据库操作类[单列模式]
 */
class DAOMySQLi implements DbInterface{

	/**
	 * 唯一的数据库单列对象
	 */
	private static $_instance;
	
	public $error;

	/**
	 * mysqli对象
	 * @var [type]
	 */
	private $_mysqli;

	/**
	 * 对外提供一个公共的静态方法生成对象
	 * @return [type] [description]
	 */
	public static function getSingleton(array $option = array()){
		if (!self::$_instance instanceof self) {
			self::$_instance = new self($option);
		}
		return self::$_instance;
	}

	/**
	 * 连接数据库
	 * @param array $option 数据库信息
	 */
	private function __construct($option){
		$this->_mysqli = new \MySQLi($option['host'], $option['username'], $option['password'], $option['dbname'],$option['port']);
		if ($this->_mysqli->connect_errno) {
			$this->error = '数据库连接失败 ' . $this->_mysqli->connect_error;
			return;
		}
		$this->_mysqli->set_charset($option['charset']);
	}

	/**
	 * 防止克隆
	 */
	private function __clone(){}

	/**
	 * 从数据库中取出一条结果
	 * @param  string $sql 查询的语句
	 * @return array      成功返回一条结果，失败返回false
	 */
	public function fetch($sql = ''){
		if(!$res = $this->_mysqli->query($sql)){
			$this->error = 'sql语句执行失败！' . $sql . ' '.$this->_mysqli->error;
			return false;
		}
		$arr = $res->fetch_assoc();
		$res->free();
		return $arr;
	}

	/**
	 * 从数据库中取出所有结果
	 * @param  string $sql 查询的SQL语句
	 * @return array      成功返回所有结果，失败返回false
	 */
	public function fetchAll($sql = ''){
		$arr = array();
		$res = $this->_mysqli->query($sql);
		if(!$res){
			$this->error = 'sql语句执行失败！' . $sql . ' '.$this->_mysqli->error;
			return false;
		}
		while ($row = $res->fetch_assoc()) {
			$arr[] = $row;
		}
		$res->free();
		return $arr;
	}

	/**
	 * 完成数据库的dml操作
	 * @param  string $sql 要执行的SQL语句
	 * @return boot		   成功返回true，失败返回false
	 */
	public function query($sql = ''){
		$res = $this->_mysqli->query($sql);
		if(!$res){
			$this->error = 'sql语句执行失败！' . $sql . ' '.$this->_mysqli->error;
			return false;
		}
		return $res;
	}
	

	/**
	 * 获取最后一次插入的主键ID
	 * @return int  主键id
	 */
	public function getInsertId(){
		return $this->_mysqli->insert_id;
	}

	/**
	 * 返回受影响的记录数
	 * @return int  数量
	 */
	public function getAffectedRows(){
		return $this->_mysqli->affected_rows;
	}

	/**
	 * 返回mysql数据版本
	 * @return int  版本号
	 */
	public function getVersion(){
		return $this->fetch('select VERSION()')['VERSION()'];
	}

	/**
	 * 开启一个事务
	 * @return boot 成功返回true，失败防护false
	 */
	public function beginTrans(){
		return $this->_mysqli->autocommit(false);
	}

	/**
	 * 提交当前事务
	 * @return boot  成功返回true，失败返回false
	 */
	public function commit(){
		return $this->_mysqli->commit();
	}

	/**
	 * 回滚当前事务
	 * @return boot 成功返回true，失败返回false
	 */
	public function rollback(){
		return $this->_mysqli->rollback();
	}

	/**
	 * 转义在SQL语句中使用的特殊字符
	 * @param  string $str  字符串
	 * @return string/boot  成功返回转义的字符串，失败返回false
	 */
	public function escapeString($str){
		return $this->_mysqli->real_escape_string($str);
	}

	/**
	 * 资源回收
	 */
	public function close(){
		if(is_resource(self::$_instance)){
			self::$_instance->close();
			self::$_instance = null;
			$this->_mysqli = null;
		}
	}

	/**
	 * 析构函数
	 */
	public function __destruct(){
		$this->close();
	}
}
