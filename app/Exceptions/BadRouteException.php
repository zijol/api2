<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

class BadRouteException extends ApiException
{
    public $httpCode = 404;
    public $customType = 'bad_route';
    public $errorMessage = 'Bad Route';
    public $customCode = 4004;
}
