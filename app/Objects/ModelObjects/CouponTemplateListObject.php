<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 14:38
 */

namespace App\Objects\ModelObjects;

use App\Objects\ListObject;

class CouponTemplateListObject extends ListObject
{
    protected $itemClass = CouponTemplateItemObject::class;
}
