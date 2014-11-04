<?php
class page {

	//��ҳ��
	protected $count;
	//��ǰҳ��
	protected $page;
	//�ܼ�¼����������
	protected $total;
	//��һҳ
	protected $prev='��һҳ';
	//��һҳ
	protected $next='��һҳ';
	//��ҳ
	protected $first='��ҳ';
	//βҳ
	protected $last='βҳ';
	//��ʼ��¼��
	protected $start;
	//������¼��
	protected $end;
	//ÿҳ��ʾ����
	protected $num;
	//URL
	protected $url;
	//��һҳ��
	protected $prevNum;
	//��һҳ��
	protected $nextNum;


	//��ʹ����Ա����
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
	//�õ�ƫ����  limit ƫ����,����   limit 0,5   5,5  10,5

	public function getOffset(){

	return ($this->page-1)*$this->num;
	}


	//�õ���ҳЧ��
	//
	//search.php?keywords=�ֻ�&page=1
	//
	//��xҳ   �ӵ�n����¼����n����¼  ��xҳ ��ҳ  ��һҳ  ��һҳ  βҳ

	public function getPage(){

	$string='��'.$this->page.'ҳ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�ӵ�'.$this->start.'����¼����'.$this->end.'����¼&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��'.$this->count.'ҳ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$this->url.'page=1">'.$this->first.'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

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