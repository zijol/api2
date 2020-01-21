<?php

namespace App\Objects\ModelObjects;

use App\Objects\ListObject;

/**
 * Class ArObjectListObject
 * ListObject 对象
 * @package App\Objects\ModelObjects
 */
class MemberUserListObject extends ListObject
{
    /**
     * @var string 指定Item的类型类 eg. MemberUserItemObject::class
     */
    protected $itemClass = MemberUserItemObject::class;
}
