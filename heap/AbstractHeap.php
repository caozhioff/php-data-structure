<?php

abstract class AbstractHeap {
	public $elements;

	public function __construct()
	{
		$this->elements[0] = 0;
	}

	protected function cmp($n1, $n2) 
	{
		return $n1>$n2 ? 1 : ($n1==$n2 ? 0 : -1); 
	}

	protected function swap($index1, $index2) 
	{
		$temp = $this->elements[$index1];
		$this->elements[$index1] = $this->elements[$index2];
		$this->elements[$index2] = $temp;
	}

	protected function checkDel()
	{
		if ($this->elements[0] == 0) {
			throw new Exception("no data, cannot del");	
		}
	}

	abstract function add($ele);

	abstract function del();

	abstract function replace($ele);


	//crate a random array,1<random<100
	public function randomArr($count)
	{
		$arr = [];
		for($i=0;$i<$count;$i++){
			array_push($arr, rand(1,1000));
		}
		
		echo 'random array' . "\r\n";
		print_r($arr);
		return $arr;
	}

	public function createHeap($arr){
		foreach($arr as $v){
			$this->add($v);
		}
	}

	public function delTest($count){
		echo 'before del:' . "\r\n";
		$this->showElements();
		for($i=0;$i<$count;$i++) {
			$this->del();
			echo 'remove smallest ele, print the heap:' . "\r\n";
			$this->showElements();
		}
	}

	public function showElements()
	{
		for($i=1;$i<=$this->elements[0];$i++){
			echo $this->elements[$i] . ' ';
		}
		echo "\r\n";
	}
}