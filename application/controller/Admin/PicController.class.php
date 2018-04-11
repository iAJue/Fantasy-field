<?php
namespace application\controller\Admin;
use framework\core\Controller;
use framework\core\Factory;
/**
* 图库控制器
*/
class PicController extends Controller{

    public function __construct(){
        $this->checksession();
    }

	// 显示后台我的图库界面
	public function IndexAction(){
		$this->display('application/view/Admin/header.php');
		$this->display('application/view/Admin/pic.php');
		$this->display('application/view/Admin/footer.php');
	}

	//查询我的图库信息
	public function QueryAction(){
		$res = Factory::M('PicModel');  
		$key = isset($_GET['key']) ? 'WHERE (pid=\''.$_GET['key'].'\' || username=\''.$_GET['key'].'\')' : '';
        if ($_SESSION['authen']['role'] != 'admin') {
            $key .= $key == '' ? ' WHERE' : ' and';
            $key .= ' pic.uid = \'' . $_SESSION['authen']['uid'] .'\'';
        }
        $limit = isset($_GET['limit']) ? $_GET['limit'] : '10';
        $page = isset($_GET['page']) ? ($_GET['page'] - 1) * $limit : '0';
        $result = $res->pic_query($page,$limit,$key);
        $data  = array();
        foreach ($result as $value) {
            $data[] = array(
            	"picId" => $value['id'],
                "picpid" => $value['pid'],
                "picuid" => $value['username']!=''? $value['username'] : '游客',
                "picip" => $value['ip'],
                "picdate" => date('Y-m-d H:i:s',$value['date'])
            );
        }
        $data = array(
            'code' => '0',
            'msg' => '',
            'count' => $res->pic_count('WHERE uid = \''.$_SESSION['authen']['uid'].'\''),
            'data' => $data
        );
        echo json_encode($data);
	}

	/**
     * 删除图片
     */
    public function DelAction(){
        $picId = isset($_POST['picId']) ? $_POST['picId'] : '';
        if ($picId != '') {
            if (is_array($picId)) {
                $picId = implode(',',$picId);
            }
            $result = Factory::M('PicModel');
            if($result->pic_del($picId)){
                echo '删除成功';
            }else{
                echo '删除失败';
            }
        }
    }

}