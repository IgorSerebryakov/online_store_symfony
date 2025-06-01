<?php

class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function removeDuplicates(&$nums) {
        $count = count($nums);

        for ($i = 0, $j = $i + 1; $j <= $count - 1;) {
            if (count($nums) == 1) {
                break;
            }

            if ($nums[$j] != $nums[$i]) {
                $i = $j;
                $j++;
            } else {
                unset($nums[$j]);
                $j++;
            }
        }
    }
}

$nums = [-3,-1,0,0];
$solution = new Solution();
$solution->removeDuplicates($nums);
var_dump($nums);



