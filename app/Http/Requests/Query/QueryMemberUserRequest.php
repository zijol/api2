<?php

namespace App\Http\Requests\Query;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

/**
 * Class QueryMemberUserRequest
 * @package App\Http\Requests\Query
 */
class QueryMemberUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer'
        ];
    }
}
