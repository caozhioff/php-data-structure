<?php


/**
 * example
 * 输入: 1->2->3->4->5->NULL
 * 输出: 5->4->3->2->1->NULL
 */

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class Solution {

    /**
     * @param ListNode $head
     * @return ListNode
     */
    function reverseList($head) {
	   	$pre = null;
	   	$cur = $head;
	   	while ($cur != null) {
	   		$temp = $cur->next;
	   		$cur->next = $pre;
	   		$pre = $cur;
	   		$cur = $temp;
	  	 }

	   	return $pre;
    }
}