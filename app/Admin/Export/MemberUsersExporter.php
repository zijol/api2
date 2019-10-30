<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2019/10/30
 * Time: 16:24
 */

namespace App\Admin\Export;

use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;


class MemberUsersExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '会员列表.csv';

    protected $columns = [
        'no' => '编号',
        'name' => '姓名',
        'phone' => '电话',
        'level' => '等级',
        'created_at' => '注册时间',
    ];

    public function map($user): array
    {
        return [
            $user->no,
            $user->name,
            $user->phone,
            $user->level,
            $user->created_at,
        ];
    }
}
