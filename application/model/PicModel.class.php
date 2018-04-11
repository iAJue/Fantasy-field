<?php
namespace application\model;
use framework\core\Model;
/**
* 图库模型类
*/
class PicModel extends Model{
	
	/**
	 * 保存上传成功的图片地址
	 * 多条数据形式的字符串
	 */
	public function pic_add($values){
		return $this->mysqli->query("INSERT INTO {$this->prefix}pic (`pid`, `uid`, `date`,`ip`) values $values");
	}

	/**
	 * 随机返回指定n张图片
	 */
	public function pic_rand($n){
		return $this->mysqli->fetchAll("SELECT * FROM {$this->prefix}pic order by rand() limit {$n}");
	}

	/**
	 * 查询所有图片信息
	 * @param  [type] $page  [description]
	 * @param  [type] $limit [description]
	 * @param  string $where [description]
	 * @return [type]        [description]
	 */
	public function pic_query($page,$limit,$where=''){
		return $this->mysqli->fetchAll("SELECT pic.*, user.username as username FROM {$this->prefix}pic as pic LEFT JOIN {$this->prefix}user as user ON pic.uid = user.uid $where ORDER BY pic.date DESC limit $page, $limit");
	}

	/**
	 * 查询所有图片数量
	 */
	public function pic_count($where=''){
		return $this->mysqli->fetch("SELECT count(*) FROM {$this->prefix}pic $where")['count(*)'];
	}

	/**
	 * 批量删除图片
	 */
	public function pic_del($ids){
		return $this->mysqli->query("DELETE FROM {$this->prefix}pic WHERE id in($ids)");
	}

	/**
	 * 查询指定图片详细信息
	 * @param  [type] $pid 图片pid
	 * @return [type]      [description]
	 */
	public function pic_details($pid){
		return $this->mysqli->fetch("SELECT pid,date,uid FROM {$this->prefix}pic WHERE pid = '{$pid}'");
	}

	/**
	 * 查询最新图片
	 * @return [type] [description]
	 */
	public function pic_newest($page, $limit){
		return $this->mysqli->fetchAll("SELECT pid FROM {$this->prefix}pic ORDER BY id DESC limit {$page}, {$limit}");
	}
}