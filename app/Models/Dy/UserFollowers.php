<?php

namespace App\Models\Dy;

/**
 * Class UserFollowers
 *
 * @package Common\Model\Lbf
 * @property $id
 * @property $uid
 * @property $follow_uid
 */
class UserFollowers extends DyModel
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected static $idPrefix = '';
    protected static $live_mode = true;

    protected $table = 'dy_user_followers';
    protected $test_table = 'dy_user_followers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'uid',
        'follow_uid',
    ];
}
