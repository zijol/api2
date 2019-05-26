<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

use \Illuminate\Contracts\Support\Responsable;

class ValidatorException extends \Exception implements Responsable
{
    private $_type = 'invalid_parameters';

    public function __construct(string $message = "", int $code = 4000, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function toResponse($request)
    {
        return response()->make([
            'code' => $this->code,
            'type' => $this->_type,
            'message' => $this->message
        ], 400);
    }
}