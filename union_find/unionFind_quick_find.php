<?php

/**
 * 并查集 quick_find实现 查找复杂度O(1) union复杂度O(n)
 * 思想：右边树所有节点嫁接成为右边树的子节点 树的高度永远是2
 */


class UF_quick_find {
	public $parents;

	public function __construct($length) 
	{
		$this->parents = range(0, $length - 1);
	}

    /**
     * 查找某个节点所在集合<即他的父节点的值>
     * @param  [type] $v [description]
     * @return [type]    [description]
     */
	public function find($v)
	{
		return $this->parents[$v];
	}

    /**
     * 合并两个节点，默认以左边的为父节点
     * @param  [type] $v1 [description]
     * @param  [type] $v2 [description]
     * @return [type]     [description]
     */
	public function union($v1, $v2)
	{
		$p1 = $this->find($v1);
		$p2 = $this->find($v2);
		if ($p1 == $p2) return;
		for ($i=0; $i < count($this->parents); $i++) { 
			if ($this->parents[$i] == $p2) {
				$this->parents[$i] = $p1;
			}
		}
	}


    /**
     * 检测两个节点是否连通
     * @param  [type]  $v1 [description]
     * @param  [type]  $v2 [description]
     * @return boolean     [description]
     */
	public function isConnect($v1, $v2) 
	{
		return $this->find($v1) == $this->find($v2);
	}
}