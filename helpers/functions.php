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
     * @return float
     */
    function fen_to_yuan($fen = 100)
    {
        return floatval(bcdiv($fen, 100, 2));
    }
}

if (!function_exists('yuan_to_fen')) {
    /**
     * 元转分
     *
     * @param int|float $yuan
     * @return integer
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

if (!function_exists('parse_to_xml_str')) {
    /**
     * 解析成xml能正常识别的字符串
     *
     * @param string $str
     * @return string
     */
    function parse_to_xml_str($str)
    {
        return str_ireplace(["<", ">", "&", "\"", "'"], ["&lt;", "&gt;", "&amp;", "&quot;", "&apos;"], $str);
    }
}

if (!function_exists('camelize')) {
    /**
     * 下划线转驼峰
     * 思路:
     * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
     * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
     * @param string $uncamelized_words
     * @param string $separator
     * @return string
     */
    function camelize($uncamelized_words, $separator = '_')
    {
        $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
        return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
    }
}

if (!function_exists('uncamelize')) {
    /**
     * 驼峰命名转下划线命名
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     * @param string $camelCaps
     * @param string $separator
     * @return string
     */
    function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}
