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

    const KEY_MAP = [
        'name' => 'user_name',
        'password' => 'user_password',
        'nickname' => 'user_nickname',
        'role' => 'user_role',
        'avatar' => 'user_avatar',
        'mobile' => 'user_mobile',
        'login_at' => 'user_login_at',
        'login_err_times' => 'user_login_err_times',
        'access_token' => 'user_access_token',
        'created_at' => 'user_created_at',
        'updated_at' => 'user_updated_at',
    ];
}
