<?php
namespace framework\libraries\code;
/**
* 验证码生成类
*/
class ValidateCode {
	/**
	 * 用于保存画布资源
	 */
	private $img = null;
	/**
	 * 输出一个验证码
	 */
	public function Generate(){
		$this->CreateImage();
		header("Content-Type:image/jpeg");//告诉浏览器返回的资源为JPEG格式的图片
		imagejpeg($this->img);//已JPEG的格式输出画布到浏览器或文件
		imagedestroy($this->img);//销毁画布资源
	}
	/**
	 * 生成一个验证码
	 */
	private function CreateImage(){
		$this->createBg();
		$this->createLine();
		$phrase = $this->createFont();
		$_SESSION['authnum_session'] = $phrase;
	}
	/**
	 * 生成验证码图片背景
	 */
	private function createBg(){
		// 1、创建画布用于画验证码
		$this->img = imagecreatetruecolor(250, 100);//创建一个画布并设置宽高 新建一个真彩色图像(默认黑色背景)

		$color = imagecolorallocate($this->img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)
			);//给画布分配一个随机背景颜色，调色并没有直接给画布。mt_rand()生成一个更好的随机数
		imagefill($this->img, 0, 0, $color);//给画布从0,0开始填充颜色
	}
	/**
	 * 生成验证码干扰点、干扰线
	 */
	private function createLine(){
		// 2、添加干扰线、干扰点
		for ($i=0; $i < 10; $i++) { 
			$color = imagecolorallocate($this->img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));//调色，用于分配颜色
			imageline($this->img, mt_rand(0,250), mt_rand(0,100), mt_rand(0,250), mt_rand(0,100), $color);//随机在画布上画一条随机颜色的线段
		}
		for ($i=0; $i < 100; $i++) { 
			$color = imagecolorallocate($this->img, mt_rand(0,255),mt_rand(0,255), mt_rand(0,255));//返回一个颜色的标识符
			imagesetpixel($this->img, mt_rand(0,250), mt_rand(0,100), $color);//在画布上随机画一个单一像素(画点)
		}
	}
	/**
	 * 生成验证码文字
	 * @return	string	返回生成的验证码
	 */
	private function createFont(){
		// 3、添加字母数字
		$rand_str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//用于随机输出的字符串
		$str_arr = array();
		for ($i=0; $i < 4; $i++) { 
			$str_arr[] = $rand_str[mt_rand(0,strlen($rand_str)-1)];//随机取4个字符加到数组中
		}
		$x_start = 250/4; //单个字符所占的宽度
		$phrase = '';
		foreach ($str_arr as $value) {
			$color = imagecolorallocate($this->img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
			//参数分别为 画布资源，字体大小，字体角度，字符高度，字体颜色，字体样式，内容
			imagettftext($this->img, 50, mt_rand(-30,30), $x_start, 150/2, $color, APP_PATH.'framework/libraries/code/framd.ttf' , $value);
			$x_start +=50;
			$phrase.= $value;
		}
		return $phrase;
	}
	/**
	 * 检测验证码是否正确
	 * @param	string	$str	用户所输入验证码
	 * @return	boolean/string	成功返true, 失败返回false
	 */
	public static function Verify($str){
		if (isset($_SESSION['authnum_session']) && $str != '' && strtolower($_SESSION['authnum_session']) == strtolower($str)) {
			unset($_SESSION['authnum_session']);
			return true;
		}else{
			return false;
		}
	}
}