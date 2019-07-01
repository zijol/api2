<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/20
 * Time: 14:41
 */

namespace App\Http\Controllers\Web;

use App\Exceptions\AuthorizeException;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExampleRequest;

class IndexController extends Controller
{
    /**
     * @param ExampleRequest $request
     * @throws AuthorizeException
     */
    public function index(ExampleRequest $request)
    {
        throw new AuthorizeException('Welcome to zijol api.', "", "", "no", ["Mtgg" => "zijol"]);
    }
}
