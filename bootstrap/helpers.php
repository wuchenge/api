<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-22 16:03:03
 */

/**
 * 生成随机码
 *
 * @return string
 */
function createCode($type = 1, $len = 6)
{
    switch ($type) {
        case 1:
            $seed = '234578abcdefghjkmnpqrstuvwxy';
            break;

        default:
            $seed = '0123456789';
            break;
    }

    $code = '';
    $max = strlen($seed)-1;

    for ($i = 0; $i < $len; ++$i) {
        $code .= $seed[mt_rand(0, $max)];
    }

    return $code;
}
