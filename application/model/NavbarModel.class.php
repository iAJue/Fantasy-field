<?php
namespace application\model;
use framework\core\Model;
/**
* 导航栏模型类
*/
class NavbarModel extends Model{
	
	/**
	 * 查询导航栏
	 */
	public function navbar_queryAll($page,$limit,$where=''){
		return $this->mysqli->fetchAll("SELECT * FROM {$this->prefix}navi $where limit $page, $limit");
	}

	/**
	 * 查询导航栏数量
	 * @return [type] [description]
	 */
	public function navbar_count(){
		return $this->mysqli->fetch("SELECT count(*) FROM {$this->prefix}navi")['count(*)'];
	}

	/**
	 * 显示或隐藏导航
	 */
	public function navbar_hide($id,$hide = 'n'){
		return $this->mysqli->query("UPDATE {$this->prefix}navi SET hide = '{$hide}' WHERE id = '{$id}'");
	}

	/**
	 * 批量删除导航
	 */
	public function navbar_del($navbarids){
		return $this->mysqli->query("DELETE FROM {$this->prefix}navi WHERE id in($navbarids)");
	}
	
	/**
	 * 修改一个导航
	 * @return [type] [description]
	 */
	public function navbar_update($navbarName,$navbarUrl,$navbarHide,$navbarIcon,$id){
		return $this->mysqli->query("UPDATE {$this->prefix}navi SET naviname = '{$navbarName}', url = '{$navbarUrl}', hide = '{$navbarHide}', icon = '{$navbarIcon}' WHERE id = '{$id}'");
	}

	/**
	 * 增加一个新导航
	 * @return [type] [description]
	 */
	public function navbar_add($name,$url,$hide,$iocn){
		return $this->mysqli->query("INSERT INTO {$this->prefix}navi (`naviname`,`url`,`hide`,`icon`) values('{$name}','{$url}','{$hide}','$iocn')");
	}
}