<?php
namespace App\Models\Dy;

/**
 * Class VUser
 *
 * @package Common\Model\Lbf
 * @property $id
 * @property $short_id
 * @property $unique_id
 * @property $nickname
 * @property $gender
 * @property $search_level
 * @property $search_base
 * @property $grab_fans
 * @property $created_at
 * @property $updated_at
 */
class VUser extends DyModel
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected static $idPrefix = '';
    protected static $live_mode = true;

    protected $table = 'dy_v_user';
    protected $test_table = 'dy_v_user';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'short_id',
        'unique_id',
        'nickname',
        'gender',
        'search_level',
        'search_base',
        'grab_fans',
    ];
}
