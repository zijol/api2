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
 * @property $sync_times
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
        'sync_times',
    ];
}
