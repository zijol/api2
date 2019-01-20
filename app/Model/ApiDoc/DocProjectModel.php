<?php

namespace App\Model\ApiDoc;

use App\Model\BaseModel;

class DocProjectModel extends BaseModel
{
    const CREATED_AT = 'project_created_at';
    const UPDATED_AT = 'project_updated_at';

    protected $connection = 'api_doc';
    protected $table = 'doc_project';

    protected $fillable = [
        'project_name',
        'project_description',
        'project_created_at',
        'project_updated_at',
    ];
}
