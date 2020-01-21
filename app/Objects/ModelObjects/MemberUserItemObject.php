<?php

namespace App\Objects\ModelObjects;

use App\Enums\DataTypeEnum;

/**
 * Class MemberUserItemObject
 * 组成 ListObject 的元素对象
 * @package App\Objects\ModelObjects
 */
class MemberUserItemObject extends MemberUserObject
{
    /**
     * @var array 对象的属性&类型定义
     */
    protected $_objectKeys = [
        'admin_id' => [
            DataTypeEnum::INTEGER
        ],
        'no' => [
            DataTypeEnum::INTEGER
        ],
        'name' => [
            DataTypeEnum::STRING
        ],
        'phone' => [
            DataTypeEnum::STRING
        ],
        'level' => [
            DataTypeEnum::INTEGER
        ],
        'balance' => [
            DataTypeEnum::INTEGER
        ],
        'points' => [
            DataTypeEnum::INTEGER
        ],
    ];
}
