<?php

namespace App\Http\Requests;

use App\Enums\CouponTemplateTypeEnum;
use App\Rules\Price;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostCouponTemplateRequest extends FormRequest
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
     * @return array
     * @throws \ReflectionException
     */
    public function rules()
    {
        return [
            'type' => [
                'required',
                'integer',
                Rule::in(CouponTemplateTypeEnum::enums())
            ],
            'name' => 'required|string|between:1,32',
            'amount' => [
                'filled', new Price(),
            ],
            'discount' => [
                'filled', Rule::in(range(1, 100)),
            ],
            'attain_amount' => [
                'filled', new Price(),
            ],
            'discount_amount' => [
                'filled', new Price(),
            ],
            'expire' => [
                'filled', 'integer'
            ],
        ];
    }
}
