<?php
namespace application\controller\Admin;
use framework\core\Controller;
use framework\core\Factory;
/**
* 用户控制器
*/
class UserController extends Controller{

    public function __construct(){
        $this->checksession(true);
    }

	// 显示后台用户管理界面
	public function IndexAction(){
		$this->display('application/view/Admin/header.php');
		$this->display('application/view/Admin/user.php');
		$this->display('application/view/Admin/footer.php');
	}

    /**
     * 查询用户列表
     */
    public function QueryAction(){
        $res = Factory::M('UserModel');
        $key = isset($_GET['key']) ? 'WHERE username=\''.$_GET['key'].'\' || email=\''.$_GET['key'].'\'' : '';
        $limit = isset($_GET['limit']) ? $_GET['limit'] : '10';
        $page = isset($_GET['page']) ? ($_GET['page'] - 1) * $limit : '0';
        $result = $res->user_queryAll($page,$limit,$key);
        $data  = array();
        foreach ($result as $value) {
            if ($value['activation'] == 'n' && $value['role'] != 'admin' ) {
                $userStatus = '未激活';
            }else if($value['isseal'] == 'y'){
                $userStatus = '限制使用';
            }else{
                $userStatus = '正常使用';
            }
            $data[] = array(
                "usersId" =>  $value['uid'],
                "userName" => $value['username'],
                "userEmail" => $value['email'],
                "userIp" => $value['ip'],
                "userStatus" => $userStatus,
                "userGrade" => $value['role'] == 'admin' ? '超级管理员' : '普通用户',
                "userEndTime" => date('Y-m-d H:i:s',$value['time'])
            );
        }
        $data = array(
            'code' => '0',
            'msg' => '',
            'count' => $res->user_count(),
            'data' => $data
        );
        echo json_encode($data);
    }

    /**
     * 删除用户
     */
    public function DelAction(){
        $usersId = isset($_POST['usersId']) ? $_POST['usersId'] : '';
        if ($usersId != '') {
            if (is_array($usersId)) {
                $usersId = implode(',',$usersId);
            }
            $result = Factory::M('UserModel');
            if($result->user_del($usersId)){
                echo '删除成功';
            }else{
                echo '删除失败';
            }
        }
    }

    /**
     * 启用或禁用一个用户
     */
    public function DisableAction(){
        $uid = isset($_POST['uid']) ? $_POST['uid'] : '';
        $seal = isset($_POST['seal']) ? $_POST['seal'] : '';
        if ($uid != '' && $seal != '') {
            $result = Factory::M('UserModel');
            if($result->user_seal($uid,$seal)){
                echo '成功';
            }else{
                echo '失败';
            }
        }
    }
}

