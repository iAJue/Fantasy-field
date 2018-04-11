<?php
namespace application\controller\Admin;
use framework\core\Controller;
use framework\core\Factory;
use framework\libraries\Upload;
/**
* 个人中心控制器
*/
class UserinfoController extends Controller{

	public function __construct(){
		$this->checksession();
	}

	// 显示个人中心
	public function IndexAction(){
		$this->display('application/view/Admin/header.php');
		$this->display('application/view/Admin/userinfo.php');
		$this->display('application/view/Admin/footer.php');
	}

	/**
	 * 上传头像
	 * @return [type] [description]
	 */
	public function UploadAction(){
		if (isset($_FILES['file'])) {
			$upload = new Upload('file','upload/original','jpg,png,gif,bmp,jpeg');
			$result = $upload->run('1024000',false,'uid_'.$_SESSION['authen']['uid']);
			if(is_array($result)){
				if($result[0]['error'] == '0'){
					resizeImage('upload/original/'.$result[0]['name'],'upload/'.'uid_'.$_SESSION['authen']['uid'].'.jpg',200,200);
					$res = Factory::M('UserModel');
					$res->user_photo('uid_'.$_SESSION['authen']['uid'].'.jpg',$_SESSION['authen']['uid']);
					echo json_encode(['code'=>'0','src'=> PATH_URL . 'upload/'.$result[0]['name']]);
				}else{
					echo json_encode(['code' => $result[0]['error'],'msg' => Upload::getErrorText($result[0]['error'])]);
				}
			}else{
				echo json_encode(['code' => '8','msg' => $result]);
			}
		}
	}

	/**
	 * 修改资料
	 * @return [type] [description]
	 */
	public function UpdateAction(){
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		if ($username != '' && $pwd != '' && $password != '') {
			$result = Factory::M('UserModel');
			if (!$result->user_isexis($username,$_SESSION['authen']['uid'])) {
				if($result->user_pass($_SESSION['authen']['uid'])['password']==md5($pwd)){
					if($result->user_modify($username,md5($password),$_SESSION['authen']['uid'])){
						echo '资料修改成功，请退出重新登录！';
						unset($_SESSION['authen']);
				        session_destroy();
				        if(isset($_COOKIE[session_name()])) {
				            setCookie(session_name(), "", time()-42000, "/");
				        }
					}else{
						echo '出于不可抗力的因素，导致你的资料修改失败le~';
					}
				}else{
					echo '旧密码不符合！';
				}
			}else{
				echo '用户名已存在！';
			}
		}else{
			echo '参数有误！';
		}
	}

	/**
	 * 个人中心资料查询
	 * @return [type] [description]
	 */
	public function DataAction(){
		$res = Factory::M('UserModel')->user_fetch($_SESSION['authen']['uid']);
		$data = [
			'username'	=> $res['username'],
			'role' 		=> $res['role']=='admin' ? '超级管理员' : '普通用户',
			'time' 		=> date('Y-m-d H:i:s',$res['time']),
			'ip'	 	=> $res['ip'],
			'photo' 	=> $res['photo'] == '' ? PATH_URL . 'application/view/Admin/images/author.jpg' : PATH_URL . 'upload/' .$res['photo'],
			'email' 	=> $res['email']
		];
		echo json_encode($data);
	}
}
