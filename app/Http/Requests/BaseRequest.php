<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
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
        return [];
    }

    /**
     * 分页通用的规则
     *
     * @return array
     */
    protected function paginateRules()
    {
        return [
            'page' => 'filled|integer|between:1,10000',
            'per_page' => 'filled|integer|between:1,100',
        ];
    }
}
