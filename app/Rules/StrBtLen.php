<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrBtLen implements Rule
{
    private $_minLen = 1;
    private $_maxLen = 64;

    /**
     * StrBtLen constructor.
     * @param int $minLen
     * @param int $maxLen
     */
    public function __construct($minLen = 1, $maxLen = 64)
    {
        $this->_minLen = $minLen;
        $this->_maxLen = $maxLen;
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
        $len = mb_strlen($value);

        return $len >= $this->_minLen && $len <= $this->_maxLen;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.str_bt_len', [
            'min_len' => $this->_minLen,
            'max_len' => $this->_maxLen,
        ]);
    }
}
