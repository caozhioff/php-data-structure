<?php


class Solution {
    public $data;
    public $height;
    
    /**
     * @param Integer[][] $M
     * @return Integer
     */
    function findCircleNum($M) {
        $num = count($M);
        $this->init($num);
        foreach ($M as $key => $value) {
            for ($i=0; $i < $num-1; $i++) { 
                if ($i != $key && $value[$i] == 1) {
                    $this->union($key, $i);
                }
            }
        }

        $count = 0;
        foreach ($this->data as $k => $v) {
            if ($k == $v) {
                $count++;
            }
        }
        return $count;
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