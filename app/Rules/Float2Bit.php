<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Float2Bit implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return boolval(preg_match('/^0$|^0\.(\d{1,2})$|^[1-9](\d*)(\.\d{1,2})?$/', $value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.float_2_bit');
    }
}
