<?php

/**
 * 并查集 quickUnion实现 查找复杂度O(logn) union复杂度O(logn)
 * 思想 合并左树和右树的根节点
 */


class UF_quick_union {
	public $parents;

	public function __construct($length)
	{
		$this->parents = range(0, $length - 1);
	}

	/**
     * 查找某个节点所在集合<即根节点的值>
     * @param  [type] $v [description]
     * @return [type]    [description]
     */
	public function find($v)
	{
		while ($this->parents[$v] != $v) {
			$v = $this->parents[$v];
		}

		return $v;
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
		$this->parents[$p2] = $p1; 
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