<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 14:38
 */

namespace App\Objects\ModelObjects;

use App\Enums\DataTypeEnum;
use App\Enums\CouponTemplateTypeEnum;
use App\Objects\SimpleObject;

class CouponTemplateObject extends SimpleObject
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
        ],
        'created_at' => [
            DataTypeEnum::STRING
        ],
        'updated_at' => [
            DataTypeEnum::STRING
        ],
    ];

    /**
     * 优惠券类型
     *
     * @param $type
     * @return string
     */
    public static function transferType($type)
    {
        $types = CouponTemplateTypeEnum::transfers();
        return $types[$type] ?? "未知";
    }
}
