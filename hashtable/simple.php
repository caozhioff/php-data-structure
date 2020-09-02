<?php


//php实现一个简单hashtable
class HashTable {
	private $buckets;
	
	private $size = 10;
	
	public function __construct()
	{
		$this->buckets = new SplFixedArray($this->size);//模拟java中 arr = new int[10]
	}
	
	private function hash_func($str)
	{
		$hashCode = 0;
		for($i=0; $i< strlen($str); $i++) {
			$hashCode += ord($str[$i]);
		}
		
		return $hashCode%$this->size;
	}
	
	public function add($key, $val)
	{
		$index = $this->hash_func($key);
		if (isset($this->buckets[$index])) {//遍历,判断key是否存在，存在更新，不存在插入链表尾部
			$head = $this->buckets[$index];
			if ($head->key == $key) {
				$head->val = $val;
				return;
			}
			while($head->next != null) {
				$head = $head->next;
				if ($head->key == $key) {
					$head->val = $val;
					return;
				}
			}
			$head->next = new Node($key, $val, null);//不存在，插入链表尾部
		} else {
			$this->buckets[$index] = new Node($key, $val, null);
		}
		
		return true;
	}
	
	public function find($key)
	{
		$index = $this->hash_func($key);
		$current = $this->buckets[$index];
		while($current != null) {
			if ($current->key == $key) {
				return $current->val;
			}
			$current = $current->next;
		}
		
		return null;
	}
}

class Node{
	public $key;
	public $val;
	public $next;
	
	public function __construct($key, $val, $next)
	{
		$this->key = $key;
		$this->val = $val;
		$this->next = $next;
	}
}

$ht = new HashTable;
$ht->add('A', 1111);
$ht->add('h', 333); //code:4
$ht->add('aa', 222);//code:4
$ht->add('aa', 333);
$ht->add('h', 44);
echo $ht->find('h');
echo $ht->find('aa');
echo $ht->find('A');
print_r($ht);
exit;