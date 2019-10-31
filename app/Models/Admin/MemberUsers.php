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
 * @property int $admin_id
 * @property string $no
 * @property string $name
 * @property string $phone
 * @property int $level
 * @property int $balance
 * @property int $points
 */
class MemberUsers extends AdminModel
{
    protected $connection = 'admin';
    public $table = 'member_users';
}
