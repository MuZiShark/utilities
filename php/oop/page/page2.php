<?php

class Mysql{
	
	private $host; //主机名
	private $username; //用户名
	private $password; //密码
	private $dbname; //数据库名
	private $conn; //链接资源
	private $pconnect; //是否持久连接
	private $charset; //数据库编码
	public $histories; //保存执行的sql语句
	public $querynum = 0;  //查询的次数
	
	//构造函数,初始化时连接数据库
	public function __construct($host, $username, $password, $dbname, $charset, $pconnect = 0){
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;
		$this->charset = $charset;
		if($pconnect){
			if(!$this->conn = mysql_pconnect($this->host,$this->username,$this->password)){
				$this->halt('Cannot connect to mysql');
			}
		}else{
			if(!$this->conn = mysql_connect($this->host,$this->username,$this->password)){
				$this->halt('Cannot connect to mysql');
			}
		}
		mysql_select_db($this->dbname);
		mysql_query("SET NAMES {$this->charset}");
	}
	//使用mysql_unbuffered_query不会使用缓冲区，但是它也有缺点，比如你不能使用mysql_num_rows来取得它结果的数量。
	function query($sql, $type = '', $cachetime = FALSE) {
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->conn)) && $type != 'SILENT') {
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querynum++;
		$this->histories[] = $sql;
		return $query;
	}

	//默认返回关联数组
	public function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}
	
	//返回第一行第一列
	function result_first($sql) {
		$query = $this->query($sql);
		return $this->result($query, 0);
	}
	
	//返回第一行数据
	function fetch_first($sql) {
		$query = $this->query($sql);
		return $this->fetch_array($query);
	}

	function fetch_all($sql, $id = '') {
		$arr = array();
		$query = $this->query($sql);
		while($data = $this->fetch_array($query)) {
			$id ? $arr[$data[$id]] = $data : $arr[] = $data;
		}
		return $arr;
	}
	function affected_rows() {
		return mysql_affected_rows($this->conn);
	}

	function error() {
		return (($this->conn) ? mysql_error($this->conn) : mysql_error());
	}

	function errno() {
		return intval(($this->conn) ? mysql_errno($this->conn) : mysql_errno());
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}
       //返回字段的数目
	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}
	//如果 AUTO_INCREMENT 的列的类型是 BIGINT，则 mysql_insert_id() 返回的值将不正确,但是可以用LAST_INSERT_ID() 来替代
	function insert_id() {
		return ($id = mysql_insert_id($this->conn)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}
	
	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}
	//取得列信息
	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		return mysql_get_server_info($this->conn);
	}

	function close() {
		return mysql_close($this->conn);
	}
	//中断提示
	public function halt($message = '', $sql = ''){
		$error = mysql_error();
		$errorno = mysql_errno();
		$s = '';
		if($message) {
			$s = "<b>Error info:</b> $message<br />";
		}
		if($sql) {
			$s .= '<b>SQL:</b>'.htmlspecialchars($sql).'<br />';
		}
		$s .= '<b>Error:</b>'.$error.'<br />';
		$s .= '<b>Errno:</b>'.$errorno.'<br />';
		exit($s);
	}
}
?>