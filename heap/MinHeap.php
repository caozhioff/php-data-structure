<?php


require_once 'AbstractHeap.php';

/**
 * 数组实现最小堆 
 * 数组0号位置存放size
 */
class MinHeap extends AbstractHeap {


	public function add($ele)
	{
		$this->elements[0] += 1;
		$this->elements[$this->elements[0]] = $ele;
		$this->percolateUp($this->elements[0]);
	}

	//移除最小的元素
	public function del()
	{
		$this->checkDel();
		$this->elements[1] = $this->elements[$this->elements[0]];
		unset($this->elements[$this->elements[0]]);
		$this->elements[0] -= 1;
		$this->percolateDown(1);
	}

	//ele替换最小的元素
	public function replace($ele)
	{
		$this->elements[1] = $ele;
		$this->percolateDown(1);
	}

	//找出数组最大的top k个数
	public function topMaxK($array, $k) 
	{
		if (count($array) <= $k) return $array;
		foreach ($array as $key => $value) {
			if ($key + 1 <= $k) {
				$this->add($value);
			} else {
				$this->replace($value);
			}
		}

		return array_slice($this->elements, 1);
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
}


$min = new MinHeap;
$arr = $min->randomArr(10);
print_r($min->topMaxK($arr, 5));
//$min->createHeap($arr);
//$min->replace(55);
//$min->showElements();
//$min->delTest(10);
