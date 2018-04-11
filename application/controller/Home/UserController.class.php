<?php
namespace application\controller\Home;
use framework\core\Controller;
use framework\core\Factory;
use framework\libraries\code\ValidateCode;
use framework\libraries\phpmail\Mail;
/**
 * 用户控制器,负责用户的注册登录
 */
class UserController extends Controller{

	// 登录验证
	public function LoginAction(){
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		$verifycode = isset($_POST['verifycode']) ? $_POST['verifycode'] : '';
		if($username != '' && $password != '' && $verifycode != ''){
			if($this->VerifyAction()){
				$mysqli = Factory::M('UserModel');
				if($result = $mysqli->user_query($username,md5($password))){
					if ($result['role'] == 'admin') {
						$res=['code'=>'0000','username'=>$username,'msg'=>'欢迎回来，管理员！'];
						$_SESSION['authen'] = ['uid'=>$result['uid'],'username'=>$result['username'],'role'=>'admin'];
					}elseif (configGet('verification')=='y' && $result['activation'] == 'n') {
						$res=['code'=>'0004','username'=>$username,'msg'=>'当前账号未激活！'];
					}elseif ($result['isseal'] == 'y') {
						$res=['code'=>'0005','username'=>$username,'msg'=>'您的账号已被管理员禁止登录！'];
					}else{
						$res=['code'=>'0000','username'=>$username,'msg'=>'登录成功，欢迎回来！'];
						$_SESSION['authen'] = ['uid'=>$result['uid'],'username'=>$result['username'],'role'=>''];
					}
				}else{
					$res=['code'=>'0001','msg'=>'用户名或密码错误！'];
				}
			}else{
				$res=['code'=>'0002','msg'=>'您输入的验证码有误！'];
			}
		}else{
			$res=['code'=>'0003','msg'=>'提交参数有误！'];
		}
		echo json_encode($res);
	}

    /**
     * 用户退出
     * @return [type] [description]
     */
    public function LogoutAction(){
        unset($_SESSION['authen']);
        session_destroy();
        if(isset($_COOKIE[session_name()])) {
            setCookie(session_name(), "", time()-42000, "/");
        }
        Msg('安全退出！');
    }

	// 接收注册信息
	public function DoregisterAction(){
		if(configGet('register') == 'n') Msg('网站已关闭对外注册！','error');
		$r_password = isset($_POST['password']) ?$_POST['password'] :'';
		$r_user_name = isset($_POST['username']) ? $_POST['username'] : '';
		$r_email = isset($_POST['email']) ? $_POST['email'] : '';
		if ($r_email != '' && $r_email != '' && $r_user_name != '') {
			if(checkMail($r_email) && checkPass($r_password) && checkNmae($r_user_name)){
				$mysqli = Factory::M('UserModel');
				if ($mysqli->user_limitip(getIp())< configGet('limitip')) {
					$activation = $mysqli->hasUserEmail($r_user_name,$r_email);
					if (!$activation['activation']) {
						if (configGet('verification')=='y') {
							$token = md5($r_user_name.$r_email . time());
							$result = $mysqli->user_add($r_user_name,md5($r_password),time(),$r_email,$token,getIp());
							$res = $this->Activation($r_user_name,$r_email,$token);
						}else{ //不需要验证
							$result = $mysqli->user_add($r_user_name,md5($r_password),time(),$r_email,'',getIp());
							$res = ['code'=> '0000','msg'=>'注册成功！欢迎使用' . configGet('title')];
						}
					}elseif ($activation['activation'] == 'n' && configGet('verification')=='y') { //重新注册发邮件
						$token = md5($r_user_name.$r_email . time());
						$mysqli->user_update($r_user_name,md5($r_password),time(),$r_email,$token);
						$res = $this->Activation($r_user_name,$r_email,$token);
					}else{
						$res = ['code'=> '0001','msg'=>'用户名或邮箱已存在！' ];
					}
				}else{
					$res = ['code'=> '0004','msg'=>'当前ip注册数量已达最大上限！' ];
				}
			}else{
				$res = ['code'=> '0002','msg'=>'提交参数不合法！' ];
			}
		}else{
			$res = ['code'=> '0003','msg'=>'提交参数有误！' ];
		}
		echo json_encode($res);
	}

	/**
	 * 发送激活邮件
	 * @param  [type] $r_user_name 用户名 
	 * @param  [type] $r_email     发送的邮箱地址
	 * @param  [type] $token       唯一标识符
	 * @return [type]              [description]
	 */
	private function Activation($r_user_name,$r_email,$token){
		$title = configGet('title');
		$etime = configGet('etime');
		$url = PATH_URL;
		$html = <<<EOT
亲爱的 $r_user_name:<br><br>欢迎使用{$title}通行证!<br><br>请点击下面的链接完成邮箱验证:<br><br><a href="{$url}Home/User/ActivateAction/token/$token">{$url}Home/User/ActivateAction/token/$token</a><br>如果以上链接无法点击，请将该链接复制到浏览器（如 Chrome）的地址栏中访问，也可以成功完成邮箱验证！<br><br><br><br>1. 为了保障您账号的安全性, 请在{$etime}小时内完成验证, 此链接将在您激活过一次后失效!<br><br>2. 如您没有注册过{$title}账号, 请您忽略此邮件, 由此给您带来的不便敬请谅解。<br><br><br><br>- {$title}<br>(这是一封自动产生的Email，请勿回复)
EOT;
		$Mail = new Mail($GLOBALS['appconfig']['host'],$GLOBALS['appconfig']['port'],$GLOBALS['appconfig']['auth'],$GLOBALS['appconfig']['user'],$GLOBALS['appconfig']['pass']);
		if($Mail->send($r_email,'注册成功，请激活！',$html,$title)){
			$res = ['code'=> '0000','msg'=>'注册成功，请前往邮箱激活！' ];
		}else{
			$res = ['code'=> '0004','msg'=>'激活邮件发送失败，请重新注册！' ];
		}
		return $res;
	}

	// 生成验证码
	public function MakeCaptcAction(){
		$captcha = new ValidateCode();
		$captcha->Generate();
	}

	// 检测验证码
	private function VerifyAction(){
		$verifycode = isset($_POST['verifycode']) ? $_POST['verifycode'] : '';
		if(ValidateCode::Verify($verifycode)){
			return true;
		}
		return false;
	}

	/**
	 * 用户激活
	 */
	public function ActivateAction(){
		$token = isset($_GET['token']) ? $_GET['token'] :'';
		if ($token!= '') {
			$mysqli = Factory::M('UserModel');
			if($mysqli->activate($token,time(),$GLOBALS['appconfig']['etime']*3600)){
				if($mysqli->user_activate($token)){
					Msg("激活成功！","success","感谢您注册");
				}else{
					Msg("激活失败，请重试！", "error","出于不可抗力因素，到账您的账号激活失败");
				}
			}else{
				Msg("激活链接无效或已过期！", "info","请返回页面重新注册");
			}
		}else{
			Msg("参数有误！", "error","请不要随意修改链接");
		}
	}
}