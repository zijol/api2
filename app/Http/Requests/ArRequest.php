<?php

namespace App\Http\Requests;

use App\Rules\Float2Bit;
use App\Rules\StrMaxLen;
use Illuminate\Foundation\Http\FormRequest;

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
            'id' => 'filled',
        ];
    }
}