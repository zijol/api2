<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 14:38
 */

namespace App\Objects\ModelObjects;

use App\Objects\ListObject;

/**
 * Class ArObjectListObject
 * ListObject 对象
 * @package App\Objects\ModelObjects
 */
class ArListObject extends ListObject
{
    /**
     * @var string 指定Item的类型类 eg. AnyItemObject::class
     */
    protected $itemClass = ArItemObject::class;
}
