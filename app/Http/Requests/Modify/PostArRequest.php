<?php

namespace App\Http\Requests\Modify;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class PostArRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => 'required|string',
            'method' => ['required', Rule::in(['POST', 'GET', 'DELETE', 'PUT'])],
            'headers' => 'filled|array',
            'data' => 'filled|array',
            'periods' => 'required|array|max:10',
        ];
    }
}
