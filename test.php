<?php

function canJump(array $array): bool
{
    for ($jump = 0; $jump < count($array);) {
        $length = count($array) - 1;

        if ($jump == $length) {
            return true;
        }

        if ($array[$jump] == 0 || $jump > $length) {
            return false;
        }

        $jump += $array[$jump];
    }

    return false;
}

var_dump(canJump([2,3,1,1,4])); //true
var_dump(canJump([3,2,1,1,4])); //false
var_dump(canJump([1,2,1,0,4])); //false
var_dump(canJump([10,2,1,0,4])); //false



