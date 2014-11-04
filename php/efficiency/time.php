<?

    class runtime {
        public $StartTime = 0;
        public $StopTime = 0;

        function get_microtime() {
            list($usec, $sec) = explode(' ', microtime());
            return ((float)$usec + (float)$sec);
        }
        
        function start() {
            $this->StartTime = $this->get_microtime();
        }
        
        function stop() {
            $this->StopTime = $this->get_microtime();
        }
        
        function spent(){
            return round(($this->StopTime - $this->StartTime) * 1000, 4);
        }
    }

    $runtime= new runtime(); 

    $data = array('tencent' => array('cadfdg', 'dfdgg'), 'sina' => array('111', '4654654'), '163' => array('111', '4654654'), 'sohu' => array('111', '4654654'));
    $runtime->start();  
    foreach ($data as $key => $rows) {
        foreach ($rows as $val) {
	        echo $val . ' ';
        }
    }

    $runtime->stop();

    echo "页面执行时间: ".$runtime->spent()." 毫秒"."<br/>"; 

    $runtime->start();  
    //$data =array('tencent' => array('cadfdg', 'dfdgg'));
    foreach($data['tencent'] as $val) {
        echo $val . ' ';
    }
    //$data = array('sina' => array('111', '4654654'));
    foreach($data['sina'] as $val) {
        echo $val . ' ';
    }
    //$data = array('163' => array('111', '4654654'));
    foreach($data['163'] as $val) {
        echo $val . ' ';
    }
    //$data = array('sohu' => array('111', '4654654'));
    foreach($data['sohu'] as $val) {
        echo $val . ' ';
    }
    $runtime->stop();
    echo "页面执行时间: ".$runtime->spent()." 毫秒"; 

?>