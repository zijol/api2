<?php

namespace App\Http\Requests\Query;

use App\Rules\ID;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

/**
 * Class QueryExampleRequest
 * @package App\Http\Requests\Modify
 */
class QueryDummyNameOriginalRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [
                'required', 'integer', new ID('example')
            ],
            //
        ];
    }
}
