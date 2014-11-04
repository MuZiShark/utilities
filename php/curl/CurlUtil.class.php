<?php

/**
 * Created by JetBrains PhpStorm.
 * Author:
 * Date:
 * Create Time:
 * Last Update Time:
 */

class CurlUtil {
    private $_curl;
    private $_timeout = 30;

    public function __construct($refer_str = '', $user_agent_str = '', $post_data_str = '', $cookie_str = '', $is_need_head = 0) {	
    	$this->_curl = curl_init();

        if($refer_str != '') {
            curl_setopt($this->_curl, CURLOPT_REFERER, $refer_str);
        }
        if($user_agent_str != '') {
            curl_setopt($this->_curl, CURLOPT_USERAGENT, $user_agent_str);
        }
        if($post_data_str != '') {
            curl_setopt($this->_curl, CURLOPT_POSTFIELDS, $post_data_str);
        }
        if($cookie_str != '') {
            curl_setopt($this->_curl, CURLOPT_COOKIEFILE, str_replace('\\', '/', dirname(__FILE__)) . '/' . $cookie_str);
            curl_setopt($this->_curl, CURLOPT_COOKIEJAR, str_replace('\\', '/', dirname(__FILE__)) . '/' . $cookie_str);
        }

        curl_setopt($this->_curl, CURLOPT_HTTPHEADER, array('Accept-Language:zh-CN,zh;q=0.8'));

        curl_setopt($this->_curl, CURLOPT_HEADER, $is_need_head);
        curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_curl, CURLOPT_TIMEOUT, $this->_timeout);
        curl_setopt($this->_curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->_curl, CURLOPT_MAXREDIRS, 5);
    }

    public function __destruct() {
        curl_close($this->_curl);
    }

    /**
     * 单量抓取函数
     */
    public function getUrl($url) {
        curl_setopt($this->_curl, CURLOPT_URL, $url);
        return curl_exec($this->_curl);
    }
}

$url = "http://www.baidu.com/";

$test = new CurlUtil();
$data = $demo->getUrl($url);
var_dump($data);

?>