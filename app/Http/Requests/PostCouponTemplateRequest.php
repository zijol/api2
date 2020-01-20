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
            'amount' => $this->amountRules(),
            'discount' => $this->discountRules(),
            'attain_amount' => $this->attainDiscountAmountRules(),
            'discount_amount' => $this->attainDiscountAmountRules(),
            'expire' => 'required|integer',
        ];
    }

    protected function amountRules()
    {
        $data = $this->validationData();
        return $data['type'] == 0
            ? ['required', new Price(),]
            : ['filled', new Price(),];
    }

    protected function discountRules()
    {
        $data = $this->validationData();
        return $data['type'] == 1
            ? ['required', new Price(),]
            : ['filled', new Price(),];
    }

    protected function attainDiscountAmountRules()
    {
        $data = $this->validationData();
        return $data['type'] == 2
            ? ['required', new Price(),]
            : ['filled', new Price(),];
    }
}
