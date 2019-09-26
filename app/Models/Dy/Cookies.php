<?php

namespace App\Models\Dy;

/**
 * Class User
 *
 * @package Common\Model\Lbf
 * @property $id
 * @property $cookies
 * @property $err_times
 * @property $expires_at
 */
class Cookies extends DyModel
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected static $idPrefix = '';
    protected static $live_mode = true;

    protected $table = 'dy_cookies';
    protected $test_table = 'dy_cookies';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $casts = [
        'cookies' => 'array'
    ];

    protected $fillable = [
        'id',
        'cookies',
        'err_times',
        'expires_at',
    ];
}
