<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index() {
    	$this->show('欢迎使用ThinkPHP！您现在访问的是Admin模块的Index控制器！');
    }

    public function welcome() {
        $User = D('User');
        $list =$User->getField('uid',true);
        var_dump($list);die();
        $this->display();
    }

    public function send()
    {
        header("content-type:text/html; charset=utf-8");
        //实例化PHPMailer对象
        static $mailer = null;
        if (!$mailer) {
            import("@.Util.Mail.PHPMailer");
            $mailer = new \PHPMailer();
        }
        $address = 'li_rui@mama.cn';
        $title = '您好！';
        $content = '这是我的测试邮件！';
        if (sendMail($mailer, $address, $title, $content)) {
            echo '发送成功';
        } else {
            echo '发送失败';
        }
    }


}