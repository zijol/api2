<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 15:20
 */

namespace App\Enums;


class CouponTemplateTypeEnum extends BaseEnum
{
    CONST AMOUNT_COUPON = 0;
    CONST DISCOUNT_COUPON = 1;
    CONST ATTAIN_COUPON = 2;

    /**
     * @return array
     */
    public static function transfers()
    {
        return [
            self::AMOUNT_COUPON => '现金券',
            self::DISCOUNT_COUPON => '折扣券',
            self::ATTAIN_COUPON => '满减券',
        ];
    }
}
