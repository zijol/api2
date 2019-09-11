<?php

namespace App\Models\Dy;

/**
 * Class RawUser
 *
 * @package Common\Model\Lbf
 * @property $id
 * @property $raw_data
 * @property $created_at
 * @property $updated_at
 */
class RawUser extends DyModel
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected static $idPrefix = '';
    protected static $live_mode = true;

    protected $table = 'dy_raw_user';
    protected $test_table = 'dy_raw_user';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $casts = [
        'raw_data' => 'array',
    ];

    protected $fillable = [
        'id',
        'raw_data',
    ];
}
