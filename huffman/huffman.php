<?php


//简单的优先队列<弹出最小元素,最小堆实现>
class PriorityQueue {
	public $elements;

	public function __construct()
	{
		$this->elements[0] = 0;
	}

	public function size()
	{
		return count($this->elements) - 1;
	}

	//入列
	public function add($node)
	{
		$this->elements[0] += 1;
		$this->elements[$this->elements[0]] = $node;
		$this->percolateUp($this->elements[0]);
	}

	//最小的元素出队
	public function poll()
	{
		$this->checkDel();
		$popNode = $this->elements[1];
		$this->elements[1] = $this->elements[$this->elements[0]];
		unset($this->elements[$this->elements[0]]);
		$this->elements[0] -= 1;
		$this->percolateDown(1);
		return $popNode;
	}

	//下滤操作 注：此类节点索引从1开始
	//1.判断index是否为非叶子节点  最后一个非叶子节点index为 floor(n>>1)
	//2.非叶子节点判断是否有右子节点
	//3.取子节点小的比较进行下滤操作
	private function percolateDown($index)
	{
		while ($index <= floor($this->elements[0]>>1)) {
			$minIndex = $index<<1;//左子节点索引
			if ($this->elements[0] >= ($minIndex+1)) {//存在右子节点
				$minIndex = ($this->elements[$minIndex] <= $this->elements[$minIndex+1]) ? $minIndex : ($minIndex + 1);
			}
			if ($this->cmp($this->elements[$index], $this->elements[$minIndex]) > 0) {
				$this->swap($index, $minIndex);
				$index = $minIndex;
			} else {
				return;
			}
		}
	}

	protected function checkDel()
	{
		if ($this->elements[0] == 0) {
			throw new Exception("no data, cannot del");	
		}
	}

	//上滤操作
	private function percolateUp($index)
	{
		if ($index == 1) return;//添加的第一个元素
		//父节点索引，除以2向下取整
		while (($parentIndex = floor(($index>>1))) >= 1) {//循环条件是只要还有父节点就进行比较
			if($this->cmp($this->elements[$parentIndex], $this->elements[$index]) > 0) {//父亲比他大
				$this->swap($index, $parentIndex);
				$index = $parentIndex;
			} else {
				return;
			}
		}
	}

	private function cmp($n1, $n2) 
	{
		return $n1->weight > $n2->weight ? 1 : ($n1->weight == $n2->weight ? 0 : -1); 
	}

	private function swap($index1, $index2) 
	{
		$temp = $this->elements[$index1];
		$this->elements[$index1] = $this->elements[$index2];
		$this->elements[$index2] = $temp;
	}
}


class Node {
	public $weight;
	public $left;
	public $right;
	public $code = '';

	public function __construct($weight, $left = null, $right = null)
	{
		$this->weight = $weight;
		$this->left = $left;
		$this->right = $right;
	}
}


class Huffman {
	public $root;
	private $nodes = [];

	public function createHuffman($weights)
	{
		//优先队列，弹出最小两个元素构建哈夫曼树
		$priorityQueue = new PriorityQueue;
		for ($i=0; $i < count($weights); $i++) { 
			$this->nodes[$i] = new Node($weights[$i]);
			$priorityQueue->add($this->nodes[$i]);//构建森林
		}

		while ($priorityQueue->size() > 1) {//优先队列只剩一个元素时候结束循环
			$left = $priorityQueue->poll();
			$right = $priorityQueue->poll();
			$parent = new Node($left->weight+$right->weight, $left, $right);
			$priorityQueue->add($parent);
		}

		$this->root = $priorityQueue->poll();
	}

	public function preTravelsal($head)
	{
		if ($head == null) return;
		echo $head->weight . "\r\n";
		$this->preTravelsal($head->left);
		$this->preTravelsal($head->right);
	}
}


// $huffman = new Huffman;
// $huffman->createHuffman([7,3,2,18,25,9]);

// print_r($huffman->preTravelsal($huffman->root));