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
        'id' => [DataTypeEnum::STRING, ],
		'admin_id' => [DataTypeEnum::STRING, ],
		'no' => [DataTypeEnum::STRING, ],
		'name' => [DataTypeEnum::STRING, ],
		'phone' => [DataTypeEnum::STRING, ],
		'level' => [DataTypeEnum::STRING, ],
		'balance' => [DataTypeEnum::STRING, ],
		'points' => [DataTypeEnum::STRING, ],
		'created_at' => [DataTypeEnum::STRING, ],
		'updated_at' => [DataTypeEnum::STRING, ],
		'deleted_at' => [DataTypeEnum::STRING, ],
    ];
}
