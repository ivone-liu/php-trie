<?php
function quickSort($arr) {
    $len = count($arr); // 读取数组长度
    if ($len < 1) {  // 只有一个元素的时候
        return $arr;
    }
    $base = $min = $max = [];
    $base_item = $arr[0]; // 赋值为数组第一个元素的值
    for ($i = 0; $i < $len; $i++) { // 遍历整个需排序的数组
        if ($arr[$i] < $base_item) {  // 如果其中的某个元素，比第一个元素小
            $min[] = $arr[$i];
        } else if ($arr[$i] > $base_item) { // 如果其中的某个元素，比第一个元素大
            $max[] = $arr[$i];
        } else {
            $base[] = $arr[$i]; // 为首元素自身
        }
    }
    $min = quickSort($min); // 对比首元素小的元素找位置
    $max = quickSort($max); // 对比首元素大的元素找位置
    return array_merge($min, $base, $max); // 此时已确定base_item位置
}
$nums = [99,17,26,4,33,92,18,9];
print_r(quickSort($nums));
