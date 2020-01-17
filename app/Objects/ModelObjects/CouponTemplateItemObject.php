<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 14:38
 */

namespace App\Objects\ModelObjects;

use App\Enums\DataTypeEnum;

class CouponTemplateItemObject extends CouponTemplateObject
{
    protected $_objectKeys = [
        'id' => [
            DataTypeEnum::INTEGER
        ],
        'type' => [
            DataTypeEnum::STRING,
            [__CLASS__, "transferType"]
        ],
        'amount' => [
            DataTypeEnum::INTEGER,
            "fen_to_yuan"
        ],
        'discount' => [
            DataTypeEnum::FLOAT,
            "to_discount"
        ],
        'attain_amount' => [
            DataTypeEnum::FLOAT,
            'fen_to_yuan',
        ],
        'discount_amount' => [
            DataTypeEnum::FLOAT,
            'fen_to_yuan',
        ]
    ];
}
