<?php


//binary search tree
class Node {
	public $val;
	public $left;
	public $right;
	public $parent;
	
	public function __construct($val, $parent){
		$this->val = $val;
		$this->parent = $parent;
	}
}

class BinarySearchTree {
	public $root;
	public $size;
	
	//添加节点
	public function add($val){
		$this->checkVal($val);
		if ($this->root === null) {
			$this->root = new Node($val, null);
			$this->size++;
			return;
		} else {
			$temp = $this->root;
			$parent = $this->root;
			while($temp) {
				$parent = $temp;
				$cmp = $this->cmp($temp->val, $val);
				if ($cmp > 0){
					$temp = $temp->left;
					$flag = 1;
				} elseif ($cmp < 0) {
					$temp = $temp->right;
					$flag = 2;
				} else {
					return;
				}				
			}
			$node = new Node($val, $parent);
			if ($flag == 1) {
				$parent->left = $node;
			} else {
				$parent->right = $node;
			}
			$this->size++;
		}
	}
	
	//查找节点
	public function find($val){
		$this->checkVal($val);
		$temp = $this->root;
		$times = 0;
		while($temp) {
			$times++;
			$cmp = $this->cmp($temp->val, $val);
			if ($cmp > 0) {
				$temp = $temp->left;
			} elseif ($cmp < 0) {
				$temp = $temp->right;
			} else {
				echo '找了' . $times . '次，找到了！';
				return $temp;
			}
		}
		
		echo '找了' . $times . '次，没找到！';
		return $temp;
	}
	
	//删除节点 度为(0,1,2)
	public function del($val){
		$this->checkVal($val);
		$node = $this->find($val);
		if ($node == null) return null;
		if ($this->hasTwoChildren($node)) {//*** 找前驱或者后继，替换值，删除被替换节点 ****
			$preNode = $this->precursorNode($node);
			$node->val = $preNode->val;
			if ($this->isLeaf($preNode)) {//叶子节点
				$this->delLeafNode($preNode);
			} else {//度为1
				$this->delNodeOneChild($preNode);
			}
		} elseif ($this->isLeaf($node)) {
			$this->delLeafNode($node);
		} else {
			$this->delNodeOneChild($node);
		}
	}
	
	private function delNodeOneChild($node) {
		if($leftChild = $this->leftChild($node)) {
			if ($this->isRoot($node->val)) {
				$this->root = $node->left;
				$node->left = null;
			} else {
				$node->parent->left = $leftChild;
				$node->left = null;
			}
		} else {
			if ($this->isRoot($node->val)) {
				$this->root = $node->right;
				$node->right = null;
			} else {
				$node->parent->right = $this->rightChild($node);
				$node->right = null;
			}
		}
	}
	
	private function delLeafNode($node) {
		if ($node->parent == null) {
			$this->root = null;
		} else {
			if ($this->isLeftChild($node)) {
				$node->parent->left = null;
			} else {
				$node->parent->right = null;
			}
		}
	}
	
	//前序遍历
	public function preOrderTraversal(){
		$arr = [];
		$this->pre($this->root, $arr);
		print_r($arr);
	}
	
	//中序遍历
	public function inOrderTraversal(){
		$this->middle($this->root);
	}
	
	//后序遍历
	public function postOrderTraversal(){
		$this->last($this->root);
	}
	
	//层序遍历
	public function levelTraversal(){
		$this->checkVal($this->root);
		$queue = [];
		$result = [];
		array_push($queue, $this->root);
		while($queue) {
			$node = array_shift($queue);
			array_push($result, $node->val);
			if ($node->left) {
				array_push($queue, $node->left);
			}
			if ($node->right) {
				array_push($queue, $node->right);
			}
		}
		
		print_r($result);
	}
	
	//前驱节点
	public function precursorNode($node){
		$this->checkVal($node);
		if ($node->left) {
			$precursor = $node->left;
			while($precursor->right) {
				$precursor = $precursor->right;
			}
			return $precursor;
		} elseif ($precursor = $node->parent) {
			while ($precursor) {
				if ($precursor->right == $node) {
					return $precursor;
				} else {
					$node = $precursor;
					$precursor = $precursor->parent;
				}
			}
			return null;
		} else {
			return null;
		}
	}
	
	//后继节点
	public function successorNode($node){
		$this->checkVal($node);
		if ($node->right) {
			$precursor = $node->right;
			while($precursor->left) {
				$precursor = $precursor->left;
			}
			return $precursor;
		} elseif ($precursor = $node->parent) {
			while ($precursor) {
				if ($precursor->left == $node) {
					return $precursor;
				} else {
					$node = $precursor;
					$precursor = $precursor->parent;
				}
			}
			return null;
		} else {
			return null;
		}
	}
	
	private function pre($node, &$arr){
		if ($node === null) return null;
		array_push($arr, $node->val);
		echo $node->val . ' ';
		$this->pre($node->left, $arr);
		$this->pre($node->right, $arr);
	}
	
	private function middle($node){
		if ($node === null) return null;
		$this->middle($node->left);
		echo $node->val . ' ';
		$this->middle($node->right);
	}
	
	private function last($node){
		if ($node === null) return null;
		$this->last($node->left);
		$this->last($node->right);
		echo $node->val . ' ';
	}
	
	private function isRoot($val){
		return $this->root && $this->root->val === $val;
	}
	
	private function isLeaf($node){
		return $node && $node->left === null && $node->right === null;
	}
	
	private function isLeftChild($node){
		return $node->parent->left == $node;
	}
	
	private function isRightChild($node){
		return $node->parent->right == $node;
	}
	
	private function leftChild($node){
		return $node->left;
	}
	
	private function rightChild($node){
		return $node->right;
	}
	
	private function hasTwoChildren($node){
		return $node->left !== null && $node->right !== null;
	}
	
	private function cmp($v1, $v2){
		return $v1>$v2 ? 1 : ($v1 == $v2 ? 0 : -1);
	}
	
	private function checkVal($val){
		if ($val == null) {
			throw new Exception('error val');
		}
	}
}

$b = new BinarySearchTree;
$b->add(1);
$b->add(5);
$b->add(3);
$b->add(2);
$b->add(6);
$b->add(4);
//print_r($b->root);
$b->find(6);
$b->find(7);

$b->preOrderTraversal();
echo '<br/>';
echo "\r\n";
$b->inOrderTraversal();
echo '<br/>';
echo "\r\n";
$b->postOrderTraversal();
echo '<br>';
echo "\r\n";
$b->levelTraversal();
echo '<br>';
echo "\r\n";
//print_r($b->precursorNode($b->find(5)));
//print_r($b->precursorNode($b->find(2)));
//print_r($b->successorNode($b->find(4)));
//var_dump($b->precursorNode($b->find(1)));

$b->del(1);
print_r($b->root);