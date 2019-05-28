<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

class NotFoundException extends ApiException
{
    public $type = 'not_found';
    public $code = 4004;
    public $message = 'Not Fount';
}