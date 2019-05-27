<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrMaxLen implements Rule
{
    private $_maxLen = 64;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $maxLen = 64)
    {
        $this->_maxLen = $maxLen;
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
        return mb_strlen($value) <= $this->_maxLen;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.str_max_len', [
            'max_len' => $this->_maxLen
        ]);
    }
}
