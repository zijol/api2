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
