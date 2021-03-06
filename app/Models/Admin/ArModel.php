<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2019/10/30
 * Time: 14:41
 */

namespace App\Models\Admin;

/**
 * Class MemberUsers
 * @package App\Models\Admin
 *
 * @property int $id
 * @property int $type
 * @property string $url
 * @property string $method
 * @property string $data
 * @property int $next_time
 * @property int $time_periods
 * @property int $status
 */
class ArModel extends AdminModel
{
    protected $connection = 'admin';
    public $table = 'ar';

    public $cast = [
        'time_periods' => 'array',
        'data' => 'array',
        'headers' => 'array',
    ];

    protected $fillable = [
        'type',
        'url',
        'data',
        'method',
        'headers',
        'time_periods',
        'next_time',
    ];
}
