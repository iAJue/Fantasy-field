<?php
namespace framework\libraries;
/**
 * 文件上传类
 */

final class Upload{

	public $dir, $allow, $message=array();
	private $files=array();

	/**
	 * 初始化类
	 * @param	string	$name	表单名称
	 * @param	string	$dir	上传文件保存目录
	 * @param	string	$allow	允许上传类型
	 */
	public function __construct($name, $dir, $allow='jpg,png,gif,bmp,jpeg,txt'){
		if(isset($_FILES[$name])){
			foreach($_FILES[$name] as $key => $value){
				$this->files[$key] = (array)$value;
			}
			$this->dir = rtrim($dir, '/') . '/';
			$this->allow = explode(',', strtolower($allow));
			(is_dir($this->dir) || mkdir($dir, 0777, true)) || $this->message = -1;
		}else{
			$this->message = 8;		//初始化失败
		}
	}

	/**
	 * 运行
	 * @param	integer	$maxSize	最大允许上传字节数
	 * @param	boolean	$randName	随机文件名
	 * @param	boolean	$name		当不随机文件名时指定的文件名
	 * @param	boolean	$cover		覆盖原有文件
	 * @return	string/array		处理结果
	 */
	public function run($maxSize=1000000, $randName=true, $name='', $cover=true){

		//检查初始化
		if($this->message===8 || $this->message==-1)
			return self::getErrorText($this->message);

		$count = count($this->files['name']);
		for($i=0; $i<$count; $i++){

			//有效检查
			if(!$this->files['tmp_name'][$i])
				continue;

			//变量初始
			$arr = array(
				'name'		=>	$this->files['name'][$i],
				'type'		=>	$this->files['type'][$i],
				'tmp_name'	=>	$this->files['tmp_name'][$i],
				'error'		=>	$this->files['error'][$i],
				'size'		=>	$this->files['size'][$i]
			);
			$info = array(
				'name'	=>	$arr['name'],
				'type'	=>	$arr['type'],
				'size'	=>	$arr['size']
			);
			$fileExt = strtolower(getFileExt($arr['name']));

			//检查大小
			if($arr['size'] > $maxSize)
				$arr['error'] = -2;

			//检查类型
			if(!in_array($fileExt, $this->allow))
				$arr['error'] = -3;

			//检查错误
			if($arr['error'] != 0){
				$info['error'] = $arr['error'];
				$info['errorText'] = self::getErrorText($info['error']);
				$this->message[] = $info;
				is_file($arr['tmp_name']) && @unlink($arr['tmp_name']);
				continue;
			}

			//设置名称
			$info['name'] = $randName ? \getRandName('.'.$fileExt) : $name . '.' . $fileExt;

			//检查覆盖
			if(!is_file($this->dir . $info['name']) || $cover)
				move_uploaded_file($arr['tmp_name'], $this->dir . $info['name']) || $info['error'] = -4;

			//添加日志
			$info['error'] = isset($info['error']) ? $info['error'] : 0;
			$info['errorText'] = self::getErrorText($info['error']);
			$this->message[] = $info;

			//垃圾回收
			if($info['error']===0 && is_file($arr['tmp_name']))
				@unlink($arr['tmp_name']);

		}

		//返回结果
		return $this->message;

	}

	/**
	 * 获取错误信息文本
	 * @param	[type]	$error	错误ID
	 * @return	string			文本信息
	 */
	public static function getErrorText($error){
		switch($error){
			case -4:
				return '文件移动失败(可能因为出现中文文件名, 建议使用英文或自动生成)';
			case -3:
				return '上传类型不被允许';
			case -2:
				return '文件大小超出设置范围';
			case -1:
				return '上传目录无效，请重新指定';
			case 0:
				return '上传成功';
			case 1:
				return '上传文件大小超过 php.ini 中 upload_max_filesize 选项限制值';
			case 2:
				return '上传文件大小超过 HTML 表单中 MAX_FILE_SIZE 选项指定值';
			case 3:
				return '文件上传不完整';
			case 4:
				return '文件没有被上传';
			case 6:
				return 'PHP找不到临时文件夹';
			case 7:
				return 'PHP文件写入失败';
			case 8:
				return '上传表单名称指定错误';
			default:
				return '未知错误';
		}
	}

}

