<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2019/10/30
 * Time: 14:41
 */

namespace App\Models\Admin;

use App\Models\BaseModel;

class AdminModel extends BaseModel
{
    protected $connection = 'admin';

    public $table = 'member_users';
}
