<?php

namespace App\Models\Admin;

/**
 * Class MemberUserModel
 * @package App\Models\Admin
 */
class MemberUserModel extends AdminModel
{
    /**
     * @var string 连接名
     */
    protected $connection = 'admin';

    /**
     * @var string 表名
     */
    public $table = 'member_users';

    /**
     * @var array 字段类型映射
     */
    public $cast = [
        //
    ];

    /**
     * @var array 可写字段
     */
    protected $fillable = [
        'admin_id',
        'no',
        'name',
        'phone',
        'level',
        'balance',
        'points',
    ];

    /**
     * @var array 属性 <-> 字段 [ 'object_key' => 'db_key' ]
     */
    public static $KeyMap = [
        //
    ];

    /**
     * @var string ID 前缀
     */
    protected static $idPrefix = '';
}
