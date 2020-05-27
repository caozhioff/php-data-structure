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
 * 单向链表
 */
class SingleLinkedList {
	public $size = 0;
	public $head = null;


	/**
	 * 清空
	 * @return [type] [description]
	 */
	public function clear()
	{
		$this->head = null;
		$this->size = 0;
	}

	/**
	 * 获取index结点的值
	 * @param  [type] $index [description]
	 * @return [type]        [description]
	 */
	public function get($index)
	{
		$node = $this->getNode2($index);
		if ($node) return $node->element;
	}

	/**
	 * 设置index结点的值
	 * @param [type] $index   [description]
	 * @param [type] $element [description]
	 */
	public function set($index, $element)
	{
		$node = $this->getNode2($index);
		if ($node) $node->element = $element;
	}

	/**
   	 * 新增节点
   	 * @param [type] $element [description]
   	 */
	public function add($element)
	{
		$this->insert($this->size, $element);
	}

	/**
	 * 插入节点
	 * @param  [type] $index   [插入位置 0:插入在头部 size:插入在尾部 其余插在中间]
	 * @param  [type] $element [description]
	 * @return [type]          [description]
	 */
	public function insert($index,$element)
	{
		$node = new Node(null, $element);
		if ($index == 0) {
			$node->next = $this->head;
			$this->head = $node;
		} else {
			$preNode = $this->getNode2($index - 1);//前驱节点
			$nextNode = $preNode->next;
			$preNode->next = $node;
			$node->next = $nextNode;
		}

		$this->size++;
	}

	/**
	 * 根据index进行删除
	 * @param  [type] $index [description]
	 * @return [type]        [description]
	 */
    public function del2($index)
    {
    	$node = $this->head;
    	if ($index == 0) {
    		$this->head = $node->next;
    	} else {
    		$preNode = $this->getNode2($index-1);//前驱
	    	$node = $preNode->next;
	    	$preNode->next = $node->next;
    	}

		$this->size--;	
    	return $node->element;
    }

	/**
	 * 根据element删除节点
	 * @param  [type] $element [description]
	 * @return [type]          [description]
	 */
	public function del($element)
	{
		$this->del2($this->indexOf($element));
	}


	/**
	 * 查找值所在链接的位置
	 * @param  [type] $element [description]
	 * @return [type]          [description]
	 */
	public function indexOf($element)
	{
		$current = $this->head;
		$index = 0;
		while ($current != null) {
			if ($current->element == $element) {
				return $index;
			}
			$current = $current->next;
			$index++;
		}
		return -1;
	}


	/**
	 * element是否存在于链表中
	 * @param  [type] $element [description]
	 * @return [type]          [description]
	 */
	public function isContain($element) 
	{
		return $this->indexOf($element) >= 0;
	}

	/**
	 * 打印链表的element
	 * @return [type] [description]
	 */
	public function toString()
	{
		$data = [];
		$current = $this->head;
		while ($current != null) {
			array_push($data, $current->element);
			$current = $current->next;
		}

		echo implode(',', $data);
	}

	/**
     * 获取节点<根据值>
     * @param  [type] $element [description]
     * @return [type]          [description]
     */
	private function getNode($element){
		$this->getNode2($this->indexOf($element));
	}

	/**
	 * 获取节点<根据index>
	 * @param  [type] $index [description]
	 * @return [type]        [description]
	 */
	private function getNode2($index){
		$this->checkIndex($index);

		$current = $this->head;
		for ($i=0; $i < $index; $i++) { 
			$current = $current->next;
		}
		return $current;
	}

	/**
	 * 检查index是否可用
	 * @param  [type] $index [description]
	 * @return [type]        [description]
	 */
	private function checkIndex($index)
	{
		if ($index < 0 || $index > $this->size) {
			throw new Exception("Error Index");
			
		}
	}
}

$ll = new SingleLinkedList();

$ll->add(1);
$ll->add(3);
$ll->insert(1,2);
$ll->insert(3,4);
var_dump($ll->get(3)); //4
$ll->set(3,100);
$ll->toString(); //1,2,3,100
var_dump($ll->get(3));//100

print_r($ll->del(3)); //100
print_r($ll);
print_r($ll->indexOf(2));//1

$ll->clear();
$ll->toString();