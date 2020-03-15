<?php
function insertSort($arr) {
    $len = count($arr);
    for ($i = 1; $i < $len; $i++) { // 忽略0,从1开始循环
        $tmp = $arr[$i];  // 将当前的值设为暂存状态
        for ($j = $i - 1; $j >= 0; $j--) { // 循环所有排在$arr[$i]之前的数据
            if ($tmp < $arr[$j]) { // 当出现暂存值小于$arr[$i]之前的数据
                $arr[$j+1] = $arr[$j]; // 往后挪一位
                $arr[$j] = $tmp; // 将暂存值插入
            } else {
                break; // 如果没有插入则表示已经排序完成
            }
        }
    }
    return $arr;
}
