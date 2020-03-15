<?php
// 倒序排序
$arr1 = [1,5,3,9,11,4,6,88,2];
for ($i = 1; $i < count($arr1); $i++) {
    for ($j = 0; $j < count($arr1) - $i; $j++) { 
        if ($arr1[$j] < $arr1[$j+1]) { // 比较下标为n和n+1的大小,如果n<n+1,则相互调换位置
            list($arr1[$j+1], $arr1[$j]) = [$arr1[$j], $arr1[$j+1]];
        }
    }
}
print_r($arr1);
$arr2 = [1,5,3,9,11,4,6,88,2];
for ($i = 0; $i < count($arr2); $i++) {
    for ($j = 1; $j < count($arr2) - $i; $j++) {
        if ($arr2[$j] > $arr2[$j-1]) { // 比较下标为n和n-1的大小,如果n>n-1,则相互调换位置
            list($arr2[$j], $arr2[$j-1]) = [$arr2[$j-1], $arr2[$j]];
        }
    }
}
print_r($arr2);
// 正序排序
$arr3 = [1,5,3,9,11,4,6,88,2];
for ($i = 0; $i < count($arr3); $i++) {
    for ($j = 1; $j < count($arr3) - $i; $j++) {
        if ($arr3[$j] < $arr3[$j-1]) { // 比较下标为n和n-1的大小,如果n<n-1,则相互调换位置
            list($arr3[$j], $arr3[$j-1]) = [$arr3[$j-1], $arr3[$j]];
        }
    }
}
print_r($arr3);
$arr4 = [1,5,3,9,11,4,6,88,2];
for ($i = 1; $i < count($arr4); $i++) {
    for ($j = 0; $j < count($arr4) - $i; $j++) {
        if ($arr4[$j+1] < $arr4[$j]) { // 比较下标为n和n+1的大小,如果n+1<n,则相互调换位置
            list($arr4[$j+1], $arr4[$j]) = [$arr4[$j], $arr4[$j+1]];
        }
    }
}
print_r($arr4);
