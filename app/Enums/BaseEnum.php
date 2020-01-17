<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 10:18
 */

namespace App\Enums;

class BaseEnum
{
    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function enums()
    {
        $oClass = new \ReflectionClass(static::class);
        $cArr = $oClass->getConstants();
        return array_unique(array_values($cArr));
    }
}
