<?php
namespace application\controller\Admin;
use framework\core\Controller;
use framework\core\Factory;
/**
* 导航栏控制器
*/
class NavbarController extends Controller{

    public function __construct(){
        $this->checksession(true);
    }

    //显示导航页面
    public function IndexAction(){
        $this->display('application/view/Admin/header.php');
        $this->display('application/view/Admin/navbar.php');
        $this->display('application/view/Admin/footer.php');
    }

    //添加导航界面
    public function NavbaraddAction(){
        $this->display('application/view/Admin/navbaradd.php');
    }

    /**
     * 查询导航栏信息
     */
    public function QueryAction(){
        $key = isset($_GET['key']) ? 'WHERE naviname=\''.$_GET['key'].'\' || url=\''.$_GET['key'].'\'' : '';
        $limit = isset($_GET['limit']) ? $_GET['limit'] : '10';
        $page = isset($_GET['page']) ? ($_GET['page'] - 1) * $limit : '0';
        $res = Factory::M('NavbarModel');
        $result = $res->navbar_queryAll($page,$limit,$key);
        $data  = array();
        foreach ($result as $value) {
            $data[] = array(
                "navbarId" =>  $value['id'],
                "navbarName" => $value['naviname'],
                "navbarHide" => $value['hide']=='y'? 'checked':'',
                "navbarUrl" => $value['url'],
                "icon" => $value['icon']
            );
        }
        $data = array(
            'code' => '0',
            'msg' => '',
            'count' => $res->navbar_count(),
            'data' => $data
        );
        echo json_encode($data);
    }

    /**
     * 删除导航
     */
    public function DelAction(){
        $navbarsId = isset($_POST['navbarsId']) ? $_POST['navbarsId'] : '';
        if ($navbarsId != '') {
            if (is_array($navbarsId)) {
                $navbarsId = implode(',',$navbarsId);
            }
            $result = Factory::M('NavbarModel');
            if($result->navbar_del($navbarsId)){
                echo '删除成功';
            }else{
                echo '删除失败';
            }
        }
    }

    /**
     * 显示或隐藏一个导航
     */
    public function HideAction(){
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $hide = isset($_POST['hide']) ? $_POST['hide'] : '';
        if ($id != '' && $hide != '') {
            $result = Factory::M('NavbarModel');
            if($result->navbar_hide($id,$hide)){
                echo '成功';
            }else{
                echo '失败';
            }
        }
    }

    /**
     * 添加或修改一个导航
     */
    public function AddAction(){
        $navbarId = isset($_POST['navbarId']) ? $_POST['navbarId'] : '';
        $navbarName = isset($_POST['navbarName']) ? $_POST['navbarName'] : '';
        $navbarUrl = isset($_POST['navbarUrl']) ? $_POST['navbarUrl'] : '';
        $navbarIcon = isset($_POST['navbarIcon']) ? $_POST['navbarIcon'] : '';
        $navbarHide = isset($_POST['navbarHide']) ? $_POST['navbarHide'] : 'n';
        if ($navbarName != '' && $navbarUrl != '') {
            $res = Factory::M('NavbarModel');
            if ($navbarId != '') {
                echo $res->navbar_update($navbarName,$navbarUrl,$navbarHide,$navbarIcon,$navbarId);
            }else{
                echo $res->navbar_add($navbarName,$navbarUrl,$navbarHide,$navbarIcon);
            } 
        }
    }
}

