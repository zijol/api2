<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Price implements Rule
{
    protected $maxPrice = 1000000000;
    protected $allowZero = false;

    /**
     * Create a new rule instance.
     *
     * @param int $maxPrice 最高价格
     * @param boolean $allowZero 是否允许0
     * @return void
     */
    public function __construct($maxPrice = 1000000000, $allowZero = false)
    {
        $this->maxPrice = $maxPrice;
        $this->allowZero = $allowZero;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = intval($value);

        return $this->allowZero
            ? ((0 <= $value) && ($value < $this->maxPrice))
            : ((0 < $value) && ($value < $this->maxPrice));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.price', [
            'min_price' => sprintf('%.2f', ($this->allowZero ? 0 : 1) / 100),
            'max_price' => sprintf('%.2f', $this->maxPrice / 100),
        ]);
    }
}
