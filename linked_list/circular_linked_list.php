<?php

/**
 * 节点
 */
class Node {
	public $next;
	public $element;
	public function __construct($next, $element)
	{
		$this->next = $next;
		$this->element = $element;
	}
}


/**
 * 环形链表
 */
class CircularLinkedList {
	public $size;
	public $head;

	const NOT_FOUND = -1;

	/**
	 * 插入最后节点时候，next指向头节点
	 * @param  [type] $index   [description]
	 * @param  [type] $element [description]
	 * @return [type]          [description]
	 */
	public function insert($index, $element)
	{
		$node = new Node(null, $element);
		if ($index == 0) {
			$node->next = $node;
			$this->head = $node;
		} else {
			$preNode = $this->getNode($index - 1);
			$nextNode = $preNode->next;
			$preNode->next = $node;
			$node->next = $nextNode ? $nextNode : $this->head;
		}

		$this->size++;
	}

	public function add($element)
	{
		$this->insert($this->size, $element);
	}

	public function delByIndex($index)
	{
		$node = $this->head;
		if ($this->size == 1) {
			$this->head = null;
		} else {
			if ($index == 0) {
				$lastNode = $this->getNode($this->size - 1);
				$nextNode = $node->next;
				$lastNode->next = $nextNode;
				$this->head = $nextNode;
			} else {
				$preNode = $this->getNode($index - 1);
				$node = $preNode->next;
				$nextNode = $node->next;
				$preNode->next = $nextNode;
			}
		}

		$this->size--;
		return $node->element;
	}

	public function delByEle($element)
	{
		$this->delByIndex($this->indexOf($element));
	}

	public function isEmpty()
	{
		return $this->size > 0;
	}

	public function clear()
	{
		$this->head = null;
		$this->size = 0;
	}

	public function indexOf($element)
	{
		$node = $this->head;
		$curIndex = 0;
		while ($node != null) {
			if ($node->element == $element) {
				return $curIndex;
			}
			$node = $node->next;
			$curIndex++;
		}

		return static::NOT_FOUND;
	}

	public function contains($element)
	{
		return $this->indexOf($element) != static::NOT_FOUND;
	}

	public function get($index)
	{
		$node = $this->getNode($index);
		if ($node) return $node->element;
	}

	public function set($index, $element)
	{
		$node = $this->getNode($index);
		if ($node) 	$node->element = $element;
	}

	public function toString()
	{
		$data = [];
		$node = $this->head;
		for ($i=0; $i < $this->size; $i++) { 
			array_push($data, $node->element);
			$node = $node->next;
		}

		echo implode(',', $data);
	}

	private function getNode($index)
	{
		$this->checkIndex($index);
		$node = $this->head;
		for ($i=0; $i < $index ; $i++) { 
			$node = $node->next;
		}

		return $node;
	}

	private function checkIndex($index)
	{
		if ($index < 0 || $index > $this->size) {
			throw new Exception("Error Index");
		}
	}
}


$cl = new CircularLinkedList();

$cl->add(1);
$cl->add(2);
$cl->insert(2,3);
$cl->toString();
$cl->delByEle(1);
$cl->delByEle(3);
echo $cl->get(0);