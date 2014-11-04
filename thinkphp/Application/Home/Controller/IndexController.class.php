<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	
	public function index() {
    	$this->show('欢迎使用ThinkPHP！您现在访问的是Home模块的Index控制器！');
    }
    
    public function welcome() { // 访问地址：http://www.lirui.cn/index.php/admin/index/welcome
    	$this->display('index');
    }
}