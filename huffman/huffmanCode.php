<?php

//哈夫曼编码
//ascii码<每一个字符表示为特定8位二进制>编码是等长编码，虽然容易设计，方便读写，但是编码结果太长，会占用过多资源
//哈夫曼编码可以减少信息编码的总长度来实现信息的压缩

//例如 ABCDBBDDEEBBB
//ascii 结果为01000001 01000010 01000011 01000100 01000010 01000010 ...... 13*8 = 104

//出现概率 A-1 B-6 C-1 D-3 E-2 [1,6,1,3,2] huffmancode->createCode([1,6,1,3,2])


require_once 'huffman.php';

class HuffmanCode {
	public $root;
	private $nodes = [];

	public function createHuffmanTree($weights)
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

	//递归，填充各结点的二进制编码
	public function encode($node, $code)
	{
		if ($node == null) return;
		$node->code = $code;
		$this->encode($node->left, $node->code . '0');
		$this->encode($node->right, $node->code . '1');
	}

	//根据索引获取对应的二进制编码
	public function convertHuffmanCode($index)
	{
		return $this->nodes[$index]->code;
	}
}

$str = 'ABCDBBDDEEBBB';
$mapArr = [];
for ($i=0; $i < strlen($str) ; $i++) { 
	if (!array_key_exists($str[$i], $mapArr)) {
		$mapArr[$str[$i]] = 1;
	} else {
		$mapArr[$str[$i]] += 1;
	}
}//print_r($mapArr);die; ['A' => 1, 'B' => 6, 'C' => 1, 'D' => 3, 'E' => 2]
$code = new HuffmanCode;
$code->createHuffmanTree(array_values($mapArr));
$code->encode($code->root, '');//节点加上对应二进制码

$codeArr = []; //存储字符对应二级制码
$i = 0;
foreach ($mapArr as $char => $weight) {
	$codeArr[$char] = $code->convertHuffmanCode($i);
	$i++;
}

//print_r($codeArr);die; //['A' => 1110, 'B' => 0, 'C' => 1111, 'D' => 10, 'E' => 110]