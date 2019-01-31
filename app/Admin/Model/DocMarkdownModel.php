<?php

namespace App\Admin\Model;

use App\Model\BaseModel;

class DocMarkdownModel extends BaseModel
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // 数据库连接名
    protected $connection = 'admin';
    // 用户等级表 表名
    protected $table = 'admin_doc_markdown';
    // test表后缀
    protected $test_table_suffix = '_test';

    // 数据表可操作字段
    protected $fillable = [
        'classify',
        'title',
        'description',
        'content',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
