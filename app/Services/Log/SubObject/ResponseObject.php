<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/11
 * Time: 14:20
 */

namespace App\Services\Log\SubObject;

use Illuminate\Http\Response;

class ResponseObject extends AbstractSubObject
{
    protected $_attributes = [
        'header' => '',
        'body' => '',
        'status' => '',
    ];

    /**
     * RequestObject constructor.
     * @param Response $response
     */
    public function __construct($response)
    {
        if (is_object($response) && $response->getStatusCode() != '500') {
            parent::__construct([
                'header' => $response->headers->all(),
                'body' => $response->getContent(),
                'status' => $response->getStatusCode(),
            ]);
        } else {
            parent::__construct([
                'header' => '',
                'body' => '',
                'status' => '',
            ]);
        }
    }
}
