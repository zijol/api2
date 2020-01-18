<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrMinLen implements Rule
{
    private $_minLen = 1;
    /**
     * Create a new rule instance.
     * @param int $minLen
     * @return void
     */
    public function __construct($minLen = 1)
    {
        $this->_minLen = $minLen;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return mb_strlen($value) >= $this->_minLen;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.str_min_len', [
            'min_len' => $this->_minLen
        ]);
    }
}
