<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

use \Illuminate\Contracts\Support\Responsable;

class ForbiddenException extends \Exception implements Responsable
{
    private $_type = 'forbidden';

    public function __construct(string $message = "Invite forbidden.", int $code = 4003, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function toResponse($request)
    {
        return response()->make([
            'code' => $this->code,
            'type' => $this->_type,
            'message' => $this->message
        ], 403);
    }
}