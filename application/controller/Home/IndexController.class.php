<?php
namespace application\controller\Home;
use framework\core\Factory;
use framework\core\Controller;
use framework\libraries\Sinaupload;
/**
 * 首页控制器
 */
class IndexController extends Controller{

	/**
	 * 显示首页面
	 */
	public function IndexAction(){
		ob_start();
		$res = Factory::M('PicModel');
		$result = Factory::M('NavbarModel');
		$prompt = configGet('register') == 'n' ? '关闭注册，' : '';
		$prompt.= configGet('tourist')=='n' ? '关闭游客上传，' : '';
		$record = configGet('record') != '' ? '<a href="http://www.miibeian.gov.cn/" target="_blank">'.configGet('record') .'</a>' : '';
		$title = configGet('siteinfo')=='' ? configGet('title') : configGet('title') . ' - ' . configGet('siteinfo');
		$username = isset($_SESSION['authen'])? $_SESSION['authen']['username'] : '';
		$this->assign('AUTH',$username);
		$this->assign('count',number_format($res->pic_count()));
		$this->assign('title',$title);
		$this->assign('prompt',$prompt);
		$this->assign('record',$record);
		$this->assign('footerinfo',str_replace('&#039;','\'',htmlspecialchars_decode(configGet('footerinfo'))));
		$this->assign('register',configGet('register'));
		$this->assign('description',configGet('description'));
		$this->assign('keywords',configGet('keywords'));
		$this->assign('explore',configGet('explore'));
		$this->assign('tourist',$username=='' ? configGet('tourist'): '');
		$this->assign('navbar',$result->navbar_queryAll('0','5',"WHERE hide = 'n'"));
		$this->display('application/view/Home/index.php');
		$out = ob_get_clean();
		$out = str_replace('<span class="yright"></span><br>','<span class="yright">本站由轻量级图床程序<a href="https://img.52ecy.cn/" title="一个二次元图片的领域">幻想领域</a>强力驱动</span><br>',$out);
		$out = str_replace('<!--','',$out);
		$out = str_replace('-->','',$out);
		if(!strpos($out,'<span class="yright">本站由轻量级图床程序<a href="https://img.52ecy.cn/" title="一个二次元图片的领域">幻想领域</a>强力驱动</span><br>')){
			header("Location: https://img.52ecy.cn/service/copyright.html");
			$out = '';
			exit;
		}
		echo($out);
		ob_end_flush();
	}

	/**
	 * 探索界面
	 */
	public function ExploreAction(){
		$this->Check();
		$result = Factory::M('PicModel');
		$res = Factory::M('NavbarModel');
		$level = array('large','bmiddle','mw1024','mw690','small','square','thumb180','thumbnail');
		$level = $level[$GLOBALS['appconfig']['level']];
		$this->assign('AUTH',isset($_SESSION['authen'])? $_SESSION['authen']['username'] : '');
		$this->assign('level',$level);
		$this->assign('active','Explore');
		$this->assign('title','探索 - '.$GLOBALS['appconfig']['title']);
		$this->assign('description',configGet('description'));
		$this->assign('keywords',configGet('keywords'));
		$this->assign('pic',$result->pic_rand(40));
		$this->assign('navbar',$res->navbar_queryAll('0','5',"WHERE hide = 'n'"));
		$this->display('application/view/Home/header.php');
		$this->display('application/view/Home/explore.php');
	}

	/**
	 * 最新的
	 */
	public function NewestAction(){
		$this->Check();
		$level = array('large','bmiddle','mw1024','mw690','small','square','thumb180','thumbnail');
		$level = $level[$GLOBALS['appconfig']['level']];
		$this->assign('level',$level);
		$this->assign('active','Newest');
		$this->assign('title','最新的 - '.$GLOBALS['appconfig']['title']);
		$this->assign('AUTH',isset($_SESSION['authen'])? $_SESSION['authen']['username'] : '');
		$this->assign('navbar',Factory::M('NavbarModel')->navbar_queryAll('0','5',"WHERE hide = 'n'"));
		$this->assign('description',configGet('description'));
		$this->assign('keywords',configGet('keywords'));
		$this->assign('pic',Factory::M('PicModel')->pic_newest(0,40));
		$this->display('application/view/Home/header.php');
		$this->display('application/view/Home/explore.php');
	}

	/**
	 * 随机一张图片详情页
	 */
	public function RandAction(){
		$this->Check();
		$pid = Factory::M('PicModel')->pic_rand(1);
		if ($pid!=array()) {
			Jump(PATH_URL . $pid[0]['pid']);
		}else{
			Msg('暂时还没有图片！','info');
		}
	}

	/**
	 * 图片详情页
	 */
	public function DetailsAction(){
		$this->Check();
		$pid = isset($_GET['pid']) ? $_GET['pid'] : '';
		if ($pid =='') {
			Msg('图片不存在！','info','图片找不到咯-.-');
		}
		$picdetails = Factory::M('PicModel')->pic_details($pid);
		if (!$picdetails) {
			Msg('图片不存在！','info','图片找不到咯-.-');
		}
		$res = Factory::M('NavbarModel');
		$userinfo = Factory::M('UserModel')->user_fetch($picdetails['uid']);
		$level = array('large','bmiddle','mw1024','mw690','small','square','thumb180','thumbnail');
		$level = $level[$GLOBALS['appconfig']['level']];
		$this->assign('AUTH',isset($_SESSION['authen'])? $_SESSION['authen']['username'] : '');
		$this->assign('level',$level);
		$this->assign('active','Rand');
		$this->assign('description',configGet('description'));
		$this->assign('keywords',configGet('keywords'));
		$this->assign('picid',$picdetails['pid']);
		$this->assign('navbar',$res->navbar_queryAll('0','5',"WHERE hide = 'n'"));
		$this->assign('title', $picdetails['pid'].' - '.$GLOBALS['appconfig']['title']);
		$this->assign('user',$userinfo['username']);
		$this->assign('portrait',$userinfo['photo']=='' ? PATH_URL.'application/view/Admin/images/author.jpg': PATH_URL.'upload/uid_'.$picdetails['uid'].'.jpg');
		$this->assign('time',smartDate($picdetails['date']));
		$this->display('application/view/Home/header.php');
		$this->display('application/view/Home/details.php');
	}

	/**
	 * 下拉探索请求图片接口
	 */
	public function RandomAction(){
		$this->Check();
		$result = Factory::M('PicModel');
		$imgarr = $result->pic_rand(10);
		$level = array('large','bmiddle','mw1024','mw690','small','square','thumb180','thumbnail');
		$level = $level[$GLOBALS['appconfig']['level']];
		$data = array();
		foreach ($imgarr as $value) {
			$data['src'][] = 'https://ws3.sinaimg.cn/' . $level . '/' . $value['pid'];
		}
		echo json_encode($data);
	}

	/**
	 * 下拉最新的请求图片接口
	 */
	public function NewestdownAction(){
		$this->Check();
		$page = isset($_GET['page']) ? ($_GET['page'] - 1) * 10 : '0';
		$imgarr = Factory::M('PicModel')->pic_newest($page,10);
		$level = array('large','bmiddle','mw1024','mw690','small','square','thumb180','thumbnail');
		$level = $level[$GLOBALS['appconfig']['level']];
		$data = array();
		foreach ($imgarr as $value) {
			$data['src'][] = 'https://ws3.sinaimg.cn/' . $level . '/' . $value['pid'];
		}
		echo json_encode($data);
	}

	/**
	 * 上传图片到新浪
	 */
	public function UploadAction() {
		if (configGet('tourist')=='n') {
			$this->checksession();
		}
		$infoArr = $this->BuildInfo($_FILES);
		if ($infoArr) {
			$res['code'] = '-1';
			$res['url'] = '';	
			$values = '';
			$this->CookieSet();
			$upload = new Sinaupload(configGet('cookie'));
			foreach ($infoArr as $val) {
			    $name = $val['name'];//得到文件名
			    if($val['size'] < 10*1024*1024){
			        $type = strtolower(substr($name,strrpos($name,'.')+1));//得到上传文件类型
			        $allow_type = array('jpg','png','gif','jpeg');//定义允许上传为类型
			        //判断文件类型是否允许上传
			        if (in_array($type, $allow_type)){
			            //判断是否通过http post上传
			            if (is_uploaded_file($val['tmp_name'])){
			                $str = $upload->upload($val['tmp_name']);
			                $str = json_decode($str,true);
							if (!isset($str['data']['pics']['pic_1']['pid'])) {
								$res['code'] = '上传失败，请稍后重试！';
							}else{
								$uid = isset($_SESSION['authen']['uid']) ? $_SESSION['authen']['uid'] : '';
								$values .= '(\''.$str['data']['pics']['pic_1']['pid'].'\',\''.$uid.'\',\''.time().'\',\''.getIp().'\'),';
								$res['code'] = '0000';
								$res['url'] .=  $upload->getImageUrl($str['data']['pics']['pic_1']['pid']) . '
';
							}
			            }
			        }
			    }
			}
		}else{
			$res['code'] = '上传数据有误！';
		}
		$result = Factory::M('PicModel');
		$result->pic_add(trim($values,','));
		echo json_encode($res);
	}

	/**
	 * 更新cookie(新浪cookie24小时整失效，超过20小时则重新获取)
	 */
	private function CookieSet(){
		if (time() - $GLOBALS['appconfig']['time'] > 20*3600) {
			configSet(array('time'=>time(),'cookie'=>Sinaupload::login(configGet('username'),configGet('password'))));
		}
	}

	/**
	 * 判断探索界面是否开放
	 * @return [type] [description]
	 */
	private function Check(){
		if(configGet('explore')=='n') Msg('页面未开放！','info');
	}
	
	/**
	 * 多文件上传转单文件数组
	 */
	private function BuildInfo(){
		$i = 0;
		foreach ($_FILES as $v){//三维数组转换成2维数组
		    if(is_string($v['name'])){ //单文件上传
		        $info[$i] = $v;
		        $i++;
		    }else{ // 多文件上传
		        foreach ($v['name'] as $key=>$val){//2维数组转换成1维数组
		            //取出一维数组的值，然后形成另一个数组
		            //新的数组的结构为：info=>i=>('name','size'.....)
		            $info[$i]['name'] = $v['name'][$key];
		            $info[$i]['size'] = $v['size'][$key];
		            $info[$i]['type'] = $v['type'][$key];
		            $info[$i]['tmp_name'] = $v['tmp_name'][$key];
		            $info[$i]['error'] = $v['error'][$key];
		            $i++;
		        }
		    }
		}
		return $info;
	} 

	
}

