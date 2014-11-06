<?php
namespace Metronic\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index() {
        $this->show('欢迎使用ThinkPHP！您现在访问的是Metronic模块的Index控制器！');
    }

    public function welcome() {
        $this->display('index');
    }
}