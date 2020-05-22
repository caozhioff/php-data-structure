<?php

/*用以太网线缆将 n 台计算机连接成一个网络，计算机的编号从 0 到 n-1。线缆用 connections 表示，其中 connections[i] = [a, b] 连接了计算机 a 和 b。

网络中的任何一台计算机都可以通过网络直接或者间接访问同一个网络中其他任意一台计算机。

给你这个计算机网络的初始布线 connections，你可以拔开任意两台直连计算机之间的线缆，并用它连接一对未直连的计算机。请你计算并返回使所有计算机都连通所需的最少操作次数。如果不可能，则返回 -1 。 

来源：力扣（LeetCode）
链接：https://leetcode-cn.com/problems/number-of-operations-to-make-network-connected*/

//例如： n = 6, connections = [[0,1],[0,2],[0,3],[1,2],[1,3]]

/*1 <= n <= 10^5
1 <= connections.length <= min(n*(n-1)/2, 10^5)
connections[i].length == 2
0 <= connections[i][0], connections[i][1] < n
connections[i][0] != connections[i][1]
没有重复的连接。
两台计算机不会通过多条线缆连接。

来源：力扣（LeetCode）
链接：https://leetcode-cn.com/problems/number-of-operations-to-make-network-connected*/

class Solution {
	public $data;

    public $height;

    /**
     * @param Integer $n
     * @param Integer[][] $connections
     * @return Integer
     */
    function makeConnected($n, $connections) {
        $this->init($n);
    	if ($n > count($connections) + 1) {
    		return -1;
    	}
        foreach ($connections as $value) {
            $this->union($value[0], $value[1]);
        }

        //结果为树的个数减去1，节点值等于index的节点为每棵树的根节点
        $count = 0;
        foreach ($this->data as $k => $v) {
            if ($this->data[$k] == $v) {
                $count++;
            }
        }

        return $count - 1;
    }

    private function init($n){
        $this->data = range(0, $n - 1);
        for ($i=0; $i < $n - 1 ; $i++) { 
            $this->height[$i] = 1;//默认高度1
        }
    }
    
    //quick_union
    private function find($v){
        while ($v != $this->data[$v]) {
            $v = $this->data[$v];
        }

        return $v;
    }

    //quick_union
    private function union($v1, $v2){
        $p1 = $this->find($v1);
        $p2 = $this->find($v2);
        if ($p1 == $p2) return;
        $h1 = $this->height($p1);
        $h2 = $this->height($p2);
        //低的向高的合并
        if ($h1 > $h2) {
            $this->data[$p2] = $p1;
        } elseif ($h1 < $h2) {
            $this->data[$p1] = $p2;
        } else {//height+1
            $this->data[$p2] = $p1;
            $this->height[$p1] += 1;
        }
    }
    
    //获取根节点高度
    private function height($p){
        return $this->height[$p];
    }
}