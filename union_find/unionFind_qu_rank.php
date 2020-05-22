<?php

/**
 * quick_union 优化,
 * 合并时候高度小的树合并到高度大的树<也可以根据size来合并，效率相近>
 */


class UF_qu_rank {
	public $parents;
	public $height;

	public function __construct($length)
	{
		$this->parents = range(0, $length - 1);
		for ($i=0; $i < $length - 1; $i++) { 
			$this->height[$i] = 1;//初始高度为1
		}
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
     * 合并两个节点，高度低的合并到高的上
     * @param  [type] $v1 [description]
     * @param  [type] $v2 [description]
     * @return [type]     [description]
     */
	public function union($v1, $v2)
	{
		$p1 = $this->find($v1);
		$p2 = $this->find($v2);
		if ($p1 == $p2) return;
		$h1 = $this->height($p1);
		$h2 = $this->height($p2);
		if ($h1 < $h2) {
			$this->parents[$p1] = $p2;
		} elseif ($h1 > $h2) {
			$this->parents[$p2] = $p1;
		} else {//高度+1
			$this->parents[$p2] = $p1;
			$this->height[$p1] += 1;  
		}
	}

    /**
     * 获取节点所在树的高度
     * @param  [type] $v [description]
     * @return [type]    [description]
     */
	public function height($p) 
	{
		return $this->height[$p];
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