<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/3
 * Time: 09:47
 */

namespace App\Services\Helper;

/**
 * Class DataTransfer
 *
 * 辅助做数据转换
 *
 * @package App\Services\Helper
 */
class DataTransfer
{
    /**
     * 简化数组的键
     *
     * @param $data
     * @param $search
     * @return array
     */
    public static function SimplifyData($data, $search)
    {
        if (!is_array($data)) {
            return $data;
        }

        $result = [];
        foreach ($data as $key => $value) {
            $result[str_replace($search, '', $key)] = $value;
        }

        return $result;
    }

    /**
     * 复杂化数组的键
     *
     * @param $data
     * @param string $prefix
     * @param string $suffix
     * @return array
     */
    public static function ComplicateData($data, $prefix = '', $suffix = '')
    {
        if (!is_array($data)) {
            return $data;
        }

        $result = [];
        foreach ($data as $key => $value) {
            $result[$prefix . $key . $suffix] = $value;
        }

        return $result;
    }
}
