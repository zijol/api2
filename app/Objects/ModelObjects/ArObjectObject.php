<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 14:38
 */

namespace App\Objects\ModelObjects;

use App\Enums\DataTypeEnum;
use App\Objects\SimpleObject;

class ArObjectObject extends SimpleObject
{
    protected $_objectKeys = [
        'id' => [
            DataTypeEnum::INTEGER
        ],
        'type' => [
            DataTypeEnum::INTEGER
        ],
        'method' => [
            DataTypeEnum::STRING
        ],
        'headers' => [
            DataTypeEnum::ARRAY
        ],
        'data' => [
            DataTypeEnum::ARRAY
        ],
        'next_time' => [
            DataTypeEnum::STRING
        ],
        'time_periods' => [
            DataTypeEnum::ARRAY
        ],
        'status' => [
            DataTypeEnum::STRING,
            [__CLASS__, "toStatus"]
        ],
    ];

    /**
     * @param $status
     * @return mixed|string
     */
    public static function toStatus($status)
    {
        $allStatus = [
            '0' => '未发送',
            '1' => '发送中',
            '2' => '已完成'
        ];
        return $allStatus[$status] ?? "未知";
    }
}
