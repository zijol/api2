<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 10:06
 */

namespace App\Objects;

use App\Enums\DataTypeEnum;


/**
 * Class UserObject
 *
 * @property string $name
 * @property integer $age
 * @property UserObject $target
 *
 * @package App\Objects
 */
class UserObject extends BaseObject
{
    protected $_objectKeys = [
        'name' => [DataTypeEnum::STRING],
        'age' => [DataTypeEnum::FLOAT],
        'target' => [DataTypeEnum::OBJECT, UserObject::class],
    ];
}
