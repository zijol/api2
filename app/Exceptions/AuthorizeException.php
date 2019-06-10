<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

class AuthorizeException extends ApiException
{
    public $type = 'authorize_error';
    public $code = 4001;
    public $message = 'Authorize Error';
    public $httpCode = 401;
}