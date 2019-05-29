<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/20
 * Time: 14:41
 */

namespace App\Http\Controllers\Web;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExampleRequest;
use App\Services\RedisLock\ExampleLock;

class IndexController extends Controller
{
    /**
     * @param ExampleRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ForbiddenException
     */
    public function index(ExampleRequest $request)
    {
        $params = $request->validated();

        ExampleLock::safeGet($params);

        if (!random_int(0, 1)) {
            throw new ForbiddenException('拒绝访问');
        }

        return self::JsonResponse($params);
    }
}
