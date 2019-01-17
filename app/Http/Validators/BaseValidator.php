<?php

namespace App\Http\Validators;

use App\Services\Helper\ErrorCode\ErrorCode;
use App\Services\Helper\Make;
use Illuminate\Support\Facades\Validator;

/**
 * Class BaseValidator
 *
 * fast validate class
 *
 * @package App\Http\Validators
 */
abstract class BaseValidator extends Validator
{
    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    protected static $validator = null;

    /**
     * @return array
     */
    abstract protected static function rules();

    /**
     * @return array
     */
    protected static function message()
    {
        return [];
    }

    /**
     * @return array
     */
    protected static function customAttributes()
    {
        return [];
    }

    /**
     * validate data, no error will return true
     * @param $data
     * @return array|bool
     */
    public static function validate($data)
    {
        static::$validator = static::make($data, static::rules(), static::message(), static::customAttributes());

        if (static::$validator->fails()) {
            return Make::ApiFail(ErrorCode::PARAM_ERROR, static::$validator->errors()->all());
        } else {
            return true;
        }
    }

    /**
     * get the validated data
     *
     * @return array
     */
    public static function getValidatedData()
    {
        if (static::$validator !== null) {
            return static::$validator->validate();
        }
        return [];
    }
}
