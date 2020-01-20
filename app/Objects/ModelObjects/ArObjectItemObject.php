<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 14:38
 */

namespace App\Objects\ModelObjects;

use App\Enums\DataTypeEnum;

class ArObjectItemObject extends ArObjectObject
{
    protected $_objectKeys = [
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
}
