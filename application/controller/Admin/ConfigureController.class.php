<?php
namespace application\controller\Admin;
use framework\core\Controller;
/**
* 后台配置控制器
*/
class ConfigureController extends Controller{

	public function __construct(){
		$this->checksession(true);
	}

	// 显示后台配置界面
	public function IndexAction(){
		$this->display('application/view/Admin/header.php');
		$this->display('application/view/Admin/configure.php');
		$this->display('application/view/Admin/footer.php');
	}

	/**
	 * 获取配置数据
	 * @return [type] [description]
	 */
	public function DataAction(){
		$data = array(
			'register'		=> configGet('register'),	//注册
			'tourist'		=> configGet('tourist'),	//游客
			'verification'	=> configGet('verification'),	//注册验证
			'explore'		=> configGet('explore'),
			'limitip' 		=> configGet('limitip'),
			'title' 		=> configGet('title'),
			'siteinfo' 		=> configGet('siteinfo'),
			'keywords' 		=> configGet('keywords'),
			'description' 	=> configGet('description'),
			'record' 		=> configGet('record'),
			'footerinfo' 	=> str_replace('&#039;','\'',htmlspecialchars_decode(configGet('footerinfo'))),
			'username' 		=> configGet('username'),
			'password'		=> configGet('password'),
			'level' 		=> configGet('level'),
			'user' 			=> configGet('user'),
			'pass' 			=> configGet('pass'),
			'etime' 		=> configGet('etime')
		);
		echo json_encode($data);
	}

	/**
	 * 修改配置数据
	 */
	public function UpdateAction(){
		$data = [
		#===========网站开关================
		'register' => isset($_POST['register']) ? 'y' : 'n',	//注册
		'tourist' => isset($_POST['tourist']) ? 'y' : 'n',	//游客
		'verification' => isset($_POST['verification']) ? 'y' : 'n',	//注册验证
		'explore' => isset($_POST['explore']) ? 'y' : 'n',	//探索
		'limitip' => isset($_POST['limitip']) ? $_POST['limitip'] : '1',
		#===========网站基本配置============
		'title' => isset($_POST['title']) ? $_POST['title'] : '幻想领域', 	//站点标题
		'siteinfo' => isset($_POST['siteinfo']) ? $_POST['siteinfo'] : '',	//站点副标题
		'keywords' => isset($_POST['keywords']) ? $_POST['keywords'] : '二次元图片,新浪图床,幻想领域,阿珏博客',	//站点关键字
		'description' => isset($_POST['description']) ? $_POST['description'] : '',	//站点描述
		'record' => isset($_POST['record']) ? $_POST['record'] : '',	//备案号
		'footerinfo' => isset($_POST['footerinfo']) ? $_POST['footerinfo'] : '',	//底部信息
		#===========新浪图床配置============
		'username' => isset($_POST['username']) ? $_POST['username'] : '',	//新浪账号
		'password' => isset($_POST['password']) ? $_POST['password'] : '',	//新浪密码
		'time' => time()-3600*24,
		'level' => isset($_POST['level']) ? $_POST['level'] : '4',	//探索缩略图级别0-7	
		#===========email邮箱配置============
		'auth' => isset($_POST['user']) ? $_POST['user'] : '',		//	登录账号
		'user' => isset($_POST['user']) ? $_POST['user'] : '',		//	账号
		'pass' => isset($_POST['pass']) ? $_POST['pass'] : '',				//	密码
		'etime' => isset($_POST['etime']) ? $_POST['etime'] : '12',				//验证码有效时间(小时)
		];
		echo configSet($data);
	}
}
