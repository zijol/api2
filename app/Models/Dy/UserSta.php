<?php

namespace App\Models\Dy;

/**
 * Class UserSta
 * @property $id
 * @property $raw_count
 * @property $user_count
 * @property $v_count
 * @package App\Models\Dy
 */
class UserSta extends DyModel
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'dy_user_sta';
    protected $test_table = 'dy_user';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'raw_count',
        'user_count',
        'v_count',
    ];
}
