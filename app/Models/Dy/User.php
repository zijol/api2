<?php

namespace App\Models\Dy;

/**
 * Class User
 *
 * @package Common\Model\Lbf
 * @property $id
 * @property $short_id
 * @property $unique_id
 * @property $nickname
 * @property $gender
 * @property $aweme_count
 * @property $following_count
 * @property $favoriting_count
 * @property $total_favorited
 * @property $is_phone_binded
 * @property $bind_phone
 * @property $created_at
 * @property $updated_at
 */
class User extends DyModel
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected static $idPrefix = '';
    protected static $live_mode = true;

    protected $table = 'dy_user';
    protected $test_table = 'dy_user';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'short_id',
        'unique_id',
        'nickname',
        'gender',
        'aweme_count',
        'following_count',
        'favoriting_count',
        'total_favorited',
        'is_phone_binded',
        'bind_phone',
    ];
}