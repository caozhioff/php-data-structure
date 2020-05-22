<?php

include 'unionFind_quick_find.php';

include 'unionFind_quick_union.php';

include 'unionFind_qu_rank.php';


$uf_qf = new UF_quick_find(10);
$uf_qf->union(0,1);
$uf_qf->union(0,2);


$uf_qu = new UF_quick_union(10);
$uf_qu->union(0,1);
$uf_qu->union(2,3);
$uf_qu->union(1,3);
//print_r($uf_qu->isConnect(0,3));


$uf_qu_r = new UF_qu_rank(10);
$uf_qu_r->union(0,1);
$uf_qu_r->union(2,3);
$uf_qu_r->union(1,3);
print_r($uf_qu_r->parents);
print_r($uf_qu_r->height);
print_r($uf_qu_r->isConnect(0,3));