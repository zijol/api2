<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 16:05
 */

namespace App\Objects\PaginationObjects;

use App\Enums\DataTypeEnum;
use App\Objects\SimpleObject;
use App\Objects\ListObject;

class PaginateDataObject extends SimpleObject
{
    /**
     * @param PaginateObject $paginationObject
     * @param ListObject $listObject
     * @return PaginateDataObject
     */
    public static function init($paginationObject, $listObject)
    {
        return static::instance([
            'list' => $listObject,
            'page' => $paginationObject->page,
            'per_page' => $paginationObject->per_page,
            'total' => $paginationObject->total,
        ]);
    }

    /**
     * @var array
     */
    protected $_objectKeys = [
        'page' => [
            DataTypeEnum::INTEGER,
        ],
        'per_page' => [
            DataTypeEnum::INTEGER,
        ],
        'total' => [
            DataTypeEnum::INTEGER,
        ],
        'list' => [
            DataTypeEnum::OBJECT
        ]
    ];
}
