<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

class ForbiddenException extends ApiException
{
    public $type = 'invite_forbidden';
    public $code = 4003;
    public $message = 'Invite Forbidden';
}