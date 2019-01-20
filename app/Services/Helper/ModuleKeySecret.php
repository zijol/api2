<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/26
 * Time: 14:42
 */

namespace App\Services\Helper;

class ModuleKeySecret
{
    /**
     * 生成secret时使用的slot
     */
    const MIX_PREFIX = 'zijol_';

    /**
     * @var array 支持的键表
     */
    public static $keyMap = [
        'zijol' => 'zijol',
        'api' => 'api',
    ];

    /**
     * 获取key
     *
     * @param $key
     * @return null|string
     */
    public static function getSecret($key)
    {
        return isset(self::$keyMap[$key]) ? md5(self::MIX_PREFIX . self::$keyMap[$key]) : null;
    }


    /**
     * 签名算法
     *
     * @param array $data
     * @param string $secret 通过getSecret获取到的secret来进行签名
     * @return string
     */
    public static function sign($data = [], $secret = '')
    {
        ksort($data);
        $tmp = [];
        foreach ($data as $k => $v) {
            $tmp[] = $k . '=' . $v;
        }
        $str = implode('&', $tmp) . '&' . $secret;
        return strtolower(sha1($str));
    }
}
