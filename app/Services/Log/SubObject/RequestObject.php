<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/11
 * Time: 14:20
 */

namespace App\Services\Log\SubObject;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RequestObject extends AbstractSubObject
{
    protected $_attributes = [
        'uri' => '',
        'row_uri' => '',
        'method' => '',
        'body' => '',
        'query' => '',
        'header' => ''
    ];

    /**
     * RequestObject constructor.
     * @param Request $request
     */
    public function __construct($request)
    {
        if ($request instanceof Request) {
            parent::__construct([
                'uri' => $request->url(),
                'row_uri' => $request->getQueryString(),
                'method' => $request->getMethod(),
                'body' => $request->getContent(),
                'query' => $request->getQueryString(),
                'header' => $request->headers->all()
            ]);
        } else {
            parent::__construct($request);
        }
    }
}
