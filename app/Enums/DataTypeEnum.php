<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 10:41
 */

namespace App\Enums;

/**
 * Class DataTypeEnum
 * @package App\Enums
 */
class DataTypeEnum extends BaseEnum
{
    CONST STRING = 'String';
    CONST INTEGER = 'Integer';
    CONST FLOAT = 'Float';
    CONST ARRAY = 'Array';
    CONST BOOL = 'Bool';
    CONST OBJECT = 'Object';
    CONST NIL = 'Null';
}
