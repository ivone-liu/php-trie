<?php
function selectSort($arr) {
    $len = count($arr);
    for ($i = 0; $i < $len; $i++) {
        $p = $i; // 假设当前的最小元素为$arr[$i]
        for ($j = $i + 1; $j < $len; $j++) { // 循环遍历下标大于$i的所有元素
            if ($arr[$p] > $arr[$j]) {
                $p = $j;  // 如果有其他元素小于$arr[$i],则把下标值重新赋值为$j
            }
        }
        if ($p != $i) { // 当前元素非最小元素时
            list($arr[$p], $arr[$i]) = [$arr[$i], $arr[$p]];  // 将此两元素的位置替换
        }
    }
    return $arr;
}
$arr = [99,17,26,4,33,92,18,9];
print_r(selectSort($arr));
