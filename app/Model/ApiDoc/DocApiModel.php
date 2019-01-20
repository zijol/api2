<?php

namespace App\Model\ApiDoc;

use App\Model\BaseModel;

class DocApiModel extends BaseModel
{
    const CREATED_AT = 'api_created_at';
    const UPDATED_AT = 'api_updated_at';

    protected $connection = 'api_doc';

    protected $fillable = [
        'api_name',
        'api_description',
        'api_method',
        'api_uri',
        'api_query_string',
        'api_req_headers',
        'api_req_params',
        'api_res_headers'
    ];
}
