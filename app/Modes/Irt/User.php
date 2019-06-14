<?php

namespace App\Modes\Irt;

class User extends BaseMode
{
    const UPDATED_AT = 'user_updated_at';
    const CREATED_AT = 'user_created_at';

    public $table = 'irt_user';
    public $primaryKey = 'user_id';

    public $fillable = [
        'user_name',
        'user_nickname',
        'user_role',
        'user_avatar',
        'user_mobile',
        'user_login_at',
        'user_login_err_times',
        'user_access_token',
    ];

    public static function infoFields()
    {
        return implode(',', [
            'user_id AS id',
            'user_nickname AS nickname',
            'user_role AS role',
            'user_mobile AS mobile',
            'user_avatar AS avatar',
            'user_login_at AS login_at',
            'user_access_token'
        ]);
    }
}
