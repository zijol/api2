<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/28
 * Time: 10:24
 */

namespace App\Objects;

use App\Enums\DataTypeEnum;

/**
 * @property $page
 * @property $per_page
 * @property $total
 * @property $total_page
 */
class PaginationObject extends SimpleObject
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
