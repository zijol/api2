<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2019/10/30
 * Time: 11:33
 */

if (!function_exists('yaConfig')) {
    /**
     * 获取配置
     *
     * @param string $name $fileName.section.key || $filename.section || $filename
     * @param null $default
     * @return mixed
     */
    function yaConfig($name, $default = null)
    {
        return \Yaconf::get($name, $default);
    }
}

if (!function_exists('fen_to_yuan')) {
    /**
     * 分转元
     *
     * @param int $fen
     * @return string
     */
    function fen_to_yuan($fen = 100)
    {
        return floatval(bcdiv($fen, 100, 2));
    }
}

if (!function_exists('yuan_to_fen')) {
    /**
     * 分转元
     *
     * @param int|float $yuan
     * @return string
     */
    function yuan_to_fen($yuan = 100)
    {
        return intval($yuan * 100);
    }
}

if (!function_exists('to_discount')) {
    /**
     * 折扣
     *
     * @param int $discount
     * @return string
     */
    function to_discount($discount = 100)
    {
        return sprintf("%.1f", bcdiv($discount, 10, 1));
    }
}
