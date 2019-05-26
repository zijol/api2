<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

class ValidatorException extends ApiException
{
    public $type = 'invalid_parameters';
    public $code = 4000;
    public $message = 'Invalid Parameters';
}
