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
    public $type = 'bad_route';
    public $code = 4004;
    public $message = 'Bad Route';
    public $httpCode = 404;
}