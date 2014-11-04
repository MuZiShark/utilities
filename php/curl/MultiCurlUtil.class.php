<?php

/**
 * Created by JetBrains PhpStorm.
 * Author:
 * Date:
 * Create Time:
 * Last Update Time:
 */

class MultiCurlUtil {
    private $_mcurl;
    private $_timeout = 30;
    private $_handleArr = array();

    public function __construct($urlArr, $refer_str = '', $user_agent_str = '', $post_data_str = '', $cookie_str = '', $is_need_head = 0) {
        if(!is_array($urlArr)) {
            return false;
        }
        $this->_mcurl = curl_multi_init();

        foreach ($urlArr as $i => $url)
        {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            if ($refer_str != '') {
                curl_setopt($ch, CURLOPT_REFERER, $refer_str);
            }
            if ($user_agent_str != '') {
                curl_setopt($ch, CURLOPT_USERAGENT, $user_agent_str);
            }
            if ($post_data_str != '') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data_str[$i]);
            }
            if ($cookie_str != '') {
                curl_setopt($ch, CURLOPT_COOKIEFILE, str_replace('\\', '/', dirname(__FILE__)) . '/'. $cookie_str);
                curl_setopt($ch, CURLOPT_COOKIEJAR, str_replace('\\', '/', dirname(__FILE__)) . '/'. $cookie_str);
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Language:zh-CN,zh;q=0.8'));

            curl_setopt($ch, CURLOPT_HEADER, $is_need_head);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

            curl_multi_add_handle($this->_mcurl, $ch);
            $this->_handleArr[$i++] = $ch;
        }
        return $this->_handleArr;
    }

    public function __destruct() {
        curl_multi_close($this->_mcurl);
    }

    /**
     * 批量抓取函数
     */
    public function getUrls() {
        $running = 0;
        $dataArr = array();
        if(!is_array($this->_handleArr)) return false;

        do {
            curl_multi_exec($this->_mcurl, $running);
        } while($running > 0);

        foreach($this->_handleArr as $key => $url)
        {
            $content = curl_multi_getcontent($url);
            $dataArr[$key] = (curl_errno($url) == 0) ? $content : false;
        }
        return $dataArr;
    }
}

$urlArr = array(
		"http://www.cnwust.com/Show/270",
		"http://www.cnwust.com/News/72916",
		"http://www.cnwust.com/News/73185",
);

$test = new MultiCurlUtil($urlArr);
$data = $test->getUrls();
var_dump($data);

?>