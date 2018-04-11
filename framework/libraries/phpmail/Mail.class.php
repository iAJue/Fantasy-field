<?php
namespace framework\libraries\phpmail;
/**
 * 邮箱发信类
 */
final class Mail{
	//调试模式
	public $debug=false;
	private $smtp;

	/**
	 * 构造函数
	 * @param	string	$host	发信服务器
	 * @param	integer	$port	服务器端口
	 * @param	boolean	$auth	登录账号
	 * @param	string	$user	账号
	 * @param	string	$pass	密码
	 */
	public function __construct($host='', $port=25, $auth=false, $user=null, $pass=null){
		$this->smtp = new Smtp($host, $port, $auth, $user, $pass);
		$this->smtp->debug = $this->debug;
	}

	/**
	 * 发送
	 * @param	string	$to			收信地址
	 * @param	integer	$title		邮件标题
	 * @param	boolean	$content	邮件内容
	 * @param	string	$from		邮件发件人
	 * @param	string	$type		邮件类型(TXT or HTML)
	 * @return	boolean
	 */
	public function send($to, $title, $content, $from, $type='HTML'){
		return $this->smtp->sendmail($to, $from, $this->smtp->user, $title, $content, strtoupper($type));
	}
}
