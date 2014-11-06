<?php
namespace Metronic\Controller;
use Think\Controller;

class PublicController extends Controller {
    public function verify() {
        $config = array(
            'fontSize' => 40,
            'length' => 4,
            'useCurve' => false,
            'useNoise' => false,
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    public function login() {
        $this->display('login');
    }
}

