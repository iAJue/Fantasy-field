<?php
namespace application\model;
use framework\core\Model;
/**
 * 用户模型类
 */
class UserModel extends Model{

	/**
	 * 插入一个用户
	 * @param  string $u 用户名
	 * @param  string $p 密码
	 * @param  string $m 注册时间
	 * @param  string $e 邮箱
	 * @param  string $t 唯一标识符
	 * @param  string $i ip地址
	 * @return boot      成功返回true，失败返回false
	 */
	public function user_add($u,$p,$m,$e,$t,$i){
		return $this->mysqli->query("INSERT INTO {$this->prefix}user (`username`, `password`, `time`, `email`,`activatecode`,`ip`) values ('{$u}','{$p}','{$m}','{$e}','{$t}','{$i}')");
	}
	
	/**
	 * 注册一个用户(重新发送邮件的)
	 * @param  string $u 用户名
	 * @param  string $p 密码
	 * @param  string $m 注册时间
	 * @param  string $e 邮箱
	 * @param  string $t 唯一标识符
	 * @return boot    成功返回true，失败返回false
	 */
	public function user_update($u,$p,$m,$e,$t){
		return $this->mysqli->query("UPDATE {$this->prefix}user SET username = '{$u}', password = '{$p}', time = '{$m}', email = '{$e}', activatecode = '{$t}' WHERE (username = '{$u}' || email = '{$e}') and activation = 'n'");
	}

	/**
	 * 查询用户名或邮箱是否注册
	 * @param  string  $u 用户名
	 * @param  string  $e 邮箱
	 * @return array/false    成功返回array，失败返回false
	 */
	public function hasUserEmail($u,$e){
		return $this->mysqli->fetch("SELECT activation FROM {$this->prefix}user WHERE username = '{$u}' || email = '{$e}'");
	}

	/**
	 * 查询用户状态是否正常
	 * @param  string $u 用户名和密码
	 * @return boot  失败返回false，成功查询结果
	 */
	public function user_query($u,$p){
		return $this->mysqli->fetch("SELECT uid,username,role,isseal,activation FROM {$this->prefix}user WHERE username = '{$u}' and password = '{$p}'");
	}


	/**
	 * 查询激活码是否有效(存在并且没有过期)
	 * @param  string $t 唯一激活码
	 * @param  string $t 当前时间
	 * @param  string $t 有效时间
	 * @return boot   成功返回true，失败false
	 */
	public function activate($token,$time,$etime){
		return $this->mysqli->fetch("SELECT 1 FROM {$this->prefix}user WHERE activatecode = '{$token}' and {$time} - time < {$etime}");
	}

	/**
	 * 激活用户
	 * @param  string $token 激活码
	 * @return boot        成功返回true，失败返回false
	 */
	public function user_activate($token){
		return $this->mysqli->query("UPDATE {$this->prefix}user SET activation = 'y', activatecode = '' WHERE  activatecode = '{$token}'");
	}
	
	/**
	 * 按条件查询所有用户
	 * @param  string $page  查询页数
	 * @param  string $limit 查询数量
	 * @param  string $where 查询条件
	 * @return array        成功返回array，失败返回false
	 */
	public function user_queryAll($page,$limit,$where=''){
		return $this->mysqli->fetchAll("SELECT uid,username,role,time,ip,isseal,email,activation FROM {$this->prefix}user $where limit $page, $limit");
	}

	/**
	 * 查询所有用户数量
	 */
	public function user_count(){
		return $this->mysqli->fetch("SELECT count(*) FROM {$this->prefix}user")['count(*)'];
	}

	/**
	 * 批量删除用户
	 */
	public function user_del($userids){
		return $this->mysqli->query("DELETE FROM {$this->prefix}user WHERE uid in($userids) and role != 'admin'");
	}

	/**
	 * 启用或禁用一个用户
	 */
	public function user_seal($uid,$seal = 'y'){
		return $this->mysqli->query("UPDATE {$this->prefix}user SET isseal = '{$seal}' WHERE uid = '{$uid}'");
	}

	/**
	 * 查询指定用户信息
	 * @return [type] [description]
	 */
	public function user_fetch($uid){
		return $this->mysqli->fetch("SELECT username,role,time,ip,photo,email FROM {$this->prefix}user WHERE uid = '{$uid}'");
	}

	/**
	 * 查询用户密码
	 * @return [type] [description]
	 */
	public function user_pass($uid){
		return $this->mysqli->fetch("SELECT password FROM {$this->prefix}user WHERE uid = '{$uid}'");
	}

	/**
	 * 修改用户资料
	 * @return [type] [description]
	 */
	public function user_modify($user,$pwd,$uid){
		return $this->mysqli->query("UPDATE {$this->prefix}user SET username = '{$user}', password = '{$pwd}' WHERE uid = '{$uid}'");
	}

	/**
	 * 修改用户头像
	 * @return [type] [description]
	 */
	public function user_photo($photo,$uid){
		return $this->mysqli->query("UPDATE {$this->prefix}user SET photo = '{$photo}' WHERE uid = '{$uid}'");
	}

	/**
	 * 检测除自己以外用户名是否存在
	 * @return [type] [description]
	 */
	public function user_isexis($user,$uid){
		return $this->mysqli->fetch("SELECT 1 FROM {$this->prefix}user WHERE username = '{$user}' and uid != '{$uid}'");
	}

	/**
	 * 返回指定ip在24小时内的注册数量
	 * @return [type] [description]
	 */
	public function user_limitip($ip){
		return $this->mysqli->fetch("SELECT count(*) FROM {$this->prefix}user WHERE ip = '{$ip}' and (unix_timestamp(now()) - time) < (3600*24)")['count(*)'];
	}
}