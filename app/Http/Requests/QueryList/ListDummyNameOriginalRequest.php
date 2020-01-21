<?php

namespace App\Http\Requests\QueryList;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

/**
 * Class ListExampleRequest
 * @package App\Http\Requests\Modify
 */
class ListDummyNameOriginalRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'id' => [
                'required', 'string', Rule::in(['1'])
            ]
        ], $this->paginateRules());
    }
}
