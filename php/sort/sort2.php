<?php
/**
 * 四种排序算法设计（PHP）
 *
 * 1) 插入排序(Insertion Sort)的基本思想是：
	  每次将一个待排序的记录，按其关键字大小插入到前面已经排好序的子文件中的适当位置，直到全部记录插入完成为止。
   2) 选择排序(Selection Sort)的基本思想是：
      每一趟从待排序的记录中选出关键字最小的记录，顺序放在已排好序的子文件的最后，直到全部记录排序完毕。
   3) 冒泡排序的基本思想是：
      两两比较待排序记录的关键字，发现两个记录的次序相反时即进行交换，直到没有反序的记录为止。
   4) 快速排序实质上和冒泡排序一样，都是属于交换排序的一种应用。所以基本思想和上面的冒泡排序是一样的。
 * 
 * @author quanshuidingdang
 */
class Sort {
	private $arr 	= array();	
	private $sort	= 'insert';
	private $marker = '_sort';
	
	private $debug = TRUE;
	
	/**
	 * 构造函数
	 *
	 * @param	array	例如： $config = array (
									'arr' => array(22,3,41,18) , 	//需要排序的数组值
									'sort' => 'insert',			  	//可能值: insert, select, bubble, quick
									'debug' => TRUE	    			//可能值: TRUE, FALSE
									)
	 */
	public function __construct($config = array()) {
		if ( count($config) > 0) {
			$this->_init($config);
		}
	}
	
	/**
	 * 获取排序结果
	 */
	public function display() {
		return $this->arr;
	}
	
	/**
	 * 初始化
	 *
	 * @param	array
	 * @return 	bool
	 */
	private function _init($config = array()) {
		//参数判断
		if ( !is_array($config) OR count($config) == 0) {
			if ($this->debug === TRUE) {
				$this->_log("sort_init_param_invaild");
			}
			return FALSE;
		}
		
		//初始化成员变量
		foreach ($config as $key => $val) {
			if ( isset($this->$key)) {
				$this->$key = $val;
			}
		}
		
		//调用相应的成员方法完成排序
		$method = $this->sort . $this->marker;
		if ( ! method_exists($this, $method)) {
			if ($this->debug === TRUE) {
				$this->_log("sort_method_invaild");
			}
			return FALSE;
		}
		
		if ( FALSE === ($this->arr = $this->$method($this->arr)))
			return FALSE;
		return TRUE;
	}
	
	/**
	 * 插入排序
	 * 
	 * @param	array
	 * @return	bool
	 */
	private function insert_sort($arr) {
		//参数判断
		if ( ! is_array($arr) OR count($arr) == 0) {
			if ($this->debug === TRUE) {
				$this->_log("sort_array(insert)_invaild");
			}
			return FALSE;
		}
		
		//具体实现
		$count = count($arr);
		for ($i = 1; $i < $count; $i++) {
			$tmp = $arr[$i];
			for($j = $i-1; $j >= 0; $j--) {	
				if($arr[$j] > $tmp) {
					$arr[$j+1] = $arr[$j];
					$arr[$j] = $tmp;
				}
			}
		}
		return $arr;
	}
	
	/**
	 * 选择排序
	 * 
	 * @param	array
	 * @return	bool
	 */
	private function select_sort($arr) {
		//参数判断
		if ( ! is_array($arr) OR count($arr) == 0) {
			if ($this->debug === TRUE) {
				$this->_log("sort_array(select)_invaild");
			}
			return FALSE;
		}
		
		//具体实现
		$count = count($arr);
		for ($i = 0; $i < $count-1; $i++) {
			$min = $i;
			for ($j = $i+1; $j < $count; $j++) {
				if ($arr[$min] > $arr[$j])  $min = $j;
			}
			if ($min != $i) {
				$tmp = $arr[$min];
				$arr[$min] = $arr[$i];
				$arr[$i] = $tmp;
			}
		}
		return $arr;
	}
	
	/**
	 * 冒泡排序
	 * 
	 * @param	array
	 * @return	bool
	 */
	private function bubble_sort($arr) {
		//参数判断
		if ( ! is_array($arr) OR count($arr) == 0) {
			if ($this->debug === TRUE) {
				$this->_log("sort_array(bubble)_invaild");
			}
			return FALSE;
		}
		
		//具体实现
		$count = count($arr);
		for ($i = 0; $i < $count; $i++) {
			for ($j = $count-1; $j > $i; $j--) {
				if ($arr[$j] < $arr[$j-1]) {
					$tmp = $arr[$j];
					$arr[$j] = $arr[$j-1];
					$arr[$j-1] = $tmp;
				}
			}
		}
		return $arr;	
	}
	
	/**
	 * 快速排序
	 * 
	 * @param	array
	 * @return	bool
	 */
	private function quick_sort($arr) {
		//具体实现
		if (count($arr) <= 1) return $arr; 
		$key = $arr[0];
		$left_arr = array();
		$right_arr = array();
		for ($i = 1; $i < count($arr); $i++){
			if ($arr[$i] <= $key)
				$left_arr[] = $arr[$i];
			else
				$right_arr[] = $arr[$i];
		}
		$left_arr = $this->quick_sort($left_arr);
		$right_arr = $this->quick_sort($right_arr); 

		return array_merge($left_arr, array($key), $right_arr);
	}
	
	/**
	 * 日志记录
	 */
	private function _log($msg) {
		$msg = 'date[' . date('Y-m-d H:i:s') . '] ' . $msg . '\n';
		return @file_put_contents('sort_err.log', $msg, FILE_APPEND);
	}
}

/*End of file sort.php*/
/*Location htdocs/sort.php */

?>