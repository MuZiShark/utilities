<?php
class page {

	//总页数
	protected $count;
	//当前页码
	protected $page;
	//总记录数，总条数
	protected $total;
	//上一页
	protected $prev='上一页';
	//下一页
	protected $next='下一页';
	//首页
	protected $first='首页';
	//尾页
	protected $last='尾页';
	//开始记录数
	protected $start;
	//结束记录数
	protected $end;
	//每页显示条数
	protected $num;
	//URL
	protected $url;
	//上一页数
	protected $prevNum;
	//下一页数
	protected $nextNum;


	//初使化成员属性
	public function __construct($url,$total,$num=5){
		$this->url=$url;
		$this->total=$total;
		$this->num=$num;
		$this->count=$this->getCount();
		$this->page=emptyempty($_GET['page'])?1:(int)$_GET['page'];
		$this->prevNum=$this->getPrev();
		$this->nextNum=$this->getNext();
		$this->start=$this->getStart();
		$this->end=$this->getEnd();

	}

	protected function getStart(){

		return ($this->page-1)*$this->num+1;

	}

	protected function getEnd(){

		return min($this->page*$this->num,$this->total);

	}

	protected function getNext(){

		if($this->page>=$this->count){

			return false;

		}else{

			return $this->page+1;
		}

	}

	protected function getPrev(){

		if($this->page<=1){
			return false;
		}else{

			return $this->page-1;
		}

	}

	protected function getCount(){
		return ceil($this->total/$this->num);
	}
	//
	//
	//得到偏移量  limit 偏移量,数量   limit 0,5   5,5  10,5

	public function getOffset(){

	return ($this->page-1)*$this->num;
	}


	//得到分页效果
	//
	//search.php?keywords=手机&page=1
	//
	//第x页   从第n条记录到第n条记录  共x页 首页  上一页  下一页  尾页

	public function getPage(){

	$string='第'.$this->page.'页&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;从第'.$this->start.'条记录到第'.$this->end.'条记录&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;共'.$this->count.'页&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$this->url.'page=1">'.$this->first.'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	if($this->prevNum){
			$string.='<a href="'.$this->url.'page='.$this->prevNum.'">'.$this->prev.'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	}else{
	$string.=$this->prev.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }


        if($this->nextNum){
	$string.='<a href="'.$this->url.'page='.$this->nextNum.'">'.$this->next.'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	}else{
	$string.=$this->next.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}

	$string.='<a href="'.$this->url.'page='.$this->count.'">'.$this->last.'</a>';


	return $string;
	}

}

?>