<?php
namespace application\controller\Admin;
use framework\core\Controller;
use framework\core\Factory;
use framework\libraries\Autoupdate;

/**
* 后台首页控制器
*/
class IndexController extends Controller{

    public function __construct(){
        $this->checksession();
    }

	// 显示后台首页
	public function IndexAction(){
        if ($_SESSION['authen']['role']) {
            $result = Factory::M('IndexModel');
            if (function_exists("imagecreate")) {
                if (function_exists('gd_info')) {
                    $ver_info = gd_info();
                    $gd_ver = $ver_info['GD Version'];
                } else{
                    $gd_ver = '支持';
                }
            } else{
                $gd_ver = '不支持';
            }
            $this->assign('prefix',$result->getPrefix());
            $this->assign('gd_ver',$gd_ver);
            $this->assign('version',$result->getVersion());
        }else{
            $res = Factory::M('UserModel')->user_fetch($_SESSION['authen']['uid']);
            $this->assign('ip',$res['ip']);
            $this->assign('time',date('Y-m-d H:i:s',$res['time']));
            $this->assign('email',$res['email']);
            $this->assign('count',Factory::M('PicModel')->pic_count('WHERE uid= '.$_SESSION['authen']['uid']));
        }
        $this->assign('username',$_SESSION['authen']['role']=='admin'?'管理员':$_SESSION['authen']['username']);
		$this->display('application/view/Admin/header.php');
		$this->display('application/view/Admin/index.php');
		$this->display('application/view/Admin/footer.php');
	}

    /**
     * 更新程序
     */
    public function UpdateAction(){
        $update = new Autoupdate(APP_PATH,false);
        $update->currentVersion = APP_VERSION;
        $update->updateUrl = 'https://img.52ecy.cn/service/'; //幻想领域服务域名
        $latest = $update->checkUpdate();
        if ($latest !== false) {
            if ($latest > $update->currentVersion) {
                if ($update->update()) {
                    if($update->replaceupdate()){
                        $res=['code'=>'0000','msg'=>'更新成功，欢迎体验最新的幻想领域系统^_^'];
                    }else{
                        $res=['code'=>'0004','msg'=>'更新文件效验失败！'];
                    }
                }else {
                    $res=['code'=>'0002','msg'=>'在线更新失败，请尝试手动更新！信息：'.$update->getLastError()];
                }
            }else {
                $res=['code'=>'0001','msg'=>'没有发现可用的新版本！'];
            }
        } else {
            $res=['code'=>'0003','msg'=>$update->getLastError()];
        }
        echo json_encode($res);
    }
}
