<?php
namespace framework\database;
/**
 * DB接口类
 */
interface DbInterface{

	public function query($sql);					//执行SQL
	
	public function fetch($sql);					//从结果集中取出一行

	public function fetchAll($sql);					//从结果集中取出全部数据

	public function getInsertId();					//获取最后插入主键ID

	public function getAffectedRows();				//获取受影响的记录数

	public function getVersion();					//获取数据库版本

	public function beginTrans();					//开启事务

	public function commit();						//提交事务

	public function rollback();						//回滚事务

	public function escapeString($str);				//数据安全处理

	public function close();						//资源回收

	public function __destruct();					//析构函数

}