<?php

namespace App\Objects\ModelObjects;

use App\Enums\DataTypeEnum;
use App\Objects\SimpleObject;

/**
 * Class MemberUserObject
 * 简单对象
 * @package App\Objects\ModelObjects
 */
class MemberUserObject extends SimpleObject
{
    /**
     * @var array 对象的属性&类型定义
     */
    protected $_objectKeys = [
        'id' => [
            DataTypeEnum::INTEGER
        ],
        'admin_id'  => [
            DataTypeEnum::INTEGER
        ],
        'no'  => [
            DataTypeEnum::INTEGER
        ],
        'name'  => [
            DataTypeEnum::STRING
        ],
        'phone'  => [
            DataTypeEnum::STRING
        ],
        'level'  => [
            DataTypeEnum::INTEGER
        ],
        'balance'  => [
            DataTypeEnum::INTEGER
        ],
        'points'  => [
            DataTypeEnum::INTEGER
        ],
    ];
}
