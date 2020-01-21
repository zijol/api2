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
     * @param PaginateObject $paginateObject
     * @param ListObject $listObject
     * @return PaginateDataObject
     */
    public static function initWithPaginate($paginateObject, $listObject)
    {
        return new static([
            'list' => $listObject,
            'page' => $paginateObject->page,
            'per_page' => $paginateObject->per_page,
            'total' => $paginateObject->total,
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
