<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/28
 * Time: 10:24
 */

namespace App\Objects\PaginationObjects;

use App\Enums\DataTypeEnum;
use App\Objects\SimpleObject;

/**
 * @property $page
 * @property $per_page
 * @property $total
 * @property $total_page
 */
class PaginateObject extends SimpleObject
{
    protected $_objectKeys = [
        'page' => [
            DataTypeEnum::INTEGER,
        ],
        'per_page' => [
            DataTypeEnum::INTEGER,
        ],
        'total' => [
            DataTypeEnum::INTEGER,
        ]
    ];
}
