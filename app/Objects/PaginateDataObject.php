<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 16:05
 */

namespace App\Objects;

use App\Enums\DataTypeEnum;

class PaginateDataObject extends SimpleObject
{
    /**
     * @param PaginationObject $paginationObject
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
