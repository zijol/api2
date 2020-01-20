<?php

namespace App\Http\Requests;

use App\Rules\Float2Bit;
use App\Rules\StrMaxLen;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

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
