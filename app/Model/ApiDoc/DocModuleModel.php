<?php

namespace App\Model\ApiDoc;

use App\Model\BaseModel;

class DocModuleModel extends BaseModel
{
    const CREATED_AT = 'module_created_at';
    const UPDATED_AT = 'module_updated_at';

    protected $fillable = [
        'module_project',
        'module_name',
        'module_description',
        'module_created_at',
        'module_updated_at',
    ];
}
