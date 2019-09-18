<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ID implements Rule
{
    protected $minLen = 32;
    protected $maxLen = 40;
    protected $objectName = '';

    /**
     * Create a new rule instance.
     *
     * @param string $objectName 对象名字（用于错误提示）
     * @param int $minLen 最短支持
     * @param int $maxLen 最长支持
     * @return void
     */
    public function __construct($objectName, $minLen = 16, $maxLen = 40)
    {
        $this->objectName = $objectName;
        $this->minLen = $minLen;
        $this->maxLen = $maxLen;
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
        $len = mb_strlen(trim($value));
        return $len >= $this->minLen && $len <= $this->maxLen;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.id', [
            'object_name' => $this->objectName,
            'min_len' => $this->minLen,
            'max_len' => $this->maxLen,
        ]);
    }
}
