<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2019/10/30
 * Time: 14:41
 */

namespace App\Models\Admin;

/**
 * Class MemberUsers
 * @package App\Models\Admin
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property int $amount
 * @property int $discount
 * @property int $attain_amount
 * @property int $discount_amount
 * @property int $expire
 * @property string $created_at
 * @property string $updated_at
 */
class MemberCouponTemplate extends AdminModel
{
    protected $connection = 'admin';
    public $table = 'member_coupon_template';
}
